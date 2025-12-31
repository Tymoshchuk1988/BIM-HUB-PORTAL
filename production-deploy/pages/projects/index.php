<?php
// Projects page
$current_page = 'projects';
$page_title = 'Проекти BIM | BIM Hub';
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
        
        /* Projects Content */
        .projects-content {
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
        
        /* Filters */
        .filters {
            display: flex;
            justify-content: center;
            gap: var(--space-md);
            margin-bottom: var(--space-2xl);
            flex-wrap: wrap;
        }
        
        .filter-btn {
            padding: var(--space-sm) var(--space-lg);
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-full);
            background: white;
            color: var(--gray-700);
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition);
        }
        
        .filter-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        
        .filter-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        /* Projects Grid */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: var(--space-xl);
            margin-bottom: var(--space-3xl);
        }
        
        .project-card {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: all var(--transition);
            border: 1px solid var(--gray-200);
        }
        
        .project-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-2xl);
        }
        
        .project-header {
            padding: var(--space-xl);
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            position: relative;
            min-height: 180px;
        }
        
        .project-badge {
            position: absolute;
            top: var(--space-xl);
            right: var(--space-xl);
            background: var(--accent);
            color: var(--gray-900);
            padding: var(--space-xs) var(--space-md);
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 700;
        }
        
        .project-title {
            font-size: 1.5rem;
            margin-bottom: var(--space-xs);
        }
        
        .project-location {
            opacity: 0.9;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: var(--space-xs);
        }
        
        .project-body {
            padding: var(--space-xl);
        }
        
        .project-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--space-md);
            margin-bottom: var(--space-lg);
        }
        
        .project-stat {
            display: flex;
            flex-direction: column;
        }
        
        .stat-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: var(--space-xs);
        }
        
        .stat-value {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-900);
        }
        
        .project-description {
            color: var(--gray-600);
            line-height: 1.7;
            margin-bottom: var(--space-lg);
        }
        
        /* Map Section */
        .map-section {
            padding: var(--space-3xl) 0;
            background: var(--gray-50);
        }
        
        .map-container {
            height: 500px;
            background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
            border-radius: var(--radius-lg);
            margin-top: var(--space-2xl);
            position: relative;
            overflow: hidden;
        }
        
        .map-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-500);
            font-size: 1.25rem;
        }
        
        /* Statistics */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-xl);
            margin-top: var(--space-3xl);
        }
        
        .stat-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            text-align: center;
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
            
            .projects-grid {
                grid-template-columns: 1fr;
            }
            
            .filters {
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: var(--space-sm);
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
                <a href="/pages/projects/" class="nav-link active">Проекти</a>
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
            <h1 class="page-hero-title fade-in-up">Проекти BIM</h1>
            <p class="page-hero-subtitle fade-in-up delay-1">
                Реєстр проектів з використанням будівельного інформаційного моделювання для відновлення України
            </p>
        </div>
    </section>

    <!-- Projects Content -->
    <section class="projects-content">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Активні проекти</h2>
                <p class="section-subtitle">
                    Пілотні проекти з використанням BIM-технологій у різних регіонах України
                </p>
            </div>
            
            <!-- Filters -->
            <div class="filters fade-in-up delay-1">
                <button class="filter-btn active" data-filter="all">Всі проекти</button>
                <button class="filter-btn" data-filter="infrastructure">Інфраструктура</button>
                <button class="filter-btn" data-filter="housing">Житлове будівництво</button>
                <button class="filter-btn" data-filter="education">Освітні заклади</button>
                <button class="filter-btn" data-filter="healthcare">Охорона здоров'я</button>
                <button class="filter-btn" data-filter="completed">Завершені</button>
            </div>
            
            <!-- Projects Grid -->
            <div class="projects-grid">
                <!-- Project 1 -->
                <div class="project-card fade-in-up delay-1" data-category="infrastructure">
                    <div class="project-header">
                        <div class="project-badge">LOD 350</div>
                        <h3 class="project-title">Міст через Дніпро</h3>
                        <div class="project-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Черкаська область
                        </div>
                    </div>
                    <div class="project-body">
                        <div class="project-stats">
                            <div class="project-stat">
                                <div class="stat-label">Бюджет</div>
                                <div class="stat-value">₴2.5 млрд</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Термін</div>
                                <div class="stat-value">2025-2027</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Прогрес</div>
                                <div class="stat-value">35%</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">BIM Level</div>
                                <div class="stat-value">2</div>
                            </div>
                        </div>
                        <p class="project-description">
                            Комплексне моделювання мостової конструкції з розрахунками навантажень та енергоефективними рішеннями
                        </p>
                        <button class="btn btn-primary" onclick="showProjectDetails(1)" style="width: 100%;">
                            <i class="fas fa-info-circle"></i> Детальніше
                        </button>
                    </div>
                </div>
                
                <!-- Project 2 -->
                <div class="project-card fade-in-up delay-2" data-category="housing">
                    <div class="project-header">
                        <div class="project-badge">LOD 300</div>
                        <h3 class="project-title">Житловий комплекс "Відродження"</h3>
                        <div class="project-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Київська область
                        </div>
                    </div>
                    <div class="project-body">
                        <div class="project-stats">
                            <div class="project-stat">
                                <div class="stat-label">Бюджет</div>
                                <div class="stat-value">₴850 млн</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Термін</div>
                                <div class="stat-value">2024-2026</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Прогрес</div>
                                <div class="stat-value">60%</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">BIM Level</div>
                                <div class="stat-value">2</div>
                            </div>
                        </div>
                        <p class="project-description">
                            12-поверховий житловий комплекс з сучасними інженерними системами та "розумними" технологіями
                        </p>
                        <button class="btn btn-primary" onclick="showProjectDetails(2)" style="width: 100%;">
                            <i class="fas fa-info-circle"></i> Детальніше
                        </button>
                    </div>
                </div>
                
                <!-- Project 3 -->
                <div class="project-card fade-in-up delay-3" data-category="education">
                    <div class="project-header">
                        <div class="project-badge">LOD 400</div>
                        <h3 class="project-title">Школа майбутнього</h3>
                        <div class="project-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Львівська область
                        </div>
                    </div>
                    <div class="project-body">
                        <div class="project-stats">
                            <div class="project-stat">
                                <div class="stat-label">Бюджет</div>
                                <div class="stat-value">₴320 млн</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Термін</div>
                                <div class="stat-value">2025-2026</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Прогрес</div>
                                <div class="stat-value">25%</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">BIM Level</div>
                                <div class="stat-value">3</div>
                            </div>
                        </div>
                        <p class="project-description">
                            Інноваційний навчальний заклад з енергоефективними рішеннями та інклюзивним середовищем
                        </p>
                        <button class="btn btn-primary" onclick="showProjectDetails(3)" style="width: 100%;">
                            <i class="fas fa-info-circle"></i> Детальніше
                        </button>
                    </div>
                </div>
                
                <!-- Project 4 -->
                <div class="project-card fade-in-up delay-1" data-category="healthcare">
                    <div class="project-header">
                        <div class="project-badge">LOD 350</div>
                        <h3 class="project-title">Обласна лікарня</h3>
                        <div class="project-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Дніпропетровська область
                        </div>
                    </div>
                    <div class="project-body">
                        <div class="project-stats">
                            <div class="project-stat">
                                <div class="stat-label">Бюджет</div>
                                <div class="stat-value">₴1.2 млрд</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Термін</div>
                                <div class="stat-value">2025-2028</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Прогрес</div>
                                <div class="stat-value">15%</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">BIM Level</div>
                                <div class="stat-value">2</div>
                            </div>
                        </div>
                        <p class="project-description">
                            Сучасний медичний комплекс з передовими технологіями та ефективним плануванням простору
                        </p>
                        <button class="btn btn-primary" onclick="showProjectDetails(4)" style="width: 100%;">
                            <i class="fas fa-info-circle"></i> Детальніше
                        </button>
                    </div>
                </div>
                
                <!-- Project 5 -->
                <div class="project-card fade-in-up delay-2" data-category="infrastructure">
                    <div class="project-header">
                        <div class="project-badge">LOD 300</div>
                        <h3 class="project-title">Автошлях Н-31</h3>
                        <div class="project-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Донецька область
                        </div>
                    </div>
                    <div class="project-body">
                        <div class="project-stats">
                            <div class="project-stat">
                                <div class="stat-label">Бюджет</div>
                                <div class="stat-value">₴4.8 млрд</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Термін</div>
                                <div class="stat-value">2025-2029</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Прогрес</div>
                                <div class="stat-value">10%</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">BIM Level</div>
                                <div class="stat-value">2</div>
                            </div>
                        </div>
                        <p class="project-description">
                            Проектування та будівництво автомобільної дороги з комплексним моделюванням інфраструктури
                        </p>
                        <button class="btn btn-primary" onclick="showProjectDetails(5)" style="width: 100%;">
                            <i class="fas fa-info-circle"></i> Детальніше
                        </button>
                    </div>
                </div>
                
                <!-- Project 6 -->
                <div class="project-card fade-in-up delay-3" data-category="completed">
                    <div class="project-header">
                        <div class="project-badge" style="background: var(--success); color: white;">Завершено</div>
                        <h3 class="project-title">Термінал аеропорту</h3>
                        <div class="project-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Запорізька область
                        </div>
                    </div>
                    <div class="project-body">
                        <div class="project-stats">
                            <div class="project-stat">
                                <div class="stat-label">Бюджет</div>
                                <div class="stat-value">₴950 млн</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Термін</div>
                                <div class="stat-value">2023-2024</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Прогрес</div>
                                <div class="stat-value">100%</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">BIM Level</div>
                                <div class="stat-value">2</div>
                            </div>
                        </div>
                        <p class="project-description">
                            Модернізація пасажирського терміналу з повним BIM-моделюванням та оптимізацією процесів
                        </p>
                        <button class="btn btn-primary" onclick="showProjectDetails(6)" style="width: 100%;">
                            <i class="fas fa-info-circle"></i> Детальніше
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Map Section -->
            <div class="map-section fade-in-up delay-4">
                <div class="section-header">
                    <h2 class="section-title">Географія проектів</h2>
                    <p class="section-subtitle">
                        Розподіл проектів BIM по території України
                    </p>
                </div>
                
                <div class="map-container">
                    <div class="map-placeholder">
                        <div style="text-align: center;">
                            <i class="fas fa-map fa-4x" style="margin-bottom: var(--space-md); color: var(--gray-400);"></i>
                            <p style="color: var(--gray-500);">Інтерактивна карта проектів</p>
                            <p style="color: var(--gray-400); font-size: 0.95rem; margin-top: var(--space-sm);">
                                Функціонал карти знаходиться в розробці
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Statistics -->
            <div class="section-header fade-in-up">
                <h2 class="section-title">Статистика проектів</h2>
                <p class="section-subtitle">
                    Загальні показники та результати реалізації проектів BIM
                </p>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card fade-in-up delay-1">
                    <div class="stat-value">42</div>
                    <div class="stat-label">Активних проектів</div>
                </div>
                
                <div class="stat-card fade-in-up delay-2">
                    <div class="stat-value">₴28.5 млрд</div>
                    <div class="stat-label">Загальний бюджет</div>
                </div>
                
                <div class="stat-card fade-in-up delay-3">
                    <div class="stat-value">67%</div>
                    <div class="stat-label">Середній прогрес</div>
                </div>
                
                <div class="stat-card fade-in-up delay-4">
                    <div class="stat-value">18</div>
                    <div class="stat-label">Завершених проектів</div>
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

    <!-- Project Details Modal -->
    <div id="projectModal" class="modal" style="display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); overflow-y: auto;">
        <div class="modal-content" style="background-color: white; margin: 5% auto; padding: var(--space-xl); border-radius: var(--radius-lg); width: 90%; max-width: 800px; position: relative; box-shadow: var(--shadow-2xl);">
            <span class="close-modal" onclick="closeModal('projectModal')" style="color: var(--gray-500); float: right; font-size: 28px; font-weight: bold; cursor: pointer; position: absolute; right: var(--space-md); top: var(--space-md);">&times;</span>
            <div id="projectModalContent"></div>
        </div>
    </div>

    <!-- Login Modal -->
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
        
        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const filter = this.dataset.filter;
                const projects = document.querySelectorAll('.project-card');
                
                projects.forEach(project => {
                    if (filter === 'all' || project.dataset.category === filter) {
                        project.style.display = 'block';
                        setTimeout(() => {
                            project.style.opacity = '1';
                            project.style.transform = 'translateY(0)';
                        }, 10);
                    } else {
                        project.style.opacity = '0';
                        project.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            project.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
        
        // Project details modal
        const projectDetails = {
            1: {
                title: 'Міст через Дніпро',
                location: 'Черкаська область',
                budget: '₴2.5 млрд',
                duration: '2025-2027',
                progress: '35%',
                bimLevel: '2',
                lod: '350',
                description: 'Комплексне моделювання мостової конструкції з розрахунками навантажень та енергоефективними рішеннями',
                details: 'Проект включає повну BIM-модель мосту з детальним моделюванням усіх конструктивних елементів, інженерних систем та навколишньої інфраструктури. Використовуються передові технології аналізу навантажень та моніторингу будівництва.',
                team: 'Проектна команда: 25 фахівців',
                status: 'В процесі',
                category: 'Інфраструктура'
            },
            2: {
                title: 'Житловий комплекс "Відродження"',
                location: 'Київська область',
                budget: '₴850 млн',
                duration: '2024-2026',
                progress: '60%',
                bimLevel: '2',
                lod: '300',
                description: '12-поверховий житловий комплекс з сучасними інженерними системами та "розумними" технологіями',
                details: 'Проект реалізується з повним BIM-циклом: від концептуального проектування до експлуатації. Включає моделювання архітектурних, конструктивних та інженерних систем з інтеграцією "розумних" технологій управління будівлею.',
                team: 'Проектна команда: 18 фахівців',
                status: 'В процесі',
                category: 'Житлове будівництво'
            },
            3: {
                title: 'Школа майбутнього',
                location: 'Львівська область',
                budget: '₴320 млн',
                duration: '2025-2026',
                progress: '25%',
                bimLevel: '3',
                lod: '400',
                description: 'Інноваційний навчальний заклад з енергоефективними рішеннями та інклюзивним середовищем',
                details: 'Проект включає комплексне BIM-моделювання з високим рівнем деталізації. Особливу увагу приділено енергоефективності, доступності для людей з обмеженими можливостями та створенню сучасного освітнього середовища.',
                team: 'Проектна команда: 22 фахівці',
                status: 'В процесі',
                category: 'Освітні заклади'
            }
        };
        
        function showProjectDetails(projectId) {
            const project = projectDetails[projectId];
            if (!project) return;
            
            const content = `
                <h2 style="margin-bottom: var(--space-md);">${project.title}</h2>
                <div style="display: flex; align-items: center; gap: var(--space-sm); margin-bottom: var(--space-lg); color: var(--gray-600);">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>${project.location}</span>
                    <span style="margin-left: var(--space-md); padding: var(--space-xs) var(--space-sm); background: var(--primary-light); color: var(--primary); border-radius: var(--radius-full); font-size: 0.875rem; font-weight: 600;">${project.category}</span>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: var(--space-md); margin-bottom: var(--space-xl);">
                    <div style="background: var(--gray-50); padding: var(--space-md); border-radius: var(--radius);">
                        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: var(--space-xs);">Бюджет</div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">${project.budget}</div>
                    </div>
                    <div style="background: var(--gray-50); padding: var(--space-md); border-radius: var(--radius);">
                        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: var(--space-xs);">Термін</div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">${project.duration}</div>
                    </div>
                    <div style="background: var(--gray-50); padding: var(--space-md); border-radius: var(--radius);">
                        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: var(--space-xs);">Прогрес</div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">${project.progress}</div>
                    </div>
                    <div style="background: var(--gray-50); padding: var(--space-md); border-radius: var(--radius);">
                        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: var(--space-xs);">BIM Level</div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">${project.bimLevel}</div>
                    </div>
                </div>
                
                <div style="margin-bottom: var(--space-xl);">
                    <h3 style="margin-bottom: var(--space-md);">Опис проекту</h3>
                    <p style="color: var(--gray-600); line-height: 1.7; margin-bottom: var(--space-md);">${project.description}</p>
                    <p style="color: var(--gray-600); line-height: 1.7;">${project.details}</p>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: var(--space-xl); border-top: 1px solid var(--gray-200);">
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">Команда</div>
                        <div style="font-weight: 600;">${project.team}</div>
                    </div>
                    <div style="padding: var(--space-sm) var(--space-lg); background: ${project.status === 'Завершено' ? 'var(--success)' : 'var(--warning)'}; color: white; border-radius: var(--radius-full); font-weight: 600;">${project.status}</div>
                </div>
            `;
            
            document.getElementById('projectModalContent').innerHTML = content;
            document.getElementById('projectModal').style.display = 'block';
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
