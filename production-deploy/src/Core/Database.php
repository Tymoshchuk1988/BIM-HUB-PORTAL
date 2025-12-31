<?php

namespace BIMHub\Core;

use PDO;
use PDOException;

class Database
{
    private $pdo;
    private $config;
    
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->connect();
    }
    
    private function connect(): void
    {
        $dsn = sprintf(
            'pgsql:host=%s;port=%d;dbname=%s',
            $this->config['host'],
            $this->config['port'],
            $this->config['database']
        );
        
        try {
            $this->pdo = new PDO(
                $dsn,
                $this->config['username'],
                $this->config['password'],
                $this->config['options']
            );
        } catch (PDOException $e) {
            throw new PDOException(
                'Database connection failed: ' . $e->getMessage(),
                (int)$e->getCode()
            );
        }
    }
    
    public function query(string $sql, array $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    public function getLastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
    
    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }
    
    public function commit(): bool
    {
        return $this->pdo->commit();
    }
    
    public function rollBack(): bool
    {
        return $this->pdo->rollBack();
    }
}
