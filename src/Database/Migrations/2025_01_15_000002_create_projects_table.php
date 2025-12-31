<?php

class CreateProjectsTable
{
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function up() {
        $sql = <<<SQL
        CREATE TABLE projects (
            id BIGSERIAL PRIMARY KEY,
            uuid UUID DEFAULT gen_random_uuid() UNIQUE,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) UNIQUE NOT NULL,
            description TEXT,
            location VARCHAR(500),
            address JSONB,
            status VARCHAR(50) DEFAULT 'planning',
            budget DECIMAL(15, 2),
            currency VARCHAR(3) DEFAULT 'UAH',
            start_date DATE,
            end_date DATE,
            bim_level VARCHAR(20),
            progress_percentage INTEGER DEFAULT 0,
            created_by BIGINT REFERENCES users(id),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        
        CREATE INDEX idx_projects_slug ON projects(slug);
        CREATE INDEX idx_projects_status ON projects(status);
        CREATE INDEX idx_projects_created_by ON projects(created_by);
        SQL;
        
        $this->db->query($sql);
    }
    
    public function down() {
        $sql = "DROP TABLE IF EXISTS projects CASCADE";
        $this->db->query($sql);
    }
}
