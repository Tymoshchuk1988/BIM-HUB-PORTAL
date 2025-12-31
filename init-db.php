<?php
// Скрипт ініціалізації бази даних
require_once 'config.php';
$config = require 'config.php';

try {
    // Підключення без вибору бази
    $pdo = new PDO(
        "mysql:host={$config['host']}",
        $config['username'],
        $config['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Створення бази якщо не існує
    $pdo->exec("CREATE DATABASE IF NOT EXISTS {$config['database']} 
                CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ База даних створена/перевірена\n";
    
    // Використання бази
    $pdo->exec("USE {$config['database']}");
    
    // Виконання SQL з файлу
    $sql = file_get_contents('create-tables.sql');
    $pdo->exec($sql);
    
    echo "✅ Таблиці створені\n";
    echo "✅ Демо дані додані\n";
    
} catch (PDOException $e) {
    echo "❌ Помилка: " . $e->getMessage() . "\n";
}
