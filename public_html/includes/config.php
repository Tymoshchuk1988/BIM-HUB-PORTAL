<?php
// Проста конфігурація
define('DB_HOST', 'localhost');
define('DB_NAME', 'bimhub_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('BASE_URL', 'https://bimhub.site');

// Функція для підключення до БД
function getDBConnection() {
    try {
        $conn = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        return $conn;
    } catch (PDOException $e) {
        die("Помилка підключення до БД: " . $e->getMessage());
    }
}

// Функція для перенаправлення
function redirect($url) {
    header("Location: $url");
    exit();
}

// Функція для перевірки авторизації
function requireAuth() {
    if (!isset($_SESSION['user_id'])) {
        redirect('/login.php');
    }
}

// Стартуємо сесію
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
