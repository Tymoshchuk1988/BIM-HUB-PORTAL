#!/bin/bash

echo "🏗️ Створення базових файлів архітектури..."

# 1. config/app.php
cat > config-app.php << 'CONFIG_EOF'
<?php
// config/app.php - Основна конфігурація додатка
return [
    'name' => 'BIM Hub Portal',
    'env' => 'production',
    'debug' => false,
    'url' => 'https://bimhub.site',
    'timezone' => 'Europe/Kyiv',
    
    // Налаштування бази даних
    'database' => [
        'host' => 'ec606796.mysql.tools',
        'database' => 'ec606796_bimhub',
        'username' => 'ec606796_bimhub',
        'password' => '(9ypA;7Ha6',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
    ],
    
    // Налаштування автентифікації
    'auth' => [
        'jwt_secret' => 'bimhub-portal-secret-key-2025-change-in-production',
        'jwt_expire' => 86400, // 24 години
    ],
    
    // API налаштування
    'api' => [
        'version' => 'v1',
        'prefix' => 'api',
        'rate_limit' => 100,
    ],
];
?>
CONFIG_EOF

# 2. src/Core/Application.php
cat > src-core-application.php << 'APP_EOF'
<?php
// src/Core/Application.php - Основний клас додатка
namespace BIMHub\Core;

class Application
{
    private static $instance;
    private $config = [];
    private $services = [];
    
    private function __construct()
    {
        // Завантаження конфігурації
        $this->loadConfig();
    }
    
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function loadConfig(): void
    {
        $configPath = __DIR__ . '/../../config/app.php';
        if (file_exists($configPath)) {
            $this->config = require $configPath;
        }
    }
    
    public function getConfig(string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->config;
        }
        
        $keys = explode('.', $key);
        $value = $this->config;
        
        foreach ($keys as $k) {
            if (!is_array($value) || !array_key_exists($k, $value)) {
                return $default;
            }
            $value = $value[$k];
        }
        
        return $value;
    }
    
    public function setService(string $name, $service): void
    {
        $this->services[$name] = $service;
    }
    
    public function getService(string $name)
    {
        return $this->services[$name] ?? null;
    }
    
    public function run(): void
    {
        // Тут буде запуск додатка
        echo "BIM Hub Portal Application is running!";
    }
}
?>
APP_EOF

# 3. src/Core/Database.php
cat > src-core-database.php << 'DB_EOF'
<?php
// src/Core/Database.php - Клас для роботи з базою даних
namespace BIMHub\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance;
    private $connection;
    
    private function __construct()
    {
        $app = Application::getInstance();
        $config = $app->getConfig('database');
        
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
            $this->connection = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            
            // Встановлюємо часовий пояс
            $this->connection->exec("SET time_zone = '+02:00'");
            
        } catch (PDOException $e) {
            throw new \RuntimeException("Database connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection(): PDO
    {
        return $this->connection;
    }
    
    public function table(string $table): QueryBuilder
    {
        return new QueryBuilder($this->connection, $table);
    }
    
    // Допоміжні методи
    public function selectOne(string $sql, array $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }
    
    public function selectAll(string $sql, array $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function execute(string $sql, array $params = []): int
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
    
    public function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }
}

class QueryBuilder
{
    private $connection;
    private $table;
    private $conditions = [];
    private $params = [];
    
    public function __construct(PDO $connection, string $table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }
    
    public function where(string $column, string $operator, $value): self
    {
        $this->conditions[] = "$column $operator ?";
        $this->params[] = $value;
        return $this;
    }
    
    public function get(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(' AND ', $this->conditions);
        }
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchAll();
    }
}
?>
DB_EOF

# 4. public/api/index.php
cat > public-api-index.php << 'API_EOF'
<?php
// public/api/index.php - Вхідна точка API
require_once __DIR__ . '/../../config/app.php';

// Налаштування заголовків для API
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Обробка preflight запитів
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Простий маршрутизатор API
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Видаляємо префікс /api
$apiPath = str_replace('/api', '', parse_url($requestUri, PHP_URL_PATH));

// Проста маршрутизація
$routes = [
    'GET /' => 'getApiInfo',
    'GET /status' => 'getStatus',
    'POST /auth/login' => 'authLogin',
    'GET /projects' => 'getProjects',
];

$routeKey = "$requestMethod $apiPath";

if (isset($routes[$routeKey])) {
    $functionName = $routes[$routeKey];
    $response = $functionName();
} else {
    http_response_code(404);
    $response = [
        'status' => 'error',
        'message' => 'Endpoint not found',
        'path' => $apiPath
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Функції API
function getApiInfo(): array
{
    return [
        'status' => 'success',
        'data' => [
            'name' => 'BIM Hub Portal API',
            'version' => '1.0.0',
            'description' => 'API для BIM Hub Portal - Building Information Modeling platform',
            'endpoints' => [
                'GET /api' => 'Інформація про API',
                'GET /api/status' => 'Статус системи',
                'POST /api/auth/login' => 'Авторизація',
                'GET /api/projects' => 'Список проектів',
            ]
        ]
    ];
}

function getStatus(): array
{
    return [
        'status' => 'success',
        'data' => [
            'system' => 'online',
            'timestamp' => date('c'),
            'php_version' => phpversion(),
            'server' => $_SERVER['SERVER_SOFTWARE'],
        ]
    ];
}

function authLogin(): array
{
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data || !isset($data['email']) || !isset($data['password'])) {
        http_response_code(400);
        return [
            'status' => 'error',
            'message' => 'Email та пароль обов\'язкові'
        ];
    }
    
    // Тут буде реальна автентифікація
    return [
        'status' => 'success',
        'data' => [
            'message' => 'Автентифікація успішна (демо)',
            'email' => $data['email'],
            'token' => 'demo-jwt-token-' . time(),
            'expires_in' => 86400
        ]
    ];
}

function getProjects(): array
{
    // Підключення до бази даних
    $config = require __DIR__ . '/../../config/app.php';
    $dbConfig = $config['database'];
    
    try {
        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset={$dbConfig['charset']}";
        $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
        
        $stmt = $pdo->query("SELECT id, name, description, status, created_at FROM projects LIMIT 10");
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'status' => 'success',
            'data' => [
                'projects' => $projects,
                'count' => count($projects),
                'total' => $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn()
            ]
        ];
        
    } catch (PDOException $e) {
        http_response_code(500);
        return [
            'status' => 'error',
            'message' => 'Database error',
            'error' => $e->getMessage()
        ];
    }
}
?>
API_EOF

echo "✅ Створено файли базової архітектури"
