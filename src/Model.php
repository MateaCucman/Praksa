<?php
namespace Matea\Praksa;

use Matea\Praksa\Connection;

abstract class Model
{
    protected string $tableName;
    protected int|string $primaryKey;
    public array $attributes;

    public function save()
    {
        $this->primaryKey = Connection::getInstance()->insert($this->tableName, $this->attributes);
        $this->attributes = self::find($this->primaryKey)->toArray();
    }

    public function update()
    {
        $idValue = end($this->attributes);
        $idKey = key($this->attributes);
        array_pop($this->attributes);
        Connection::getInstance()->update($this->tableName, $this->attributes, [$idKey => $idValue]);
    }

    static public function find($primaryKey): ?Model
    {
        $instance = new static();
        $query = "SELECT * FROM $instance->tableName WHERE $instance->primaryKey = ?";
        $instance->attributes = Connection::getInstance()->fetchAssoc($query, [$primaryKey]);

        return $instance;
    }

    static public function select($params): array
    {
        $query = 'SELECT id, name FROM products
                    WHERE type = :type AND id > :id
                    LIMIT 20';
        
        $pdo = Connection::getInstance()->fetchAssocAll($query, $params);
        return $pdo;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}
