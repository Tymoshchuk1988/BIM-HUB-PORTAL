<?php
// config.php - Продакшен конфігурація для BIM Hub Portal
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Налаштування бази даних (продакшен)
define('DB_HOST', 'ec606796.mysql.tools');
define('DB_NAME', 'ec606796_bimhub');
define('DB_USER', 'ec606796_bimhub');
define('DB_PASS', '(9ypA;7Ha6');

// Налаштування сайту
define('SITE_URL', 'https://bimhub.site');
define('SITE_NAME', 'BIM Hub Portal');
define('TIMEZONE', 'Europe/Kiev');
date_default_timezone_set(TIMEZONE);

// Безпека
define('SESSION_NAME', 'BIMHUB_SESSION');
define('CSRF_TOKEN_NAME', 'bimhub_csrf');

// Починаємо сесію
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// Функція для підключення до БД
function getDB() {
    static $db = null;
    
    if ($db === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $db = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ]);
        } catch (PDOException $e) {
            // У продакшені логуємо помилку
            error_log("Database connection error: " . $e->getMessage());
            
            // Для користувача показуємо просте повідомлення
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                echo '<div style="padding:20px;background:#ffebee;color:#c62828;border:2px solid #c62828;margin:20px;border-radius:5px;">';
                echo '<h3>⚠️ Помилка системи</h3>';
                echo '<p>Не вдається підключитися до бази даних. Будь ласка, спробуйте пізніше.</p>';
                echo '<p><small>Якщо проблема триває, зверніться до адміністратора.</small></p>';
                echo '</div>';
            }
            return false;
        }
    }
    
    return $db;
}

// Перевірка авторизації
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
}

// Отримання поточного користувача
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'name' => $_SESSION['user_name'],
            'role' => $_SESSION['user_role']
        ];
    }
    return null;
}

// Перенаправлення якщо не авторизований
function requireAuth() {
    if (!isLoggedIn()) {
        header('Location: ' . SITE_URL . '/login.php');
        exit;
    }
}

// Перевірка ролі користувача
function requireRole($requiredRole) {
    requireAuth();
    if ($_SESSION['user_role'] !== $requiredRole) {
        header('Location: ' . SITE_URL . '/');
        exit;
    }
}

// Функція для хешування пароля
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Функція для перевірки пароля
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Захист від XSS
function cleanInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Генерація CSRF токена
function generateCSRFToken() {
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

// Перевірка CSRF токена
function verifyCSRFToken($token) {
    return isset($_SESSION[CSRF_TOKEN_NAME]) && 
           hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}
?>
