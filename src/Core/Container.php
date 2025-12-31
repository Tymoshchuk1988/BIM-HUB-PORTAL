<?php
declare(strict_types=1);

namespace BIMHub\Core;

use Exception;
use ReflectionClass;

class Container
{
    private array $bindings = [];
    private array $instances = [];
    private array $aliases = [];

    public function set(string $abstract, $concrete = null): void
    {
        if ($concrete === null) {
            $concrete = $abstract;
        }
        
        $this->bindings[$abstract] = $concrete;
        
        // Якщо передали об'єкт, зберігаємо його як instance
        if (is_object($concrete) && !$concrete instanceof \Closure) {
            $this->instances[$abstract] = $concrete;
            unset($this->bindings[$abstract]);
        }
    }

    public function singleton(string $abstract, $concrete = null): void
    {
        if ($concrete === null) {
            $concrete = $abstract;
        }
        
        $this->set($abstract, function () use ($concrete) {
            static $instance;
            
            if ($instance === null) {
                $instance = $this->build($concrete);
            }
            
            return $instance;
        });
    }

    public function alias(string $abstract, string $alias): void
    {
        $this->aliases[$alias] = $abstract;
    }

    public function get(string $abstract)
    {
        // Перевіряємо аліаси
        $abstract = $this->aliases[$abstract] ?? $abstract;
        
        // Повертаємо готовий instance якщо є
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }
        
        // Отримуємо конкретну реалізацію
        $concrete = $this->bindings[$abstract] ?? $abstract;
        
        // Якщо це замикання, викликаємо його
        if ($concrete instanceof \Closure) {
            $object = $concrete($this);
        } else {
            $object = $this->build($concrete);
        }
        
        // Зберігаємо singleton instance
        if (isset($this->bindings[$abstract]) && $this->bindings[$abstract] instanceof \Closure) {
            $this->instances[$abstract] = $object;
        }
        
        return $object;
    }

    public function has(string $abstract): bool
    {
        $abstract = $this->aliases[$abstract] ?? $abstract;
        
        return isset($this->bindings[$abstract]) || 
               isset($this->instances[$abstract]) ||
               class_exists($abstract);
    }

    private function build(string $concrete)
    {
        try {
            $reflection = new ReflectionClass($concrete);
            
            // Перевіряємо чи клас можна створити
            if (!$reflection->isInstantiable()) {
                throw new Exception("Class {$concrete} is not instantiable");
            }
            
            // Отримуємо конструктор
            $constructor = $reflection->getConstructor();
            
            // Якщо конструктора немає, просто створюємо
            if ($constructor === null) {
                return $reflection->newInstance();
            }
            
            // Отримуємо параметри конструктора
            $parameters = $constructor->getParameters();
            $dependencies = [];
            
            foreach ($parameters as $parameter) {
                $type = $parameter->getType();
                
                if ($type === null || $type->isBuiltin()) {
                    // Примітивний тип - намагаємося отримати з конфігурації
                    if ($parameter->isDefaultValueAvailable()) {
                        $dependencies[] = $parameter->getDefaultValue();
                    } else {
                        throw new Exception(
                            "Cannot resolve parameter \${$parameter->getName()} of class {$concrete}"
                        );
                    }
                } else {
                    // Тип об'єкта - рекурсивно створюємо
                    $typeName = $type->getName();
                    $dependencies[] = $this->get($typeName);
                }
            }
            
            return $reflection->newInstanceArgs($dependencies);
            
        } catch (\ReflectionException $e) {
            throw new Exception("Cannot build {$concrete}: " . $e->getMessage());
        }
    }

    public function call($callable, array $parameters = [])
    {
        if (is_string($callable) && strpos($callable, '@') !== false) {
            // Формат "ClassName@method"
            [$class, $method] = explode('@', $callable);
            $instance = $this->get($class);
            $callable = [$instance, $method];
        }
        
        return call_user_func_array($callable, $parameters);
    }
}
