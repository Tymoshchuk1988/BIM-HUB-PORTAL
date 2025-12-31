#!/bin/bash
# 🚀 BIM HUB - ШВИДКИЙ ДЕПЛОЙ З БАЗОЮ

echo "========================================="
echo "🚀 ШВИДКИЙ ДЕПЛОЙ BIM HUB PORTAL"
echo "========================================="

# Використовуємо існуючий скрипт деплою
./deploy-final.sh

echo ""
echo "🛠️  ДОДАЄМО БАЗУ ДАНИХ..."
echo "-----------------------------------------"

# Створюємо простий файл конфігурації
cat > db-config.php << 'CFG'
<?php
// Проста конфігурація для локальної розробки
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
    // Локальна розробка
    return [
        'host' => 'localhost',
        'dbname' => 'bimhub_portal',
        'user' => 'root',
        'pass' => '',
        'type' => 'mysql'
    ];
} else {
    // Продакшен (bimhub.site)
    return [
        'host' => 'localhost',
        'dbname' => 'ec606796_bimhub',
        'user' => 'ec606796_bimhub',
        'pass' => 'Tymoshchuk1988',
        'type' => 'mysql'
    ];
}
CFG

# Завантажуємо на хостинг
sshpass -p "Tymoshchuk1988" scp db-config.php ec606796@ec606796.ftp.tools:/home/ec606796/bimhub.site/www/config-db.php

# Створюємо просту сторінку для тесту бази
cat > test-db-online.php << 'TEST'
<?php
header('Content-Type: text/html; charset=utf-8');
echo "<h1>BIM Hub - Тест бази даних</h1>";

$config = require 'config-db.php';

try {
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $config['user'], $config['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Підключення до бази успішне!</p>";
    
    // Перевіримо таблиці
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "<p>📭 Таблиць не знайдено. Створюємо...</p>";
        
        // Прості таблиці
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) UNIQUE,
                name VARCHAR(255),
                role VARCHAR(50) DEFAULT 'viewer'
            )
        ");
        
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS projects (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255),
                description TEXT,
                status VARCHAR(50) DEFAULT 'active'
            )
        ");
        
        echo "<p>✅ Базові таблиці створені</p>";
    } else {
        echo "<p>📊 Знайдено таблиць: " . count($tables) . "</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Помилка: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>ℹ️ Базу даних потрібно створити через cPanel або phpMyAdmin</p>";
}
TEST

# Завантажуємо тест
sshpass -p "Tymoshchuk1988" scp test-db-online.php ec606796@ec606796.ftp.tools:/home/ec606796/bimhub.site/www/test-db.php

# Очищуємо тимчасові файли
rm -f db-config.php test-db-online.php

echo ""
echo "✅ ДЕПЛОЙ З БАЗОЮ ДАНИХ ЗАВЕРШЕНО!"
echo ""
echo "🌐 Тестування:"
echo "   • Сайт: https://bimhub.site"
echo "   • Тест БД: https://bimhub.site/test-db.php"
echo ""
echo "💡 Якщо бази немає, створіть її через cPanel:"
echo "   1. Залогіньтесь в cPanel"
echo "   2. Знайдіть 'MySQL Databases'"
echo "   3. Створіть базу: ec606796_bimhub"
echo "   4. Створіть користувача: ec606796_bimhub"
echo "   5. Надайте всі права"
echo "   6. Пароль: Tymoshchuk1988"
