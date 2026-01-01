<?php
// api.php - Дуже проста версія
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'status' => 'success',
    'message' => 'BIM Hub API працює!',
    'version' => '2.0.0',
    'timestamp' => date('Y-m-d H:i:s'),
    'endpoints' => [
        '/api/status' => 'Статус системи',
        '/api/projects' => 'Проекти',
        '/api/users' => 'Користувачі'
    ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
