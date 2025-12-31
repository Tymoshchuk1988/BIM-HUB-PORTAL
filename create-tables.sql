-- Таблиця користувачів
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255),
    role ENUM('admin', 'manager', 'viewer') DEFAULT 'viewer',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Таблиця проектів
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    status ENUM('planning', 'design', 'construction', 'completed') DEFAULT 'planning',
    progress INT DEFAULT 0,
    budget DECIMAL(15,2),
    start_date DATE,
    end_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Таблиця документів
CREATE TABLE IF NOT EXISTS documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    title VARCHAR(255) NOT NULL,
    file_name VARCHAR(255),
    file_type VARCHAR(50),
    file_size INT,
    uploaded_by INT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Демо дані
INSERT IGNORE INTO users (email, password_hash, full_name, role) VALUES
('admin@bimhub.site', MD5('admin123'), 'Адміністратор', 'admin'),
('manager@bimhub.site', MD5('manager123'), 'Менеджер Проектів', 'manager');

INSERT IGNORE INTO projects (name, slug, description, status, progress) VALUES
('Відбудова житлового будинку', 'reconstruction-building', 'Повна відбудова зруйнованого будинку', 'construction', 65),
('Модернізація інфраструктури', 'infrastructure-modernization', 'Оновлення комунальних мереж', 'design', 30);
