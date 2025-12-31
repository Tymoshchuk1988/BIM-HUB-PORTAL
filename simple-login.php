<?php
require_once 'config.php';

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Тест підключення</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .ok { color: green; background: #e8f5e9; padding: 10px; border-radius: 5px; }
        .error { color: red; background: #ffebee; padding: 10px; border-radius: 5px; }
        .warning { color: orange; background: #fff3e0; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🧪 Тестування підключення до БД</h1>";

// Тест 1: Перевірка сесії
echo "<h2>1. Перевірка сесії</h2>";
if (session_status() === PHP_SESSION_ACTIVE) {
    echo "<p class='ok'>✅ Сесія активна</p>";
} else {
    echo "<p class='error'>❌ Сесія не активна</p>";
}

// Тест 2: Підключення до БД
echo "<h2>2. Підключення до бази даних</h2>";
$db = getDB();
if ($db) {
    echo "<p class='ok'>✅ Підключення до БД успішне</p>";
    
    // Тест 3: Простий запит
    try {
        echo "<h2>3. Тестовий запит</h2>";
        $stmt = $db->query("SELECT COUNT(*) as user_count FROM users");
        $result = $stmt->fetch();
        echo "<p class='ok'>✅ Запит виконано успішно</p>";
        echo "<p>Користувачів у базі: <strong>" . $result['user_count'] . "</strong></p>";
        
        // Тест 4: Перевірка адмін обліковки
        echo "<h2>4. Перевірка адміністратора</h2>";
        $stmt = $db->query("SELECT email, full_name, role FROM users WHERE email = 'admin@bimhub.site'");
        $admin = $stmt->fetch();
        
        if ($admin) {
            echo "<p class='ok'>✅ Адмін знайдений</p>";
            echo "<p>Email: " . $admin['email'] . "</p>";
            echo "<p>Ім'я: " . $admin['full_name'] . "</p>";
            echo "<p>Роль: " . $admin['role'] . "</p>";
        } else {
            echo "<p class='warning'>⚠️ Адмін не знайдений, але це може бути нормально</p>";
        }
        
    } catch (PDOException $e) {
        echo "<p class='error'>❌ Помилка запиту: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p class='error'>❌ Не вдалося підключитися до БД</p>";
    
    // Показуємо помилку з сесії якщо є
    if (isset($_SESSION['db_error'])) {
        echo "<p class='error'>Деталі: " . htmlspecialchars($_SESSION['db_error']) . "</p>";
        unset($_SESSION['db_error']);
    }
}

// Тест 5: Форма входу
echo "<h2>5. Форма входу</h2>";
echo "<form method='POST' action='login-action.php'>
    <div>
        <label>Email:</label><br>
        <input type='email' name='email' value='admin@bimhub.site' required>
    </div>
    <div>
        <label>Пароль:</label><br>
        <input type='password' name='password' value='Admin@123' required>
    </div>
    <br>
    <button type='submit'>Увійти</button>
</form>";

echo "</body></html>";
?>
