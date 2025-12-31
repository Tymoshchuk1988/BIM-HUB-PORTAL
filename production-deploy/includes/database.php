<?php
// Database configuration
class Database {
    private static $connection = null;
    
    public static function connect() {
        if (self::$connection === null) {
            $host = 'localhost';
            $dbname = 'bimhub_db';
            $username = 'root';
            $password = '';
            
            try {
                self::$connection = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                    $username,
                    $password,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}