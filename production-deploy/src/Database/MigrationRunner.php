<?php
declare(strict_types=1);

namespace BIMHub\Database;

use BIMHub\Core\Database;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class MigrationRunner
{
    private Database $db;
    private string $migrationsPath;
    private string $migrationsTable = 'migrations';
    
    public function __construct(Database $db, string $migrationsPath)
    {
        $this->db = $db;
        $this->migrationsPath = rtrim($migrationsPath, '/');
        
        // Створюємо таблицю міграцій якщо не існує
        $this->createMigrationsTable();
    }
    
    private function createMigrationsTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->migrationsTable} (
            id BIGSERIAL PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            batch INTEGER NOT NULL,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        $this->db->execute($sql);
    }
    
    public function migrate(?string $migrationName = null): array
    {
        $executed = [];
        
        if ($migrationName) {
            // Виконуємо конкретну міграцію
            $migration = $this->loadMigration($migrationName);
            $this->runUp($migration);
            $executed[] = $migration->getName();
        } else {
            // Виконуємо всі невиконані міграції
            $pending = $this->getPendingMigrations();
            
            foreach ($pending as $migration) {
                $this->runUp($migration);
                $executed[] = $migration->getName();
            }
        }
        
        return $executed;
    }
    
    public function rollback(?int $steps = null): array
    {
        $rolledBack = [];
        $lastBatch = $this->getLastBatch();
        
        if (!$lastBatch) {
            return [];
        }
        
        $migrationsToRollback = $this->getMigrationsForBatch($lastBatch);
        
        if ($steps !== null) {
            $migrationsToRollback = array_slice($migrationsToRollback, 0, $steps);
        }
        
        foreach ($migrationsToRollback as $migrationInfo) {
            $migration = $this->loadMigration($migrationInfo['migration']);
            $this->runDown($migration);
            $rolledBack[] = $migration->getName();
        }
        
        return $rolledBack;
    }
    
    public function fresh(): void
    {
        // Отримуємо всі виконані міграції в зворотньому порядку
        $executedMigrations = $this->getExecutedMigrations();
        $executedMigrations = array_reverse($executedMigrations);
        
        foreach ($executedMigrations as $migrationInfo) {
            $migration = $this->loadMigration($migrationInfo['migration']);
            $this->runDown($migration);
        }
        
        // Виконуємо всі міграції знову
        $this->migrate();
    }
    
    private function getPendingMigrations(): array
    {
        $allMigrations = $this->getAllMigrationFiles();
        $executedMigrations = $this->getExecutedMigrations();
        
        $executedNames = array_column($executedMigrations, 'migration');
        
        $pending = [];
        foreach ($allMigrations as $migrationFile) {
            $migration = $this->loadMigrationFromFile($migrationFile);
            if (!in_array($migration->getName(), $executedNames, true)) {
                $pending[] = $migration;
            }
        }
        
        // Сортуємо за timestamp
        usort($pending, fn($a, $b) => $a->getTimestamp() <=> $b->getTimestamp());
        
        return $pending;
    }
    
    private function getAllMigrationFiles(): array
    {
        if (!is_dir($this->migrationsPath)) {
            return [];
        }
        
        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->migrationsPath)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }
        
        sort($files);
        return $files;
    }
    
    private function getExecutedMigrations(): array
    {
        $sql = "SELECT migration FROM {$this->migrationsTable} ORDER BY id ASC";
        return $this->db->fetchAll($sql);
    }
    
    private function getLastBatch(): int
    {
        $sql = "SELECT MAX(batch) as last_batch FROM {$this->migrationsTable}";
        $result = $this->db->fetchOne($sql);
        return (int) ($result['last_batch'] ?? 0);
    }
    
    private function getMigrationsForBatch(int $batch): array
    {
        $sql = "SELECT migration FROM {$this->migrationsTable} 
                WHERE batch = ? ORDER BY id DESC";
        return $this->db->fetchAll($sql, [$batch]);
    }
    
    private function loadMigration(string $name): Migration
    {
        $filePath = $this->migrationsPath . '/' . $name . '.php';
        
        if (!file_exists($filePath)) {
            throw new Exception("Migration not found: {$name}");
        }
        
        return $this->loadMigrationFromFile($filePath);
    }
    
    private function loadMigrationFromFile(string $filePath): Migration
    {
        require_once $filePath;
        
        $className = pathinfo($filePath, PATHINFO_FILENAME);
        $fullClassName = "BIMHub\\Database\\Migrations\\{$className}";
        
        if (!class_exists($fullClassName)) {
            throw new Exception("Migration class not found: {$fullClassName}");
        }
        
        return new $fullClassName($this->db);
    }
    
    private function runUp(Migration $migration): void
    {
        $this->db->transaction(function () use ($migration) {
            $migration->up();
            
            $batch = $this->getLastBatch() + 1;
            $this->recordMigration($migration->getName(), $batch);
        });
    }
    
    private function runDown(Migration $migration): void
    {
        $this->db->transaction(function () use ($migration) {
            $migration->down();
            $this->removeMigration($migration->getName());
        });
    }
    
    private function recordMigration(string $name, int $batch): void
    {
        $sql = "INSERT INTO {$this->migrationsTable} (migration, batch) VALUES (?, ?)";
        $this->db->execute($sql, [$name, $batch]);
    }
    
    private function removeMigration(string $name): void
    {
        $sql = "DELETE FROM {$this->migrationsTable} WHERE migration = ?";
        $this->db->execute($sql, [$name]);
    }
    
    public function status(): array
    {
        $allMigrations = $this->getAllMigrationFiles();
        $executedMigrations = $this->getExecutedMigrations();
        
        $executedNames = array_column($executedMigrations, 'migration');
        
        $status = [];
        foreach ($allMigrations as $filePath) {
            $migration = $this->loadMigrationFromFile($filePath);
            $name = $migration->getName();
            
            $status[] = [
                'migration' => $name,
                'status' => in_array($name, $executedNames) ? 'executed' : 'pending',
                'batch' => $this->getBatchForMigration($name),
                'executed_at' => $this->getExecutionTime($name),
            ];
        }
        
        return $status;
    }
    
    private function getBatchForMigration(string $name): ?int
    {
        $sql = "SELECT batch FROM {$this->migrationsTable} WHERE migration = ?";
        $result = $this->db->fetchOne($sql, [$name]);
        return $result['batch'] ?? null;
    }
    
    private function getExecutionTime(string $name): ?string
    {
        $sql = "SELECT executed_at FROM {$this->migrationsTable} WHERE migration = ?";
        $result = $this->db->fetchOne($sql, [$name]);
        return $result['executed_at'] ?? null;
    }
}
