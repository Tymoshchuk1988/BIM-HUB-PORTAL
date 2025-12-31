<?php

require_once __DIR__ . '/../src/Core/Database.php';

use BIMHub\Core\Database;
use BIMHub\Database\Seeders\DatabaseSeeder;

// Завантажуємо конфігурацію
$config = require __DIR__ . '/../config/database.php';

// Ініціалізуємо базу даних
$database = new Database($config);

// Запускаємо сидер
$seeder = new DatabaseSeeder($database);
$seeder->run();
