<?php
// Library page
$current_page = 'library';
$page_title = 'Бібліотека BIM | BIM Hub';
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
        
        /* Library Content */
        .library-content {
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
        
        /* Search */
        .search-container {
            max-width: 800px;
            margin: 0 auto var(--space-3xl);
        }
        
        .search-box {
            position: relative;
        }
        
        .search-input {
            width: 100%;
            padding: var(--space-lg) var(--space-xl) var(--space-lg) 3.5rem;
            border: 2px solid var(--gray-300);
            border-radius: var(--radius-lg);
            font-size: 1.125rem;
            transition: all var(--transition);
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: var(--shadow-lg);
        }
        
        .search-icon {
            position: absolute;
            left: var(--space-lg);
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            font-size: 1.25rem;
        }
        
        /* Categories */
        .categories {
            display: flex;
            justify-content: center;
            gap: var(--space-md);
            margin-bottom: var(--space-3xl);
            flex-wrap: wrap;
        }
        
        .category-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--space-sm);
            padding: var(--space-lg);
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            min-width: 150px;
            cursor: pointer;
            transition: all var(--transition);
        }
        
        .category-btn:hover {
            transform: translateY(-4px);
            border-color: var(--primary-light);
            box-shadow: var(--shadow-lg);
        }
        
        .category-btn.active {
            background: var(--primary-light);
            border-color: var(--primary);
        }
        
        .category-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--primary-light), white);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.5rem;
        }
        
        .category-name {
            font-weight: 600;
            color: var(--gray-800);
        }
        
        /* Resources Grid */
        .resources-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: var(--space-xl);
            margin-bottom: var(--space-3xl);
        }
        
        .resource-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            border: 1px solid var(--gray-200);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }
        
        .resource-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-2xl);
            border-color: var(--primary-light);
        }
        
        .resource-badge {
            position: absolute;
            top: var(--space-xl);
            right: var(--space-xl);
            padding: var(--space-xs) var(--space-sm);
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 700;
        }
        
        .badge-standard {
            background: var(--primary-light);
            color: var(--primary);
        }
        
        .badge-template {
            background: var(--accent-light);
            color: var(--warning);
        }
        
        .badge-component {
            background: var(--success-light);
            color: var(--success);
        }
        
        .resource-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--gray-100), white);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-lg);
            color: var(--gray-700);
            font-size: 1.5rem;
        }
        
        .resource-title {
            font-size: 1.25rem;
            margin-bottom: var(--space-sm);
            color: var(--gray-900);
        }
        
        .resource-description {
            color: var(--gray-600);
            line-height: 1.7;
            margin-bottom: var(--space-lg);
        }
        
        .resource-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: var(--space-md);
            border-top: 1px solid var(--gray-100);
        }
        
        .resource-type {
            font-size: 0.875rem;
            color: var(--gray-500);
        }
        
        .resource-size {
            font-size: 0.875rem;
            color: var(--gray-500);
        }
        
        /* Standards Section */
        .standards-section {
            padding: var(--space-3xl) 0;
            background: var(--gray-50);
        }
        
        .standards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: var(--space-xl);
        }
        
        .standard-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            border: 1px solid var(--gray-200);
        }
        
        .standard-header {
            display: flex;
            align-items: center;
            gap: var(--space-md);
            margin-bottom: var(--space-lg);
        }
        
        .standard-code {
            background: var(--primary);
            color: white;
            padding: var(--space-sm) var(--space-md);
            border-radius: var(--radius);
            font-weight: 700;
            font-size: 0.875rem;
        }
        
        .standard-title {
            font-size: 1.25rem;
            color: var(--gray-900);
        }
        
        /* Templates Section */
        .templates-section {
            padding: var(--space-3xl) 0;
            background: white;
        }
        
        .templates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-xl);
        }
        
        .template-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            border: 2px dashed var(--gray-300);
            text-align: center;
            transition: all var(--transition);
            cursor: pointer;
        }
        
        .template-card:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }
        
        .template-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary-light), white);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto var(--space-lg);
            color: var(--primary);
            font-size: 1.75rem;
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
            
            .resources-grid {
                grid-template-columns: 1fr;
            }
            
            .categories {
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: var(--space-sm);
            }
            
            .category-btn {
                min-width: 120px;
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
                <a href="/pages/library/" class="nav-link active">Бібліотека</a>
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
            <h1 class="page-hero-title fade-in-up">Бібліотека BIM</h1>
            <p class="page-hero-subtitle fade-in-up delay-1">
                Централізована база знань: стандарти, шаблони, компоненти та навчальні матеріали
            </p>
        </div>
    </section>

    <!-- Library Content -->
    <section class="library-content">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Ресурси бібліотеки</h2>
                <p class="section-subtitle">
                    Доступ до всіх необхідних матеріалів для успішного впровадження BIM
                </p>
            </div>
            
            <!-- Search -->
            <div class="search-container fade-in-up delay-1">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Пошук стандартів, шаблонів, компонентів...">
                </div>
            </div>
            
            <!-- Categories -->
            <div class="categories fade-in-up delay-2">
                <div class="category-btn active" data-category="all">
                    <div class="category-icon">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <div class="category-name">Всі</div>
                </div>
                
                <div class="category-btn" data-category="standards">
                    <div class="category-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="category-name">Стандарти</div>
                </div>
                
                <div class="category-btn" data-category="templates">
                    <div class="category-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="category-name">Шаблони</div>
                </div>
                
                <div class="category-btn" data-category="components">
                    <div class="category-icon">
                        <i class="fas fa-cube"></i>
                    </div>
                    <div class="category-name">Компоненти</div>
                </div>
                
                <div class="category-btn" data-category="guides">
                    <div class="category-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="category-name">Посібники</div>
                </div>
            </div>
            
            <!-- Resources Grid -->
            <div class="resources-grid">
                <!-- Resource 1 -->
                <div class="resource-card fade-in-up delay-1" data-category="standards">
                    <div class="resource-badge badge-standard">ISO</div>
                    <div class="resource-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3 class="resource-title">ISO 19650 Серія</h3>
                    <p class="resource-description">
                        Міжнародні стандарти управління інформацією при будівництві з використанням BIM
                    </p>
                    <div class="resource-meta">
                        <span class="resource-type">Стандарт</span>
                        <span class="resource-size">PDF, 2.4 MB</span>
                    </div>
                </div>
                
                <!-- Resource 2 -->
                <div class="resource-card fade-in-up delay-2" data-category="templates">
                    <div class="resource-badge badge-template">Шаблон</div>
                    <div class="resource-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h3 class="resource-title">EIR (BIM Execution Plan)</h3>
                    <p class="resource-description">
                        Шаблон плану виконання BIM-проекту для визначення вимог та очікувань
                    </p>
                    <div class="resource-meta">
                        <span class="resource-type">Шаблон</span>
                        <span class="resource-size">DOCX, 1.8 MB</span>
                    </div>
                </div>
                
                <!-- Resource 3 -->
                <div class="resource-card fade-in-up delay-3" data-category="components">
                    <div class="resource-badge badge-component">LOD 300</div>
                    <div class="resource-icon">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <h3 class="resource-title">Бібліотека конструкцій</h3>
                    <p class="resource-description">
                        Стандартизовані BIM-компоненти конструктивних елементів будівель
                    </p>
                    <div class="resource-meta">
                        <span class="resource-type">Компоненти</span>
                        <span class="resource-size">RFA, 45 MB</span>
                    </div>
                </div>
                
                <!-- Resource 4 -->
                <div class="resource-card fade-in-up delay-4" data-category="standards">
                    <div class="resource-badge badge-standard">ДСТУ</div>
                    <div class="resource-icon">
                        <i class="fas fa-flag"></i>
                    </div>
                    <h3 class="resource-title">ДСТУ Б В.2.3-ХХХ</h3>
                    <p class="resource-description">
                        Національні стандарти BIM для України (адаптація міжнародних стандартів)
                    </p>
                    <div class="resource-meta">
                        <span class="resource-type">Стандарт</span>
                        <span class="resource-size">PDF, 3.1 MB</span>
                    </div>
                </div>
                
                <!-- Resource 5 -->
                <div class="resource-card fade-in-up delay-1" data-category="guides">
                    <div class="resource-badge badge-template">Посібник</div>
                    <div class="resource-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="resource-title">Посібник з LOD</h3>
                    <p class="resource-description">
                        Детальний посібник з рівнів деталізації (LOD) у BIM-моделюванні
                    </p>
                    <div class="resource-meta">
                        <span class="resource-type">Посібник</span>
                        <span class="resource-size">PDF, 5.2 MB</span>
                    </div>
                </div>
                
                <!-- Resource 6 -->
                <div class="resource-card fade-in-up delay-2" data-category="templates">
                    <div class="resource-badge badge-template">Шаблон</div>
                    <div class="resource-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="resource-title">MIDP Шаблон</h3>
                    <p class="resource-description">
                        Шаблон плану управління інформацією на стадії проектування
                    </p>
                    <div class="resource-meta">
                        <span class="resource-type">Шаблон</span>
                        <span class="resource-size">XLSX, 850 KB</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Standards Section -->
    <section class="standards-section">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Ключові стандарти BIM</h2>
                <p class="section-subtitle">
                    Міжнародні та національні стандарти для впровадження BIM в Україні
                </p>
            </div>
            
            <div class="standards-grid">
                <div class="standard-card fade-in-up delay-1">
                    <div class="standard-header">
                        <div class="standard-code">ISO 19650-1</div>
                        <h3 class="standard-title">Концепції та принципи</h3>
                    </div>
                    <p>Основні концепції та принципи управління інформацією протягом життєвого циклу об'єкта</p>
                </div>
                
                <div class="standard-card fade-in-up delay-2">
                    <div class="standard-header">
                        <div class="standard-code">ISO 19650-2</div>
                        <h3 class="standard-title">Фаза проектування</h3>
                    </div>
                    <p>Вимоги до управління інформацією на стадії проектування та будівництва</p>
                </div>
                
                <div class="standard-card fade-in-up delay-3">
                    <div class="standard-header">
                        <div class="standard-code">EN 17412</div>
                        <h3 class="standard-title">Рівні деталізації</h3>
                    </div>
                    <p>Визначення рівнів деталізації (LOD) для BIM-моделей та інформації</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Templates Section -->
    <section class="templates-section">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Готові шаблони</h2>
                <p class="section-subtitle">
                    Стандартизовані шаблони документів для BIM-проектів
                </p>
            </div>
            
            <div class="templates-grid">
                <div class="template-card fade-in-up delay-1" onclick="downloadTemplate('BEP')">
                    <div class="template-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h3>BEP Шаблон</h3>
                    <p>План виконання BIM-проекту</p>
                </div>
                
                <div class="template-card fade-in-up delay-2" onclick="downloadTemplate('EIR')">
                    <div class="template-icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <h3>EIR Шаблон</h3>
                    <p>Вимоги до інформації замовника</p>
                </div>
                
                <div class="template-card fade-in-up delay-3" onclick="downloadTemplate('MIDP')">
                    <div class="template-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3>MIDP Шаблон</h3>
                    <p>План управління інформацією</p>
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
        
        // Category filter functionality
        document.querySelectorAll('.category-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.category-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const category = this.dataset.category;
                const resources = document.querySelectorAll('.resource-card');
                
                resources.forEach(resource => {
                    if (category === 'all' || resource.dataset.category === category) {
                        resource.style.display = 'block';
                        setTimeout(() => {
                            resource.style.opacity = '1';
                            resource.style.transform = 'translateY(0)';
                        }, 10);
                    } else {
                        resource.style.opacity = '0';
                        resource.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            resource.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
        
        // Search functionality
        const searchInput = document.querySelector('.search-input');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const resources = document.querySelectorAll('.resource-card');
            
            resources.forEach(resource => {
                const title = resource.querySelector('.resource-title').textContent.toLowerCase();
                const description = resource.querySelector('.resource-description').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    resource.style.display = 'block';
                    setTimeout(() => {
                        resource.style.opacity = '1';
                        resource.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    resource.style.opacity = '0';
                    resource.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        resource.style.display = 'none';
                    }, 300);
                }
            });
        });
        
        // Template download
        function downloadTemplate(templateName) {
            alert(`Завантаження шаблону ${templateName}. Для повного функціоналу необхідно увійти в систему.`);
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
