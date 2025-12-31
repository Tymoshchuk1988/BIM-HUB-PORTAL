<?php
// setup.php - Налаштування бази даних через веб-інтерфейс
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIM Hub - Налаштування бази даних</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; }
        .container { background: white; border-radius: 15px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; max-width: 900px; width: 100%; }
        .header { background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%); color: white; padding: 30px; text-align: center; }
        .header h1 { font-size: 2.5em; margin-bottom: 10px; }
        .header p { opacity: 0.9; }
        .content { padding: 30px; }
        .step { margin-bottom: 30px; padding: 20px; border-radius: 10px; background: #f8f9fa; border-left: 5px solid #007bff; }
        .step h2 { color: #007bff; margin-bottom: 15px; }
        .step h3 { color: #495057; margin: 15px 0 10px 0; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #495057; font-weight: 500; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; font-size: 16px; }
        .btn { background: #007bff; color: white; border: none; padding: 12px 24px; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: 500; transition: background 0.3s; }
        .btn:hover { background: #0056b3; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #1e7e34; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .result { margin-top: 20px; padding: 15px; border-radius: 5px; display: none; }
        .success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; }
        pre { background: #2c3e50; color: #ecf0f1; padding: 15px; border-radius: 5px; overflow-x: auto; margin: 10px 0; }
        .code-block { position: relative; }
        .copy-btn { position: absolute; top: 10px; right: 10px; background: #6c757d; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
        .alert { padding: 15px; border-radius: 5px; margin: 15px 0; }
        .alert-warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; }
        .tab { display: none; }
        .tab.active { display: block; }
        .tab-nav { display: flex; border-bottom: 2px solid #dee2e6; margin-bottom: 20px; }
        .tab-link { padding: 10px 20px; cursor: pointer; border: none; background: none; color: #6c757d; font-weight: 500; }
        .tab-link.active { color: #007bff; border-bottom: 3px solid #007bff; margin-bottom: -2px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏗️ BIM Hub Portal</h1>
            <p>Налаштування бази даних та системи</p>
        </div>
        
        <div class="content">
            <div class="tab-nav">
                <button class="tab-link active" onclick="openTab('tab1')">📊 База даних</button>
                <button class="tab-link" onclick="openTab('tab2')">⚙️ Конфігурація</button>
                <button class="tab-link" onclick="openTab('tab3')">👥 Користувачі</button>
                <button class="tab-link" onclick="openTab('tab4')">📁 Файли</button>
            </div>
            
            <!-- ТАБ 1: Налаштування бази даних -->
            <div id="tab1" class="tab active">
                <div class="step">
                    <h2>📊 Налаштування підключення до бази даних</h2>
                    
                    <?php
                    // Перевірка підключення до бази
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_connection'])) {
                        $host = $_POST['host'] ?? 'ec606796.mysql.tools';
                        $dbname = $_POST['dbname'] ?? 'ec606796_bimhub';
                        $user = $_POST['user'] ?? 'ec606796_bimhub';
                        $pass = $_POST['pass'] ?? '(9ypA;7Ha6';
                        
                        echo '<div class="alert alert-warning">';
                        echo '<h3>🔍 Тестування підключення...</h3>';
                        
                        try {
                            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
                            $pdo = new PDO($dsn, $user, $pass, [
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                            ]);
                            
                            echo '<div class="result success">';
                            echo '✅ <strong>Успішне підключення!</strong><br>';
                            echo 'Версія MySQL: ' . $pdo->query('SELECT VERSION()')->fetchColumn() . '<br>';
                            
                            // Перевірка таблиць
                            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
                            if (empty($tables)) {
                                echo 'Таблиці: Не знайдено (база порожня)';
                            } else {
                                echo 'Таблиць знайдено: ' . count($tables);
                            }
                            echo '</div>';
                            
                            $_SESSION['db_config'] = compact('host', 'dbname', 'user', 'pass');
                            
                        } catch (PDOException $e) {
                            echo '<div class="result error">';
                            echo '❌ <strong>Помилка підключення:</strong><br>';
                            echo htmlspecialchars($e->getMessage());
                            echo '</div>';
                        }
                        
                        echo '</div>';
                    }
                    ?>
                    
                    <form method="POST">
                        <div class="form-group">
                            <label for="host">Хост бази даних:</label>
                            <input type="text" id="host" name="host" value="ec606796.mysql.tools" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="dbname">Назва бази даних:</label>
                            <input type="text" id="dbname" name="dbname" value="ec606796_bimhub" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="user">Користувач:</label>
                            <input type="text" id="user" name="user" value="ec606796_bimhub" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="pass">Пароль:</label>
                            <input type="password" id="pass" name="pass" value="(9ypA;7Ha6" required>
                        </div>
                        
                        <button type="submit" name="test_connection" class="btn">🔍 Тестувати підключення</button>
                        
                        <?php if (isset($_SESSION['db_config'])): ?>
                        <button type="button" class="btn btn-success" onclick="createTables()">🗄️ Створити таблиці</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            
            <!-- ТАБ 2: Конфігурація -->
            <div id="tab2" class="tab">
                <div class="step">
                    <h2>⚙️ Генерація конфігураційних файлів</h2>
                    
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_config'])) {
                        $config_content = '<?php
// 📁 Конфігурація BIM Hub Portal
define(\'DB_HOST\', \'' . ($_SESSION['db_config']['host'] ?? 'localhost') . '\');
define(\'DB_NAME\', \'' . ($_SESSION['db_config']['dbname'] ?? 'bimhub') . '\');
define(\'DB_USER\', \'' . ($_SESSION['db_config']['user'] ?? 'root') . '\');
define(\'DB_PASS\', \'' . ($_SESSION['db_config']['pass'] ?? '') . '\');
define(\'SITE_URL\', \'https://bimhub.site\');
define(\'SITE_NAME\', \'BIM Hub Portal\');

session_start();

// Функція для підключення до БД
function getDB() {
    static $db = null;
    
    if ($db === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $db = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
    
    return $db;
}

// Перевірка авторизації
function isLoggedIn() {
    return isset($_SESSION[\'user_id\']) && isset($_SESSION[\'user_role\']);
}

// Отримання поточної сторінки
function getCurrentPage() {
    $path = $_SERVER[\'PHP_SELF\'];
    $page = basename($path, \'.php\');
    return $page;
}
?>';
                        
                        echo '<div class="code-block">';
                        echo '<button class="copy-btn" onclick="copyCode(\'config-code\')">Копіювати</button>';
                        echo '<pre id="config-code">' . htmlspecialchars($config_content) . '</pre>';
                        echo '</div>';
                        
                        echo '<div class="result info">';
                        echo '📋 Скопіюйте цей код у файл <strong>config.php</strong> у корені сайту';
                        echo '</div>';
                    }
                    ?>
                    
                    <p>Створіть конфігураційний файл для вашого сайту:</p>
                    <form method="POST">
                        <button type="submit" name="generate_config" class="btn">📄 Згенерувати config.php</button>
                    </form>
                </div>
            </div>
            
            <!-- ТАБ 3: Користувачі -->
            <div id="tab3" class="tab">
                <div class="step">
                    <h2>👥 Створення користувачів системи</h2>
                    <p>Додайте перших користувачів до системи:</p>
                    
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_users'])) {
                        if (isset($_SESSION['db_config'])) {
                            $config = $_SESSION['db_config'];
                            
                            try {
                                $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
                                $pdo = new PDO($dsn, $config['user'], $config['pass'], [
                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                                ]);
                                
                                // SQL для створення таблиць і користувачів
                                $sql = "
                                -- Таблиця користувачів
                                CREATE TABLE IF NOT EXISTS users (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    email VARCHAR(255) UNIQUE NOT NULL,
                                    password_hash VARCHAR(255) NOT NULL,
                                    full_name VARCHAR(255),
                                    role ENUM('admin', 'project_manager', 'bim_specialist', 'viewer') DEFAULT 'viewer',
                                    status ENUM('active', 'inactive') DEFAULT 'active',
                                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                    INDEX idx_email (email),
                                    INDEX idx_role (role)
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                                
                                -- Демо користувачі
                                INSERT IGNORE INTO users (email, password_hash, full_name, role) VALUES
                                ('admin@bimhub.site', '" . password_hash('Admin@123', PASSWORD_DEFAULT) . "', 'Адміністратор Системи', 'admin'),
                                ('manager@bimhub.site', '" . password_hash('Manager@123', PASSWORD_DEFAULT) . "', 'Менеджер Проектів', 'project_manager'),
                                ('bim@bimhub.site', '" . password_hash('Bim@123', PASSWORD_DEFAULT) . "', 'BIM Спеціаліст', 'bim_specialist');
                                ";
                                
                                $pdo->exec($sql);
                                
                                echo '<div class="result success">';
                                echo '✅ <strong>Користувачі успішно створені!</strong><br>';
                                echo 'Облікові дані для входу:<br>';
                                echo '<ul>';
                                echo '<li><strong>admin@bimhub.site</strong> / Admin@123 (Адміністратор)</li>';
                                echo '<li><strong>manager@bimhub.site</strong> / Manager@123 (Менеджер)</li>';
                                echo '<li><strong>bim@bimhub.site</strong> / Bim@123 (BIM спеціаліст)</li>';
                                echo '</ul>';
                                echo '</div>';
                                
                            } catch (PDOException $e) {
                                echo '<div class="result error">';
                                echo '❌ <strong>Помилка:</strong> ' . htmlspecialchars($e->getMessage());
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="result error">';
                            echo '❌ Спочатку налаштуйте підключення до бази даних (Вкладка 1)';
                            echo '</div>';
                        }
                    }
                    ?>
                    
                    <form method="POST">
                        <button type="submit" name="create_users" class="btn btn-success">👥 Створити демо-користувачів</button>
                    </form>
                </div>
            </div>
            
            <!-- ТАБ 4: Файли -->
            <div id="tab4" class="tab">
                <div class="step">
                    <h2>📁 Створення необхідних файлів</h2>
                    
                    <?php
                    // Логіка створення файлів
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $files_created = [];
                        
                        if (isset($_POST['create_login'])) {
                            $login_content = '<?php
require_once "config.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");
    
    $db = getDB();
    if ($db) {
        $stmt = $db->prepare("SELECT id, email, password_hash, full_name, role FROM users WHERE email = ? AND status = ?active?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user["password_hash"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_email"] = $user["email"];
            $_SESSION["user_name"] = $user["full_name"];
            $_SESSION["user_role"] = $user["role"];
            
            header("Location: index.php");
            exit;
        } else {
            $error = "Невірний email або пароль";
        }
    } else {
        $error = "Помилка підключення до бази даних";
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <h1>🔐 Вхід до BIM Hub Portal</h1>
        
        <?php if ($error): ?>
        <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
        <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" name="login" class="btn">Увійти</button>
        </form>
        
        <p style="margin-top: 20px;">
            <a href="index.php">← Повернутися на головну</a>
        </p>
    </div>
</body>
</html>';
                            
                            if (file_put_contents('login.php', $login_content)) {
                                $files_created[] = 'login.php';
                            }
                        }
                        
                        if (!empty($files_created)) {
                            echo '<div class="result success">';
                            echo '✅ <strong>Створені файли:</strong><br>';
                            echo '<ul>';
                            foreach ($files_created as $file) {
                                echo "<li>$file</li>";
                            }
                            echo '</ul>';
                            echo '</div>';
                        }
                    }
                    ?>
                    
                    <p>Створіть необхідні файли для роботи порталу:</p>
                    
                    <form method="POST">
                        <div class="form-group">
                            <button type="submit" name="create_login" class="btn">🔐 Створити login.php</button>
                            <button type="submit" name="create_dashboard" class="btn">📊 Створити dashboard.php</button>
                            <button type="submit" name="create_css" class="btn">🎨 Створити style.css</button>
                        </div>
                    </form>
                    
                    <div class="alert alert-warning">
                        <strong>⚠️ Важливо!</strong> Після налаштування видаліть цей файл (setup.php) з сервера!
                    </div>
                </div>
            </div>
            
            <div class="step">
                <h2>✅ Завершення налаштування</h2>
                <p>Після виконання всіх кроків ваш портал буде готовий до роботи.</p>
                
                <div class="form-group">
                    <a href="https://bimhub.site" class="btn btn-success" target="_blank">🌐 Перейти на сайт</a>
                    <button class="btn btn-danger" onclick="deleteSetupFile()">🗑️ Видалити цей файл налаштування</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function openTab(tabName) {
            // Приховуємо всі вкладки
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Приховуємо всі посилання
            document.querySelectorAll('.tab-link').forEach(link => {
                link.classList.remove('active');
            });
            
            // Показуємо вибрану вкладку
            document.getElementById(tabName).classList.add('active');
            event.currentTarget.classList.add('active');
        }
        
        function copyCode(elementId) {
            const codeElement = document.getElementById(elementId);
            const textArea = document.createElement('textarea');
            textArea.value = codeElement.textContent;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            
            const btn = event.target;
            const originalText = btn.textContent;
            btn.textContent = '✅ Скопійовано!';
            setTimeout(() => {
                btn.textContent = originalText;
            }, 2000);
        }
        
        function createTables() {
            if (confirm('Створити всі необхідні таблиці в базі даних?')) {
                // Тут буде AJAX запит для створення таблиць
                alert('Створення таблиць... Перейдіть на вкладку "👥 Користувачі" для завершення.');
                openTab('tab3');
            }
        }
        
        function deleteSetupFile() {
            if (confirm('Видалити файл налаштування? Цю дію неможливо скасувати.')) {
                fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'delete_setup=true'
                }).then(response => {
                    if (response.ok) {
                        alert('Файл видалено! Перенаправляємо на головну сторінку...');
                        window.location.href = '/';
                    }
                });
            }
        }
        
        // Автоматичне тестування підключення при завантаженні
        window.onload = function() {
            <?php if (!isset($_SESSION['db_config'])): ?>
            document.querySelector('button[name="test_connection"]').click();
            <?php endif; ?>
        };
    </script>
</body>
</html>

<?php
// Обробка видалення файлу
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_setup'])) {
    unlink(__FILE__);
    header('Location: /');
    exit;
}
?>
