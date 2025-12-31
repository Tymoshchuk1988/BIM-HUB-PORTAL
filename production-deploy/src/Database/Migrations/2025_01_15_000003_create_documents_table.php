<?php

class CreateDocumentsTable
{
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function up() {
        $sql = <<<SQL
        CREATE TABLE documents (
            id BIGSERIAL PRIMARY KEY,
            uuid UUID DEFAULT gen_random_uuid() UNIQUE,
            project_id BIGINT REFERENCES projects(id),
            title VARCHAR(255) NOT NULL,
            description TEXT,
            file_name VARCHAR(500),
            file_path VARCHAR(500),
            file_type VARCHAR(100),
            file_size BIGINT,
            mime_type VARCHAR(100),
            category VARCHAR(50),
            version INTEGER DEFAULT 1,
            is_latest BOOLEAN DEFAULT TRUE,
            uploaded_by BIGINT REFERENCES users(id),
            uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            metadata JSONB
        );
        
        CREATE INDEX idx_documents_project_id ON documents(project_id);
        CREATE INDEX idx_documents_category ON documents(category);
        CREATE INDEX idx_documents_uploaded_by ON documents(uploaded_by);
        CREATE INDEX idx_documents_is_latest ON documents(is_latest) WHERE is_latest = TRUE;
        SQL;
        
        $this->db->query($sql);
    }
    
    public function down() {
        $sql = "DROP TABLE IF EXISTS documents CASCADE";
        $this->db->query($sql);
    }
}
