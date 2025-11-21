<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SiswaPembayaranController extends Controller
{
    private function statusPembayaran($nisn) {
        $urutanBulan = [
            "Januari","Februari","Maret","April","Mei","Juni",
            "Juli","Agustus","September","Oktober","November","Desember"
        ];

        $bulanSudah = Pembayaran::where('nisn', $nisn)
            ->pluck('bulan_dibayar')
            ->toArray();

        $data = [];
        foreach ($urutanBulan as $bln) {
            $data[$bln] = in_array($bln, $bulanSudah) ? 'lunas' : 'belum';
        }

        return $data;
    }

    public function index()
    {
        $siswa = Auth::guard('siswa')->user();

        $status = $this->statusPembayaran($siswa->nisn);

        return view('siswa.pembayaran.index', [
            'siswa' => $siswa,
            'status' => $status
        ]);
    }

    public function history()
{
    $siswa = Auth::guard('siswa')->user();
    $pembayaran = Pembayaran::where('nisn', $siswa->nisn)
        ->orderBy('tgl_bayar', 'DESC')
        ->get();

    $totalBulan = $pembayaran->count();
    $totalBayar = $pembayaran->sum('jumlah_bayar');

    // Jika belum pernah bayar
    if ($pembayaran->isEmpty()) {
        return view('siswa.pembayaran.history', [
            'siswa' => $siswa,
            'pembayaran' => [],
            'belumBayar' => true,
            'totalBulan' => 0,      // <-- penting
            'totalBayar' => 0,      // <-- penting
        ]);
    }

    $tunggakan = ($siswa->spp->nominal * 12) - $totalBayar;

    return view('siswa.pembayaran.history', [
        'siswa' => $siswa,
        'pembayaran' => $pembayaran,
        'belumBayar' => false,
        'totalBayar' => $totalBayar,
        'tunggakan' => $tunggakan,
        'totalBulan' => $totalBulan
    ]);
}

    public function detail()
    {
        $siswa = Auth::guard('siswa')->user();
        $pembayaran = Pembayaran::where('nisn', $siswa->nisn)->get();
        $totalBulan = $pembayaran->count();

        if ($pembayaran->count() == 0) {
            return view('siswa.pembayaran.detail', [
                'siswa' => $siswa,
                'pembayaran' => [],
                'belumBayar' => true,
                'totalBulan' => 0,
                'totalBayar' => 0,
                'bulanSudah' => [],
                'bulanBelum' => [],
                'tunggakan' => $siswa->spp->nominal * 12
            ]);
        }
        $urutanBulan = [
            "Januari","Februari","Maret","April","Mei","Juni",
            "Juli","Agustus","September","Oktober","November","Desember"
        ];

        $sudah = $pembayaran->pluck('bulan_dibayar')->toArray();
        $belum = array_diff($urutanBulan, $sudah);

        $totalBayar = $pembayaran->sum('jumlah_bayar');
        $tunggakan = $siswa->spp->nominal * 12 - $totalBayar;

        return view('siswa.pembayaran.detail', [
            'siswa' => $siswa,
            'pembayaran' => $pembayaran,
            'bulanSudah' => $sudah,
            'bulanBelum' => $belum,
            'belumBayar' => false,
            'totalBayar' => $totalBayar,
            'tunggakan' => $tunggakan,
            'totalBulan' => $totalBulan
        ]);
    }
}
