<?php
// Простий тест PHP
echo "<!DOCTYPE html>";
echo "<html lang='uk'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>BIM Hub - Тест PHP</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }";
echo ".success { color: green; background: #e8f5e8; padding: 15px; border-radius: 5px; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<h1>BIM Hub - Тест PHP</h1>";
echo "<div class='success'>";
echo "✅ PHP працює коректно!<br>";
echo "Версія PHP: " . phpversion() . "<br>";
echo "Сервер: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Дата: " . date('Y-m-d H:i:s');
echo "</div>";
echo "</body>";
echo "</html>";
?>
