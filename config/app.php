<?php

return [
    'app' => [
        'name' => 'Façon Puzzle',
        'url' => 'http://localhost',
        'env' => 'development'
    ],
    
    'database' => [
        'host' => 'localhost',
        'name' => 'facon_puzzle',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4'
    ],
    
    'uploads' => [
        'directory' => __DIR__ . '/../public/uploads',
        'max_size' => 10 * 1024 * 1024, // 10 Mo
        'allowed_types' => [
            'image/jpeg',
            'image/png',
            'image/gif'
        ],
        'max_dimensions' => [
            'width' => 4096,
            'height' => 4096
        ]
    ],
    
    'session' => [
        'name' => 'facon_puzzle_session',
        'lifetime' => 7200 // 2 heures
    ],
    
    'security' => [
        'salt' => 'votre_sel_secret_ici',
        'pepper' => 'votre_poivre_secret_ici'
    ]
]; 