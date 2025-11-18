<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps = false;
    protected $fillable = [
        'id_petugas',
        'nisn',
        'tgl_bayar',
        'bulan_dibayar',
        'tahun_dibayar',
        'id_spp',
        'jumlah_bayar',
    ];

    public function siswa(){
        return $this->belongsTo(Siswa::class, 'nisn','nisn');
    }

    public function petugas(){
        return $this->belongsTo(Petugas::class, 'id_petugas','id_petugas');
    }

    public function spp(){
        return $this->belongsTo(Spp::class, 'id_spp','id_spp');
    }
}
