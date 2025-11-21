<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Petugas;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranController extends Controller
{
    private function statusPembayaranSiswa($nisn){

    $urutanBulan = [
        "Januari","Februari","Maret","April","Mei","Juni",
        "Juli","Agustus","September","Oktober","November","Desember"
    ];

    $bulanSudah = Pembayaran::where('nisn', $nisn)
        ->pluck('bulan_dibayar')
        ->toArray();   // langsung string, bukan JSON

    $data = [];
    foreach ($urutanBulan as $bln) {
        $data[$bln] = in_array($bln, $bulanSudah) ? 'lunas' : 'belum';
    }

    return $data;
}

    public function index(Request $request)
{
    $filterKelas = $request->kelas;
    $filterNama  = $request->nama;

    $siswaQuery = Siswa::with('kelas');

    if ($filterKelas) {
        $siswaQuery->where('id_kelas', $filterKelas);
    }

    if ($filterNama) {
        $siswaQuery->where('nama', 'LIKE', '%' . $filterNama . '%');
    }

    $siswa = $siswaQuery->get();


    $hasil = [];
    foreach ($siswa as $s) {
        $hasil[] = [
            'nisn' => $s->nisn,
            'nama' => $s->nama,
            'kelas' => $s->kelas->nama_kelas ?? '-',
            'id_kelas' => $s->id_kelas,
            'status' => $this->statusPembayaranSiswa($s->nisn)
        ];
    }   

    return view('admin.pembayaran.index', [
        'data' => $hasil,
        'kelas' => Kelas::all(),
        'filterKelas' => $filterKelas,
        'filterNama' => $filterNama,
    ]);
}


    public function bayar($nisn){
        $siswa = Siswa::findOrFail($nisn);
        $status = $this->statusPembayaranSiswa($nisn);
        $tanggalSekarang = Carbon::now()->format('Y-m-d');
        $bulanBelum = array_keys(array_filter($status, fn($v) => $v === 'belum'));

        return view('admin.pembayaran.bayar', [
            'siswa' => $siswa,
            'bulanBelum' => $bulanBelum,
            'tanggalSekarang' => $tanggalSekarang,
        ]);
    }

    public function store(Request $request){
    $request->validate([
        'nisn' => 'required',
        'bulan' => 'required|array',
        'id_spp' => 'required',
    ]);

    $siswa = Siswa::with('spp')->findOrFail($request->nisn);
    $nominal = $siswa->spp->nominal;
    $idPetugas = Auth::guard('petugas')->id() ?? 1;

    foreach ($request->bulan as $bln) {
        Pembayaran::create([
            'id_petugas'    => $idPetugas,
            'nisn'          => $request->nisn,
            'tgl_bayar'     => now(),
            'bulan_dibayar' => $bln,        //  TIDAK JSON
            'tahun_dibayar' => date('Y'),
            'id_spp'        => $request->id_spp,
            'jumlah_bayar'  => $nominal,    //  per bulan
        ]);
    }

    return redirect()->route('admin.pembayaran.index')
        ->with('success', 'Pembayaran berhasil dicatat!');
}

   public function history($nisn)
{
    $siswa = Siswa::with(['kelas','spp', 'pembayaran.petugas'])->findOrFail($nisn);

    // Ambil semua pembayaran siswa
    $pembayaran = Pembayaran::where('nisn', $nisn)->orderBy('tgl_bayar', 'DESC')->get();

    // Total bulan dibayar = jumlah record
    $totalBulan = $pembayaran->count();

    // Total pembayaran
    $totalBayar = $pembayaran->sum('jumlah_bayar');

    // Hitung tunggakan (1 tahun = 12 bulan)
    $nominal = $siswa->spp->nominal;
    $tunggakan = ($nominal * 12) - $totalBayar;

    return view('admin.pembayaran.history', [
        'siswa' => $siswa,
        'pembayaran' => $pembayaran,
        'totalBulan' => $totalBulan,
        'totalBayar' => $totalBayar,
        'tunggakan' => $tunggakan,
    ]);
}


    public function detail($nisn){
    $siswa = Siswa::with('kelas','spp')->findOrFail($nisn);
    $pembayaran = Pembayaran::where('nisn', $nisn)->get();

    $urutanBulan = [
        "Januari","Februari","Maret","April","Mei","Juni",
        "Juli","Agustus","September","Oktober","November","Desember"
    ];

    $sudah = $pembayaran->pluck('bulan_dibayar')->toArray();
    $belum = array_diff($urutanBulan, $sudah);

    $totalBayar = $pembayaran->sum('jumlah_bayar');
    $tunggakan = $siswa->spp->nominal * 12 - $totalBayar;

    return view('admin.pembayaran.detail', [
        'siswa' => $siswa,
        'pembayaran' => $pembayaran,
        'bulanSudah' => $sudah,
        'bulanBelum' => $belum,
        'totalBayar' => $totalBayar,
        'tunggakan' => $tunggakan,
    ]);
}
    
    public function cetakPDF($nisn)
{
    $urutanBulan = [
        "Januari","Februari","Maret","April","Mei","Juni",
        "Juli","Agustus","September","Oktober","November","Desember"
    ];

    $siswa = Siswa::with('kelas','spp')->findOrFail($nisn);
    $pembayaran = Pembayaran::where('nisn', $nisn)->get();

    $bulanDibayar = $pembayaran->pluck('bulan_dibayar')->toArray();
    $bulanBelum = array_diff($urutanBulan, $bulanDibayar);

    $totalBayar = $pembayaran->sum('jumlah_bayar');
    $tunggakan = $siswa->spp->nominal * 12 - $totalBayar;

    $p = Pembayaran::with('petugas')->where('nisn', $nisn)
            ->orderBy('tgl_bayar', 'DESC')->firstOrFail();

    $hariTanggal = \Carbon\Carbon::parse($p->tgl_bayar)
        ->translatedFormat('l, d F Y');

    $pdf = Pdf::loadView('admin.pembayaran.cetak', [
        'siswa' => $siswa,
        'pembayaran' => $pembayaran,
        'bulanDibayar' => $bulanDibayar,
        'bulanBelum' => $bulanBelum,
        'totalBayar' => $totalBayar,
        'tunggakan' => $tunggakan,
        'p' => $p,
        'hariTanggal' => strtoupper($hariTanggal)
    ]);

    return $pdf->stream('Kuitansi-SPP-'.$nisn.'.pdf');
}

public function kartuSPP($nisn)
{
    $urutanBulan = [
        "Juli","Agustus","September","Oktober","November","Desember",
        "Januari","Februari","Maret","April","Mei","Juni"
    ];

    $siswa = Siswa::with(['kelas','spp'])->findOrFail($nisn);

    // Ambil seluruh pembayaran siswa ini
    $pembayaran = Pembayaran::where('nisn', $nisn)
        ->get()
        ->keyBy('bulan_dibayar'); 
        // keyBy agar mudah dipanggil berdasarkan nama bulan

    $pdf = \PDF::loadView('admin.pembayaran.kartu_spp', [
        'siswa' => $siswa,
        'pembayaran' => $pembayaran,
        'urutanBulan' => $urutanBulan
    ])->setPaper('a4', 'portrait');

    return $pdf->stream('kartu spp '.$siswa->nama.'.pdf');
}


}
