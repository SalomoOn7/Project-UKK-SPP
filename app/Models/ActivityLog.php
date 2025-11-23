<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model{

    public $timestamps = false;
     protected $fillable = [
        'user_id',
        'user_type',
        'aktivitas',
        'waktu',
        'ip_address',
        'user_agent'
    ];
}
