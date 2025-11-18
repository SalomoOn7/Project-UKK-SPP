<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
}
