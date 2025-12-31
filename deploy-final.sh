#!/bin/bash
# 🏁 BIM HUB - ФІНАЛЬНИЙ ДЕПЛОЙ СКРИПТ

echo "╔══════════════════════════════════════════╗"
echo "║         BIM HUB PORTAL - ДЕПЛОЙ          ║"
echo "╚══════════════════════════════════════════╝"

# Конфігурація
PASSWORD="Tymoshchuk1988"
HOST="ec606796.ftp.tools"
USER="ec606796"
REMOTE="/home/ec606796/bimhub.site/www"
LOCAL="./public_html"

# Кольори
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

ok() { echo -e "${GREEN}✓ $1${NC}"; }
fail() { echo -e "${RED}✗ $1${NC}"; }
info() { echo -e "${YELLOW}→ $1${NC}"; }

# Перевірка підключення
info "Перевірка підключення..."
if ! sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no -o ConnectTimeout=10 "$USER@$HOST" "echo 'Connected'" &>/dev/null; then
    fail "Не вдається підключитися"
    exit 1
fi
ok "Підключення успішне"

# Функція завантаження
upload() {
    local what="$1"
    local where="$2"
    
    if sshpass -p "$PASSWORD" scp -o StrictHostKeyChecking=no -r "$what" "$USER@$HOST:$where" 2>/dev/null; then
        ok "$(basename "$what")"
        return 0
    else
        fail "$(basename "$what")"
        return 1
    fi
}

# Функція SSH команди
run() {
    sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no "$USER@$HOST" "$1"
}

# Основний деплой
echo ""
info "Фаза 1: Основні файли"
upload "$LOCAL/index.php" "$REMOTE/"
upload "$LOCAL/login.php" "$REMOTE/"
upload "$LOCAL/contact.php" "$REMOTE/"
upload "$LOCAL/layout.php" "$REMOTE/"
upload "$LOCAL/.htaccess" "$REMOTE/"

echo ""
info "Фаза 2: Ресурси"
upload "$LOCAL/css/" "$REMOTE/css/"
upload "$LOCAL/js/" "$REMOTE/js/"
upload "$LOCAL/includes/" "$REMOTE/includes/"

echo ""
info "Фаза 3: Сторінки"
run "mkdir -p $REMOTE/pages/{strategy,projects,library,education,team}"
upload "$LOCAL/pages/strategy/index.php" "$REMOTE/pages/strategy/"
upload "$LOCAL/pages/projects/index.php" "$REMOTE/pages/projects/"
upload "$LOCAL/pages/library/index.php" "$REMOTE/pages/library/"
upload "$LOCAL/pages/education/index.php" "$REMOTE/pages/education/"
upload "$LOCAL/pages/team/index.php" "$REMOTE/pages/team/"

echo ""
info "Фаза 4: Права доступу"
run "
    cd $REMOTE
    find . -type d -exec chmod 755 {} \;
    find . -type f -exec chmod 644 {} \;
    chmod 755 ./ pages/ pages/*/
    echo 'Права встановлено'
"

echo ""
info "Фаза 5: Перевірка"
echo "Перевіряю доступність сайту..."

check_url() {
    local url="$1"
    local name="$2"
    if curl -s -f -o /dev/null -w "%{http_code}" "$url" | grep -q "200\|301\|302"; then
        ok "$name"
    else
        fail "$name"
    fi
}

check_url "https://bimhub.site/" "Головна"
check_url "https://bimhub.site/pages/strategy/" "Стратегія"
check_url "https://bimhub.site/pages/projects/" "Проекти"
check_url "https://bimhub.site/pages/library/" "Бібліотека"
check_url "https://bimhub.site/pages/education/" "Навчання"
check_url "https://bimhub.site/pages/team/" "Команда"
check_url "https://bimhub.site/contact.php" "Контакти"

echo ""
echo "╔══════════════════════════════════════════╗"
echo "║           ДЕПЛОЙ ЗАВЕРШЕНО!             ║"
echo "╚══════════════════════════════════════════╝"
echo ""
echo "🌐 Сайт доступний: https://bimhub.site"
echo ""
echo "📁 Сторінки:"
echo "  • /pages/strategy/"
echo "  • /pages/projects/"
echo "  • /pages/library/"
echo "  • /pages/education/"
echo "  • /pages/team/"
echo ""
echo "⏳ Оновлення кешу: 1-2 хвилини"
