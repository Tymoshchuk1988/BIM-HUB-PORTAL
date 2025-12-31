<?php
// Тестова сторінка BIM Hub Portal
echo '<!DOCTYPE html>';
echo '<html lang="uk">';
echo '<head>';
echo '    <meta charset="UTF-8">';
echo '    <title>BIM Hub - Тестова сторінка</title>';
echo '    <style>';
echo '        body { font-family: Arial, sans-serif; padding: 20px; }';
echo '        .success { color: green; font-weight: bold; }';
echo '        .info { background: #f0f0f0; padding: 15px; border-radius: 5px; }';
echo '    </style>';
echo '</head>';
echo '<body>';
echo '    <h1>BIM Hub Portal - Тестова сторінка</h1>';
echo '    <div class="success">✅ PHP працює правильно!</div>';
echo '    <div class="info">';
echo '        <p><strong>Версія PHP:</strong> ' . phpversion() . '</p>';
echo '        <p><strong>Сервер:</strong> ' . $_SERVER['SERVER_SOFTWARE'] . '</p>';
echo '        <p><strong>Дата:</strong> ' . date('Y-m-d H:i:s') . '</p>';
echo '    </div>';
echo '    <p><a href="/">Повернутися на головну</a></p>';
echo '</body>';
echo '</html>';
?>
