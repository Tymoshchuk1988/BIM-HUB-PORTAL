#!/bin/bash
# 🚀 BIM HUB - ПРОСТИЙ ДЕПЛОЙ СКРИПТ

echo "=================================================="
echo "🚀 BIM HUB PORTAL - ШВИДКИЙ ДЕПЛОЙ"
echo "=================================================="

PASSWORD="Tymoshchuk1988"
REMOTE_HOST="ec606796.ftp.tools"
REMOTE_USER="ec606796"
REMOTE_PATH="/home/ec606796/bimhub.site/www"
LOCAL_PATH="./public_html"

# Колірні повідомлення
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

success() { echo -e "${GREEN}✅ $1${NC}"; }
error() { echo -e "${RED}❌ $1${NC}"; }
info() { echo -e "${YELLOW}📌 $1${NC}"; }

# Функція для завантаження
upload() {
    if sshpass -p "$PASSWORD" scp -o StrictHostKeyChecking=no -r "$1" "$REMOTE_USER@$REMOTE_HOST:$2" 2>/dev/null; then
        success "Завантажено: $(basename "$1")"
        return 0
    else
        error "Помилка: $(basename "$1")"
        return 1
    fi
}

echo ""
info "1. ЗАВАНТАЖЕННЯ ОСНОВНИХ СТОРІНОК"
echo "----------------------------------------"

# Створюємо структуру на сервері
sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no "$REMOTE_USER@$REMOTE_HOST" "
    mkdir -p $REMOTE_PATH/pages/{strategy,projects,library,education,team}
    mkdir -p $REMOTE_PATH/{css,js,includes,uploads,assets}
"

# Головна сторінка
upload "$LOCAL_PATH/index.php" "$REMOTE_PATH/"

# Основний CSS та JS
if [ -f "$LOCAL_PATH/css/main.css" ]; then
    upload "$LOCAL_PATH/css/" "$REMOTE_PATH/"
fi
if [ -f "$LOCAL_PATH/js/main.js" ]; then
    upload "$LOCAL_PATH/js/" "$REMOTE_PATH/"
fi

# Сторінки порталу
for page in strategy projects library education team; do
    if [ -f "$LOCAL_PATH/pages/$page/index.php" ]; then
        upload "$LOCAL_PATH/pages/$page/index.php" "$REMOTE_PATH/pages/$page/"
    fi
done

echo ""
info "2. ЗАВАНТАЖЕННЯ ДОДАТКОВИХ ФАЙЛІВ"
echo "----------------------------------------"

# Додаткові файли
for file in login.php logout.php contact.php layout.php .htaccess; do
    if [ -f "$LOCAL_PATH/$file" ]; then
        upload "$LOCAL_PATH/$file" "$REMOTE_PATH/"
    fi
done

# Includes
if [ -d "$LOCAL_PATH/includes" ]; then
    upload "$LOCAL_PATH/includes/" "$REMOTE_PATH/"
fi

# Assets (якщо є)
if [ -d "$LOCAL_PATH/assets" ]; then
    upload "$LOCAL_PATH/assets/" "$REMOTE_PATH/"
fi

echo ""
info "3. НАЛАШТУВАННЯ ПРАВ ДОСТУПУ"
echo "----------------------------------------"

sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no "$REMOTE_USER@$REMOTE_HOST" "
    cd $REMOTE_PATH
    
    # Основні права
    find . -type d -exec chmod 755 {} \;
    find . -type f -exec chmod 644 {} \;
    
    # Спеціальні права
    chmod 755 ./
    chmod 755 pages/
    chmod 755 pages/*/
    
    # Uploads
    if [ -d 'uploads' ]; then
        chmod -R 777 uploads/
    fi
    
    echo '✅ Права доступу оновлено'
"

echo ""
echo "=================================================="
success "ДЕПЛОЙ ЗАВЕРШЕНО УСПІШНО!"
echo "=================================================="
echo ""
info "🌐 САЙТ ДОСТУПНИЙ ЗА АДРЕСАМИ:"
echo "   • Головна: https://bimhub.site/"
echo "   • Стратегія: https://bimhub.site/pages/strategy/"
echo "   • Проекти: https://bimhub.site/pages/projects/"
echo "   • Бібліотека: https://bimhub.site/pages/library/"
echo "   • Навчання: https://bimhub.site/pages/education/"
echo "   • Команда: https://bimhub.site/pages/team/"
echo "   • Контакти: https://bimhub.site/contact.php"
echo ""
info "⏳ Оновлення кешу: 1-2 хвилини"

# Швидка перевірка
echo ""
info "📡 ШВИДКА ПЕРЕВІРКА СТОРІНОК:"
curl -s -o /dev/null -w "Головна: %{http_code}\n" https://bimhub.site/
for page in strategy projects library education team; do
    curl -s -o /dev/null -w "$page: %{http_code}\n" "https://bimhub.site/pages/$page/"
done
