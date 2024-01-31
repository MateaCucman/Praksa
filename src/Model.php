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
        //self::find($primaryKey);
        $value = end($this->attributes);
        $key = key($this->attributes);
        array_pop($this->attributes);
        Connection::getInstance()->update($this->tableName, $this->attributes, [$key => $value]);

        // $setClause = implode(', ', array_map(function ($column) {
        //     return "$column = ?";
        // }, array_keys($this->attributes)));

        // $query = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?";
        // $values = array_merge(array_values($this->attributes), [$this->{$this->primaryKey}]);

        // $this->executeQuery($query, $values);

        // $this->fill($this->find($this->{$this->primaryKey})->toArray());
    }

    static public function find($primaryKey): ?Model
    {
        $instance = new static();
        $query = "SELECT * FROM $instance->tableName WHERE $instance->primaryKey = ?";
        $instance->attributes = Connection::getInstance()->fetchAssoc($query, [$primaryKey]);

        return $instance;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}
