<?php
namespace Matea\Praksa;

use Matea\Praksa\Connection;

abstract class Model
{
    use Traits\Timestamp, Traits\softDelete;

    protected string $tableName;
    protected int|string $primaryKey;

    public function save(): void
    {
        $this->enableTimestamp();
        $key = key($this->toArray());

        if(is_array($this->toArray()[$key])){
            foreach($this->toArray()[$key] as $eachData){
                $this->getCreatedAt();
                $created_at[] = $this->created_at;
            }
            $this->created_at = $created_at;
        } else {
            $this->getCreatedAt();
        }
        Connection::getInstance()->insert($this->tableName, $this->toArray());
        $this->{$this->primaryKey} = Connection::getInstance()->connection->lastInsertId();
    }

    public function update($primaryKey): void
    {
        if($this->created_at){
            $this->enableTimestamp();
        }
        $this->getUpdatedAt();

        Connection::getInstance()->update($this->tableName, $this->toArray(), [$this->primaryKey => $primaryKey]);
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
        $instance = new static();
        $query = "SELECT * FROM $instance->tableName
                    WHERE $instance->primaryKey > ?
                    LIMIT 20";

        $pdo = Connection::getInstance()->fetchAssocAll($query, $params);
        return $pdo;
    }

    public function delete($primaryKey): void
    {
        $query = "DELETE FROM $this->tableName WHERE $this->tableName.$this->primaryKey = ?";
        $pdo = Connection::getInstance()->delete($query, [$primaryKey]);
    }

    public function softDelete($primaryKey): void
    {
        $this->getSoftDelete($primaryKey);
        $this->update($primaryKey);
    }

    public function toArray(): array
    {
        $data = [];
        foreach($this as $key => $value){
            if($key !== 'primaryKey' && $key !== 'tableName' && $key !== 'timestampEnabled'){
                $data[$key] = $value;
            }
        }
        
        return $data;
    }
}
