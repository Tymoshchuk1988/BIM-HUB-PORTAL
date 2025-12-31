<?php
// Strategy page
$current_page = 'strategy';
$page_title = 'Стратегія BIM | BIM Hub';
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            /* Color Palette - Professional */
            --primary: #1a56db;
            --primary-dark: #1e429f;
            --primary-light: #ebf5ff;
            --secondary: #111827;
            --accent: #f59e0b;
            --accent-light: #fef3c7;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            
            /* Neutrals */
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            /* Spacing */
            --space-xs: 0.25rem;
            --space-sm: 0.5rem;
            --space-md: 1rem;
            --space-lg: 1.5rem;
            --space-xl: 2rem;
            --space-2xl: 3rem;
            --space-3xl: 4rem;
            
            /* Typography */
            --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-heading: 'Manrope', var(--font-sans);
            
            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            
            /* Border Radius */
            --radius-sm: 0.25rem;
            --radius: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
            --radius-full: 9999px;
            
            /* Transitions */
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition: 250ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 350ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: var(--font-sans);
            font-size: 16px;
            line-height: 1.6;
            color: var(--gray-800);
            background-color: var(--gray-50);
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            font-weight: 700;
            line-height: 1.2;
            color: var(--gray-900);
        }
        
        a {
            text-decoration: none;
            color: inherit;
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 var(--space-lg);
        }
        
        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            z-index: 1000;
            padding: var(--space-md) 0;
            transition: all var(--transition);
        }
        
        .header.scrolled {
            padding: var(--space-sm) 0;
            box-shadow: var(--shadow-lg);
        }
        
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }
        
        .logo-text {
            display: flex;
            flex-direction: column;
        }
        
        .logo-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--gray-900);
            letter-spacing: -0.025em;
        }
        
        .logo-subtitle {
            font-size: 0.75rem;
            color: var(--gray-500);
            font-weight: 500;
            letter-spacing: 0.05em;
        }
        
        .nav {
            display: flex;
            align-items: center;
            gap: var(--space-xl);
        }
        
        .nav-link {
            position: relative;
            font-weight: 600;
            color: var(--gray-700);
            padding: var(--space-sm) 0;
            transition: color var(--transition);
            font-size: 0.95rem;
        }
        
        .nav-link:hover {
            color: var(--primary);
        }
        
        .nav-link.active {
            color: var(--primary);
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--primary);
            border-radius: var(--radius-full);
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: var(--space-md);
        }
        
        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-sm);
            padding: 0.625rem 1.5rem;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 0.875rem;
            line-height: 1;
            border: none;
            cursor: pointer;
            transition: all var(--transition);
            outline: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: var(--shadow-md);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-secondary {
            background: transparent;
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }
        
        .btn-secondary:hover {
            border-color: var(--gray-400);
            background: var(--gray-50);
        }
        
        /* Page Hero */
        .page-hero {
            padding-top: 120px;
            padding-bottom: var(--space-3xl);
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            color: white;
            text-align: center;
        }
        
        .page-hero-title {
            font-size: 3rem;
            margin-bottom: var(--space-md);
            line-height: 1.1;
        }
        
        .page-hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.7;
        }
        
        /* Strategy Content */
        .strategy-content {
            padding: var(--space-3xl) 0;
            background: white;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: var(--space-3xl);
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .section-title {
            font-size: 2.5rem;
            margin-bottom: var(--space-md);
            color: var(--gray-900);
        }
        
        .section-subtitle {
            font-size: 1.125rem;
            color: var(--gray-600);
            line-height: 1.7;
        }
        
        /* Strategy Grid */
        .strategy-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-xl);
            margin-bottom: var(--space-3xl);
        }
        
        .strategy-card {
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            border: 1px solid var(--gray-200);
            transition: all var(--transition);
        }
        
        .strategy-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-2xl);
            border-color: var(--primary-light);
        }
        
        .strategy-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary-light), white);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-lg);
            color: var(--primary);
            font-size: 1.75rem;
            border: 1px solid var(--gray-200);
        }
        
        .strategy-card-title {
            font-size: 1.5rem;
            margin-bottom: var(--space-md);
            color: var(--gray-900);
        }
        
        .strategy-card-description {
            color: var(--gray-600);
            line-height: 1.7;
        }
        
        /* Roadmap */
        .roadmap {
            margin: var(--space-3xl) 0;
        }
        
        .roadmap-timeline {
            position: relative;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .roadmap-timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(to bottom, var(--primary), var(--accent));
            transform: translateX(-50%);
        }
        
        .roadmap-item {
            position: relative;
            margin-bottom: var(--space-2xl);
            width: 50%;
            padding: var(--space-xl);
        }
        
        .roadmap-item:nth-child(odd) {
            left: 0;
        }
        
        .roadmap-item:nth-child(even) {
            left: 50%;
        }
        
        .roadmap-dot {
            position: absolute;
            width: 24px;
            height: 24px;
            background: white;
            border: 4px solid var(--primary);
            border-radius: var(--radius-full);
            top: var(--space-xl);
        }
        
        .roadmap-item:nth-child(odd) .roadmap-dot {
            right: -12px;
        }
        
        .roadmap-item:nth-child(even) .roadmap-dot {
            left: -12px;
        }
        
        .roadmap-year {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: var(--space-xs) var(--space-md);
            border-radius: var(--radius-full);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: var(--space-sm);
        }
        
        .roadmap-content {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-lg);
        }
        
        .roadmap-title {
            font-size: 1.25rem;
            margin-bottom: var(--space-sm);
            color: var(--gray-900);
        }
        
        /* KPIs */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-xl);
            margin-top: var(--space-2xl);
        }
        
        .kpi-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            text-align: center;
        }
        
        .kpi-value {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: var(--space-sm);
        }
        
        .kpi-label {
            font-size: 1rem;
            opacity: 0.9;
        }
        
        /* Footer */
        .footer {
            background: var(--gray-900);
            color: white;
            padding: var(--space-3xl) 0 var(--space-xl);
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-2xl);
            margin-bottom: var(--space-2xl);
        }
        
        .footer-col-title {
            font-size: 1rem;
            font-weight: 700;
            color: white;
            margin-bottom: var(--space-lg);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-link {
            padding: var(--space-xs) 0;
            color: var(--gray-400);
            transition: color var(--transition);
        }
        
        .footer-link:hover {
            color: white;
        }
        
        .footer-bottom {
            padding-top: var(--space-xl);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: var(--gray-400);
            font-size: 0.875rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav {
                display: none;
            }
            
            .page-hero-title {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .roadmap-timeline::before {
                left: 0;
            }
            
            .roadmap-item {
                width: 100%;
                left: 0 !important;
                padding-left: var(--space-2xl);
            }
            
            .roadmap-item:nth-child(odd) .roadmap-dot,
            .roadmap-item:nth-child(even) .roadmap-dot {
                left: -12px;
                right: auto;
            }
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
    </style>
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
                    <div class="logo-subtitle">ПОРТАЛ</div>
                </div>
            </a>
            
            <nav class="nav">
                <a href="/" class="nav-link">Головна</a>
                <a href="/pages/strategy/" class="nav-link active">Стратегія</a>
                <a href="/pages/projects/" class="nav-link">Проекти</a>
                <a href="/pages/library/" class="nav-link">Бібліотека</a>
                <a href="/pages/education/" class="nav-link">Навчання</a>
                <a href="/pages/team/" class="nav-link">Команда</a>
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

    <!-- Page Hero -->
    <section class="page-hero">
        <div class="container">
            <h1 class="page-hero-title fade-in-up">Стратегія впровадження BIM</h1>
            <p class="page-hero-subtitle fade-in-up delay-1">
                Комплексний план розвитку будівельного інформаційного моделювання в Україні на 2025-2028 роки
            </p>
        </div>
    </section>

    <!-- Strategy Content -->
    <section class="strategy-content">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Ключові напрямки стратегії</h2>
                <p class="section-subtitle">
                    Шість стратегічних пріоритетів для успішного впровадження BIM в Україні
                </p>
            </div>
            
            <div class="strategy-grid">
                <div class="strategy-card fade-in-up delay-1">
                    <div class="strategy-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <h3 class="strategy-card-title">Нормативно-правова база</h3>
                    <p class="strategy-card-description">
                        Розробка та впровадження національних стандартів BIM, адаптація міжнародних стандартів ISO 19650
                    </p>
                </div>
                
                <div class="strategy-card fade-in-up delay-2">
                    <div class="strategy-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="strategy-card-title">Кадровий потенціал</h3>
                    <p class="strategy-card-description">
                        Підготовка BIM-фахівців, створення освітніх програм, сертифікація спеціалістів
                    </p>
                </div>
                
                <div class="strategy-card fade-in-up delay-3">
                    <div class="strategy-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="strategy-card-title">Технологічна інфраструктура</h3>
                    <p class="strategy-card-description">
                        Розвиток програмних рішень, хмарних платформ, інтеграція з державними системами
                    </p>
                </div>
                
                <div class="strategy-card fade-in-up delay-4">
                    <div class="strategy-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h3 class="strategy-card-title">Пілотні проекти</h3>
                    <p class="strategy-card-description">
                        Реалізація пілотних проектів BIM в ключових галузях: житлове будівництво, інфраструктура
                    </p>
                </div>
                
                <div class="strategy-card fade-in-up delay-1">
                    <div class="strategy-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3 class="strategy-card-title">Міжнародна співпраця</h3>
                    <p class="strategy-card-description">
                        Участь у міжнародних ініціативах, обмін досвідом з країнами ЄС та США
                    </p>
                </div>
                
                <div class="strategy-card fade-in-up delay-2">
                    <div class="strategy-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="strategy-card-title">Моніторинг та оцінка</h3>
                    <p class="strategy-card-description">
                        Система моніторингу прогресу, KPI, регулярна оцінка ефективності впровадження
                    </p>
                </div>
            </div>
            
            <!-- Roadmap -->
            <div class="roadmap">
                <div class="section-header fade-in-up">
                    <h2 class="section-title">Дорожня карта впровадження</h2>
                    <p class="section-subtitle">
                        Поетапний план дій на 2025-2028 роки
                    </p>
                </div>
                
                <div class="roadmap-timeline">
                    <div class="roadmap-item fade-in-up delay-1">
                        <span class="roadmap-year">2025</span>
                        <div class="roadmap-content">
                            <h3 class="roadmap-title">Підготовчий етап</h3>
                            <p>Формування робочих груп, розробка стандартів, запуск пілотних проектів</p>
                        </div>
                        <div class="roadmap-dot"></div>
                    </div>
                    
                    <div class="roadmap-item fade-in-up delay-2">
                        <span class="roadmap-year">2026</span>
                        <div class="roadmap-content">
                            <h3 class="roadmap-title">Етап розширення</h3>
                            <p>Масштабування на регіональному рівні, підготовка кадрів, розвиток інфраструктури</p>
                        </div>
                        <div class="roadmap-dot"></div>
                    </div>
                    
                    <div class="roadmap-item fade-in-up delay-3">
                        <span class="roadmap-year">2027</span>
                        <div class="roadmap-content">
                            <h3 class="roadmap-title">Етап інтеграції</h3>
                            <p>Повномасштабне впровадження, інтеграція з держсистемами, міжнародна співпраця</p>
                        </div>
                        <div class="roadmap-dot"></div>
                    </div>
                    
                    <div class="roadmap-item fade-in-up delay-4">
                        <span class="roadmap-year">2028</span>
                        <div class="roadmap-content">
                            <h3 class="roadmap-title">Етап оптимізації</h3>
                            <p>Вдосконалення процесів, аналіз результатів, планування наступних етапів</p>
                        </div>
                        <div class="roadmap-dot"></div>
                    </div>
                </div>
            </div>
            
            <!-- KPIs -->
            <div class="section-header fade-in-up">
                <h2 class="section-title">Ключові показники ефективності</h2>
                <p class="section-subtitle">
                    Цілі та метрики для оцінки прогресу впровадження BIM
                </p>
            </div>
            
            <div class="kpi-grid">
                <div class="kpi-card fade-in-up delay-1">
                    <div class="kpi-value">80%</div>
                    <div class="kpi-label">Держзамовлень з BIM</div>
                </div>
                
                <div class="kpi-card fade-in-up delay-2">
                    <div class="kpi-value">5000+</div>
                    <div class="kpi-label">Сертифікованих фахівців</div>
                </div>
                
                <div class="kpi-card fade-in-up delay-3">
                    <div class="kpi-value">30%</div>
                    <div class="kpi-label">Економія ресурсів</div>
                </div>
                
                <div class="kpi-card fade-in-up delay-4">
                    <div class="kpi-value">100+</div>
                    <div class="kpi-label">Успішних проектів</div>
                </div>
            </div>
        </div>
    </section>

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
                        <li><a href="#" class="footer-link">Мінрозвитку</a></li>
                        <li><a href="#" class="footer-link">Мінцифри</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>© 2025 Усі права захищено.</p>
                <p style="margin-top: var(--space-sm);">Розроблено для потреб відбудови України</p>
            </div>
        </div>
    </footer>

    <!-- Modals -->
    <div id="loginModal" class="modal" style="display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
        <div class="modal-content" style="background-color: white; margin: 15% auto; padding: var(--space-xl); border-radius: var(--radius-lg); width: 90%; max-width: 400px; position: relative; box-shadow: var(--shadow-2xl);">
            <span class="close-modal" onclick="closeModal('loginModal')" style="color: var(--gray-500); float: right; font-size: 28px; font-weight: bold; cursor: pointer; position: absolute; right: var(--space-md); top: var(--space-md);">&times;</span>
            <h3>Вхід до системи</h3>
            <form id="loginForm" style="margin-top: var(--space-lg);">
                <input type="email" placeholder="Email" required style="width: 100%; padding: var(--space-md); margin-bottom: var(--space-md); border: 1px solid var(--gray-300); border-radius: var(--radius);">
                <input type="password" placeholder="Пароль" required style="width: 100%; padding: var(--space-md); margin-bottom: var(--space-md); border: 1px solid var(--gray-300); border-radius: var(--radius);">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Увійти</button>
            </form>
        </div>
    </div>

    <div id="demoModal" class="modal" style="display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
        <div class="modal-content" style="background-color: white; margin: 15% auto; padding: var(--space-xl); border-radius: var(--radius-lg); width: 90%; max-width: 500px; position: relative; box-shadow: var(--shadow-2xl);">
            <span class="close-modal" onclick="closeModal('demoModal')" style="color: var(--gray-500); float: right; font-size: 28px; font-weight: bold; cursor: pointer; position: absolute; right: var(--space-md); top: var(--space-md);">&times;</span>
            <h3>Демо-доступ до порталу</h3>
            <p style="margin-top: var(--space-md); color: var(--gray-600);">Заповніть форму для отримання демо-доступу до повного функціоналу порталу BIM Hub.</p>
            <form id="demoForm" style="margin-top: var(--space-lg);">
                <input type="text" placeholder="Ім'я та прізвище" required style="width: 100%; padding: var(--space-md); margin-bottom: var(--space-md); border: 1px solid var(--gray-300); border-radius: var(--radius);">
                <input type="email" placeholder="Email" required style="width: 100%; padding: var(--space-md); margin-bottom: var(--space-md); border: 1px solid var(--gray-300); border-radius: var(--radius);">
                <input type="text" placeholder="Організація" required style="width: 100%; padding: var(--space-md); margin-bottom: var(--space-md); border: 1px solid var(--gray-300); border-radius: var(--radius);">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Запросити демо-доступ</button>
            </form>
        </div>
    </div>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Intersection Observer for animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        // Observe all elements with fade-in-up class
        document.querySelectorAll('.fade-in-up').forEach(el => {
            observer.observe(el);
        });
        
        // Modal functions
        function showLoginModal() {
            document.getElementById('loginModal').style.display = 'block';
        }
        
        function showDemoModal() {
            document.getElementById('demoModal').style.display = 'block';
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
        
        // Form submission
        document.getElementById('loginForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Функціонал входу знаходиться в розробці. Скоро буде доступно!');
            closeModal('loginModal');
        });
        
        document.getElementById('demoForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Дякуємо за запит! Ми зв\'яжемося з вами для надання демо-доступу.');
            closeModal('demoModal');
        });
    </script>
</body>
</html>
