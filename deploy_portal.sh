#!/bin/bash

# BIM Hub Portal - Деплой скрипт
echo "=================================================="
echo "🚀 BIM HUB PORTAL - ДЕПЛОЙ НА ХОСТИНГ"
echo "=================================================="

# Дані для доступу
SSH_HOST="ec606796@ec606796.ftp.tools"
SSH_PASSWORD="Tymoshchuk1988"
REMOTE_PATH="/home/ec606796/bimhub.site/www"
LOCAL_PATH="./public_html"

# Перевірка наявності sshpass
if ! command -v sshpass &> /dev/null; then
    echo "❌ sshpass не встановлено"
    echo "Установіть: brew install hudochenkov/sshpass/sshpass (macOS)"
    echo "Або: sudo apt-get install sshpass (Ubuntu)"
    exit 1
fi

# Функція для виконання SSH команд
function ssh_cmd() {
    sshpass -p "$SSH_PASSWORD" ssh -o StrictHostKeyChecking=no "$SSH_HOST" "$@"
}

# Функція для завантаження файлів через SCP
function upload_files() {
    local src="$1"
    local dst="$2"
    
    echo "📤 Завантаження: $src → $dst"
    sshpass -p "$SSH_PASSWORD" scp -o StrictHostKeyChecking=no -r "$src" "${SSH_HOST}:${dst}"
}

# Функція створення директорій на сервері
function create_remote_dirs() {
    echo "📁 Створення структури директорій на сервері..."
    
    ssh_cmd "mkdir -p ${REMOTE_PATH}/{css,js,images,uploads,pages,api,includes}"
    ssh_cmd "mkdir -p ${REMOTE_PATH}/pages/{strategy,projects,library,education,team}"
    
    echo "✅ Структура директорій створена"
}

# Функція для перевірки підключення
function test_connection() {
    echo "🔍 Перевірка підключення до сервера..."
    
    if ssh_cmd "echo '✅ SSH підключення працює' && pwd"; then
        echo "✅ Підключення до сервера успішне"
        return 0
    else
        echo "❌ Помилка підключення до сервера"
        return 1
    fi
}

# Функція для деплою всіх сторінок
function deploy_all_pages() {
    echo "🚀 Деплой всіх сторінок порталу..."
    
    # Головна сторінка
    if [ -f "${LOCAL_PATH}/index.php" ]; then
        upload_files "${LOCAL_PATH}/index.php" "${REMOTE_PATH}/"
        echo "✅ Головна сторінка завантажена"
    fi
    
    # Сторінки
    if [ -d "${LOCAL_PATH}/pages" ]; then
        # Стратегія
        if [ -f "${LOCAL_PATH}/pages/strategy/index.php" ]; then
            upload_files "${LOCAL_PATH}/pages/strategy/index.php" "${REMOTE_PATH}/pages/strategy/"
            echo "✅ Сторінка Стратегія завантажена"
        fi
        
        # Проекти
        if [ -f "${LOCAL_PATH}/pages/projects/index.php" ]; then
            upload_files "${LOCAL_PATH}/pages/projects/index.php" "${REMOTE_PATH}/pages/projects/"
            echo "✅ Сторінка Проекти завантажена"
        fi
        
        # Бібліотека
        if [ -f "${LOCAL_PATH}/pages/library/index.php" ]; then
            upload_files "${LOCAL_PATH}/pages/library/index.php" "${REMOTE_PATH}/pages/library/"
            echo "✅ Сторінка Бібліотека завантажена"
        fi
        
        # Навчання
        if [ -f "${LOCAL_PATH}/pages/education/index.php" ]; then
            upload_files "${LOCAL_PATH}/pages/education/index.php" "${REMOTE_PATH}/pages/education/"
            echo "✅ Сторінка Навчання завантажена"
        fi
        
        # Команда
        if [ -f "${LOCAL_PATH}/pages/team/index.php" ]; then
            upload_files "${LOCAL_PATH}/pages/team/index.php" "${REMOTE_PATH}/pages/team/"
            echo "✅ Сторінка Команда завантажена"
        fi
    fi
    
    # CSS файли
    if [ -f "${LOCAL_PATH}/css/style.css" ]; then
        upload_files "${LOCAL_PATH}/css/style.css" "${REMOTE_PATH}/css/"
        echo "✅ CSS файли завантажені"
    fi
    
    # Створення .htaccess
    create_htaccess
    
    echo "✅ Всі сторінки завантажені"
}

