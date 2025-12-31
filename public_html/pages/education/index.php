<?php
// Education page
$current_page = 'education';
$page_title = 'Навчання BIM | BIM Hub';
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
        
        /* Education Content */
        .education-content {
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
        
        /* Programs Grid */
        .programs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: var(--space-xl);
            margin-bottom: var(--space-3xl);
        }
        
        .program-card {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--gray-200);
            transition: all var(--transition);
            position: relative;
        }
        
        .program-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-2xl);
            border-color: var(--primary-light);
        }
        
        .program-header {
            padding: var(--space-xl);
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }
        
        .program-level {
            display: inline-block;
            padding: var(--space-xs) var(--space-sm);
            background: rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: var(--space-sm);
        }
        
        .program-title {
            font-size: 1.5rem;
            margin-bottom: var(--space-sm);
        }
        
        .program-duration {
            opacity: 0.9;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: var(--space-xs);
        }
        
        .program-body {
            padding: var(--space-xl);
        }
        
        .program-description {
            color: var(--gray-600);
            line-height: 1.7;
            margin-bottom: var(--space-lg);
        }
        
        .program-features {
            list-style: none;
            margin-bottom: var(--space-xl);
        }
        
        .program-feature {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            padding: var(--space-sm) 0;
            color: var(--gray-700);
            border-bottom: 1px solid var(--gray-100);
        }
        
        .program-feature:last-child {
            border-bottom: none;
        }
        
        .feature-check {
            color: var(--success);
        }
        
        /* Courses Grid */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: var(--space-xl);
            margin-bottom: var(--space-3xl);
        }
        
        .course-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            border: 1px solid var(--gray-200);
            transition: all var(--transition);
        }
        
        .course-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-light);
        }
        
        .course-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--primary-light), white);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-lg);
            color: var(--primary);
            font-size: 1.5rem;
        }
        
        .course-title {
            font-size: 1.25rem;
            margin-bottom: var(--space-sm);
            color: var(--gray-900);
        }
        
        .course-description {
            color: var(--gray-600);
            line-height: 1.7;
            margin-bottom: var(--space-lg);
        }
        
        .course-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: var(--space-md);
            border-top: 1px solid var(--gray-100);
        }
        
        .course-duration {
            font-size: 0.875rem;
            color: var(--gray-500);
        }
        
        .course-level {
            padding: var(--space-xs) var(--space-sm);
            background: var(--gray-100);
            color: var(--gray-700);
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        /* Webinars */
        .webinars-section {
            padding: var(--space-3xl) 0;
            background: var(--gray-50);
        }
        
        .webinars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: var(--space-xl);
        }
        
        .webinar-card {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--gray-200);
        }
        
        .webinar-date {
            padding: var(--space-md);
            background: var(--primary);
            color: white;
            text-align: center;
        }
        
        .webinar-day {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
        }
        
        .webinar-month {
            font-size: 0.875rem;
            opacity: 0.9;
        }
        
        .webinar-body {
            padding: var(--space-xl);
        }
        
        .webinar-title {
            font-size: 1.25rem;
            margin-bottom: var(--space-sm);
            color: var(--gray-900);
        }
        
        .webinar-speaker {
            color: var(--gray-600);
            font-size: 0.95rem;
            margin-bottom: var(--space-lg);
        }
        
        /* Certification */
        .certification-section {
            padding: var(--space-3xl) 0;
            background: white;
        }
        
        .cert-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-xl);
            margin-top: var(--space-2xl);
        }
        
        .cert-step {
            text-align: center;
            position: relative;
        }
        
        .cert-step-number {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0 auto var(--space-lg);
        }
        
        /* Statistics */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-xl);
            margin-top: var(--space-3xl);
        }
        
        .stat-card {
            text-align: center;
            padding: var(--space-xl);
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            margin-bottom: var(--space-sm);
        }
        
        .stat-label {
            font-size: 1rem;
            color: var(--gray-600);
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
            
            .programs-grid,
            .courses-grid {
                grid-template-columns: 1fr;
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
                <a href="/pages/strategy/" class="nav-link">Стратегія</a>
                <a href="/pages/projects/" class="nav-link">Проекти</a>
                <a href="/pages/library/" class="nav-link">Бібліотека</a>
                <a href="/pages/education/" class="nav-link active">Навчання</a>
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
            <h1 class="page-hero-title fade-in-up">Навчання BIM</h1>
            <p class="page-hero-subtitle fade-in-up delay-1">
                Комплексна система підготовки та сертифікації BIM-фахівців для відновлення України
            </p>
        </div>
    </section>

    <!-- Education Content -->
    <section class="education-content">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Навчальні програми</h2>
                <p class="section-subtitle">
                    Структуровані програми навчання для різних рівнів підготовки
                </p>
            </div>
            
            <!-- Programs Grid -->
            <div class="programs-grid">
                <!-- Program 1 -->
                <div class="program-card fade-in-up delay-1">
                    <div class="program-header">
                        <div class="program-level">Початковий рівень</div>
                        <h3 class="program-title">BIM Essentials</h3>
                        <div class="program-duration">
                            <i class="far fa-clock"></i>
                            2 місяці
                        </div>
                    </div>
                    <div class="program-body">
                        <p class="program-description">
                            Основи будівельного інформаційного моделювання для початківців. Ідеальний старт для архітекторів, інженерів та менеджерів.
                        </p>
                        <ul class="program-features">
                            <li class="program-feature">
                                <i class="fas fa-check feature-check"></i>
                                Введення в BIM
                            </li>
                            <li class="program-feature">
                                <i class="fas fa-check feature-check"></i>
                                Основні стандарти
                            </li>
                            <li class="program-feature">
                                <i class="fas fa-check feature-check"></i>
                                Робота з Revit
                            </li>
                            <li class="program-feature">
                                <i class="fas fa-check feature-check"></i>
                                Практичні кейси
                            </li>
                        </ul>
                        <button class="btn btn-primary" onclick="enrollProgram('BIM Essentials')" style="width: 100%;">
                            Записатися
                        </button>
                    </div>
                </div>
                
                <!-- Program 2 -->
                <div class="program-card fade-in-up delay-2">
                    <div class="program-header">
                        <div class="program-level">Професійний рівень</div>
                        <h3 class="program-title">BIM Manager</h3>
                        <div class="program-duration">
                            <i class="far fa-clock"></i>
                            4 місяці
                        </div>
                    </div>
                    <div class="program-body">
                        <p class="program-description">
                            Підготовка BIM-менеджерів для управління складними проектами. Фокус на стандартизації, координації та управлінні.
                        </p>
                        <ul class="program-features">
                            <li class="program-feature">
                                <i class="fas fa-check feature-check"></i>
                                Управління проектами
                            </li>
                            <li class="program-feature">
                                <i class="fas fa-check feature-check"></i>
                                Стандарти ISO 19650
                            </li>
                            <li class="program-feature">
                                <i class="fas fa-check feature-check"></i>
                                Координація моделей
                            </li>
                            <li class="program-feature">
                                <i class="fas fa-check feature-check"></i>
                                Робота з Common Data Environment
                            </li>
                        </ul>
                        <button class="btn btn-primary" onclick="enrollProgram('BIM Manager')" style="width: 100%;">
                            Записатися
                        </button>
                    </div>
                </div>
                
                <!-- Program 3 -->
                <div class="program-card fade-in-up delay-3">
                    <div class="program-header">
                        <div class="program-level">Експертний рівень</div>
                        <h3 class="program-title">BIM Expert</h3>
                        <div class="program-duration">
                            <i class="far fa-clock"></i>
                            6 місяців
                        </div>
                    </div>
                    <div class="program-body">
                        <p class="program-description">
                            Поглиблена програма для експертів BIM з фокусом на стратегії впровадження, стандартизації та розвитку компетенцій.
                        </p>
                        <ul class="program-features">
                            <li class="program-feature">
                                <i class="fas fa-check feature-check"></i>
                                Стратегія впровадження
                            </li>
                            <li class="program-feature">
                                <i class="fas fa-check feature-check"></i>
                                Розробка стандартів
                            </li>
                            <li class="program-feature">
                                <i class="fas fa-check feature-check"></i>
                                Цифрова трансформація
                            </li>
                            <li class="program-feature">
                                <i class="fas fa-check feature-check"></i>
                                Міжнародна сертифікація
                            </li>
                        </ul>
                        <button class="btn btn-primary" onclick="enrollProgram('BIM Expert')" style="width: 100%;">
                            Записатися
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Courses Section -->
            <div class="section-header fade-in-up">
                <h2 class="section-title">Окремі курси</h2>
                <p class="section-subtitle">
                    Спеціалізовані курси для поглиблення конкретних навичок
                </p>
            </div>
            
            <div class="courses-grid">
                <!-- Course 1 -->
                <div class="course-card fade-in-up delay-1">
                    <div class="course-icon">
                        <i class="fas fa-drafting-compass"></i>
                    </div>
                    <h3 class="course-title">BIM для архітекторів</h3>
                    <p class="course-description">
                        Спеціалізований курс для архітекторів з фокусом на концептуальному проектуванні та візуалізації
                    </p>
                    <div class="course-meta">
                        <span class="course-duration">24 години</span>
                        <span class="course-level">Середній</span>
                    </div>
                </div>
                
                <!-- Course 2 -->
                <div class="course-card fade-in-up delay-2">
                    <div class="course-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3 class="course-title">BIM для інженерів</h3>
                    <p class="course-description">
                        Поглиблений курс для інженерів-конструкторів та інженерів МЕП з детальним моделюванням систем
                    </p>
                    <div class="course-meta">
                        <span class="course-duration">32 години</span>
                        <span class="course-level">Професійний</span>
                    </div>
                </div>
                
                <!-- Course 3 -->
                <div class="course-card fade-in-up delay-3">
                    <div class="course-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="course-title">4D/5D BIM</h3>
                    <p class="course-description">
                        Курс з планування будівництва (4D) та управління вартістю (5D) з використанням BIM-технологій
                    </p>
                    <div class="course-meta">
                        <span class="course-duration">28 години</span>
                        <span class="course-level">Просунутий</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Webinars Section -->
    <section class="webinars-section">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Майбутні вебінари</h2>
                <p class="section-subtitle">
                    Безкоштовні онлайн-заходи з експертами BIM
                </p>
            </div>
            
            <div class="webinars-grid">
                <!-- Webinar 1 -->
                <div class="webinar-card fade-in-up delay-1">
                    <div class="webinar-date">
                        <div class="webinar-day">15</div>
                        <div class="webinar-month">Березня 2025</div>
                    </div>
                    <div class="webinar-body">
                        <h3 class="webinar-title">Впровадження BIM в Україні: досвід та перспективи</h3>
                        <p class="webinar-speaker">Іван Петренко, експерт BIM</p>
                        <button class="btn btn-primary" onclick="registerWebinar(1)" style="width: 100%;">
                            Зареєструватися
                        </button>
                    </div>
                </div>
                
                <!-- Webinar 2 -->
                <div class="webinar-card fade-in-up delay-2">
                    <div class="webinar-date">
                        <div class="webinar-day">22</div>
                        <div class="webinar-month">Березня 2025</div>
                    </div>
                    <div class="webinar-body">
                        <h3 class="webinar-title">ISO 19650: Практичне застосування</h3>
                        <p class="webinar-speaker">Марія Коваль, сертифікований спеціаліст</p>
                        <button class="btn btn-primary" onclick="registerWebinar(2)" style="width: 100%;">
                            Зареєструватися
                        </button>
                    </div>
                </div>
                
                <!-- Webinar 3 -->
                <div class="webinar-card fade-in-up delay-3">
                    <div class="webinar-date">
                        <div class="webinar-day">29</div>
                        <div class="webinar-month">Березня 2025</div>
                    </div>
                    <div class="webinar-body">
                        <h3 class="webinar-title">BIM для відновлення: практичні кейси</h3>
                        <p class="webinar-speaker">Олексій Сидоренко, керівник проектів</p>
                        <button class="btn btn-primary" onclick="registerWebinar(3)" style="width: 100%;">
                            Зареєструватися
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Certification Section -->
    <section class="certification-section">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Сертифікація BIM-фахівців</h2>
                <p class="section-subtitle">
                    4 кроки до отримання сертифікату BIM-спеціаліста
                </p>
            </div>
            
            <div class="cert-steps">
                <div class="cert-step fade-in-up delay-1">
                    <div class="cert-step-number">1</div>
                    <h3>Реєстрація</h3>
                    <p style="color: var(--gray-600); margin-top: var(--space-sm);">Заповніть заявку та пройдіть вступне тестування</p>
                </div>
                
                <div class="cert-step fade-in-up delay-2">
                    <div class="cert-step-number">2</div>
                    <h3>Навчання</h3>
                    <p style="color: var(--gray-600); margin-top: var(--space-sm);">Завершіть обрану навчальну програму</p>
                </div>
                
                <div class="cert-step fade-in-up delay-3">
                    <div class="cert-step-number">3</div>
                    <h3>Екзамен</h3>
                    <p style="color: var(--gray-600); margin-top: var(--space-sm);">Складіть сертифікаційний екзамен</p>
                </div>
                
                <div class="cert-step fade-in-up delay-4">
                    <div class="cert-step-number">4</div>
                    <h3>Сертифікат</h3>
                    <p style="color: var(--gray-600); margin-top: var(--space-sm);">Отримайте сертифікат та доступ до спільноти</p>
                </div>
            </div>
            
            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card fade-in-up delay-1">
                    <div class="stat-value">850+</div>
                    <div class="stat-label">Студентів</div>
                </div>
                
                <div class="stat-card fade-in-up delay-2">
                    <div class="stat-value">42</div>
                    <div class="stat-label">Курсів</div>
                </div>
                
                <div class="stat-card fade-in-up delay-3">
                    <div class="stat-value">120+</div>
                    <div class="stat-label">Сертифікованих фахівців</div>
                </div>
                
                <div class="stat-card fade-in-up delay-4">
                    <div class="stat-value">94%</div>
                    <div class="stat-label">Задоволених студентів</div>
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
        
        // Enrollment functionality
        function enrollProgram(programName) {
            alert(`Запис на програму "${programName}". Для подальших дій необхідно увійти в систему.`);
            showLoginModal();
        }
        
        function registerWebinar(webinarId) {
            const webinars = {
                1: "Впровадження BIM в Україні: досвід та перспективи",
                2: "ISO 19650: Практичне застосування",
                3: "BIM для відновлення: практичні кейси"
            };
            alert(`Реєстрація на вебінар: "${webinars[webinarId]}". Для подальших дій необхідно увійти в систему.`);
            showLoginModal();
        }
        
        // Modal functions
        function showLoginModal() {
            document.getElementById('loginModal').style.display = 'block';
        }
        
        function showDemoModal() {
            alert('Функціонал демо-доступу знаходиться в розробці');
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
    </script>
</body>
</html>
