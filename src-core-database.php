<?php
// src/Core/Database.php - Клас для роботи з базою даних
namespace BIMHub\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance;
    private $connection;
    
    private function __construct()
    {
        $app = Application::getInstance();
        $config = $app->getConfig('database');
        
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
            $this->connection = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            
            // Встановлюємо часовий пояс
            $this->connection->exec("SET time_zone = '+02:00'");
            
        } catch (PDOException $e) {
            throw new \RuntimeException("Database connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection(): PDO
    {
        return $this->connection;
    }
    
    public function table(string $table): QueryBuilder
    {
        return new QueryBuilder($this->connection, $table);
    }
    
    // Допоміжні методи
    public function selectOne(string $sql, array $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }
    
    public function selectAll(string $sql, array $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function execute(string $sql, array $params = []): int
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
    
    public function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }
}

class QueryBuilder
{
    private $connection;
    private $table;
    private $conditions = [];
    private $params = [];
    
    public function __construct(PDO $connection, string $table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }
    
    public function where(string $column, string $operator, $value): self
    {
        $this->conditions[] = "$column $operator ?";
        $this->params[] = $value;
        return $this;
    }
    
    public function get(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(' AND ', $this->conditions);
        }
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchAll();
    }
}
?>