# Функція створення .htaccess
function create_htaccess() {
    echo "🔧 Створення .htaccess файлу..."
    
    HTACCESS_CONTENT="# BIM Hub Portal - Налаштування сервера
RewriteEngine On
RewriteBase /

# Дозволити доступ до всіх сторінок
Options -Indexes +FollowSymLinks

# PHP налаштування
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value max_input_time 300

# Маршрутизація
RewriteRule ^стратегія$ /pages/strategy/ [L]
RewriteRule ^проекти$ /pages/projects/ [L]
RewriteRule ^бібліотека$ /pages/library/ [L]
RewriteRule ^навчання$ /pages/education/ [L]
RewriteRule ^команда$ /pages/team/ [L]

# Автоматичне додавання слешу в кінці директорій
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^(.+[^/])$ \$1/ [R=301,L]

# Обробка помилок
ErrorDocument 404 /404.html
ErrorDocument 403 /403.html
ErrorDocument 500 /500.html

# Безпека
<FilesMatch \"\.(htaccess|htpasswd|ini|log|sh|sql)$\">
    Order Allow,Deny
    Deny from all
</FilesMatch>

# Кешування
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg \"access plus 1 year\"
    ExpiresByType image/jpeg \"access plus 1 year\"
    ExpiresByType image/gif \"access plus 1 year\"
    ExpiresByType image/png \"access plus 1 year\"
    ExpiresByType text/css \"access plus 1 month\"
    ExpiresByType application/javascript \"access plus 1 month\"
</IfModule>

# Заголовки безпеки
<IfModule mod_headers.c>
    Header set X-Content-Type-Options \"nosniff\"
    Header set X-Frame-Options \"SAMEORIGIN\"
    Header set X-XSS-Protection \"1; mode=block\"
</IfModule>"
    
    # Створюємо локально
    echo "$HTACCESS_CONTENT" > "${LOCAL_PATH}/.htaccess"
    
    # Завантажуємо на сервер
    upload_files "${LOCAL_PATH}/.htaccess" "${REMOTE_PATH}/"
    
    echo "✅ .htaccess створено та завантажено"
}

# Функція налаштування прав доступу
function set_permissions() {
    echo "🔐 Налаштування прав доступу..."
    
    ssh_cmd "chmod 755 ${REMOTE_PATH}"
    ssh_cmd "chmod 644 ${REMOTE_PATH}/*.php"
    ssh_cmd "chmod 644 ${REMOTE_PATH}/pages/*/*.php"
    ssh_cmd "chmod 755 ${REMOTE_PATH}/pages"
    ssh_cmd "chmod 755 ${REMOTE_PATH}/pages/*"
    
    echo "✅ Права доступу налаштовані"
}

# Функція перевірки деплою
function verify_deployment() {
    echo "🔍 Перевірка деплою..."
    
    # Перевіряємо наявність файлів на сервері
    echo "📋 Перевірка файлів на сервері:"
    
    ssh_cmd "ls -la ${REMOTE_PATH}/" || true
    echo ""
    ssh_cmd "ls -la ${REMOTE_PATH}/pages/" || true
    
    echo ""
    echo "🌐 Сторінки доступні за посиланнями:"
    echo "   https://bimhub.site/ - Головна"
    echo "   https://bimhub.site/pages/strategy/ - Стратегія"
    echo "   https://bimhub.site/pages/projects/ - Проекти"
    echo "   https://bimhub.site/pages/library/ - Бібліотека"
    echo "   https://bimhub.site/pages/education/ - Навчання"
    echo "   https://bimhub.site/pages/team/ - Команда"
}

