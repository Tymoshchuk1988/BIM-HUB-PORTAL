#!/bin/bash
echo "🚀 ШВИДКИЙ ДЕПЛОЙ НА ХОСТИНГ"
echo "==========================="

LOCAL_DIR="/Users/irynashevchuk/Documents/Тимощук/BIMHub/PORTAL/BIM-HUB-PORTAL/production-deploy"
REMOTE_DIR="/home/ec606796/bimhub.site/www"

SSH_USER="ec606796"
SSH_HOST="ec606796.ftp.tools"
SSH_PASS="Tymoshchuk1988"

if [ ! -d "$LOCAL_DIR" ]; then
    echo "❌ Помилка: Локальна директорія не існує: $LOCAL_DIR"
    echo "   Спочатку виконайте: ./organize-portal.sh"
    exit 1
fi

cd "$LOCAL_DIR"

echo "📁 Вміст локальної директорії:"
ls -la
echo ""

echo "📊 Статистика файлів:"
echo "Файлів: $(find . -type f | wc -l)"
echo "Папок: $(find . -type d | wc -l)"
echo "Загальний розмір: $(du -sh . | cut -f1)"
echo ""

read -p "🔴 Продовжити деплой на $SSH_HOST? (y/n): " -n 1 -r
echo ""
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "❌ Деплой скасовано"
    exit 0
fi

# Створення архіву
echo "📦 Створюю архів..."
ARCHIVE_NAME="portal-deploy-$(date +%Y%m%d-%H%M%S).tar.gz"
tar -czf "../$ARCHIVE_NAME" .
echo "✅ Архів створено: ../$ARCHIVE_NAME ($(du -h "../$ARCHIVE_NAME" | cut -f1))"

# Завантаження на сервер
echo "�� Завантажую на сервер..."
sshpass -p "$SSH_PASS" scp -o StrictHostKeyChecking=no \
    "../$ARCHIVE_NAME" \
    "$SSH_USER@$SSH_HOST:$REMOTE_DIR/"
    
if [ $? -eq 0 ]; then
    echo "✅ Архів завантажено на сервер"
else
    echo "❌ Помилка завантаження архіву"
    exit 1
fi

# Розпакування на сервері
echo "📂 Розпаковую на сервері..."
sshpass -p "$SSH_PASS" ssh -o StrictHostKeyChecking=no \
    "$SSH_USER@$SSH_HOST" "
    cd '$REMOTE_DIR' && \
    echo 'Бекаплю поточну версію...' && \
    tar -czf backup-portal-$(date +%Y%m%d-%H%M%S).tar.gz . --exclude='*.tar.gz' && \
    echo 'Розпаковую нову версію...' && \
    tar -xzf '$ARCHIVE_NAME' && \
    echo 'Налаштовую права доступу...' && \
    chmod 644 *.php *.css *.js && \
    chmod 755 . && \
    echo 'Очищаю архіви...' && \
    rm -f portal-deploy-*.tar.gz && \
    echo '✅ Деплой завершено успішно!'"

# Перевірка
echo ""
echo "🔍 Перевіряю результат деплою..."
sshpass -p "$SSH_PASS" ssh -o StrictHostKeyChecking=no \
    "$SSH_USER@$SSH_HOST" "
    cd '$REMOTE_DIR' && \
    echo '📁 Вміст віддаленої директорії:' && \
    ls -la | head -20 && \
    echo '' && \
    echo '📊 Статистика:' && \
    echo 'Файлів: \$(find . -maxdepth 1 -type f | wc -l)' && \
    echo 'Папок: \$(find . -maxdepth 1 -type d | wc -l)'"

echo ""
echo "🎯 ДЕПЛОЙ ЗАВЕРШЕНО!"
echo "=================="
echo ""
echo "🌐 Перевірте сайт:"
echo "• https://bimhub.site/"
echo "• https://bimhub.site/api/"
echo "• https://bimhub.site/login.php"
echo ""
echo "📝 Логіни для тесту:"
echo "• admin@bimhub.site / Admin@123"
echo "• manager@bimhub.site / Manager@123"
echo ""
echo "🔄 Якщо є проблеми, відкат до бекапу:"
echo "sshpass -p 'Tymoshchuk1988' ssh ec606796@ec606796.ftp.tools 'cd /home/ec606796/bimhub.site/www && tar -xzf backup-portal-*.tar.gz'"
