<?php
// Детальна перевірка бази даних
$config = [
    'host' => 'ec606796.mysql.tools',
    'dbname' => 'ec606796_bimhub',
    'user' => 'ec606796_bimhub',
    'pass' => '(9ypA;7Ha6'
];

echo "<h1>🔍 Детальна перевірка бази даних</h1>";
echo "<style>body{font-family:Arial;padding:20px} .success{background:#d4edda;padding:15px;border-radius:5px} .error{background:#f8d7da;padding:15px;border-radius:5px}</style>";

try {
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    echo "<div class='success'>";
    echo "<h2>✅ База даних доступна!</h2>";
    
    // Інформація про сервер
    echo "<h3>📊 Інформація про сервер:</h3>";
    echo "<p><strong>MySQL версія:</strong> " . $pdo->query('SELECT VERSION()')->fetchColumn() . "</p>";
    echo "<p><strong>Поточний користувач:</strong> " . $pdo->query('SELECT CURRENT_USER()')->fetchColumn() . "</p>";
    echo "<p><strong>Поточна база:</strong> " . $pdo->query('SELECT DATABASE()')->fetchColumn() . "</p>";
    
    // Таблиці
    echo "<h3>🗄️ Таблиці в базі:</h3>";
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "<p style='color:orange'>⚠️ Таблиць не знайдено. База порожня.</p>";
    } else {
        echo "<table border='1' cellpadding='10' style='border-collapse:collapse'>";
        echo "<tr><th>Таблиця</th><th>Записів</th><th>Розмір</th></tr>";
        
        foreach ($tables as $table) {
            $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
            $size = $pdo->query("SELECT ROUND((data_length + index_length) / 1024, 2) as size_kb FROM information_schema.TABLES WHERE table_schema = DATABASE() AND table_name = '$table'")->fetchColumn();
            
            echo "<tr>";
            echo "<td>$table</td>";
            echo "<td>$count</td>";
            echo "<td>" . ($size ? $size . " KB" : "-") . "</td>";
            echo "</tr>";
            
            // Якщо це таблиця users, покажемо користувачів
            if ($table === 'users' && $count > 0) {
                $users = $pdo->query("SELECT id, email, role FROM users")->fetchAll();
                echo "<tr><td colspan='3' style='background:#f8f9fa'>";
                echo "<strong>Користувачі:</strong><br>";
                foreach ($users as $user) {
                    echo "• {$user['email']} ({$user['role']})<br>";
                }
                echo "</td></tr>";
            }
        }
        echo "</table>";
    }
    
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<div class='error'>";
    echo "<h2>❌ Помилка підключення!</h2>";
    echo "<p><strong>Повідомлення:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Деталі конфігурації:</strong></p>";
    echo "<pre>";
    print_r($config);
    echo "</pre>";
    echo "</div>";
}
?>
