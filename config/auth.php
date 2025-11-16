<?php

return [


    'defaults' => [
    'guard' => 'petugas',
    'passwords' => 'users',
    ],

    'guards' => [
        'petugas' => [
            'driver' => 'session',
            'provider' => 'petugas',
        ],

        'siswa' => [
            'driver' => 'session',
            'provider' => 'siswa',
        ],
    ],


    'providers' => [
        'petugas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Petugas::class,
        ],

        'siswa' => [
            'driver' => 'eloquent',
            'model' => App\Models\Siswa::class,
        ],
    ],


    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
