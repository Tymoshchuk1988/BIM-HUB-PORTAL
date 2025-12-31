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
