<?php

return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'nasabah'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'nasabah',
        ],
    ],

    'providers' => [
        'nasabah' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\Nasabah::class),
        ],
    ],

    'passwords' => [
        'nasabah' => [
            'provider' => 'nasabah',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
