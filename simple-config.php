<?php
// SUPER SIMPLE config.php для тестування
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Налаштування бази даних - ПРЯМІ ЗНАЧЕННЯ
$db_host = 'ec606796.mysql.tools';
$db_name = 'ec606796_bimhub';
$db_user = 'ec606796_bimhub';
$db_pass = '(9ypA;7Ha6';

// Змінні для сайту
$site_url = 'https://bimhub.site';
$site_name = 'BIM Hub Portal';

// Стартуємо сесію
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// НАДІЙНА функція підключення до БД
function getDB() {
    global $db_host, $db_name, $db_user, $db_pass;
    
    static $db = null;
    
    if ($db === null) {
        try {
            // Підключення PDO з явними налаштуваннями
            $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
            $db = new PDO($dsn, $db_user, $db_pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
            
            // Додаткова команда для коректної роботи з UTF-8
            $db->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
            
        } catch (PDOException $e) {
            // Зберігаємо помилку у сесії
            if (session_status() === PHP_SESSION_ACTIVE) {
                $_SESSION['db_error'] = "Не вдалося підключитися до бази даних: " . $e->getMessage();
            }
            error_log("Database connection failed: " . $e->getMessage());
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
        header('Location: login.php');
        exit;
    }
}

// Перевірка ролі користувача
function requireRole($requiredRole) {
    requireAuth();
    if ($_SESSION['user_role'] !== $requiredRole) {
        header('Location: index.php');
        exit;
    }
}

// Хешування пароля
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Перевірка пароля
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Тестова функція для перевірки підключення
function testDatabaseConnection() {
    $db = getDB();
    if (!$db) {
        return false;
    }
    
    try {
        $result = $db->query("SELECT 1 as test")->fetch();
        return isset($result['test']) && $result['test'] == 1;
    } catch (Exception $e) {
        return false;
    }
}
?>
