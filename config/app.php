<?php
return [
    'name' => 'BIM Hub Portal',
    'env' => getenv('APP_ENV') ?: 'production',
    'debug' => filter_var(getenv('APP_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN),
    'url' => getenv('APP_URL') ?: 'https://bimhub.site',
    'timezone' => 'Europe/Kiev',
    'locale' => 'uk',
    'fallback_locale' => 'en',
    
    'providers' => [
        // Core providers
        \BIMHub\Core\Database::class,
        
        // Module providers
        \BIMHub\Modules\Auth\Providers\AuthServiceProvider::class,
        \BIMHub\Modules\Projects\Providers\ProjectServiceProvider::class,
    ],
    
    'middleware' => [
        'web' => [
            \BIMHub\Middleware\CorsMiddleware::class,
            \BIMHub\Middleware\LoggingMiddleware::class,
        ],
        
        'api' => [
            \BIMHub\Middleware\CorsMiddleware::class,
            \BIMHub\Middleware\JsonMiddleware::class,
            \BIMHub\Middleware\LoggingMiddleware::class,
        ],
        
        'auth' => [
            \BIMHub\Middleware\AuthMiddleware::class,
        ],
    ],
];
