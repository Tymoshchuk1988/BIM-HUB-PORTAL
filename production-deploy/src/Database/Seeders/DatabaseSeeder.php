<?php

namespace BIMHub\Database\Seeders;

class DatabaseSeeder
{
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function run() {
        echo "🌱 Seeding database...\n";
        
        $this->seedUsers();
        $this->seedProjects();
        $this->seedDocuments();
        
        echo "✅ Database seeded successfully!\n";
    }
    
    private function seedUsers() {
        echo "  👥 Seeding users... ";
        
        $users = [
            [
                'email' => 'admin@bimhub.gov.ua',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'full_name' => 'Адміністратор Системи',
                'role' => 'admin',
                'status' => 'active'
            ],
            [
                'email' => 'project.manager@bimhub.gov.ua',
                'password_hash' => password_hash('manager123', PASSWORD_DEFAULT),
                'full_name' => 'Менеджер Проектів',
                'role' => 'project_manager',
                'status' => 'active'
            ],
            [
                'email' => 'bim.specialist@bimhub.gov.ua',
                'password_hash' => password_hash('bim123', PASSWORD_DEFAULT),
                'full_name' => 'BIM Спеціаліст',
                'role' => 'bim_specialist',
                'status' => 'active'
            ],
            [
                'email' => 'viewer@bimhub.gov.ua',
                'password_hash' => password_hash('viewer123', PASSWORD_DEFAULT),
                'full_name' => 'Переглядач',
                'role' => 'viewer',
                'status' => 'active'
            ]
        ];
        
        foreach ($users as $user) {
            $this->db->query(
                "INSERT INTO users (email, password_hash, full_name, role, status) VALUES (?, ?, ?, ?, ?)",
                array_values($user)
            );
        }
        
        echo "✅ Done\n";
    }
    
    private function seedProjects() {
        echo "  🏗️ Seeding projects... ";
        
        $projects = [
            [
                'name' => 'Відбудова житлового будинку в Києві',
                'slug' => 'reconstruction-kyiv-residential',
                'description' => 'Повна відбудова 9-поверхового житлового будинку, зруйнованого в результаті бойових дій',
                'location' => 'Київ, Подільський район',
                'status' => 'construction',
                'budget' => 85000000.00,
                'start_date' => '2024-03-01',
                'end_date' => '2025-12-31',
                'bim_level' => 'LOD 350',
                'progress_percentage' => 65
            ],
            [
                'name' => 'Модернізація інфраструктури Львова',
                'slug' => 'lviv-infrastructure-modernization',
                'description' => 'Комплексна модернізація транспортної та комунальної інфраструктури міста',
                'location' => 'Львів',
                'status' => 'design',
                'budget' => 120000000.00,
                'start_date' => '2024-06-01',
                'end_date' => '2026-05-31',
                'bim_level' => 'LOD 400',
                'progress_percentage' => 30
            ],
            [
                'name' => 'Школа майбутнього в Одесі',
                'slug' => 'odesa-future-school',
                'description' => 'Будівництво сучасної школи з інноваційними класами та спортивним комплексом',
                'location' => 'Одеса, Приморський район',
                'status' => 'planning',
                'budget' => 45000000.00,
                'start_date' => '2024-09-01',
                'end_date' => '2025-08-31',
                'bim_level' => 'LOD 300',
                'progress_percentage' => 15
            ]
        ];
        
        foreach ($projects as $project) {
            $this->db->query(
                "INSERT INTO projects (name, slug, description, location, status, budget, start_date, end_date, bim_level, progress_percentage, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)",
                array_values($project)
            );
        }
        
        echo "✅ Done\n";
    }
    
    private function seedDocuments() {
        echo "  📄 Seeding documents... ";
        
        $documents = [
            [
                'project_id' => 1,
                'title' => 'Архітектурний проект',
                'file_name' => 'architectural_design.pdf',
                'file_type' => 'PDF',
                'category' => 'architectural',
                'version' => 2
            ],
            [
                'project_id' => 1,
                'title' => 'Конструктивні рішення',
                'file_name' => 'structural_solutions.pdf',
                'file_type' => 'PDF',
                'category' => 'structural',
                'version' => 1
            ],
            [
                'project_id' => 2,
                'title' => 'Дорожня схема',
                'file_name' => 'road_scheme.dwg',
                'file_type' => 'DWG',
                'category' => 'infrastructure',
                'version' => 3
            ]
        ];
        
        foreach ($documents as $doc) {
            $this->db->query(
                "INSERT INTO documents (project_id, title, file_name, file_type, category, version, uploaded_by) VALUES (?, ?, ?, ?, ?, ?, 2)",
                array_values($doc)
            );
        }
        
        echo "✅ Done\n";
    }
}
