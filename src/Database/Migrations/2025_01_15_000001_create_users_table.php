<?php

class CreateUsersTable
{
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function up() {
        $sql = <<<SQL
        CREATE TABLE users (
            id BIGSERIAL PRIMARY KEY,
            uuid UUID DEFAULT gen_random_uuid() UNIQUE,
            email VARCHAR(255) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            full_name VARCHAR(255),
            role VARCHAR(50) DEFAULT 'viewer',
            status VARCHAR(20) DEFAULT 'active',
            last_login_at TIMESTAMP,
            email_verified_at TIMESTAMP,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        
        CREATE INDEX idx_users_email ON users(email);
        CREATE INDEX idx_users_role ON users(role);
        CREATE INDEX idx_users_status ON users(status);
        SQL;
        
        $this->db->query($sql);
    }
    
    public function down() {
        $sql = "DROP TABLE IF EXISTS users CASCADE";
        $this->db->query($sql);
    }
}
