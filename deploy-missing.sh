#!/bin/bash
echo "Завантаження пропущених файлів..."

PASSWORD="Tymoshchuk1988"
REMOTE_HOST="ec606796.ftp.tools"
REMOTE_USER="ec606796"
REMOTE_PATH="/home/ec606796/bimhub.site/www"
LOCAL_PATH="./public_html"

# Функції
success() { echo -e "✅ $1"; }
error() { echo -e "❌ $1"; }

# 1. .htaccess
if [ -f "$LOCAL_PATH/.htaccess" ]; then
    sshpass -p "$PASSWORD" scp -o StrictHostKeyChecking=no "$LOCAL_PATH/.htaccess" "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/" && success ".htaccess" || error ".htaccess"
fi

# 2. JS файли
if [ -d "$LOCAL_PATH/js" ] && [ "$(ls -A $LOCAL_PATH/js)" ]; then
    echo "Завантаження JS файлів..."
    for js_file in "$LOCAL_PATH/js"/*; do
        if [ -f "$js_file" ]; then
            filename=$(basename "$js_file")
            sshpass -p "$PASSWORD" scp -o StrictHostKeyChecking=no "$js_file" "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/js/" && success "js/$filename" || error "js/$filename"
        fi
    done
else
    echo "JS папка порожня або не існує"
fi

# 3. Assets
if [ -d "$LOCAL_PATH/assets" ]; then
    echo "Завантаження assets..."
    sshpass -p "$PASSWORD" scp -o StrictHostKeyChecking=no -r "$LOCAL_PATH/assets/" "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/assets/" 2>/dev/null && success "assets/" || error "assets/"
fi

# 4. Admin (якщо є вміст)
if [ -d "$LOCAL_PATH/admin" ] && [ "$(ls -A $LOCAL_PATH/admin)" ]; then
    sshpass -p "$PASSWORD" scp -o StrictHostKeyChecking=no -r "$LOCAL_PATH/admin/" "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/admin/" && success "admin/" || error "admin/"
fi

# 5. Права доступу
echo "Налаштування прав..."
sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no "$REMOTE_USER@$REMOTE_HOST" "
    cd $REMOTE_PATH
    find . -type d -exec chmod 755 {} \;
    find . -type f -exec chmod 644 {} \;
    echo 'Права оновлено'
"

echo "✅ Готово!"
