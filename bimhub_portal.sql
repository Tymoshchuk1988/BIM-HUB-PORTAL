-- БАЗА ДАНИХ BIM HUB PORTAL
CREATE DATABASE IF NOT EXISTS bimhub_portal;
USE bimhub_portal;

-- 1. Користувачі та автентифікація
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    organization VARCHAR(100),
    position VARCHAR(100),
    avatar_url VARCHAR(500),
    role ENUM('admin', 'manager', 'expert', 'contractor', 'user') DEFAULT 'user',
    status ENUM('active', 'pending', 'blocked') DEFAULT 'pending',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Проекти (доповнюємо статичні дані)
CREATE TABLE projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    location VARCHAR(255),
    region VARCHAR(100),
    budget DECIMAL(15,2),
    budget_currency VARCHAR(3) DEFAULT 'UAH',
    start_date DATE,
    end_date DATE,
    status ENUM('planning', 'design', 'tendering', 'construction', 'completed', 'cancelled') DEFAULT 'planning',
    bim_level INT DEFAULT 1,
    lod_level ENUM('100', '200', '300', '350', '400', '500') DEFAULT '200',
    progress INT DEFAULT 0 CHECK (progress >= 0 AND progress <= 100),
    project_manager_id INT,
    client_organization VARCHAR(255),
    contract_number VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_manager_id) REFERENCES users(id)
);

-- 3. Завдання проекту
CREATE TABLE project_tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    task_type ENUM('design', 'documentation', 'coordination', 'construction', 'inspection') DEFAULT 'design',
    assigned_to INT,
    status ENUM('todo', 'in_progress', 'review', 'completed', 'blocked') DEFAULT 'todo',
    priority ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
    due_date DATE,
    completed_at TIMESTAMP NULL,
    completion_notes TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id),
    FOREIGN KEY (assigned_to) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- 4. Документи бібліотеки
CREATE TABLE library_documents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    content TEXT,
    category ENUM('standard', 'template', 'guideline', 'manual', 'case_study', 'regulation') NOT NULL,
    subcategory VARCHAR(100),
    document_type VARCHAR(50),
    file_url VARCHAR(500),
    file_size INT,
    file_format VARCHAR(20),
    version VARCHAR(20),
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    downloads_count INT DEFAULT 0,
    views_count INT DEFAULT 0,
    tags JSON,
    author_id INT,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id)
);

-- 5. Навчальні курси
CREATE TABLE courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    detailed_description TEXT,
    level ENUM('beginner', 'intermediate', 'advanced', 'expert') DEFAULT 'beginner',
    duration_hours INT,
    price DECIMAL(10,2) DEFAULT 0,
    currency VARCHAR(3) DEFAULT 'UAH',
    instructor_id INT,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    featured BOOLEAN DEFAULT FALSE,
    thumbnail_url VARCHAR(500),
    enrolled_count INT DEFAULT 0,
    rating DECIMAL(3,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES users(id)
);

-- 6. Вебінари та події
CREATE TABLE events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    event_type ENUM('webinar', 'workshop', 'conference', 'training', 'meeting') DEFAULT 'webinar',
    start_datetime DATETIME NOT NULL,
    end_datetime DATETIME,
    location_type ENUM('online', 'offline', 'hybrid') DEFAULT 'online',
    location_details VARCHAR(500),
    speaker_id INT,
    max_participants INT,
    registered_count INT DEFAULT 0,
    meeting_link VARCHAR(500),
    recording_url VARCHAR(500),
    status ENUM('upcoming', 'live', 'completed', 'cancelled') DEFAULT 'upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (speaker_id) REFERENCES users(id)
);

-- 7. Контакти та зворотній зв'язок
CREATE TABLE contacts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    organization VARCHAR(100),
    subject VARCHAR(200),
    message TEXT NOT NULL,
    contact_type ENUM('general', 'support', 'partnership', 'career', 'other') DEFAULT 'general',
    status ENUM('new', 'in_progress', 'responded', 'closed') DEFAULT 'new',
    assigned_to INT,
    response TEXT,
    responded_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES users(id)
);

-- 8. Підписки
CREATE TABLE subscribers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL,
    subscription_type ENUM('newsletter', 'updates', 'events', 'all') DEFAULT 'newsletter',
    is_active BOOLEAN DEFAULT TRUE,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    unsubscribed_at TIMESTAMP NULL
);

-- 9. Статистика сайту
CREATE TABLE site_statistics (
    id INT PRIMARY KEY AUTO_INCREMENT,
    page_url VARCHAR(500) NOT NULL,
    visitor_ip VARCHAR(45),
    user_agent TEXT,
    referrer VARCHAR(500),
    session_id VARCHAR(100),
    user_id INT NULL,
    load_time DECIMAL(10,4),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_page_url (page_url),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- 10. Налаштування сайту
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type ENUM('string', 'integer', 'boolean', 'json', 'array') DEFAULT 'string',
    category VARCHAR(50),
    description TEXT,
    is_public BOOLEAN DEFAULT FALSE,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ДЕМО ДАНІ
INSERT INTO users (email, password_hash, full_name, role, status) VALUES
('admin@bimhub.site', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Адміністратор Системи', 'admin', 'active'),
('manager@bimhub.site', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Менеджер Проектів', 'manager', 'active'),
('expert@bimhub.site', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'BIM Експерт', 'expert', 'active');

INSERT INTO settings (setting_key, setting_value, setting_type, category, description) VALUES
('site_name', 'BIM Hub Portal', 'string', 'general', 'Назва сайту'),
('site_description', 'Портал інформаційного моделювання будівель для відновлення України', 'string', 'general', 'Опис сайту'),
('contact_email', 'info@bimhub.site', 'string', 'contact', 'Контактний email'),
('maintenance_mode', 'false', 'boolean', 'general', 'Режим технічного обслуговування');
