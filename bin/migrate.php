<?php

require_once __DIR__ . '/../src/Core/Database.php';

use BIMHub\Core\Database;

// Завантажуємо конфігурацію
$config = require __DIR__ . '/../config/database.php';

// Ініціалізуємо базу даних
$database = new Database($config);

// Обробляємо команди
$command = $argv[1] ?? 'status';

$migrationDir = __DIR__ . '/../src/Database/Migrations';

$runner = new class($database, $migrationDir) {
    private $db;
    private $migrationDir;
    
    public function __construct($db, $dir) {
        $this->db = $db;
        $this->migrationDir = $dir;
        
        // Створюємо таблицю для міграцій якщо не існує
        $this->createMigrationsTable();
    }
    
    private function createMigrationsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id SERIAL PRIMARY KEY,
            migration VARCHAR(255) NOT NULL UNIQUE,
            batch INTEGER NOT NULL,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        $this->db->query($sql);
    }
    
    public function up() {
        // Отримуємо всі файли міграцій
        $files = glob($this->migrationDir . '/*.php');
        sort($files);
        
        // Отримуємо вже виконані міграції
        $executed = $this->getExecutedMigrations();
        
        $batch = $this->getNextBatchNumber();
        $executedCount = 0;
        
        foreach ($files as $file) {
            $migrationName = basename($file, '.php');
            
            // Пропускаємо якщо вже виконана
            if (in_array($migrationName, $executed)) {
                echo "⏭️  Skipping already executed: $migrationName\n";
                continue;
            }
            
            echo "🚀 Executing: $migrationName... ";
            
            try {
                // Виконуємо міграцію
                require_once $file;
                
                $className = $this->getClassName($file);
                $migration = new $className($this->db);
                $migration->up();
                
                // Записуємо у таблицю міграцій
                $this->recordMigration($migrationName, $batch);
                
                echo "✅ Done\n";
                $executedCount++;
                
            } catch (Exception $e) {
                echo "❌ Failed: " . $e->getMessage() . "\n";
                return false;
            }
        }
        
        if ($executedCount === 0) {
            echo "🎉 All migrations are already up to date!\n";
        } else {
            echo "✅ Successfully executed $executedCount migration(s)\n";
        }
        
        return true;
    }
    
    public function down($steps = 1) {
        // Отримуємо останні міграції
        $sql = "SELECT migration FROM migrations ORDER BY batch DESC, id DESC LIMIT ?";
        $migrations = $this->db->query($sql, [$steps])->fetchAll();
        
        if (empty($migrations)) {
            echo "📭 No migrations to roll back\n";
            return true;
        }
        
        foreach ($migrations as $migration) {
            $migrationName = $migration['migration'];
            $file = $this->migrationDir . '/' . $migrationName . '.php';
            
            if (!file_exists($file)) {
                echo "⚠️  Migration file not found: $migrationName\n";
                continue;
            }
            
            echo "🔙 Rolling back: $migrationName... ";
            
            try {
                require_once $file;
                
                $className = $this->getClassName($file);
                $migrationInstance = new $className($this->db);
                $migrationInstance->down();
                
                // Видаляємо запис про міграцію
                $this->removeMigration($migrationName);
                
                echo "✅ Done\n";
                
            } catch (Exception $e) {
                echo "❌ Failed: " . $e->getMessage() . "\n";
                return false;
            }
        }
        
        echo "✅ Rollback completed successfully\n";
        return true;
    }
    
    public function status() {
        $allMigrations = glob($this->migrationDir . '/*.php');
        $executedMigrations = $this->getExecutedMigrationsWithDetails();
        
        $status = [];
        
        foreach ($allMigrations as $file) {
            $migrationName = basename($file, '.php');
            $executed = array_filter($executedMigrations, fn($m) => $m['migration'] === $migrationName);
            
            if (!empty($executed)) {
                $executed = reset($executed);
                $status[] = [
                    'migration' => $migrationName,
                    'status' => 'executed',
                    'batch' => $executed['batch'],
                    'executed_at' => $executed['executed_at']
                ];
            } else {
                $status[] = [
                    'migration' => $migrationName,
                    'status' => 'pending',
                    'batch' => null,
                    'executed_at' => null
                ];
            }
        }
        
        return $status;
    }
    
    public function fresh() {
        echo "⚠️  This will drop all tables and re-run migrations. Continue? (yes/no): ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);
        
        if (trim($line) !== 'yes') {
            echo "❌ Operation cancelled\n";
            return false;
        }
        
        // Отримуємо всі таблиці
        $sql = "SELECT tablename FROM pg_tables WHERE schemaname = 'public'";
        $tables = $this->db->query($sql)->fetchAll();
        
        echo "🗑️  Dropping all tables...\n";
        foreach ($tables as $table) {
            $tableName = $table['tablename'];
            echo "  Dropping table: $tableName\n";
            $this->db->query("DROP TABLE IF EXISTS $tableName CASCADE");
        }
        
        echo "🔄 Re-creating migrations table...\n";
        $this->createMigrationsTable();
        
        echo "🚀 Running all migrations...\n";
        return $this->up();
    }
    
    private function getExecutedMigrations() {
        $sql = "SELECT migration FROM migrations ORDER BY id";
        $result = $this->db->query($sql)->fetchAll();
        
        return array_column($result, 'migration');
    }
    
    private function getExecutedMigrationsWithDetails() {
        $sql = "SELECT migration, batch, executed_at FROM migrations ORDER BY batch, id";
        return $this->db->query($sql)->fetchAll();
    }
    
    private function getNextBatchNumber() {
        $sql = "SELECT MAX(batch) as max_batch FROM migrations";
        $result = $this->db->query($sql)->fetch();
        
        return ($result['max_batch'] ?? 0) + 1;
    }
    
    private function recordMigration($name, $batch) {
        $sql = "INSERT INTO migrations (migration, batch) VALUES (?, ?)";
        $this->db->query($sql, [$name, $batch]);
    }
    
    private function removeMigration($name) {
        $sql = "DELETE FROM migrations WHERE migration = ?";
        $this->db->query($sql, [$name]);
    }
    
    private function getClassName($file) {
        $content = file_get_contents($file);
        if (preg_match('/class\s+(\w+)/', $content, $matches)) {
            return $matches[1];
        }
        throw new Exception("Could not find class name in $file");
    }
};

// Виконуємо команду
switch ($command) {
    case 'up':
        $runner->up();
        break;
        
    case 'down':
        $steps = $argv[2] ?? 1;
        $runner->down($steps);
        break;
        
    case 'fresh':
        $runner->fresh();
        break;
        
    case 'status':
    default:
        $status = $runner->status();
        
        echo str_pad('Migration', 50) . str_pad('Status', 15) . str_pad('Batch', 10) . 'Executed At' . PHP_EOL;
        echo str_repeat('-', 100) . PHP_EOL;
        
        foreach ($status as $item) {
            $statusIcon = $item['status'] === 'executed' ? '✅' : '⏳';
            echo str_pad($item['migration'], 50) .
                 str_pad($statusIcon . ' ' . $item['status'], 15) .
                 str_pad((string) ($item['batch'] ?? '-'), 10) .
                 ($item['executed_at'] ?? '-') . PHP_EOL;
        }
        
        $pending = array_filter($status, fn($s) => $s['status'] === 'pending');
        $executed = array_filter($status, fn($s) => $s['status'] === 'executed');
        
        echo PHP_EOL . "📊 Summary: " . count($executed) . " executed, " . count($pending) . " pending" . PHP_EOL;
        break;
}
