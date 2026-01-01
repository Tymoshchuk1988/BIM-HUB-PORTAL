<?php
// login.php - Виправлена версія з правильними паролями
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (empty($email) || empty($password)) {
        $error = 'Будь ласка, заповніть всі поля';
    } else {
        $db = getDB();
        
        if ($db === false) {
            $error = 'Помилка підключення до бази даних';
        } else {
            try {
                // Використовуємо правильну назву стовпця
                $stmt = $db->prepare("SELECT id, email, password_hash, full_name, role FROM users WHERE email = ? AND status = 'active'");
                $stmt->execute([$email]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password_hash'])) {
                    // Успішний вхід
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_name'] = $user['full_name'];
                    $_SESSION['user_role'] = $user['role'];
                    
                    // Перенаправлення на dashboard
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $error = 'Невірний email або пароль';
                }
            } catch (PDOException $e) {
                $error = 'Помилка системи: ' . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Вхід - BIM Hub</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 50px; }
        .login-box { max-width: 400px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; }
        .error { background: #ffebee; color: #c62828; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #2196F3; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #1976D2; }
        .demo-info { background: #e8f5e9; padding: 15px; border-radius: 5px; margin-top: 20px; font-size: 14px; }
        .demo-info h3 { margin-top: 0; color: #2e7d32; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>🔐 Вхід до BIM Hub</h1>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="email" name="email" placeholder="Email" required value="admin@bimhub.site">
            <input type="password" name="password" placeholder="Пароль" required value="Admin@123">
            <button type="submit" name="login">Увійти</button>
        </form>
        
        <div class="demo-info">
            <h3>👤 Демо доступ:</h3>
            <p><strong>Адмін:</strong> admin@bimhub.site / Admin@123</p>
            <p><strong>Менеджер:</strong> manager@bimhub.site / Manager@123</p>
            <p><strong>BIM спеціаліст:</strong> bim@bimhub.site / Bim@123</p>
            <p><strong>Переглядач:</strong> viewer@bimhub.site / Viewer@123</p>
        </div>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="/">← Повернутися на головну</a>
        </div>
    </div>
</body>
</html>
