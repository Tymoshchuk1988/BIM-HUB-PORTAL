#!/bin/bash
# 🚀 BIM HUB PORTAL - AUTOMATED DEPLOYMENT SCRIPT
# Версія 2.0: Сучасний деплой з Docker та CI/CD

echo "=================================================="
echo "🚀 BIM HUB PORTAL - АВТОМАТИЧНИЙ ДЕПЛОЙ"
echo "=================================================="

# Конфігурація
PASSWORD="Tymoshchuk1988"
REMOTE_HOST="ec606796.ftp.tools"
REMOTE_USER="ec606796"
REMOTE_PATH="/home/ec606796/bimhub.site/www"
LOCAL_PATH="./public_html"
BACKUP_PATH="./backups"
DOCKER_REGISTRY="ghcr.io/tymoshchuk1988"
DOCKER_IMAGE="bimhub-portal"

# Колірні повідомлення
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Функції для кольорових повідомлень
success() { echo -e "${GREEN}✅ $1${NC}"; }
error() { echo -e "${RED}❌ $1${NC}"; }
info() { echo -e "${YELLOW}📌 $1${NC}"; }
step() { echo -e "${BLUE}🔹 $1${NC}"; }

# Перевірка залежностей
check_dependencies() {
    step "Перевірка залежностей..."
    
    # SSH
    if ! command -v ssh &> /dev/null; then
        error "SSH не встановлено"
        exit 1
    fi
    
    # SCP
    if ! command -v scp &> /dev/null; then
        error "SCP не встановлено"
        exit 1
    fi
    
    # SSHPass для автоматизації пароля
    if ! command -v sshpass &> /dev/null; then
        info "Встановлення sshpass..."
        if [[ "$OSTYPE" == "darwin"* ]]; then
            brew install hudochenkov/sshpass/sshpass
        elif [[ -f /etc/debian_version ]]; then
            sudo apt-get install -y sshpass
        fi
    fi
    
    success "Всі залежності встановлено"
}

# Резервне копіювання
create_backup() {
    local timestamp=$(date +"%Y%m%d_%H%M%S")
    local backup_dir="$BACKUP_PATH/$timestamp"
    
    step "Створення резервної копії..."
    
    mkdir -p "$backup_dir"
    
    # Копіювання з віддаленого сервера
    if sshpass -p "$PASSWORD" scp -r "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/*" "$backup_dir/" 2>/dev/null; then
        success "Резервна копія створена: $backup_dir"
    else
        error "Не вдалося створити резервну копію"
    fi
}

# Функція для завантаження файлів
upload_file() {
    local src="$1"
    local dst="$2"
    
    if [ -f "$src" ]; then
        if sshpass -p "$PASSWORD" scp -o StrictHostKeyChecking=no "$src" "$REMOTE_USER@$REMOTE_HOST:$dst" 2>/dev/null; then
            success "Файл: $(basename "$src")"
            return 0
        else
            error "Файл: $(basename "$src")"
            return 1
        fi
    elif [ -d "$src" ]; then
        if sshpass -p "$PASSWORD" scp -o StrictHostKeyChecking=no -r "$src" "$REMOTE_USER@$REMOTE_HOST:$dst" 2>/dev/null; then
            success "Папка: $(basename "$src")"
            return 0
        else
            error "Папка: $(basename "$src")"
            return 1
        fi
    else
        error "Не знайдено: $src"
        return 1
    fi
}

# Побудова Docker образу
build_docker_image() {
    step "Побудова Docker образу..."
    
    if docker build -t $DOCKER_IMAGE:latest -t $DOCKER_IMAGE:$(date +%Y%m%d) .; then
        success "Docker образ побудовано"
        
        # Публікація на GitHub Container Registry (опціонально)
        if [ "$1" == "--publish" ]; then
            step "Публікація образу на GitHub..."
            echo "$DOCKER_REGISTRY_PASSWORD" | docker login ghcr.io -u "$DOCKER_REGISTRY_USERNAME" --password-stdin
            docker tag $DOCKER_IMAGE:latest $DOCKER_REGISTRY/$DOCKER_IMAGE:latest
            docker push $DOCKER_REGISTRY/$DOCKER_IMAGE:latest
            success "Образ опубліковано"
        fi
    else
        error "Помилка побудови Docker образу"
        exit 1
    fi
}

# Синхронізація через rsync (якщо доступно)
sync_rsync() {
    step "Синхронізація через rsync..."
    
    if command -v rsync &> /dev/null; then
        rsync -avz --delete --exclude='.git' --exclude='node_modules' --exclude='vendor' \
            -e "sshpass -p $PASSWORD ssh -o StrictHostKeyChecking=no" \
            "$LOCAL_PATH/" "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/"
        success "Синхронізація завершена"
    else
        info "rsync не знайдено, використовується scp"
        upload_all_files
    fi
}

