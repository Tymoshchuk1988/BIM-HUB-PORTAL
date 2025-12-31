# PORTAL/setup_server.py
import subprocess

def setup_server():
    """Налаштовує сервер для порталу"""
    
    commands = [
        # Створюємо папки
        "mkdir -p /home/ec606796/public_html",
        "mkdir -p /home/ec606796/public_html/uploads",
        "mkdir -p /home/ec606796/public_html/assets",
        
        # Налаштовуємо права
        "chmod 755 /home/ec606796/public_html",
        "chmod 777 /home/ec606796/public_html/uploads",
        
        # Створюємо .htaccess
        '''cat > /home/ec606796/public_html/.htaccess << 'EOF'
RewriteEngine On
RewriteBase /

# SPA routing
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [L]

# Security headers
Header set X-Content-Type-Options "nosniff"
EOF''',
        
        # Тестовий PHP файл
        '''echo "<?php phpinfo(); ?>" > /home/ec606796/public_html/info.php'''
    ]
    
    for cmd in commands:
        full_cmd = f"ssh ec606796@ec606796.ftp.tools '{cmd}'"
        print(f"▶️ {full_cmd}")
        subprocess.run(full_cmd, shell=True)
    
    print("✅ Сервер налаштовано")
    print("🌐 Перевірте: https://bimhub.site/info.php")

if __name__ == "__main__":
    setup_server()