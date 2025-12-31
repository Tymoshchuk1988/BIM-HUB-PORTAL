<?php
declare(strict_types=1);

namespace BIMHub\Database;

use BIMHub\Core\Database;
use Exception;

abstract class Migration
{
    protected Database $db;
    protected string $tableName = 'migrations';
    
    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    
    abstract public function up(): void;
    abstract public function down(): void;
    
    public function getName(): string
    {
        $className = get_class($this);
        $parts = explode('\\', $className);
        return end($parts);
    }
    
    public function getTimestamp(): string
    {
        $name = $this->getName();
        if (preg_match('/^(\d{4}_\d{2}_\d{2}_\d{6})_/', $name, $matches)) {
            return $matches[1];
        }
        return date('Y_m_d_His');
    }
    
    protected function createTable(string $table, callable $callback): void
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);
        $this->db->execute($blueprint->toSql());
    }
    
    protected function dropTable(string $table): void
    {
        $this->db->execute("DROP TABLE IF EXISTS {$table}");
    }
    
    protected function table(string $table, callable $callback): void
    {
        $blueprint = new Blueprint($table, false);
        $callback($blueprint);
        $this->db->execute($blueprint->toSql());
    }
}

class Blueprint
{
    private string $table;
    private bool $create;
    private array $columns = [];
    private array $indexes = [];
    private ?string $primaryKey = null;
    
    public function __construct(string $table, bool $create = true)
    {
        $this->table = $table;
        $this->create = $create;
    }
    
    public function id(string $column = 'id'): ColumnDefinition
    {
        return $this->bigIncrements($column);
    }
    
    public function bigIncrements(string $column): ColumnDefinition
    {
        return $this->addColumn($column, 'BIGSERIAL PRIMARY KEY');
    }
    
    public function string(string $column, int $length = 255): ColumnDefinition
    {
        return $this->addColumn($column, "VARCHAR($length)");
    }
    
    public function text(string $column): ColumnDefinition
    {
        return $this->addColumn($column, 'TEXT');
    }
    
    public function integer(string $column): ColumnDefinition
    {
        return $this->addColumn($column, 'INTEGER');
    }
    
    public function bigInteger(string $column): ColumnDefinition
    {
        return $this->addColumn($column, 'BIGINT');
    }
    
    public function decimal(string $column, int $total = 8, int $places = 2): ColumnDefinition
    {
        return $this->addColumn($column, "DECIMAL($total, $places)");
    }
    
    public function boolean(string $column): ColumnDefinition
    {
        return $this->addColumn($column, 'BOOLEAN');
    }
    
    public function json(string $column): ColumnDefinition
    {
        return $this->addColumn($column, 'JSONB');
    }
    
    public function uuid(string $column): ColumnDefinition
    {
        return $this->addColumn($column, 'UUID');
    }
    
    public function timestamps(): void
    {
        $this->timestamp('created_at')->nullable()->default('CURRENT_TIMESTAMP');
        $this->timestamp('updated_at')->nullable()->default('CURRENT_TIMESTAMP');
    }
    
    public function timestamp(string $column): ColumnDefinition
    {
        return $this->addColumn($column, 'TIMESTAMP');
    }
    
    public function date(string $column): ColumnDefinition
    {
        return $this->addColumn($column, 'DATE');
    }
    
    private function addColumn(string $name, string $type): ColumnDefinition
    {
        $column = new ColumnDefinition($name, $type);
        $this->columns[] = $column;
        return $column;
    }
    
    public function primary(string|array $columns): void
    {
        if (is_array($columns)) {
            $this->primaryKey = implode(', ', $columns);
        } else {
            $this->primaryKey = $columns;
        }
    }
    
    public function index(string|array $columns, ?string $name = null): void
    {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }
        
        $indexName = $name ?? "idx_{$this->table}_" . md5($columns);
        $this->indexes[] = "CREATE INDEX {$indexName} ON {$this->table} ({$columns})";
    }
    
    public function unique(string|array $columns, ?string $name = null): void
    {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }
        
        $indexName = $name ?? "uniq_{$this->table}_" . md5($columns);
        $this->indexes[] = "CREATE UNIQUE INDEX {$indexName} ON {$this->table} ({$columns})";
    }
    
    public function foreign(string $column, ?string $name = null): ForeignKeyDefinition
    {
        $foreignKey = new ForeignKeyDefinition($column);
        $this->indexes[] = $foreignKey;
        return $foreignKey;
    }
    
    public function toSql(): string
    {
        $sql = '';
        
        if ($this->create) {
            $columns = array_map(fn($col) => (string) $col, $this->columns);
            
            if ($this->primaryKey) {
                $columns[] = "PRIMARY KEY ({$this->primaryKey})";
            }
            
            $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (\n  " . 
                   implode(",\n  ", $columns) . "\n)";
        } else {
            // ALTER TABLE statements
            $alterColumns = array_map(
                fn($col) => "ADD COLUMN " . (string) $col,
                $this->columns
            );
            
            if (!empty($alterColumns)) {
                $sql = "ALTER TABLE {$this->table} " . implode(", ", $alterColumns);
            }
        }
        
        return $sql;
    }
    
    public function getIndexesSql(): array
    {
        return $this->indexes;
    }
}

class ColumnDefinition
{
    private string $name;
    private string $type;
    private bool $nullable = false;
    private bool $unique = false;
    private ?string $default = null;
    
    public function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
    }
    
    public function nullable(): self
    {
        $this->nullable = true;
        return $this;
    }
    
    public function unique(): self
    {
        $this->unique = true;
        return $this;
    }
    
    public function default(string $value): self
    {
        $this->default = $value;
        return $this;
    }
    
    public function __toString(): string
    {
        $sql = "{$this->name} {$this->type}";
        
        if (!$this->nullable) {
            $sql .= " NOT NULL";
        }
        
        if ($this->unique) {
            $sql .= " UNIQUE";
        }
        
        if ($this->default !== null) {
            $sql .= " DEFAULT {$this->default}";
        }
        
        return $sql;
    }
}

class ForeignKeyDefinition
{
    private string $column;
    private ?string $references = null;
    private ?string $onDelete = null;
    private ?string $onUpdate = null;
    
    public function __construct(string $column)
    {
        $this->column = $column;
    }
    
    public function references(string $table, string $column = 'id'): self
    {
        $this->references = "{$table}({$column})";
        return $this;
    }
    
    public function onDelete(string $action): self
    {
        $this->onDelete = $action;
        return $this;
    }
    
    public function onUpdate(string $action): self
    {
        $this->onUpdate = $action;
        return $this;
    }
    
    public function __toString(): string
    {
        $sql = "ALTER TABLE ? ADD FOREIGN KEY ({$this->column}) REFERENCES {$this->references}";
        
        if ($this->onDelete) {
            $sql .= " ON DELETE {$this->onDelete}";
        }
        
        if ($this->onUpdate) {
            $sql .= " ON UPDATE {$this->onUpdate}";
        }
        
        return $sql;
    }
}
