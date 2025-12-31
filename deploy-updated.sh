#!/bin/bash
# 🚀 BIM HUB - ОНОВЛЕНИЙ ДЕПЛОЙ СКРИПТ

echo "=================================================="
echo "�� BIM HUB PORTAL - ОНОВЛЕНИЙ ДЕПЛОЙ"
echo "=================================================="

# Конфігурація
PASSWORD="Tymoshchuk1988"
REMOTE_HOST="ec606796.ftp.tools"
REMOTE_USER="ec606796"
REMOTE_PATH="/home/ec606796/bimhub.site/www"
LOCAL_PATH="./public_html"
SSH_PORT="22"  # Спробуйте 2222 якщо 22 не працює

# Колірні повідомлення
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

success() { echo -e "${GREEN}✅ $1${NC}"; }
error() { echo -e "${RED}❌ $1${NC}"; }
info() { echo -e "${YELLOW}📌 $1${NC}"; }
step() { echo -e "${BLUE}🔹 $1${NC}"; }

# Функція для SSH команди
ssh_cmd() {
    sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no -o ConnectTimeout=30 -p "$SSH_PORT" "$REMOTE_USER@$REMOTE_HOST" "$1"
    return $?
}

# Функція для SCP
scp_cmd() {
    local src="$1"
    local dst="$2"
    
    if sshpass -p "$PASSWORD" scp -o StrictHostKeyChecking=no -o ConnectTimeout=30 -P "$SSH_PORT" -r "$src" "$REMOTE_USER@$REMOTE_HOST:$dst" 2>/dev/null; then
        return 0
    else
        return 1
    fi
}

# Перевірка з'єднання
check_connection() {
    step "Перевірка з'єднання з хостингом..."
    
    # Спробуємо різні порти
    for port in 22 2222; do
        info "Спробую порт $port..."
        if sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no -o ConnectTimeout=10 -p "$port" "$REMOTE_USER@$REMOTE_HOST" "echo 'Connection test'" &>/dev/null; then
            SSH_PORT="$port"
            success "З'єднання успішне на порті $port"
            return 0
        fi
    done
    
    error "Не вдалося підключитися до хостингу"
    info "Можливі рішення:"
    info "1. Перевірте інтернет з'єднання"
    info "2. Перевірте пароль"
    info "3. Хостинг може тимчасово недоступний"
    return 1
}

# Створення структури на сервері
create_structure() {
    step "Створення структури на сервері..."
    
    ssh_cmd "
        # Основні папки
        mkdir -p $REMOTE_PATH
        mkdir -p $REMOTE_PATH/css
        mkdir -p $REMOTE_PATH/js
        mkdir -p $REMOTE_PATH/includes
        mkdir -p $REMOTE_PATH/uploads
        mkdir -p $REMOTE_PATH/uploads/projects
        mkdir -p $REMOTE_PATH/uploads/documents
        mkdir -p $REMOTE_PATH/assets
        mkdir -p $REMOTE_PATH/api
        mkdir -p $REMOTE_PATH/admin
        
        # Папки сторінок
        mkdir -p $REMOTE_PATH/pages/strategy
        mkdir -p $REMOTE_PATH/pages/projects
        mkdir -p $REMOTE_PATH/pages/library
        mkdir -p $REMOTE_PATH/pages/education
        mkdir -p $REMOTE_PATH/pages/team
        
        echo 'Структура створена'
    "
}

# Завантаження файлів
upload_files() {
    step "Завантаження файлів..."
    
    # Список основних файлів
    local main_files=(
        "index.php"
        "login.php"
        "logout.php"
        "contact.php"
        "layout.php"
        "test.php"
        "test_simple.php"
        ".htaccess"
    )
    
    # Завантаження основних файлів
    for file in "${main_files[@]}"; do
        if [ -f "$LOCAL_PATH/$file" ]; then
            if scp_cmd "$LOCAL_PATH/$file" "$REMOTE_PATH/"; then
                success "$file"
            else
                error "$file"
            fi
        else
            info "Пропущено: $file (не знайдено)"
        fi
    done
    
    # Завантаження папок
    local folders=("css" "js" "includes" "assets" "api" "admin" "uploads")
    
    for folder in "${folders[@]}"; do
        if [ -d "$LOCAL_PATH/$folder" ]; then
            if scp_cmd "$LOCAL_PATH/$folder/" "$REMOTE_PATH/"; then
                success "$folder/"
            else
                error "$folder/"
            fi
        fi
    done
    
    # Завантаження сторінок
    for page in strategy projects library education team; do
        if [ -f "$LOCAL_PATH/pages/$page/index.php" ]; then
            # Створюємо папку
            ssh_cmd "mkdir -p $REMOTE_PATH/pages/$page"
            
            # Завантажуємо файл
            if scp_cmd "$LOCAL_PATH/pages/$page/index.php" "$REMOTE_PATH/pages/$page/"; then
                success "pages/$page/index.php"
            else
                error "pages/$page/index.php"
            fi
        fi
    done
}

# Налаштування прав
set_permissions() {
    step "Налаштування прав доступу..."
    
    ssh_cmd "
        cd $REMOTE_PATH
        
        echo 'Налаштування прав...'
        
        # Папки - 755, файли - 644
        find . -type d -exec chmod 755 {} \;
        find . -type f -exec chmod 644 {} \;
        
        # Спеціальні права для папок
        chmod 755 ./
        chmod 755 pages/
        chmod 755 pages/*/
        
        # Uploads - більше прав
        if [ -d 'uploads' ]; then
            chmod -R 755 uploads/
            chmod -R 777 uploads/projects/
            chmod -R 777 uploads/documents/
        fi
        
        echo '✅ Права оновлено'
    "
}

# Перевірка сайту
check_site() {
    step "Перевірка доступності сайту..."
    
    local base_url="https://bimhub.site"
    local pages=("" "pages/strategy/" "pages/projects/" "pages/library/" "pages/education/" "pages/team/" "contact.php" "login.php")
    
    info "Перевірка доступності..."
    
    for page in "${pages[@]}"; do
        local url="${base_url}/${page}"
        local status=$(curl -s -o /dev/null -w "%{http_code}" --max-time 10 "$url" 2>/dev/null)
        
        if [[ "$status" =~ ^(200|301|302)$ ]]; then
            success "$url - $status"
        else
            error "$url - $status"
        fi
        
        sleep 1
    done
}

# Головна функція
main() {
    echo "Початок оновленого деплою..."
    
    # Перевірка з'єднання
    if ! check_connection; then
        error "Не вдалося підключитися. Зупинка."
        exit 1
    fi
    
    # Створення структури
    create_structure
    
    # Завантаження файлів
    upload_files
    
    # Налаштування прав
    set_permissions
    
    # Перевірка
    check_site
    
    echo ""
    echo "=================================================="
    success "ДЕПЛОЙ ЗАВЕРШЕНО!"
    echo "=================================================="
    echo ""
    info "Сайт доступний за адресами:"
    echo "   • https://bimhub.site/"
    echo "   • https://bimhub.site/pages/strategy/"
    echo "   • https://bimhub.site/pages/projects/"
    echo "   • https://bimhub.site/pages/library/"
    echo "   • https://bimhub.site/pages/education/"
    echo "   • https://bimhub.site/pages/team/"
    echo ""
    info "Що робити далі:"
    echo "   1. Перевірте всі сторінки вручну"
    echo "   2. Протестуйте контактну форму"
    echo "   3. Перевірте завантаження файлів"
    echo ""
    echo "⏳ Оновлення кешу може зайняти 5-10 хвилин"
}

# Запуск
main
