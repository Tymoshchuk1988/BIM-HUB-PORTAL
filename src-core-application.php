<?php
// src/Core/Application.php - Основний клас додатка
namespace BIMHub\Core;

class Application
{
    private static $instance;
    private $config = [];
    private $services = [];
    
    private function __construct()
    {
        // Завантаження конфігурації
        $this->loadConfig();
    }
    
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function loadConfig(): void
    {
        $configPath = __DIR__ . '/../../config/app.php';
        if (file_exists($configPath)) {
            $this->config = require $configPath;
        }
    }
    
    public function getConfig(string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->config;
        }
        
        $keys = explode('.', $key);
        $value = $this->config;
        
        foreach ($keys as $k) {
            if (!is_array($value) || !array_key_exists($k, $value)) {
                return $default;
            }
            $value = $value[$k];
        }
        
        return $value;
    }
    
    public function setService(string $name, $service): void
    {
        $this->services[$name] = $service;
    }
    
    public function getService(string $name)
    {
        return $this->services[$name] ?? null;
    }
    
    public function run(): void
    {
        // Тут буде запуск додатка
        echo "BIM Hub Portal Application is running!";
    }
}
?>
