<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('admin.laporan.index', compact('kelas'));
    }

    public function cari(Request $request)
    {
        $id_kelas = $request->id_kelas;

        $kelas = Kelas::all();
        $siswa = Siswa::with('spp', 'kelas')->where('id_kelas', $id_kelas)->get();

        return view('admin.laporan.index', compact('kelas', 'siswa', 'id_kelas'));
    }


    public function cetakPDF($id_kelas)
{
    $kelas = Kelas::findOrFail($id_kelas);

    $siswa = Siswa::with('spp', 'kelas')
        ->where('id_kelas', $id_kelas)
        ->get();

    $bulanList = [
        'Juli','Agustus','September','Oktober','November','Desember',
        'Januari','Februari','Maret','April','Mei','Juni'
    ];

    foreach ($siswa as $s) {

    $pembayaran = Pembayaran::where('nisn', $s->nisn)->get();

    $dataPerBulan = [];
    $totalBayar = 0;

    foreach ($bulanList as $bulan) {

        $pay = $pembayaran
                ->filter(fn($p) => stripos($p->bulan_dibayar, $bulan) !== false)
                ->first();

        if ($pay) {
            $jumlah = $pay->jumlah_bayar;
            $totalBayar += $jumlah;
        } else {
            $jumlah = 0;
        }

        $dataPerBulan[$bulan] = $jumlah;
    }

    $s->detail_bulan = $dataPerBulan;
    $s->totalBayar = $totalBayar;
    $s->tunggakan = ($s->spp->nominal * 12) - $totalBayar;
}


    $pdf = Pdf::loadView('admin.laporan.cetak', [
        'kelas' => $kelas,
        'siswa' => $siswa,
        'bulanList' => $bulanList,
    ])->setPaper('A4', 'landscape'); 

    return $pdf->stream('Laporan-SPP-Kelas-'.$kelas->nama_kelas.'.pdf');
}

}
