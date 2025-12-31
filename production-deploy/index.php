<?php
// BIM Hub Portal - Professional Design
session_start();

// Визначаємо поточну сторінку для активного стану в навігації
$current_page = 'home';
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIM Hub | Портал інформаційного моделювання будівель</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS Variables -->
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
        
        /* Utility Classes */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        
        /* Header - Modern Design */
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
        
        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        
        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }
        
        /* Hero Section */
        .hero {
            padding-top: 120px;
            padding-bottom: var(--space-3xl);
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(26, 86, 219, 0.05) 0%, rgba(30, 66, 159, 0.02) 100%);
            z-index: -1;
        }
        
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--space-2xl);
            align-items: center;
        }
        
        .hero-content {
            max-width: 600px;
        }
        
        .hero-title {
            font-size: 3.5rem;
            line-height: 1.1;
            margin-bottom: var(--space-lg);
            letter-spacing: -0.025em;
            background: linear-gradient(135deg, var(--gray-900) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-description {
            font-size: 1.25rem;
            color: var(--gray-600);
            margin-bottom: var(--space-xl);
            line-height: 1.7;
        }
        
        .hero-stats {
            display: flex;
            gap: var(--space-2xl);
            margin-top: var(--space-xl);
        }
        
        .hero-stat {
            display: flex;
            flex-direction: column;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }
        
        .stat-label {
            font-size: 0.875rem;
            color: var(--gray-600);
            font-weight: 500;
            margin-top: var(--space-xs);
        }
        
        .hero-visual {
            position: relative;
        }
        
        .dashboard-preview {
            background: white;
            border-radius: var(--radius-xl);
            padding: var(--space-xl);
            box-shadow: var(--shadow-2xl);
            transform: perspective(1000px) rotateY(-10deg) rotateX(5deg);
            transition: transform var(--transition-slow);
        }
        
        .dashboard-preview:hover {
            transform: perspective(1000px) rotateY(0) rotateX(0);
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-lg);
        }
        
        .dashboard-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
        }
        
        .metric-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--space-md);
        }
        
        .metric-card {
            background: var(--gray-50);
            border-radius: var(--radius-md);
            padding: var(--space-lg);
            border: 1px solid var(--gray-200);
        }
        
        .metric-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            margin-bottom: var(--space-xs);
        }
        
        .metric-label {
            font-size: 0.875rem;
            color: var(--gray-600);
        }
        
        /* Modules Section */
        .modules {
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
        
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: var(--space-xl);
            margin-bottom: var(--space-2xl);
        }
        
        .module-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            border: 1px solid var(--gray-200);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }
        
        .module-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }
        
        .module-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-2xl);
            border-color: var(--primary-light);
        }
        
        .module-icon {
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
            border: 1px solid var(--gray-200);
        }
        
        .module-number {
            position: absolute;
            top: var(--space-xl);
            right: var(--space-xl);
            width: 32px;
            height: 32px;
            background: var(--primary);
            color: white;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
        }
        
        .module-title {
            font-size: 1.5rem;
            margin-bottom: var(--space-md);
            color: var(--gray-900);
        }
        
        .module-description {
            color: var(--gray-600);
            margin-bottom: var(--space-lg);
            line-height: 1.7;
        }
        
        .module-features {
            list-style: none;
        }
        
        .module-feature {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            padding: var(--space-sm) 0;
            border-bottom: 1px solid var(--gray-100);
            color: var(--gray-700);
            font-size: 0.95rem;
        }
        
        .module-feature:last-child {
            border-bottom: none;
        }
        
        .feature-check {
            color: var(--success);
            font-size: 0.875rem;
        }
        
        /* KPI Dashboard */
        .kpi-section {
            padding: var(--space-3xl) 0;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            color: white;
        }
        
        .kpi-header {
            text-align: center;
            margin-bottom: var(--space-3xl);
        }
        
        .kpi-title {
            font-size: 2.5rem;
            margin-bottom: var(--space-md);
            color: white;
        }
        
        .kpi-subtitle {
            font-size: 1.125rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-xl);
        }
        
        .kpi-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all var(--transition);
        }
        
        .kpi-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-4px);
        }
        
        .kpi-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-lg);
        }
        
        .kpi-card-title {
            font-size: 0.95rem;
            font-weight: 600;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .kpi-card-value {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: var(--space-md);
        }
        
        .kpi-progress {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: var(--space-sm);
        }
        
        .kpi-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--accent), #fbbf24);
            border-radius: var(--radius-full);
        }
        
        .kpi-trend {
            display: flex;
            align-items: center;
            gap: var(--space-xs);
            font-size: 0.875rem;
            opacity: 0.9;
        }
        
        /* Timeline */
        .timeline-section {
            padding: var(--space-3xl) 0;
            background: white;
        }
        
        .timeline {
            position: relative;
            max-width: 800px;
            margin: var(--space-3xl) auto 0;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, var(--primary), var(--accent));
        }
        
        .timeline-item {
            position: relative;
            padding-left: var(--space-2xl);
            margin-bottom: var(--space-2xl);
        }
        
        .timeline-dot {
            position: absolute;
            left: -9px;
            top: 0;
            width: 20px;
            height: 20px;
            background: white;
            border: 4px solid var(--primary);
            border-radius: var(--radius-full);
            box-shadow: var(--shadow-md);
        }
        
        .timeline-year {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: var(--space-xs) var(--space-md);
            border-radius: var(--radius-full);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: var(--space-sm);
        }
        
        .timeline-content {
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            border: 1px solid var(--gray-200);
            transition: all var(--transition);
        }
        
        .timeline-content:hover {
            transform: translateX(8px);
            border-color: var(--primary-light);
            box-shadow: var(--shadow-lg);
        }
        
        .timeline-title {
            font-size: 1.25rem;
            margin-bottom: var(--space-sm);
            color: var(--gray-900);
        }
        
        /* Projects Grid */
        .projects-section {
            padding: var(--space-3xl) 0;
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
        }
        
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: var(--space-xl);
            margin-top: var(--space-2xl);
        }
        
        .project-card {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: all var(--transition);
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
        @media (max-width: 1024px) {
            .hero-title {
                font-size: 3rem;
            }
            
            .hero-grid {
                grid-template-columns: 1fr;
                gap: var(--space-xl);
            }
            
            .hero-visual {
                order: -1;
            }
            
            .dashboard-preview {
                transform: none;
            }
        }
        
        @media (max-width: 768px) {
            .nav {
                display: none;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .modules-grid {
                grid-template-columns: 1fr;
            }
            
            .hero-stats {
                flex-wrap: wrap;
                gap: var(--space-xl);
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
                <a href="/" class="nav-link <?php echo $current_page == 'home' ? 'active' : ''; ?>">Головна</a>
                <a href="/pages/strategy/" class="nav-link <?php echo $current_page == 'strategy' ? 'active' : ''; ?>">Стратегія</a>
                <a href="/pages/projects/" class="nav-link <?php echo $current_page == 'projects' ? 'active' : ''; ?>">Проекти</a>
                <a href="/pages/library/" class="nav-link <?php echo $current_page == 'library' ? 'active' : ''; ?>">Бібліотека</a>
                <a href="/pages/education/" class="nav-link <?php echo $current_page == 'education' ? 'active' : ''; ?>">Навчання</a>
                <a href="/pages/team/" class="nav-link <?php echo $current_page == 'team' ? 'active' : ''; ?>">Команда</a>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content fade-in-up">
                    <h1 class="hero-title">
                        Впровадження BIM для відновлення України
                    </h1>
                    <p class="hero-description">
                        Комплексна платформа для управління процесом будівельного інформаційного моделювання. 
                        Об'єднуємо стратегію, проекти та експертів для ефективного відновлення України.
                    </p>
                    <div class="hero-actions">
                        <button class="btn btn-primary btn-lg" onclick="showDemoModal()">
                            <i class="fas fa-rocket"></i> Демо-доступ
                        </button>
                        <a href="/pages/projects/" class="btn btn-outline">
                            <i class="fas fa-building"></i> Переглянути проекти
                        </a>
                    </div>
                    
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <div class="stat-number">113</div>
                            <div class="stat-label">Стратегічних заходів</div>
                        </div>
                        <div class="hero-stat">
                            <div class="stat-number">42</div>
                            <div class="stat-label">Завершено</div>
                        </div>
                        <div class="hero-stat">
                            <div class="stat-number">7</div>
                            <div class="stat-label">Модулів порталу</div>
                        </div>
                    </div>
                </div>
                
                <div class="hero-visual fade-in-up delay-1">
                    <div class="dashboard-preview">
                        <div class="dashboard-header">
                            <div class="dashboard-title">Загальний прогрес</div>
                            <div class="dashboard-badge" style="color: var(--success); font-weight: 700;">67%</div>
                        </div>
                        <div class="metric-grid">
                            <div class="metric-card">
                                <div class="metric-value">82%</div>
                                <div class="metric-label">Виконання термінів</div>
                            </div>
                            <div class="metric-card">
                                <div class="metric-value">94%</div>
                                <div class="metric-label">Бюджетна ефективність</div>
                            </div>
                            <div class="metric-card">
                                <div class="metric-value">56%</div>
                                <div class="metric-label">Залученість</div>
                            </div>
                            <div class="metric-card">
                                <div class="metric-value">78%</div>
                                <div class="metric-label">Якість документів</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modules Section -->
    <section class="modules">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Архітектура порталу: 7 основних модулів</h2>
                <p class="section-subtitle">
                    Комплексна платформа, що охоплює всі аспекти впровадження будівельного інформаційного моделювання
                </p>
            </div>
            
            <div class="modules-grid">
                <!-- Module 1 -->
                <div class="module-card fade-in-up delay-1">
                    <div class="module-number">1</div>
                    <div class="module-icon">
                        <i class="fas fa-chess-queen"></i>
                    </div>
                    <h3 class="module-title">Стратегічна палітра керування</h3>
                    <p class="module-description">
                        Візуалізація стратегії впровадження BIM з інтерактивною дорожньою картою та KPI Dashboard
                    </p>
                    <ul class="module-features">
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Інтерактивна дорожня карта 2025-2027
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Панель ключових показників (KPI)
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Система ранжування ризиків
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Drag-and-drop функціонал
                        </li>
                    </ul>
                </div>
                
                <!-- Module 2 -->
                <div class="module-card fade-in-up delay-2">
                    <div class="module-number">2</div>
                    <div class="module-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3 class="module-title">Операційне управління заходами</h3>
                    <p class="module-description">
                        Детальна система контролю виконання заходів з автоматизованою звітністю
                    </p>
                    <ul class="module-features">
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Детальна картка заходу
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Інтерактивні контрольні списки
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Хмарне сховище документів
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Автоматична звітність
                        </li>
                    </ul>
                </div>
                
                <!-- Module 3 -->
                <div class="module-card fade-in-up delay-3">
                    <div class="module-number">3</div>
                    <div class="module-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="module-title">Бібліотека стандартів та шаблонів</h3>
                    <p class="module-description">
                        Централізована база знань з міжнародними та національними стандартами BIM
                    </p>
                    <ul class="module-features">
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            ISO 19650, EN 17412, ДСТУ
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Шаблони EIR, BEP, MIDP
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Бібліотека BIM-компонентів
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Розумна пошукова система
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="modules-grid">
                <!-- Module 4 -->
                <div class="module-card fade-in-up delay-1">
                    <div class="module-number">4</div>
                    <div class="module-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h3 class="module-title">Проєктний хаб</h3>
                    <p class="module-description">
                        Реєстр проектів BIM з картою геолокації та детальними профілями
                    </p>
                    <ul class="module-features">
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Реєстр проектів з геолокацією
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Детальні профілі проектів
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Моніторинг бюджету та термінів
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Порівняльна аналітика
                        </li>
                    </ul>
                </div>
                
                <!-- Module 5 -->
                <div class="module-card fade-in-up delay-2">
                    <div class="module-number">5</div>
                    <div class="module-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3 class="module-title">Комунікаційна платформа</h3>
                    <p class="module-description">
                        Інструменти для ефективної комунікації та співпраці всіх учасників
                    </p>
                    <ul class="module-features">
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Тематичні робочі групи
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Календар подій та вебінарів
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Система сповіщень
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Інтеграція з Teams/Slack
                        </li>
                    </ul>
                </div>
                
                <!-- Module 6 -->
                <div class="module-card fade-in-up delay-3">
                    <div class="module-number">6</div>
                    <div class="module-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="module-title">Освітній хаб</h3>
                    <p class="module-description">
                        Комплекс навчальних матеріалів та система сертифікації BIM-фахівців
                    </p>
                    <ul class="module-features">
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Каталог навчальних матеріалів
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Система сертифікації
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Персональні навчальні плани
                        </li>
                        <li class="module-feature">
                            <i class="fas fa-check feature-check"></i>
                            Міжнародні партнерства
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Module 7 -->
            <div class="module-card fade-in-up delay-4" style="max-width: 800px; margin: 0 auto;">
                <div class="module-number">7</div>
                <div class="module-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <h3 class="module-title">Адміністративний контур</h3>
                <p class="module-description">
                    Система управління користувачами з 8 рівнями доступу та повною конфігурацією
                </p>
                <ul class="module-features">
                    <li class="module-feature">
                        <i class="fas fa-check feature-check"></i>
                        Управління користувачами (8 рівнів)
                    </li>
                    <li class="module-feature">
                        <i class="fas fa-check feature-check"></i>
                        Інтеграція з Дією
                    </li>
                    <li class="module-feature">
                        <i class="fas fa-check feature-check"></i>
                        Конфігурація робочих процесів
                    </li>
                    <li class="module-feature">
                        <i class="fas fa-check feature-check"></i>
                        Журнал активності
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- KPI Dashboard -->
    <section class="kpi-section">
        <div class="container">
            <div class="kpi-header fade-in-up">
                <h2 class="kpi-title">Панель ключових показників</h2>
                <p class="kpi-subtitle">
                    Реальна картина прогресу впровадження BIM за основним показниками
                </p>
            </div>
            
            <div class="kpi-grid">
                <div class="kpi-card fade-in-up delay-1">
                    <div class="kpi-card-header">
                        <div class="kpi-card-title">Загальний прогрес</div>
                        <div class="kpi-percentage">67%</div>
                    </div>
                    <div class="kpi-card-value">67%</div>
                    <div class="kpi-progress">
                        <div class="kpi-progress-bar" style="width: 67%"></div>
                    </div>
                    <div class="kpi-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+12% за місяць</span>
                    </div>
                </div>
                
                <div class="kpi-card fade-in-up delay-2">
                    <div class="kpi-card-header">
                        <div class="kpi-card-title">Виконання термінів</div>
                        <div class="kpi-percentage">82%</div>
                    </div>
                    <div class="kpi-card-value">82%</div>
                    <div class="kpi-progress">
                        <div class="kpi-progress-bar" style="width: 82%"></div>
                    </div>
                    <div class="kpi-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+8% за місяць</span>
                    </div>
                </div>
                
                <div class="kpi-card fade-in-up delay-3">
                    <div class="kpi-card-header">
                        <div class="kpi-card-title">Бюджетна ефективність</div>
                        <div class="kpi-percentage">94%</div>
                    </div>
                    <div class="kpi-card-value">94%</div>
                    <div class="kpi-progress">
                        <div class="kpi-progress-bar" style="width: 94%"></div>
                    </div>
                    <div class="kpi-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+5% за місяць</span>
                    </div>
                </div>
            </div>
            
            <div class="kpi-grid" style="margin-top: var(--space-xl);">
                <div class="kpi-card fade-in-up delay-2">
                    <div class="kpi-card-header">
                        <div class="kpi-card-title">Залученість стейкхолдерів</div>
                        <div class="kpi-percentage">56%</div>
                    </div>
                    <div class="kpi-card-value">56%</div>
                    <div class="kpi-progress">
                        <div class="kpi-progress-bar" style="width: 56%"></div>
                    </div>
                    <div class="kpi-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+15% за місяць</span>
                    </div>
                </div>
                
                <div class="kpi-card fade-in-up delay-3">
                    <div class="kpi-card-header">
                        <div class="kpi-card-title">Якість документів</div>
                        <div class="kpi-percentage">78%</div>
                    </div>
                    <div class="kpi-card-value">78%</div>
                    <div class="kpi-progress">
                        <div class="kpi-progress-bar" style="width: 78%"></div>
                    </div>
                    <div class="kpi-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+7% за місяць</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline -->
    <section class="timeline-section">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Дорожня карта впровадження</h2>
                <p class="section-subtitle">
                    Стратегічний план розвитку на 2026-2028 роки з ключовими етапами
                </p>
            </div>
            
            <div class="timeline">
                <div class="timeline-item fade-in-up delay-1">
                    <div class="timeline-dot"></div>
                    <span class="timeline-year">Q1 2026</span>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Запуск порталу та формування команд</h3>
                        <p>Створення робочих груп, налаштування модулів, запуск тестового режиму</p>
                    </div>
                </div>
                
                <div class="timeline-item fade-in-up delay-2">
                    <div class="timeline-dot"></div>
                    <span class="timeline-year">Q2 2026</span>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Розробка стандартів та пілотні проекти</h3>
                        <p>Адаптація міжнародних стандартів, запуск пілотних проектів</p>
                    </div>
                </div>
                
                <div class="timeline-item fade-in-up delay-3">
                    <div class="timeline-dot"></div>
                    <span class="timeline-year">Q3-Q4 2026</span>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Масштабування на регіональному рівні</h3>
                        <p>Залучення регіональних адміністрацій, розширення бази користувачів</p>
                    </div>
                </div>
                
                <div class="timeline-item fade-in-up delay-4">
                    <div class="timeline-dot"></div>
                    <span class="timeline-year">2027</span>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Повномасштабне впровадження</h3>
                        <p>Інтеграція з державними системами, масова підготовка фахівців</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects -->
    <section class="projects-section">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Пілотні проекти BIM</h2>
                <p class="section-subtitle">
                    Реальні проекти з використанням будівельного інформаційного моделювання для відновлення України
                </p>
            </div>
            
            <div class="projects-grid">
                <div class="project-card fade-in-up delay-1">
                    <div class="project-header">
                        <h3 class="project-title">Будівництво нового терміналу КПП "Ягодин"</h3>
                        <div class="project-location">Волинська область</div>
                    </div>
                    <div class="project-body">
                        <div class="project-stats">
                            <div class="project-stat">
                                <div class="stat-label">Рівень BIM</div>
                                <div class="stat-value">LOD 300</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Статус</div>
                                <div class="stat-value">В процесі</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Бюджет</div>
                                <div class="stat-value">₴950 млн</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Прогрес</div>
                                <div class="stat-value">15%</div>
                            </div>
                        </div>
                        <p>Повна BIM-модель з інженерними системами та енергоефективними рішеннями</p>
                    </div>
                </div>
                
                <div class="project-card fade-in-up delay-2">
                    <div class="project-header">
                        <h3 class="project-title">Міст у Чернігівській області</h3>
                        <div class="project-location">Чернігівська область</div>
                    </div>
                    <div class="project-body">
                        <div class="project-stats">
                            <div class="project-stat">
                                <div class="stat-label">Рівень BIM</div>
                                <div class="stat-value">LOD 350</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Статус</div>
                                <div class="stat-value">Проектування</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Бюджет</div>
                                <div class="stat-value">₴120 млн</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Прогрес</div>
                                <div class="stat-value">40%</div>
                            </div>
                        </div>
                        <p>Комплексне моделювання конструкцій з розрахунками навантажень</p>
                    </div>
                </div>
                
                <div class="project-card fade-in-up delay-3">
                    <div class="project-header">
                        <h3 class="project-title">Житловий комплекс у Харкові</h3>
                        <div class="project-location">Харківська область</div>
                    </div>
                    <div class="project-body">
                        <div class="project-stats">
                            <div class="project-stat">
                                <div class="stat-label">Рівень BIM</div>
                                <div class="stat-value">LOD 300</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Статус</div>
                                <div class="stat-value">Планування</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Бюджет</div>
                                <div class="stat-value">₴250 млн</div>
                            </div>
                            <div class="project-stat">
                                <div class="stat-label">Прогрес</div>
                                <div class="stat-value">25%</div>
                            </div>
                        </div>
                        <p>Бізнес-центр з сучасними технологіями управління будівництвом</p>
                    </div>
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
        
        // Animate progress bars
        function animateProgressBars() {
            document.querySelectorAll('.kpi-progress-bar').forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.transition = 'width 1.5s ease-out';
                    bar.style.width = width;
                }, 500);
            });
        }
        
        // Wait for page load to animate progress bars
        window.addEventListener('load', animateProgressBars);
        
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
        
        console.log('BIM Hub Portal v1.0 - Professional Edition');
    </script>
</body>
</html>
