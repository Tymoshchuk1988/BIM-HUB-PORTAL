<?php
declare(strict_types=1);

// Автозавантаження через Composer
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use BIMHub\Core\Application;

// Запуск додатку
$app = Application::getInstance();
$app->bootstrap();
$app->run();