# Завантаження всіх файлів
upload_all_files() {
    step "Завантаження всіх файлів..."
    
    # Основний вміст
    upload_file "$LOCAL_PATH/index.php" "$REMOTE_PATH/"
    upload_file "$LOCAL_PATH/login.php" "$REMOTE_PATH/"
    upload_file "$LOCAL_PATH/logout.php" "$REMOTE_PATH/"
    upload_file "$LOCAL_PATH/contact.php" "$REMOTE_PATH/"
    upload_file "$LOCAL_PATH/layout.php" "$REMOTE_PATH/"
    upload_file "$LOCAL_PATH/.htaccess" "$REMOTE_PATH/"
    
    # CSS та JS
    upload_file "$LOCAL_PATH/css/" "$REMOTE_PATH/"
    upload_file "$LOCAL_PATH/js/" "$REMOTE_PATH/"
    
    # Includes
    upload_file "$LOCAL_PATH/includes/" "$REMOTE_PATH/"
    
    # Сторінки
    for page in strategy projects library education team; do
        if [ -d "$LOCAL_PATH/pages/$page" ]; then
            # Створюємо директорію на сервері
            sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no "$REMOTE_USER@$REMOTE_HOST" \
                "mkdir -p $REMOTE_PATH/pages/$page"
            
            # Завантажуємо файли
            upload_file "$LOCAL_PATH/pages/$page/index.php" "$REMOTE_PATH/pages/$page/"
            
            # Завантажуємо додаткові файли в папці
            for file in "$LOCAL_PATH/pages/$page"/*; do
                if [ -f "$file" ] && [ "$(basename "$file")" != "index.php" ]; then
                    upload_file "$file" "$REMOTE_PATH/pages/$page/"
                fi
            done
        fi
    done
    
    # Assets
    if [ -d "$LOCAL_PATH/assets" ]; then
        upload_file "$LOCAL_PATH/assets/" "$REMOTE_PATH/"
    fi
}

# Налаштування прав доступу
set_permissions() {
    step "Налаштування прав доступу..."
    
    sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no "$REMOTE_USER@$REMOTE_HOST" << 'ENDSSH'
        cd /home/ec606796/bimhub.site/www
        
        # Основні права
        find . -type d -exec chmod 755 {} \;
        find . -type f -exec chmod 644 {} \;
        
        # Спеціальні права для скриптів
        chmod 755 ./
        chmod 755 pages/
        chmod 755 pages/*/
        
        # Права для завантажень
        if [ -d "uploads" ]; then
            chmod -R 755 uploads/
            chmod -R 777 uploads/projects/
            chmod -R 777 uploads/documents/
        fi
        
        echo "✅ Права доступу оновлено"
ENDSSH
    
    success "Права доступу налаштовано"
}

# Перевірка здоров'я сайту
health_check() {
    step "Перевірка здоров'я сайту..."
    
    local url="https://bimhub.site"
    local max_attempts=10
    local attempt=1
    
    info "Очікування завантаження сайту..."
    
    while [ $attempt -le $max_attempts ]; do
        if curl -s -f "$url" > /dev/null; then
            success "Сайт доступний: $url"
            return 0
        fi
        
        info "Спроба $attempt/$max_attempts..."
        sleep 5
        ((attempt++))
    done
    
    error "Сайт не став доступним протягом 50 секунд"
    return 1
}

# Генерація звіту
generate_report() {
    local timestamp=$(date +"%Y-%m-%d %H:%M:%S")
    
    echo ""
    echo "=================================================="
    success "ДЕПЛОЙ ЗАВЕРШЕНО УСПІШНО!"
    echo "=================================================="
    echo ""
    info "📊 ЗВІТ ПРО ДЕПЛОЙ:"
    echo "   Час: $timestamp"
    echo "   Версія: 2.0"
    echo "   Сервер: $REMOTE_HOST"
    echo "   Шлях: $REMOTE_PATH"
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
    info "🔧 НАСТУПНІ КРОКИ:"
    echo "   1. Перевірте всі сторінки на коректність"
    echo "   2. Протестуйте контактну форму"
    echo "   3. Перевірте завантаження файлів"
    echo "   4. Оновіть кеш браузера (Ctrl+F5)"
    echo ""
    info "📈 МОНІТОРИНГ:"
    echo "   • Логи: $REMOTE_PATH/logs/"
    echo "   • Backups: ./backups/"
    echo "   • Статус: https://bimhub.site/health.php"
    echo ""
    echo "⏳ Оновлення кешу DNS: 5-10 хвилин"
}

# Головна функція
main() {
    echo "Початок деплою..."
    
    # Перевірка аргументів
    case "$1" in
        "--backup")
            create_backup
            exit 0
            ;;
        "--docker")
            build_docker_image "$2"
            exit 0
            ;;
        "--sync")
            sync_rsync
            exit 0
            ;;
        "--health")
            health_check
            exit 0
            ;;
        "--full")
            check_dependencies
            create_backup
            upload_all_files
            set_permissions
            health_check
            generate_report
            ;;
        *)
            # Стандартний деплой
            check_dependencies
            create_backup
            upload_all_files
            set_permissions
            health_check
            generate_report
            ;;
    esac
}

# Запуск скрипта
main "$@"
