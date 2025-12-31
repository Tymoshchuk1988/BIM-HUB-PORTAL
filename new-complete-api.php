<?php
// /api/index.php - Повний API з авторизацією
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Обробка preflight запитів
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Конфігурація
$config = [
    'name' => 'BIM Hub Portal',
    'database' => [
        'host' => 'ec606796.mysql.tools',
        'database' => 'ec606796_bimhub',
        'username' => 'ec606796_bimhub',
        'password' => '(9ypA;7Ha6',
    ],
    'jwt_secret' => 'bimhub-secret-key-2025',
    'jwt_expire' => 86400 // 24 години
];

// Функція для відправки відповіді
function sendResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// Функція для отримання JSON з тіла запиту
function getJsonInput() {
    $input = file_get_contents('php://input');
    return json_decode($input, true) ?? [];
}

// Підключення до БД
function getDB() {
    global $config;
    static $db = null;
    
    if ($db === null) {
        try {
            $db = new PDO(
                "mysql:host={$config['database']['host']};dbname={$config['database']['database']};charset=utf8mb4",
                $config['database']['username'],
                $config['database']['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            sendResponse([
                'status' => 'error',
                'message' => 'Database connection failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    return $db;
}

// Отримання поточного шляху та методу
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Видаляємо /api з початку
$path = parse_url($requestUri, PHP_URL_PATH);
$apiPath = preg_replace('#^/api(/|$)#', '', $path);
$apiPath = trim($apiPath, '/');

// Маршрутизація
switch (true) {
    // Головна сторінка API
    case ($apiPath === '' && $requestMethod === 'GET'):
        apiInfo();
        break;
        
    // Статус системи
    case ($apiPath === 'status' && $requestMethod === 'GET'):
        apiStatus();
        break;
        
    // Проекти
    case ($apiPath === 'projects' && $requestMethod === 'GET'):
        getProjects();
        break;
        
    // Користувачі
    case ($apiPath === 'users' && $requestMethod === 'GET'):
        getUsers();
        break;
        
    // Авторизація
    case ($apiPath === 'auth/login' && $requestMethod === 'POST'):
        authLogin();
        break;
        
    // Реєстрація
    case ($apiPath === 'auth/register' && $requestMethod === 'POST'):
        authRegister();
        break;
        
    // 404 - не знайдено
    default:
        sendResponse([
            'status' => 'error',
            'message' => 'Endpoint not found',
            'path' => $apiPath ?: '/',
            'method' => $requestMethod,
            'available_endpoints' => [
                'GET /' => 'API information',
                'GET /status' => 'System status',
                'GET /projects' => 'List projects',
                'GET /users' => 'List users',
                'POST /auth/login' => 'User login',
                'POST /auth/register' => 'User registration'
            ]
        ], 404);
}

// ==================== API ФУНКЦІЇ ====================

function apiInfo() {
    global $config;
    
    sendResponse([
        'status' => 'success',
        'message' => 'BIM Hub API v2.0 is working!',
        'data' => [
            'name' => $config['name'],
            'version' => '2.0.0',
            'description' => 'BIM Hub Portal REST API',
            'endpoints' => [
                'GET /' => 'API information',
                'GET /status' => 'System status',
                'GET /projects' => 'List projects',
                'GET /users' => 'List users',
                'POST /auth/login' => 'User login',
                'POST /auth/register' => 'User registration'
            ],
            'timestamp' => date('Y-m-d H:i:s'),
            'server' => [
                'php_version' => phpversion(),
                'software' => $_SERVER['SERVER_SOFTWARE']
            ]
        ]
    ]);
}

function apiStatus() {
    $db = getDB();
    
    try {
        // Перевіряємо підключення
        $db->query('SELECT 1');
        $dbStatus = 'connected';
        
        // Отримуємо статистику
        $projectsCount = $db->query("SELECT COUNT(*) FROM projects")->fetchColumn();
        $usersCount = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $activeUsers = $db->query("SELECT COUNT(*) FROM users WHERE status = 'active'")->fetchColumn();
        
    } catch (Exception $e) {
        $dbStatus = 'disconnected: ' . $e->getMessage();
        $projectsCount = 0;
        $usersCount = 0;
        $activeUsers = 0;
    }
    
    sendResponse([
        'status' => 'success',
        'data' => [
            'system' => 'online',
            'database' => $dbStatus,
            'statistics' => [
                'projects' => (int)$projectsCount,
                'users_total' => (int)$usersCount,
                'users_active' => (int)$activeUsers
            ],
            'server_time' => date('Y-m-d H:i:s'),
            'php_version' => phpversion(),
            'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB',
            'uptime' => 'API доступно'
        ]
    ]);
}

function getProjects() {
    $db = getDB();
    
    try {
        // Отримуємо проекти
        $stmt = $db->query("
            SELECT p.*, u.full_name as creator_name 
            FROM projects p 
            LEFT JOIN users u ON p.created_by = u.id 
            ORDER BY p.created_at DESC 
            LIMIT 20
        ");
        $projects = $stmt->fetchAll();
        
        $total = $db->query("SELECT COUNT(*) FROM projects")->fetchColumn();
        
        sendResponse([
            'status' => 'success',
            'data' => [
                'projects' => $projects,
                'count' => count($projects),
                'total' => (int)$total,
                'pagination' => [
                    'page' => 1,
                    'per_page' => 20,
                    'total_pages' => ceil($total / 20)
                ]
            ]
        ]);
        
    } catch (Exception $e) {
        sendResponse([
            'status' => 'error',
            'message' => 'Failed to fetch projects',
            'error' => $e->getMessage()
        ], 500);
    }
}

function getUsers() {
    $db = getDB();
    
    try {
        // Отримуємо користувачів (без паролів)
        $stmt = $db->query("
            SELECT id, email, full_name, role, status, created_at 
            FROM users 
            ORDER BY created_at DESC 
            LIMIT 20
        ");
        $users = $stmt->fetchAll();
        
        sendResponse([
            'status' => 'success',
            'data' => [
                'users' => $users,
                'count' => count($users),
                'roles_distribution' => [
                    'admin' => $db->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn(),
                    'manager' => $db->query("SELECT COUNT(*) FROM users WHERE role = 'manager'")->fetchColumn(),
                    'bim_specialist' => $db->query("SELECT COUNT(*) FROM users WHERE role = 'bim_specialist'")->fetchColumn(),
                    'viewer' => $db->query("SELECT COUNT(*) FROM users WHERE role = 'viewer'")->fetchColumn()
                ]
            ]
        ]);
        
    } catch (Exception $e) {
        sendResponse([
            'status' => 'error',
            'message' => 'Failed to fetch users',
            'error' => $e->getMessage()
        ], 500);
    }
}

function authLogin() {
    $data = getJsonInput();
    
    // Валідація
    if (empty($data['email']) || empty($data['password'])) {
        sendResponse([
            'status' => 'error',
            'message' => 'Email and password are required'
        ], 400);
    }
    
    $db = getDB();
    
    try {
        // Шукаємо користувача
        $stmt = $db->prepare("
            SELECT id, email, password_hash, full_name, role 
            FROM users 
            WHERE email = ? AND status = 'active'
        ");
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch();
        
        if (!$user) {
            sendResponse([
                'status' => 'error',
                'message' => 'Invalid email or password'
            ], 401);
        }
        
        // Перевіряємо пароль
        if (!password_verify($data['password'], $user['password_hash'])) {
            sendResponse([
                'status' => 'error',
                'message' => 'Invalid email or password'
            ], 401);
        }
        
        // Оновлюємо час останнього входу
        $db->prepare("UPDATE users SET last_login_at = NOW() WHERE id = ?")
           ->execute([$user['id']]);
        
        // Генеруємо токен (спрощена версія JWT)
        global $config;
        $payload = [
            'user_id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role'],
            'iat' => time(),
            'exp' => time() + $config['jwt_expire']
        ];
        
        $token = base64_encode(json_encode($payload));
        
        sendResponse([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role']
                ],
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => $config['jwt_expire'],
                'expires_at' => date('Y-m-d H:i:s', time() + $config['jwt_expire'])
            ]
        ]);
        
    } catch (Exception $e) {
        sendResponse([
            'status' => 'error',
            'message' => 'Authentication failed',
            'error' => $e->getMessage()
        ], 500);
    }
}

function authRegister() {
    $data = getJsonInput();
    
    // Валідація
    $required = ['email', 'password', 'full_name'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            sendResponse([
                'status' => 'error',
                'message' => "Field '$field' is required"
            ], 400);
        }
    }
    
    // Перевірка email
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        sendResponse([
            'status' => 'error',
            'message' => 'Invalid email format'
        ], 400);
    }
    
    // Перевірка пароля
    if (strlen($data['password']) < 6) {
        sendResponse([
            'status' => 'error',
            'message' => 'Password must be at least 6 characters'
        ], 400);
    }
    
    $db = getDB();
    
    try {
        // Перевіряємо чи існує email
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$data['email']]);
        
        if ($stmt->fetch()) {
            sendResponse([
                'status' => 'error',
                'message' => 'Email already registered'
            ], 409);
        }
        
        // Хешуємо пароль
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Створюємо користувача
        $stmt = $db->prepare("
            INSERT INTO users (email, password_hash, full_name, role, status) 
            VALUES (?, ?, ?, ?, 'active')
        ");
        
        $stmt->execute([
            $data['email'],
            $passwordHash,
            $data['full_name'],
            $data['role'] ?? 'viewer'
        ]);
        
        $userId = $db->lastInsertId();
        
        sendResponse([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => [
                'user_id' => $userId,
                'email' => $data['email'],
                'full_name' => $data['full_name'],
                'role' => $data['role'] ?? 'viewer'
            ]
        ], 201);
        
    } catch (Exception $e) {
        sendResponse([
            'status' => 'error',
            'message' => 'Registration failed',
            'error' => $e->getMessage()
        ], 500);
    }
}
?>
