-- Проста база даних для BIM Hub
CREATE DATABASE IF NOT EXISTS bimhub_db;
USE bimhub_db;

-- Користувачі
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    role ENUM('admin', 'manager', 'expert', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Проекти
CREATE TABLE projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    location VARCHAR(255),
    budget DECIMAL(15,2),
    status ENUM('planning', 'in_progress', 'completed') DEFAULT 'planning',
    progress INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (email, password_hash, full_name, role) VALUES 
('admin@bimhub.site', '$2y$10$YourHashedPasswordHere', 'Адміністратор', 'admin');

INSERT INTO projects (title, description, location, budget, status, progress) VALUES
('Міст через Дніпро', 'Комплексне моделювання мостової конструкції', 'Черкаська область', 2500000000.00, 'in_progress', 35),
('Житловий комплекс "Відродження"', '12-поверховий житловий комплекс', 'Київська область', 850000000.00, 'in_progress', 60);