# Функція створення тестового файлу
function create_test_file() {
    echo "🧪 Створення тестового файлу..."
    
    TEST_CONTENT="<?php
// Тестова сторінка BIM Hub Portal
echo '<!DOCTYPE html>';
echo '<html lang=\"uk\">';
echo '<head>';
echo '    <meta charset=\"UTF-8\">';
echo '    <title>BIM Hub - Тестова сторінка</title>';
echo '    <style>';
echo '        body { font-family: Arial, sans-serif; padding: 20px; }';
echo '        .success { color: green; font-weight: bold; }';
echo '        .info { background: #f0f0f0; padding: 15px; border-radius: 5px; }';
echo '    </style>';
echo '</head>';
echo '<body>';
echo '    <h1>BIM Hub Portal - Тестова сторінка</h1>';
echo '    <div class=\"success\">✅ PHP працює правильно!</div>';
echo '    <div class=\"info\">';
echo '        <p><strong>Версія PHP:</strong> ' . phpversion() . '</p>';
echo '        <p><strong>Сервер:</strong> ' . \$_SERVER['SERVER_SOFTWARE'] . '</p>';
echo '        <p><strong>Дата:</strong> ' . date('Y-m-d H:i:s') . '</p>';
echo '    </div>';
echo '    <p><a href=\"/\">Повернутися на головну</a></p>';
echo '</body>';
echo '</html>';
?>"
    
    echo "$TEST_CONTENT" > "${LOCAL_PATH}/test.php"
    upload_files "${LOCAL_PATH}/test.php" "${REMOTE_PATH}/"
    
    echo "✅ Тестова сторінка створена: https://bimhub.site/test.php"
}

# Головна функція
function main() {
    echo "Початок деплою..."
    echo "Локальна папка: ${LOCAL_PATH}"
    echo "Віддалена папка: ${REMOTE_PATH}"
    echo ""
    
    # Перевірка підключення
    if ! test_connection; then
        echo "❌ Неможливо продовжити без підключення"
        exit 1
    fi
    
    # Створення директорій
    create_remote_dirs
    
    # Деплой сторінок
    deploy_all_pages
    
    # Налаштування прав
    set_permissions
    
    # Тестовий файл
    create_test_file
    
    # Перевірка
    verify_deployment
    
    echo ""
    echo "=================================================="
    echo "🎉 ДЕПЛОЙ УСПІШНО ЗАВЕРШЕНО!"
    echo "=================================================="
    echo ""
    echo "🌐 Ваш портал доступний за адресами:"
    echo "   https://bimhub.site/"
    echo "   https://www.bimhub.site/"
    echo ""
    echo "📋 Сторінки порталу:"
    echo "   1. Головна - https://bimhub.site/"
    echo "   2. Стратегія - https://bimhub.site/pages/strategy/"
    echo "   3. Проекти - https://bimhub.site/pages/projects/"
    echo "   4. Бібліотека - https://bimhub.site/pages/library/"
    echo "   5. Навчання - https://bimhub.site/pages/education/"
    echo "   6. Команда - https://bimhub.site/pages/team/"
    echo "   7. Тест - https://bimhub.site/test.php"
    echo ""
    echo "🛠️  Для подальшої розробки:"
    echo "   1. Редагуйте файли в папці public_html/"
    echo "   2. Запускайте ./deploy_portal.sh для завантаження змін"
    echo "   3. Перевіряйте результат на сайті"
    echo ""
    echo "⚠️  Примітка: Якщо сторінки не відображаються відразу,"
    echo "    зачекайте 5-15 хвилин для оновлення кешу DNS."
    echo ""
}

# Запуск головної функції
main
