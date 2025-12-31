<?php
declare(strict_types=1);

use BIMHub\Core\Application;

if (!function_exists('app')) {
    function app(): Application
    {
        return Application::getInstance();
    }
}

if (!function_exists('config')) {
    function config(string $key, $default = null)
    {
        return app()->getConfig($key, $default);
    }
}

if (!function_exists('db')) {
    function db(): \BIMHub\Core\Database
    {
        return app()->getDatabase();
    }
}

if (!function_exists('env')) {
    function env(string $key, $default = null)
    {
        $value = getenv($key);
        
        if ($value === false) {
            return $default;
        }
        
        // Конвертація спеціальних значень
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'null':
            case '(null)':
                return null;
            case 'empty':
            case '(empty)':
                return '';
        }
        
        return $value;
    }
}

if (!function_exists('storage_path')) {
    function storage_path(string $path = ''): string
    {
        $basePath = dirname(__DIR__, 3) . '/storage';
        return $basePath . ($path ? DIRECTORY_SEPARATOR . ltrim($path, '/\\') : '');
    }
}

if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        $basePath = dirname(__DIR__, 3);
        return $basePath . ($path ? DIRECTORY_SEPARATOR . ltrim($path, '/\\') : '');
    }
}

if (!function_exists('response')) {
    function response($data = null, int $status = 200, array $headers = []): \BIMHub\Core\Http\Response
    {
        return new \BIMHub\Core\Http\Response($data, $status, $headers);
    }
}

if (!function_exists('json_response')) {
    function json_response($data, int $status = 200, array $headers = []): \BIMHub\Core\Http\JsonResponse
    {
        return new \BIMHub\Core\Http\JsonResponse($data, $status, $headers);
    }
}
