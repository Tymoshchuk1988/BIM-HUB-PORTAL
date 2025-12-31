<?php
/**
 * Базові функції для BIM Hub Portal
 */

/**
 * Отримати поточну сторінку
 */
function get_current_page() {
    return basename($_SERVER['PHP_SELF']);
}

/**
 * Перевірити, чи активна сторінка
 */
function is_active_page($page_name) {
    return get_current_page() == $page_name;
}

/**
 * Вивести заголовок сторінки
 */
function get_page_title() {
    $page = get_current_page();
    $titles = [
        'index.php' => 'Головна - BIM Hub Portal',
        'plan.php' => 'План BIM - BIM Hub Portal',
        'projects.php' => 'Проекти - BIM Hub Portal',
        'library.php' => 'Бібліотека - BIM Hub Portal',
        'contact.php' => 'Контакти - BIM Hub Portal',
    ];
    
    return isset($titles[$page]) ? $titles[$page] : 'BIM Hub Portal';
}

/**
 * Вивести інформацію про сервер
 */
function get_server_info() {
    $info = [
        'PHP Version' => phpversion(),
        'Server Software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
        'Server Name' => $_SERVER['SERVER_NAME'] ?? 'N/A',
        'Document Root' => $_SERVER['DOCUMENT_ROOT'] ?? 'N/A',
    ];
    
    return $info;
}

/**
 * Створити сповіщення
 */
function show_alert($message, $type = 'info') {
    $classes = [
        'success' => 'alert-success',
        'error' => 'alert-error',
        'warning' => 'alert-warning',
        'info' => 'alert-info'
    ];
    
    $class = isset($classes[$type]) ? $classes[$type] : 'alert-info';
    
    return "<div class='alert {$class}'>{$message}</div>";
}

/**
 * Захистити від XSS
 */
function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Перенаправити на сторінку
 */
function redirect($url) {
    header("Location: {$url}");
    exit;
}
