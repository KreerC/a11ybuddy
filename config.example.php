<?php

return [
    'db' => [
        'host' => 'localhost',
        'dbname' => 'database',
        'username' => 'username',
        'password' => 'password'
    ],
    'mail' => [
        'host' => 'smtp.example.com',
        'username' => 'username',
        'password' => 'password',
        'port' => 587,
        'from' => 'noreply@a11ybuddy.invalid',
        'fromName' => 'a11yBuddy'
    ],
    'app' => [
        'url' => 'http://localhost',
        'name' => 'a11yBuddy'
    ],
    'languages' => [
        'en' => 'English',
        'de' => 'Deutsch'
    ],
    'custom_pages' => [
        '/example' => [
            'files' => [
                'en' => 'pages/example.md',
                'de' => 'pages/example.de.md'
            ],
            'type' => 'markdown'
        ],
    ],
    'footer' => [
        "links" => [
            "en" => [
                "/example" => "Example custom page",
            ]
        ]
    ]
];