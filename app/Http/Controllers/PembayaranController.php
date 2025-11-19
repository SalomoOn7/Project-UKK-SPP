<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranController extends Controller
{
    private function statusPembayaranSiswa($nisn){
        $urutanBulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        $bulanSudahBayar = Pembayaran::where('nisn', $nisn)
            ->pluck('bulan_dibayar')
            ->toArray();

        // decode semua JSON bulan_dibayar
        $bulanSudahBayarFlat = [];
        foreach ($bulanSudahBayar as $list) {
            $arr = json_decode($list, true);
            if (is_array($arr)) {
                $bulanSudahBayarFlat = array_merge($bulanSudahBayarFlat, $arr);
            }else {
                if (!empty($list)) {
                    $bulanSudahBayarFlat[] = $list;
                }
            }
        }

        $data = [];
        foreach ($urutanBulan as $bulan) {
            $data[$bulan] = in_array($bulan, $bulanSudahBayarFlat) ? 'lunas' : 'belum';
        }

        return $data;
    }

    public function index()
    {
        $siswa = Siswa::all();
        $hasil = [];

        foreach ($siswa as $s) {
            $hasil[] = [
                'nisn' => $s->nisn,
                'nama' => $s->nama,
                'status' => $this->statusPembayaranSiswa($s->nisn)
            ];
        }

        return view('admin.pembayaran.index', [
            'data' => $hasil
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

        // Ambil nominal spp per bulan
        $siswa = Siswa::with('spp')->findOrFail($request->nisn);
        $nominal = $siswa->spp->nominal;

        // Hitung total
        $totalBayar = count($request->bulan) * $nominal;

        // Simpan 1 record pembayaran
        Pembayaran::create([
            'id_petugas'    => Auth::guard('petugas')->id() ?? 1,
            'nisn'          => $request->nisn,
            'tgl_bayar'     => now(),
            'bulan_dibayar' => json_encode($request->bulan),
            'tahun_dibayar' => date('Y'),
            'id_spp'        => $request->id_spp,
            'jumlah_bayar'  => $totalBayar,
        ]);

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil dicatat!');
    }

   public function history($nisn)
{
    $siswa = Siswa::with(['kelas','spp', 'pembayaran.petugas'])->findOrFail($nisn);

    $pembayaran = Pembayaran::where('nisn', $nisn)->get();

    $totalBulan = 0;

    foreach ($pembayaran as $p) {
        $bulan = json_decode($p->bulan_dibayar, true);

        if (!is_array($bulan)) {
            $bulan = [];
        }

        $totalBulan += count($bulan);
    }

    $totalBayar = $pembayaran->sum('jumlah_bayar');

    return view('admin.pembayaran.history', [
        'siswa' => $siswa,
        'totalBulan' => $totalBulan,
        'totalBayar' => $totalBayar,
    ]);
}

    public function detail($nisn){
        $siswa = Siswa::with('kelas','spp')->findOrFail($nisn);
        $spp = $siswa->spp;
        $pembayaran = Pembayaran::where('nisn', $nisn)->orderBy('tgl_bayar', 'DESC')->get();

        $urutanBulan = [
        "Januari","Februari","Maret","April","Mei","Juni",
        "Juli","Agustus","September","Oktober","November","Desember"
        ];

        $sudah = [];
        foreach ($pembayaran as $p) {
            $arr = json_decode($p->bulan_dibayar, true) ?? [];

            if (!is_array($arr)) {
                $arr = [];
            }
            $sudah = array_merge($sudah, $arr);
        }
        $bulanDibayar = $sudah;
        $tunggakan = array_diff($urutanBulan, $sudah);
        $totalBayar = $pembayaran->sum('jumlah_bayar');

        $belum = array_diff($urutanBulan, $sudah);
        return view('admin.pembayaran.detail', [
        'siswa' => $siswa,
        'spp' => $spp,
        'pembayaran' => $pembayaran,
        'bulanSudah' => $sudah,
        'bulanBelum' => $belum,
        'bulanDibayar' => $bulanDibayar,
        'totalBayar' => $totalBayar,
        'tunggakan' => $tunggakan,
        ]);
    }
            public function cetakPDF($nisn){
        $urutanBulan = [
        "Januari","Februari","Maret","April","Mei","Juni",
        "Juli","Agustus","September","Oktober","November","Desember"
        ];
        $pembayaran = Pembayaran::where('nisn', $nisn)->orderBy('tgl_bayar', 'DESC')->get();
        $sudah = [];
        foreach ($pembayaran as $p) {
            $arr = json_decode($p->bulan_dibayar, true) ?? [];

            if (!is_array($arr)) {
                $arr = [];
            }
            $sudah = array_merge($sudah, $arr);
        }
        $bulanDibayar = $sudah;
         $tunggakan = array_diff($urutanBulan, $sudah);


                $siswa = Siswa::with('kelas','spp')->findOrFail($nisn);
                $p = Pembayaran::with('petugas', 'siswa.kelas','siswa','siswa.spp')->where('nisn', $nisn)->orderBy('tgl_bayar', 'DESC')->firstOrFail();
                $hariTanggal =  \Carbon\Carbon::parse($p->tgl_bayar)->translatedFormat('l, d F Y');
                $pdf = Pdf::loadView('admin.pembayaran.cetak', [
                    'p' => $p,
                    'hariTanggal' => strtoupper($hariTanggal),
                    'siswa'      => $siswa,
                    'bulanDibayar' => $bulanDibayar,
                    'tunggakan' => $tunggakan,
                    'pembayaran' => $pembayaran,
                ]);

                return $pdf->download('Kuitansi-Pembayaran-' .$p->nisn.'.pdf');
        }
}
