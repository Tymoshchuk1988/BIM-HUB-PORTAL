<?php
require_once 'config.php';

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Результат входу</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .ok { color: green; background: #e8f5e9; padding: 15px; border-radius: 5px; }
        .error { color: red; background: #ffebee; padding: 15px; border-radius: 5px; }
        .info { color: blue; background: #e3f2fd; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🔐 Результат спроби входу</h1>";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<p class='error'>❌ Недійсний метод запиту</p>";
    echo "<a href='simple-login.php'>← Назад</a>";
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    echo "<p class='error'>❌ Будь ласка, заповніть всі поля</p>";
    echo "<a href='simple-login.php'>← Назад</a>";
    exit;
}

$db = getDB();
if (!$db) {
    echo "<p class='error'>❌ Помилка підключення до бази даних</p>";
    echo "<a href='simple-login.php'>← Назад</a>";
    exit;
}

try {
    // Шукаємо користувача
    $stmt = $db->prepare("SELECT id, email, password_hash, full_name, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if (!$user) {
        echo "<p class='error'>❌ Користувача з таким email не знайдено</p>";
        echo "<p>Перевірте правильність email</p>";
        echo "<a href='simple-login.php'>← Назад</a>";
        exit;
    }
    
    // Перевіряємо пароль
    if (password_verify($password, $user['password_hash'])) {
        // Успішний вхід
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role'];
        
        echo "<div class='ok'>";
        echo "<h2>✅ ВХІД УСПІШНИЙ!</h2>";
        echo "<p>Ім'я: <strong>" . htmlspecialchars($user['full_name']) . "</strong></p>";
        echo "<p>Email: <strong>" . htmlspecialchars($user['email']) . "</strong></p>";
        echo "<p>Роль: <strong>" . htmlspecialchars($user['role']) . "</strong></p>";
        echo "</div>";
        
        echo "<br>";
        echo "<a href='dashboard.php' style='background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>➡️ Перейти до панелі управління</a>";
        
        // Автоматичне перенаправлення через 3 секунди
        echo "<script>
            setTimeout(function() {
                window.location.href = 'dashboard.php';
            }, 3000);
        </script>";
        
    } else {
        echo "<p class='error'>❌ Невірний пароль</p>";
        echo "<a href='simple-login.php'>← Назад</a>";
    }
    
} catch (PDOException $e) {
    echo "<p class='error'>❌ Помилка запиту: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<a href='simple-login.php'>← Назад</a>";
}

echo "</body></html>";
?>
