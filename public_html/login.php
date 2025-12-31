<?php
require_once 'includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Будь ласка, заповніть всі поля';
    } else {
        $conn = getDBConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_role'] = $user['role'];
            
            redirect('/');
        } else {
            $error = 'Невірний email або пароль';
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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a56db 0%, #1e429f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo h1 { color: #1a56db; font-size: 32px; }
        .logo p { color: #666; margin-top: 5px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; }
        input { 
            width: 100%; 
            padding: 12px 15px; 
            border: 2px solid #e5e7eb; 
            border-radius: 8px; 
            font-size: 16px;
            transition: border 0.3s;
        }
        input:focus { 
            outline: none; 
            border-color: #1a56db; 
        }
        .error { 
            color: #ef4444; 
            background: #fee; 
            padding: 10px; 
            border-radius: 8px; 
            margin-bottom: 20px;
            display: <?php echo $error ? 'block' : 'none'; ?>;
        }
        .btn {
            background: linear-gradient(135deg, #1a56db, #1e429f);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: transform 0.2s;
        }
        .btn:hover { transform: translateY(-2px); }
        .links { text-align: center; margin-top: 20px; }
        .links a { color: #1a56db; text-decoration: none; }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>BIM HUB</h1>
            <p>Вхід до системи</p>
        </div>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="your@email.com">
            </div>
            
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>
            
            <button type="submit" class="btn">Увійти</button>
        </form>
        
        <div class="links">
            <p><a href="/">← Повернутися на головну</a></p>
            <p style="margin-top: 10px; color: #666; font-size: 14px;">
                Демо доступ: admin@bimhub.site / password123
            </p>
        </div>
    </div>
</body>
</html>
