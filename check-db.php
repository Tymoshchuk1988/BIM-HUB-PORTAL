<?php
// Тестування підключення до бази на хостингу
$host = 'localhost'; // або IP хостингу
$dbname = 'ec606796_bimhub'; // припустима назва бази
$user = 'ec606796_bimhub'; // припустимий користувач
$pass = 'Tymoshchuk1988'; // ваш пароль

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Підключення до бази успішне!\n";
    
    // Перевіримо таблиці
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "📊 Знайдено таблиць: " . count($tables) . "\n";
    
    if (count($tables) > 0) {
        echo "📋 Таблиці:\n";
        foreach ($tables as $table) {
            echo "  - $table\n";
        }
    }
    
} catch (PDOException $e) {
    echo "❌ Помилка підключення: " . $e->getMessage() . "\n";
    
    // Якщо бази немає, запропонуємо створити
    echo "\n💡 Рекомендації:\n";
    echo "1. Створіть базу через cPanel/phpMyAdmin\n";
    echo "2. Назва бази: ec606796_bimhub\n";
    echo "3. Користувач: ec606796_bimhub\n";
    echo "4. Пароль: Tymoshchuk1988\n";
}
?>
