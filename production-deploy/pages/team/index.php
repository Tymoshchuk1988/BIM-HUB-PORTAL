<?php
// Team page
$current_page = 'team';
$page_title = 'Команда BIM Hub | BIM Hub';
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
        
        /* Team Content */
        .team-content {
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
        
        /* Leadership Grid */
        .leadership-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: var(--space-xl);
            margin-bottom: var(--space-3xl);
        }
        
        .leader-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            border: 1px solid var(--gray-200);
            transition: all var(--transition);
            text-align: center;
        }
        
        .leader-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-2xl);
            border-color: var(--primary-light);
        }
        
        .leader-avatar {
            width: 120px;
            height: 120px;
            border-radius: var(--radius-full);
            margin: 0 auto var(--space-lg);
            background: linear-gradient(135deg, var(--primary-light), white);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 2.5rem;
            border: 4px solid var(--gray-100);
        }
        
        .leader-name {
            font-size: 1.5rem;
            margin-bottom: var(--space-xs);
            color: var(--gray-900);
        }
        
        .leader-position {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: var(--space-sm);
        }
        
        .leader-bio {
            color: var(--gray-600);
            line-height: 1.7;
            margin-bottom: var(--space-lg);
        }
        
        .leader-contact {
            display: flex;
            justify-content: center;
            gap: var(--space-md);
        }
        
        .contact-link {
            width: 40px;
            height: 40px;
            background: var(--gray-100);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-700);
            transition: all var(--transition);
        }
        
        .contact-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Teams Grid */
        .teams-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: var(--space-xl);
            margin-bottom: var(--space-3xl);
        }
        
        .team-card {
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            border: 1px solid var(--gray-200);
            transition: all var(--transition);
        }
        
        .team-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-light);
        }
        
        .team-icon {
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
        }
        
        .team-title {
            font-size: 1.5rem;
            margin-bottom: var(--space-md);
            color: var(--gray-900);
        }
        
        .team-members {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-sm);
            margin-bottom: var(--space-lg);
        }
        
        .member-tag {
            padding: var(--space-xs) var(--space-sm);
            background: white;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-full);
            font-size: 0.875rem;
            color: var(--gray-700);
        }
        
        .team-responsibilities {
            list-style: none;
        }
        
        .responsibility {
            display: flex;
            align-items: flex-start;
            gap: var(--space-sm);
            padding: var(--space-sm) 0;
            color: var(--gray-700);
            border-bottom: 1px solid var(--gray-200);
        }
        
        .responsibility:last-child {
            border-bottom: none;
        }
        
        .responsibility-icon {
            color: var(--success);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        /* Advisors Section */
        .advisors-section {
            padding: var(--space-3xl) 0;
            background: var(--gray-50);
        }
        
        .advisors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--space-xl);
        }
        
        .advisor-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            text-align: center;
            border: 1px solid var(--gray-200);
        }
        
        .advisor-avatar {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-full);
            margin: 0 auto var(--space-lg);
            background: linear-gradient(135deg, var(--accent-light), white);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--warning);
            font-size: 1.75rem;
            border: 3px solid var(--gray-100);
        }
        
        .advisor-name {
            font-size: 1.25rem;
            margin-bottom: var(--space-xs);
            color: var(--gray-900);
        }
        
        .advisor-role {
            color: var(--gray-600);
            font-size: 0.95rem;
            margin-bottom: var(--space-sm);
        }
        
        .advisor-organization {
            color: var(--gray-500);
            font-size: 0.875rem;
        }
        
        /* Join Team */
        .join-section {
            padding: var(--space-3xl) 0;
            background: white;
            text-align: center;
        }
        
        .join-content {
            max-width: 600px;
            margin: 0 auto;
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
            
            .leadership-grid,
            .teams-grid {
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
                <a href="/pages/education/" class="nav-link">Навчання</a>
                <a href="/pages/team/" class="nav-link active">Команда</a>
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
            <h1 class="page-hero-title fade-in-up">Наша команда</h1>
            <p class="page-hero-subtitle fade-in-up delay-1">
                Експерти та фахівці, які розвивають BIM-екосистему для відновлення України
            </p>
        </div>
    </section>

    <!-- Team Content -->
    <section class="team-content">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Керівництво</h2>
                <p class="section-subtitle">
                    Досвідчені лідери, які керують стратегією та розвитком BIM Hub
                </p>
            </div>
            
            <!-- Leadership Grid -->
            <div class="leadership-grid">
                <!-- Leader 1 -->
                <div class="leader-card fade-in-up delay-1">
                    <div class="leader-avatar">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="leader-name">Олександр Петренко</h3>
                    <div class="leader-position">Генеральний директор</div>
                    <p class="leader-bio">
                        15+ років досвіду в будівельній галузі, експерт з цифрової трансформації та BIM-технологій
                    </p>
                    <div class="leader-contact">
                        <a href="#" class="contact-link">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="contact-link">
                            <i class="fas fa-envelope"></i>
                        </a>
                        <a href="#" class="contact-link">
                            <i class="fas fa-phone"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Leader 2 -->
                <div class="leader-card fade-in-up delay-2">
                    <div class="leader-avatar">
                        <i class="fas fa-female"></i>
                    </div>
                    <h3 class="leader-name">Марія Коваль</h3>
                    <div class="leader-position">Технічний директор</div>
                    <p class="leader-bio">
                        Сертифікований BIM-менеджер, експерт з ISO 19650, керівник технічних проектів
                    </p>
                    <div class="leader-contact">
                        <a href="#" class="contact-link">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="contact-link">
                            <i class="fas fa-envelope"></i>
                        </a>
                        <a href="#" class="contact-link">
                            <i class="fas fa-phone"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Leader 3 -->
                <div class="leader-card fade-in-up delay-3">
                    <div class="leader-avatar">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 class="leader-name">Іван Сидоренко</h3>
                    <div class="leader-position">Директор з розвитку</div>
                    <p class="leader-bio">
                        Спеціаліст з міжнародного співробітництва та стратегічного планування в будівельній галузі
                    </p>
                    <div class="leader-contact">
                        <a href="#" class="contact-link">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="contact-link">
                            <i class="fas fa-envelope"></i>
                        </a>
                        <a href="#" class="contact-link">
                            <i class="fas fa-phone"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Teams Section -->
            <div class="section-header fade-in-up">
                <h2 class="section-title">Команди</h2>
                <p class="section-subtitle">
                    Спеціалізовані команди, що забезпечують роботу порталу
                </p>
            </div>
            
            <div class="teams-grid">
                <!-- Team 1 -->
                <div class="team-card fade-in-up delay-1">
                    <div class="team-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3 class="team-title">Технологічна команда</h3>
                    <div class="team-members">
                        <span class="member-tag">8 розробників</span>
                        <span class="member-tag">3 DevOps</span>
                        <span class="member-tag">2 QA</span>
                    </div>
                    <ul class="team-responsibilities">
                        <li class="responsibility">
                            <i class="fas fa-check responsibility-icon"></i>
                            <span>Розробка та підтримка платформи</span>
                        </li>
                        <li class="responsibility">
                            <i class="fas fa-check responsibility-icon"></i>
                            <span>Інтеграція зовнішніх систем</span>
                        </li>
                        <li class="responsibility">
                            <i class="fas fa-check responsibility-icon"></i>
                            <span>Забезпечення кібербезпеки</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Team 2 -->
                <div class="team-card fade-in-up delay-2">
                    <div class="team-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h3 class="team-title">Проєктна команда</h3>
                    <div class="team-members">
                        <span class="member-tag">6 менеджерів</span>
                        <span class="member-tag">4 координатори</span>
                        <span class="member-tag">3 аналітики</span>
                    </div>
                    <ul class="team-responsibilities">
                        <li class="responsibility">
                            <i class="fas fa-check responsibility-icon"></i>
                            <span>Управління BIM-проектами</span>
                        </li>
                        <li class="responsibility">
                            <i class="fas fa-check responsibility-icon"></i>
                            <span>Моніторинг прогресу</span>
                        </li>
                        <li class="responsibility">
                            <i class="fas fa-check responsibility-icon"></i>
                            <span>Координація з партнерами</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Team 3 -->
                <div class="team-card fade-in-up delay-3">
                    <div class="team-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="team-title">Навчальна команда</h3>
                    <div class="team-members">
                        <span class="member-tag">5 експертів</span>
                        <span class="member-tag">3 методисти</span>
                        <span class="member-tag">2 тренера</span>
                    </div>
                    <ul class="team-responsibilities">
                        <li class="responsibility">
                            <i class="fas fa-check responsibility-icon"></i>
                            <span>Розробка навчальних програм</span>
                        </li>
                        <li class="responsibility">
                            <i class="fas fa-check responsibility-icon"></i>
                            <span>Проведення тренінгів</span>
                        </li>
                        <li class="responsibility">
                            <i class="fas fa-check responsibility-icon"></i>
                            <span>Сертифікація фахівців</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Advisors Section -->
    <section class="advisors-section">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Експертна рада</h2>
                <p class="section-subtitle">
                    Провідні експерти та консультанти в галузі BIM та будівництва
                </p>
            </div>
            
            <div class="advisors-grid">
                <!-- Advisor 1 -->
                <div class="advisor-card fade-in-up delay-1">
                    <div class="advisor-avatar">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="advisor-name">Володимир Шевченко</h3>
                    <div class="advisor-role">Експерт з міжнародних стандартів</div>
                    <div class="advisor-organization">Колишній представник ISO</div>
                </div>
                
                <!-- Advisor 2 -->
                <div class="advisor-card fade-in-up delay-2">
                    <div class="advisor-avatar">
                        <i class="fas fa-female"></i>
                    </div>
                    <h3 class="advisor-name">Катерина Мельник</h3>
                    <div class="advisor-role">Експерт з цифрової трансформації</div>
                    <div class="advisor-organization">Міністерство цифрової трансформації</div>
                </div>
                
                <!-- Advisor 3 -->
                <div class="advisor-card fade-in-up delay-3">
                    <div class="advisor-avatar">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 class="advisor-name">Андрій Бондар</h3>
                    <div class="advisor-role">Експерт з відновлення</div>
                    <div class="advisor-organization">Агентство відновлення України</div>
                </div>
                
                <!-- Advisor 4 -->
                <div class="advisor-card fade-in-up delay-4">
                    <div class="advisor-avatar">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="advisor-name">Михайло Лисенко</h3>
                    <div class="advisor-role">Експерт з будівельних технологій</div>
                    <div class="advisor-organization">Національний університет будівництва</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Join Team Section -->
    <section class="join-section">
        <div class="container">
            <div class="join-content fade-in-up">
                <h2 class="section-title">Приєднуйтесь до команди</h2>
                <p class="section-subtitle" style="margin-bottom: var(--space-2xl);">
                    Ми завжди шукаємо талановитих фахівців для спільної роботи над відновленням України
                </p>
                <button class="btn btn-primary btn-lg" onclick="showCareersModal()" style="font-size: 1.125rem; padding: var(--space-lg) var(--space-2xl);">
                    <i class="fas fa-briefcase"></i> Переглянути вакансії
                </button>
            </div>
            
            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card fade-in-up delay-1">
                    <div class="stat-value">42</div>
                    <div class="stat-label">Члени команди</div>
                </div>
                
                <div class="stat-card fade-in-up delay-2">
                    <div class="stat-value">8</div>
                    <div class="stat-label">Експертів</div>
                </div>
                
                <div class="stat-card fade-in-up delay-3">
                    <div class="stat-value">15+</div>
                    <div class="stat-label">Років досвіду в середньому</div>
                </div>
                
                <div class="stat-card fade-in-up delay-4">
                    <div class="stat-value">5</div>
                    <div class="stat-label">Країн представництва</div>
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

    <div id="careersModal" class="modal" style="display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); overflow-y: auto;">
        <div class="modal-content" style="background-color: white; margin: 5% auto; padding: var(--space-xl); border-radius: var(--radius-lg); width: 90%; max-width: 800px; position: relative; box-shadow: var(--shadow-2xl);">
            <span class="close-modal" onclick="closeModal('careersModal')" style="color: var(--gray-500); float: right; font-size: 28px; font-weight: bold; cursor: pointer; position: absolute; right: var(--space-md); top: var(--space-md);">&times;</span>
            <h2 style="margin-bottom: var(--space-xl);">Вакансії BIM Hub</h2>
            <div id="careersContent">
                <div style="margin-bottom: var(--space-2xl);">
                    <h3 style="margin-bottom: var(--space-md);">BIM-розробник</h3>
                    <p style="color: var(--gray-600); margin-bottom: var(--space-md);">Шукаємо досвідченого розробника для роботи над платформою BIM Hub.</p>
                    <div style="display: flex; gap: var(--space-md); margin-bottom: var(--space-lg);">
                        <span style="padding: var(--space-xs) var(--space-sm); background: var(--gray-100); color: var(--gray-700); border-radius: var(--radius-full); font-size: 0.875rem;">Повна зайнятість</span>
                        <span style="padding: var(--space-xs) var(--space-sm); background: var(--gray-100); color: var(--gray-700); border-radius: var(--radius-full); font-size: 0.875rem;">Віддалено</span>
                    </div>
                    <button class="btn btn-primary" onclick="applyForJob('BIM-розробник')">Відгукнутися</button>
                </div>
                
                <div style="margin-bottom: var(--space-2xl);">
                    <h3 style="margin-bottom: var(--space-md);">BIM-менеджер проектів</h3>
                    <p style="color: var(--gray-600); margin-bottom: var(--space-md);">Потрібен досвідчений менеджер для керування BIM-проектами.</p>
                    <div style="display: flex; gap: var(--space-md); margin-bottom: var(--space-lg);">
                        <span style="padding: var(--space-xs) var(--space-sm); background: var(--gray-100); color: var(--gray-700); border-radius: var(--radius-full); font-size: 0.875rem;">Повна зайнятість</span>
                        <span style="padding: var(--space-xs) var(--space-sm); background: var(--gray-100); color: var(--gray-700); border-radius: var(--radius-full); font-size: 0.875rem;">Київ</span>
                    </div>
                    <button class="btn btn-primary" onclick="applyForJob('BIM-менеджер проектів')">Відгукнутися</button>
                </div>
            </div>
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
        
        // Careers modal
        function showCareersModal() {
            document.getElementById('careersModal').style.display = 'block';
        }
        
        function applyForJob(jobTitle) {
            alert(`Відгук на вакансію "${jobTitle}". Для подальших дій необхідно увійти в систему.`);
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
