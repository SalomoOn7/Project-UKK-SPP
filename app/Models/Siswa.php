<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Siswa extends Authenticatable
{
    use Notifiable;

    protected $table = 'siswa';
    protected $primaryKey = 'nisn';
    public $incrementing = true; 
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = [
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
}
