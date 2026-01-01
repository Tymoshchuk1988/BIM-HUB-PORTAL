#!/bin/bash
echo "🛡️  БЕЗПЕЧНИЙ ДЕПЛОЙ (без видалення)"
echo "================================="

LOCAL_DIR="/Users/irynashevchuk/Documents/Тимощук/BIMHub/PORTAL/BIM-HUB-PORTAL/production-deploy"
REMOTE_DIR="/home/ec606796/bimhub.site/www"

SSH_USER="ec606796"
SSH_HOST="ec606796.ftp.tools"
SSH_PASS="Tymoshchuk1988"

cd "$LOCAL_DIR"

echo "📋 ФАЙЛИ ДЛЯ ДЕПЛОЮ:"
echo "------------------"
find . -type f | head -20
echo "... і ще $(($(find . -type f | wc -l) - 20)) файлів"
echo ""

read -p "🚀 Почати деплой файлів? (y/n): " -n 1 -r
echo ""
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "❌ Скасовано"
    exit 0
fi

# Функція для деплою одного файлу
deploy_file() {
    local local_file="$1"
    local remote_file="$2"
    
    echo "📤 $local_file → $remote_file"
    sshpass -p "$SSH_PASS" scp -o StrictHostKeyChecking=no \
        "$local_file" \
        "$SSH_USER@$SSH_HOST:$REMOTE_DIR/$remote_file"
}

# Функція для деплою папки
deploy_dir() {
    local local_dir="$1"
    local remote_dir="$2"
    
    echo "📁 $local_dir/ → $remote_dir/"
    sshpass -p "$SSH_PASS" ssh -o StrictHostKeyChecking=no \
        "$SSH_USER@$SSH_HOST" "mkdir -p '$REMOTE_DIR/$remote_dir'"
    
    sshpass -p "$SSH_PASS" scp -o StrictHostKeyChecking=no \
        -r "$local_dir" \
        "$SSH_USER@$SSH_HOST:$REMOTE_DIR/$(dirname "$remote_dir")/"
}

# 1. Основні файли
echo ""
echo "1. 📄 ОСНОВНІ ФАЙЛИ:"
echo "------------------"
MAIN_FILES=(
    "index.php"
    "api.php"
    "login.php"
    "logout.php"
    "config.php"
    "contact.php"
    "layout.php"
)

for file in "${MAIN_FILES[@]}"; do
    if [ -f "$file" ]; then
        deploy_file "$file" "$file"
    fi
done

# 2. Папки
echo ""
echo "2. 📁 ПАПКИ:"
echo "-----------"
DIRS=(
    "api"
    "assets"
    "css"
    "js"
    "pages"
    "includes"
    "src"
)

for dir in "${DIRS[@]}"; do
    if [ -d "$dir" ]; then
        deploy_dir "$dir" "$dir"
    fi
done

# 3. Налаштування прав
echo ""
echo "3. 🔧 НАЛАШТУВАННЯ ПРАВ:"
sshpass -p "$SSH_PASS" ssh -o StrictHostKeyChecking=no "$SSH_USER@$SSH_HOST" "
    cd '$REMOTE_DIR'
    echo '   Встановлюю права доступу...'
    find . -type f -name '*.php' -exec chmod 644 {} \;
    find . -type f -name '*.css' -exec chmod 644 {} \;
    find . -type f -name '*.js' -exec chmod 644 {} \;
    echo '✅ Права встановлено'
"

# 4. Перевірка
echo ""
echo "4. ✅ ПЕРЕВІРКА:"
echo "--------------"

sshpass -p "$SSH_PASS" ssh -o StrictHostKeyChecking=no "$SSH_USER@$SSH_HOST" "
    cd '$REMOTE_DIR'
    
    echo '📊 Статистика:'
    echo '• Файлів: \$(find . -type f | wc -l)'
    echo '• Папок: \$(find . -type d | wc -l)'
    echo ''
    
    echo '🔍 Ключові файли:'
    for file in index.php api.php login.php config.php; do
        if [ -f \"\$file\" ]; then
            size=\$(stat -c%s \"\$file\")
            echo \"   ✅ \$file (\$size байт)\"
        else
            echo \"   ❌ \$file - відсутній\"
        fi
    done
    
    echo ''
    echo '📁 Вміст api/:'
    ls -la api/ 2>/dev/null || echo '   Папка не знайдена'
"

echo ""
echo "🎯 ДЕПЛОЙ ВИКОНАНО!"
echo "================="
echo ""
echo "🌐 ПЕРЕВІРТЕ:"
echo "• https://bimhub.site/"
echo "• https://bimhub.site/api/"
echo "• https://bimhub.site/api.php"
echo "• https://bimhub.site/login.php"
echo ""
echo "⚠️  УВАГА: На сервері залишились старі файли:"
echo "• dashboard.php - стара версія"
echo "• check-db-*.php - тестові файли"
echo "• final-test.php - тестовий файл"
echo ""
echo "🗑️  Щоб видалити зайві файли, виконайте:"
echo "sshpass -p 'Tymoshchuk1988' ssh ec606796@ec606796.ftp.tools 'cd /home/ec606796/bimhub.site/www && rm -f dashboard.php check-*.php final-test.php'"
