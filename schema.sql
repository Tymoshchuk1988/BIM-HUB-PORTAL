-- База даних BIM Hub
CREATE DATABASE IF NOT EXISTS bimhub_db;
USE bimhub_db;

-- Користувачі
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    role ENUM('admin', 'manager', 'expert', 'user') DEFAULT 'user',
    organization VARCHAR(255),
    position VARCHAR(100),
    avatar_url VARCHAR(500),
    status ENUM('active', 'pending', 'blocked') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
);

-- Проекти BIM
CREATE TABLE projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    location VARCHAR(255),
    budget DECIMAL(15,2),
    start_date DATE,
    end_date DATE,
    status ENUM('planning', 'design', 'construction', 'completed', 'cancelled') DEFAULT 'planning',
    bim_level INT DEFAULT 1,
    lod_level ENUM('100', '200', '300', '350', '400') DEFAULT '200',
    progress INT DEFAULT 0,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Завдання проекту
CREATE TABLE project_tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    assigned_to INT,
    status ENUM('todo', 'in_progress', 'review', 'completed') DEFAULT 'todo',
    priority ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
    due_date DATE,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id),
    FOREIGN KEY (assigned_to) REFERENCES users(id)
);

-- Документи бібліотеки
CREATE TABLE library_documents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    category ENUM('standard', 'template', 'component', 'guide', 'case_study') NOT NULL,
    file_url VARCHAR(500),
    file_type VARCHAR(50),
    file_size INT,
    description TEXT,
    tags JSON,
    downloads INT DEFAULT 0,
    uploaded_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id)
);

-- Навчальні курси
CREATE TABLE courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    level ENUM('beginner', 'intermediate', 'advanced', 'expert') DEFAULT 'beginner',
    duration_hours INT,
    price DECIMAL(10,2) DEFAULT 0,
    instructor_id INT,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES users(id)
);

-- Вебінари/Події
CREATE TABLE events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_type ENUM('webinar', 'workshop', 'conference', 'meeting') DEFAULT 'webinar',
    start_datetime DATETIME NOT NULL,
    end_datetime DATETIME,
    speaker_id INT,
    max_participants INT,
    registered_count INT DEFAULT 0,
    zoom_link VARCHAR(500),
    recording_url VARCHAR(500),
    status ENUM('upcoming', 'live', 'completed', 'cancelled') DEFAULT 'upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (speaker_id) REFERENCES users(id)
);
