<?php

return [
    'email' => env('ADMIN_EMAIL', 'admin@example.com'),
    'password' => env('ADMIN_PASSWORD', 'password'),
    'token_lifetime' => (int)env('ADMIN_TOKEN_LIFETIME', 86400), // 24 saat
    /*
    |--------------------------------------------------------------------------
    | Dosya Yükleme Ayarları
    |--------------------------------------------------------------------------
    */
    'upload' => [
        'image' => [
            'mimes' => explode(',', env('UPLOAD_IMAGE_MIMES', 'jpeg,png,jpg,gif,webp')),
            'max_size' => env('UPLOAD_IMAGE_MAX_SIZE', 2048), // KB cinsinden (2MB)
            'min_size' => env('UPLOAD_IMAGE_MIN_SIZE', 10), // KB cinsinden
        ],
        'cv' => [
            'mimes' => explode(',', env('UPLOAD_CV_MIMES', 'pdf,doc,docx')),
            'max_size' => env('UPLOAD_CV_MAX_SIZE', 5120), // KB cinsinden (5MB)
        ],
    ],
    'contact' => [
        'email' => env('ADMIN_EMAIL', 'admin@example.com'),
        'throttle' => [
            'max_attempts' => env('CONTACT_MAX_ATTEMPTS', 3),
            'decay_minutes' => env('CONTACT_DECAY_MINUTES', 60)
        ]
    ],
]; 