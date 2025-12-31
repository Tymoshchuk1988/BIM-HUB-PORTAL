<?php

return [
    'host' => getenv('DB_HOST') ?: 'db',
    'port' => getenv('DB_PORT') ?: 5432,
    'database' => getenv('DB_DATABASE') ?: 'bimhub_portal',
    'username' => getenv('DB_USERNAME') ?: 'bimhub_portal',
    'password' => getenv('DB_PASSWORD') ?: 'bimhub_portal_pass',
    'charset' => 'utf8',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];
