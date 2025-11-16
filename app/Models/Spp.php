<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    protected $table = 'spp';
    protected $primaryKey = 'id_spp';
    public $timestamps = false;

    protected $fillable = [
        'tahun',
        'nominal'
    ];
}
