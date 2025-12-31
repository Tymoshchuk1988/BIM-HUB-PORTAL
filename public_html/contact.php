<?php
require_once 'includes/config.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $organization = trim($_POST['organization'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $type = $_POST['type'] ?? 'general';
    
    // Валідація
    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Будь ласка, заповніть обов\'язкові поля';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Будь ласка, введіть коректний email';
    } else {
        try {
            $conn = getDatabaseConnection();
            $stmt = $conn->prepare("
                INSERT INTO contacts (name, email, phone, organization, subject, message, contact_type)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([$name, $email, $phone, $organization, $subject, $message, $type]);
            $success = true;
            
            // Логування
            logActivity("Контактна форма: $subject", null, 'contact');
            
        } catch (Exception $e) {
            $error = 'Сталася помилка. Будь ласка, спробуйте пізніше.';
            error_log("Contact form error: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакти - BIM Hub</title>
    <style>
        .contact-form {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 500; color: #333; }
        .required::after { content: ' *'; color: #ef4444; }
        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 16px;
            transition: border 0.3s;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #1a56db;
        }
        .success-message {
            background: #d1fae5;
            color: #065f46;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include 'layout.php'; ?>
    
    <div class="container">
        <h1 style="text-align: center; margin: 40px 0 20px;">Контакти</h1>
        
        <div class="contact-form">
            <?php if ($success): ?>
                <div class="success-message">
                    ✅ Дякуємо за ваше повідомлення! Ми зв'яжемося з вами найближчим часом.
                </div>
            <?php elseif ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label class="required">Повне ім'я</label>
                    <input type="text" name="name" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label class="required">Email</label>
                    <input type="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label>Телефон</label>
                    <input type="tel" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label>Організація</label>
                    <input type="text" name="organization" value="<?php echo htmlspecialchars($_POST['organization'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label class="required">Тема</label>
                    <input type="text" name="subject" required value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label class="required">Тип запиту</label>
                    <select name="type" required>
                        <option value="general">Загальне питання</option>
                        <option value="support">Технічна підтримка</option>
                        <option value="partnership">Партнерство</option>
                        <option value="career">Кар'єра</option>
                        <option value="other">Інше</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="required">Повідомлення</label>
                    <textarea name="message" rows="6" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                </div>
                
                <button type="submit" style="background: #1a56db; color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; width: 100%;">
                    Надіслати повідомлення
                </button>
            </form>
        </div>
    </div>
</body>
</html>
