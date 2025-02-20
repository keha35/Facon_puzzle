<?php

return [
    // Configuration générale de l'application
    'name' => 'Façon Puzzle',
    'url' => $_ENV['APP_URL'] ?? 'http://localhost/Facon_puzzle-new',
    'base_path' => $_ENV['APP_BASE_PATH'] ?? '/Facon_puzzle-new/public',
    'env' => $_ENV['APP_ENV'] ?? 'development',
    'debug' => $_ENV['APP_DEBUG'] === 'true',
    'timezone' => 'Europe/Paris',
    'locale' => 'fr',

    // Configuration des uploads
    'uploads' => [
        'directory' => __DIR__ . '/../../public/uploads',
        'max_size' => 10 * 1024 * 1024, // 10 MB
        'allowed_types' => ['image/jpeg', 'image/png', 'image/webp'],
        'max_dimensions' => [
            'width' => 4096,
            'height' => 4096
        ]
    ],

    // Configuration des puzzles
    'puzzles' => [
        'min_pieces' => 20,
        'max_pieces' => 2000,
        'default_pieces' => 500,
        'shapes' => ['rectangle', 'circle', 'heart', 'custom'],
        'materials' => ['standard', 'premium', 'wood'],
        'sizes' => [
            'small' => ['width' => 30, 'height' => 20],
            'medium' => ['width' => 45, 'height' => 30],
            'large' => ['width' => 60, 'height' => 40]
        ]
    ],

    // Configuration du cache
    'cache' => [
        'driver' => 'file',
        'path' => __DIR__ . '/../../var/cache',
        'lifetime' => 3600
    ],

    // Configuration des sessions
    'session' => [
        'name' => 'facon_puzzle_session',
        'lifetime' => 7200,
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax'
    ],

    // Configuration des emails
    'mail' => [
        'from' => [
            'address' => $_ENV['MAIL_FROM_ADDRESS'] ?? 'contact@faconpuzzle.fr',
            'name' => $_ENV['MAIL_FROM_NAME'] ?? 'Façon Puzzle'
        ],
        'reply_to' => [
            'address' => $_ENV['MAIL_REPLY_TO_ADDRESS'] ?? 'support@faconpuzzle.fr',
            'name' => $_ENV['MAIL_REPLY_TO_NAME'] ?? 'Support Façon Puzzle'
        ]
    ]
]; 