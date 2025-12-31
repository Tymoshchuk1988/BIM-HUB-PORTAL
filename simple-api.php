<?php
// /api/index.php - Спрощена версія
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Завантажуємо конфігурацію
$config = [
    'name' => 'BIM Hub Portal',
    'database' => [
        'host' => 'ec606796.mysql.tools',
        'database' => 'ec606796_bimhub',
        'username' => 'ec606796_bimhub',
        'password' => '(9ypA;7Ha6',
    ],
];

// Отримуємо шлях
$path = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Проста маршрутизація
if ($path === '/api/' && $method === 'GET') {
    echo json_encode([
        'status' => 'success',
        'message' => 'BIM Hub API v2.0',
        'data' => [
            'name' => 'BIM Hub Portal API',
            'version' => '2.0.0',
            'timestamp' => date('Y-m-d H:i:s'),
            'endpoints' => [
                'GET /api/' => 'Інформація про API',
                'GET /api/status' => 'Статус системи',
                'GET /api/projects' => 'Список проектів',
                'GET /api/users' => 'Список користувачів',
                'POST /api/auth/login' => 'Авторизація',
            ]
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// Статус
if ($path === '/api/status' && $method === 'GET') {
    // Перевірка БД
    try {
        $pdo = new PDO(
            "mysql:host={$config['database']['host']};dbname={$config['database']['database']};charset=utf8mb4",
            $config['database']['username'],
            $config['database']['password']
        );
        $dbStatus = 'connected';
        $projectsCount = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
        $usersCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    } catch (Exception $e) {
        $dbStatus = 'disconnected: ' . $e->getMessage();
        $projectsCount = 0;
        $usersCount = 0;
    }
    
    echo json_encode([
        'status' => 'success',
        'data' => [
            'system' => 'online',
            'database' => $dbStatus,
            'server_time' => date('Y-m-d H:i:s'),
            'php_version' => phpversion(),
            'projects_count' => $projectsCount,
            'users_count' => $usersCount,
            'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB'
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// Проекти
if ($path === '/api/projects' && $method === 'GET') {
    try {
        $pdo = new PDO(
            "mysql:host={$config['database']['host']};dbname={$config['database']['database']};charset=utf8mb4",
            $config['database']['username'],
            $config['database']['password']
        );
        
        $stmt = $pdo->query("
            SELECT p.*, u.full_name as creator_name 
            FROM projects p 
            LEFT JOIN users u ON p.created_by = u.id 
            ORDER BY p.created_at DESC 
            LIMIT 10
        ");
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $total = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
        
        echo json_encode([
            'status' => 'success',
            'data' => [
                'projects' => $projects,
                'count' => count($projects),
                'total' => $total
            ]
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error',
            'error' => $e->getMessage()
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    exit;
}

// Користувачі
if ($path === '/api/users' && $method === 'GET') {
    try {
        $pdo = new PDO(
            "mysql:host={$config['database']['host']};dbname={$config['database']['database']};charset=utf8mb4",
            $config['database']['username'],
            $config['database']['password']
        );
        
        $stmt = $pdo->query("
            SELECT id, email, full_name, role, status, created_at 
            FROM users 
            ORDER BY created_at DESC 
            LIMIT 10
        ");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'status' => 'success',
            'data' => [
                'users' => $users,
                'count' => count($users)
            ]
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error',
            'error' => $e->getMessage()
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    exit;
}

// Авторизація
if ($path === '/api/auth/login' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['email']) || !isset($input['password'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email and password are required'
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    try {
        $pdo = new PDO(
            "mysql:host={$config['database']['host']};dbname={$config['database']['database']};charset=utf8mb4",
            $config['database']['username'],
            $config['database']['password']
        );
        
        $stmt = $pdo->prepare("SELECT id, email, password_hash, full_name, role FROM users WHERE email = ? AND status = 'active'");
        $stmt->execute([$input['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user || !password_verify($input['password'], $user['password_hash'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            exit;
        }
        
        // Генеруємо простий токен
        $token = base64_encode(json_encode([
            'user_id' => $user['id'],
            'email' => $user['email'],
            'exp' => time() + 86400
        ]));
        
        echo json_encode([
            'status' => 'success',
            'data' => [
                'user' => [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role']
                ],
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 86400
            ]
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Authentication failed',
            'error' => $e->getMessage()
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    exit;
}

// 404 - не знайдено
http_response_code(404);
echo json_encode([
    'status' => 'error',
    'message' => 'Endpoint not found',
    'path' => $path,
    'method' => $method
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
