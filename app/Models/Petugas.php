<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Petugas extends Authenticatable
{
    use Notifiable;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';
    public $incrementing = true; 
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = [
        'username',
        'password',
        'nama_petugas',
        'level',
    ];

    protected $hidden = [
        'password',
    ];
}
