<?php
// Base layout template
$page_title = $page_title ?? 'BIM Hub | Портал інформаційного моделювання будівель';
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="/css/main.css">
    
    <!-- Page specific CSS -->
    <?php if (isset($page_css)): ?>
    <style><?php echo $page_css; ?></style>
    <?php endif; ?>
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <div class="container header-container">
            <a href="/" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <div class="logo-text">
                    <div class="logo-title">BIM HUB</div>
                    <div class="logo-subtitle">ПОРТАЛ ІНФОРМАЦІЙНОГО МОДЕЛЮВАННЯ</div>
                </div>
            </a>
            
            <nav class="nav">
                <a href="/" class="nav-link <?php echo $current_page == 'index' ? 'active' : ''; ?>">
                    Головна
                </a>
                <a href="/pages/strategy/" class="nav-link <?php echo $current_page == 'strategy' ? 'active' : ''; ?>">
                    Стратегія
                </a>
                <a href="/pages/projects/" class="nav-link <?php echo $current_page == 'projects' ? 'active' : ''; ?>">
                    Проекти
                </a>
                <a href="/pages/library/" class="nav-link <?php echo $current_page == 'library' ? 'active' : ''; ?>">
                    Бібліотека
                </a>
                <a href="/pages/education/" class="nav-link <?php echo $current_page == 'education' ? 'active' : ''; ?>">
                    Навчання
                </a>
                <a href="/pages/team/" class="nav-link <?php echo $current_page == 'team' ? 'active' : ''; ?>">
                    Команда
                </a>
            </nav>
            
            <div class="header-actions">
                <button class="btn btn-secondary" onclick="showLoginModal()">
                    <i class="fas fa-sign-in-alt"></i> Увійти
                </button>
                <button class="btn btn-primary" onclick="showDemoModal()">
                    Демо-доступ
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <?php echo $content ?? ''; ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-col-title">BIM HUB</div>
                    <p style="color: var(--gray-400); margin-bottom: var(--space-lg);">
                        Портал інформаційного моделювання будівель для відновлення України
                    </p>
                </div>
                
                <div>
                    <div class="footer-col-title">Навігація</div>
                    <ul class="footer-links">
                        <li><a href="/" class="footer-link">Головна</a></li>
                        <li><a href="/pages/strategy/" class="footer-link">Стратегія</a></li>
                        <li><a href="/pages/projects/" class="footer-link">Проекти</a></li>
                        <li><a href="/pages/library/" class="footer-link">Бібліотека</a></li>
                        <li><a href="/pages/education/" class="footer-link">Навчання</a></li>
                    </ul>
                </div>
                
                <div>
                    <div class="footer-col-title">Контакти</div>
                    <ul class="footer-links">
                        <li class="footer-link">info@bimhub.gov.ua</li>
                        <li class="footer-link">+380 44 123 4567</li>
                        <li class="footer-link">Київ, вул. Хрещатик, 1</li>
                    </ul>
                </div>
                
                <div>
                    <div class="footer-col-title">Партнери</div>
                    <ul class="footer-links">
                        <li><a href="#" class="footer-link">Агентство відновлення</a></li>
                        <li><a href="#" class="footer-link">Мінрегіон</a></li>
                        <li><a href="#" class="footer-link">Мінінфраструктури</a></li>
                        <li><a href="#" class="footer-link">ЄБРР</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>© 2024 Агентство відновлення України. Усі права захищено.</p>
                <p style="margin-top: var(--space-sm);">Розроблено для потреб відбудови України</p>
            </div>
        </div>
    </footer>

    <!-- Modals -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('loginModal')">&times;</span>
            <h3>Вхід до системи</h3>
            <form id="loginForm">
                <input type="email" placeholder="Email" required>
                <input type="password" placeholder="Пароль" required>
                <button type="submit" class="btn btn-primary">Увійти</button>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="/js/main.js"></script>
    <?php if (isset($page_js)): ?>
    <script><?php echo $page_js; ?></script>
    <?php endif; ?>
</body>
</html>
