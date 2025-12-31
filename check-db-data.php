<?php
// Перевірка даних у базі
$host = 'ec606796.mysql.tools';
$dbname = 'ec606796_bimhub';
$username = 'ec606796_bimhub';
$password = '(9ypA;7Ha6';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    echo "<h2>📊 Перевірка даних у базі</h2>";
    
    // 1. Користувачі
    $users = $pdo->query("SELECT id, email, full_name, role, created_at FROM users ORDER BY id")->fetchAll();
    echo "<h3>👥 Користувачі (" . count($users) . "):</h3>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Email</th><th>Ім'я</th><th>Роль</th><th>Дата створення</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . $user['id'] . "</td>";
        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
        echo "<td>" . htmlspecialchars($user['full_name']) . "</td>";
        echo "<td>" . htmlspecialchars($user['role']) . "</td>";
        echo "<td>" . $user['created_at'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 2. Проекти
    $projects = $pdo->query("SELECT COUNT(*) as count FROM projects")->fetch();
    echo "<h3>🏗️ Проекти: " . $projects['count'] . "</h3>";
    
    // 3. Тест пароля адміна
    echo "<h3>🔑 Тест пароля адміна:</h3>";
    $admin = $pdo->query("SELECT password_hash FROM users WHERE email = 'admin@bimhub.site'")->fetch();
    
    if ($admin) {
        // Перевіряємо пароль
        $test_password = 'Admin@123';
        if (password_verify($test_password, $admin['password_hash'])) {
            echo "<p style='color:green'>✅ Пароль адміна вірний!</p>";
        } else {
            echo "<p style='color:red'>❌ Пароль адміна невірний!</p>";
            echo "<p>Хеш у базі: " . substr($admin['password_hash'], 0, 50) . "...</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Адміна не знайдено!</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Помилка підключення: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
