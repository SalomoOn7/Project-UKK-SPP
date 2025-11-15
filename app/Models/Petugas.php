<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Petugas extends Authenticatable
{
    use Notifiable;

    protected $table = 'petugas';

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
