<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Siswa extends Authenticatable
{
    use Notifiable;

    protected $table = 'siswa';
    protected $primaryKey = 'nisn';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'nisn',
        'nis',
        'nama',
        'username',
        'password',
        'id_kelas',
        'alamat',
        'no_telp',
        'id_spp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function kelas(){
        return $this->belongsTo(Kelas::class, 'id_kelas','id_kelas');
    }
    public function spp(){
        return $this->belongsTo(Spp::class, 'id_spp','id_spp');
    }
}
