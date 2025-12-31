<?php
// Header для BIM Hub Portal
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="site-header">
    <div class="container">
        <div class="header-content">
            <!-- Logo -->
            <div class="logo">
                <a href="/">
                    <span class="logo-icon">🏗️</span>
                    <div class="logo-text">
                        <h1>BIM Hub</h1>
                        <span class="subtitle">Портал впровадження BIM</span>
                    </div>
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="main-nav">
                <ul>
                    <li><a href="/" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                        <i class="fas fa-home"></i> Головна
                    </a></li>
                    <li><a href="#plan">
                        <i class="fas fa-project-diagram"></i> План BIM
                    </a></li>
                    <li><a href="#projects">
                        <i class="fas fa-building"></i> Проекти
                    </a></li>
                    <li><a href="#library">
                        <i class="fas fa-book"></i> Бібліотека
                    </a></li>
                    <li><a href="#contact">
                        <i class="fas fa-envelope"></i> Контакти
                    </a></li>
                </ul>
            </nav>
            
            <!-- User Menu -->
            <div class="user-menu">
                <a href="#login" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Увійти
                </a>
            </div>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <nav class="mobile-nav">
        <ul>
            <li><a href="/"><i class="fas fa-home"></i> Головна</a></li>
            <li><a href="#plan"><i class="fas fa-project-diagram"></i> План BIM</a></li>
            <li><a href="#projects"><i class="fas fa-building"></i> Проекти</a></li>
            <li><a href="#library"><i class="fas fa-book"></i> Бібліотека</a></li>
            <li><a href="#contact"><i class="fas fa-envelope"></i> Контакти</a></li>
            <li><a href="#login"><i class="fas fa-sign-in-alt"></i> Увійти</a></li>
        </ul>
    </nav>
</div>
