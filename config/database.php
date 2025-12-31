<?php
return [
    'default' => getenv('DB_CONNECTION') ?: 'pgsql',
    
    'connections' => [
        'pgsql' => [
            'driver' => 'pgsql',
            'host' => getenv('DB_HOST') ?: 'db',
            'port' => getenv('DB_PORT') ?: 5432,
            'database' => getenv('DB_DATABASE') ?: 'bimhub',
            'username' => getenv('DB_USERNAME') ?: 'bimhub_user',
            'password' => getenv('DB_PASSWORD') ?: 'bimhub_password',
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],
        
        'mysql' => [
            'driver' => 'mysql',
            'host' => getenv('DB_HOST') ?: '127.0.0.1',
            'port' => getenv('DB_PORT') ?: 3306,
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'unix_socket' => getenv('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
    ],
    
    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],
    
    'redis' => [
        'client' => 'predis',
        'default' => [
            'host' => getenv('REDIS_HOST') ?: 'redis',
            'password' => getenv('REDIS_PASSWORD') ?: null,
            'port' => getenv('REDIS_PORT') ?: 6379,
            'database' => getenv('REDIS_DB') ?: 0,
        ],
    ],
];
