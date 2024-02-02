<?php
namespace Matea\Praksa;

use Matea\Praksa\Connection;

abstract class Model
{
    protected string $tableName;
    protected int|string $primaryKey;

    public function save()
    {
        Connection::getInstance()->insert($this->tableName, $this->toArray());
        $this->{$this->primaryKey} = Connection::getInstance()->connection->lastInsertId();
    }

    public function update($id)
    {
        Connection::getInstance()->update($this->tableName, $this->toArray(), [$this->primaryKey => $id]);
    }

    static public function find($primaryKey): ?Model
    {
        $instance = new static();
        $query = "SELECT * FROM $instance->tableName WHERE $instance->primaryKey = ?";
        $data = Connection::getInstance()->fetchAssoc($query, [$primaryKey]);
        foreach($data as $key => $value){
            $instance->$key = $value;
        }
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
        $data = [];
        foreach($this as $key => $value){
            if($key !== 'primaryKey' && $key !== 'tableName'){
                $data[$key] = $value;
            }
        }
        
        return $data;
    }
}
