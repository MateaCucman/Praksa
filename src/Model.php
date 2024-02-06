<?php
namespace Matea\Praksa;

use Matea\Praksa\Connection;

abstract class Model
{
    use Traits\HasTimestamps, Traits\SoftDelete;

    protected string $tableName;
    protected int|string $primaryKey;

    public function save(): void
    {
        $this->enableTimestamps();
        $key = key($this->toArray());

        if($this->timestampsEnabled){
            if(is_array($this->toArray()[$key])){
                foreach($this->toArray()[$key] as $eachData){
                    $this->setCreatedAt();
                    $created_at[] = $this->created_at;
                }
                $this->created_at = $created_at;
            } else {
                $this->setCreatedAt();
            }
        }
        Connection::getInstance()->insert($this->tableName, $this->toArray());
        $this->{$this->primaryKey} = Connection::getInstance()->connection->lastInsertId();
    }

    public function update($primaryKey): void
    {
        if($this->created_at != null){
            $this->enableTimestamps();
        }
        $this->setUpdatedAt();
        Connection::getInstance()->update($this->tableName, $this->toArray(), [$this->primaryKey => $primaryKey]);
    }

    public function find($primaryKey): ?Model
    {
        $instance = new static();
        $query = "SELECT * FROM $instance->tableName WHERE $instance->primaryKey = ?";
        $data = Connection::getInstance()->fetchAssoc($query, [$primaryKey]);
        foreach($data as $key => $value){
            $instance->$key = $value;
        }
        return $instance;
    }

    public function select($params): array
    {
        $instance = new static();
        $query = "SELECT * FROM $instance->tableName
                    WHERE $instance->primaryKey > ?
                    LIMIT 20";

        $pdo = Connection::getInstance()->fetchAssocAll($query, $params);
        return $pdo;
    }

    public function delete(string $primaryKey): void
    {
        if($this->created_at != null){
            $this->softDelete();
            $this->update($primaryKey);
        } else {
            Connection::getInstance()->delete($this->tableName, [$this->primaryKey => $primaryKey]);
        }
    }

    public function toArray(): array
    {
        $data = [];
        foreach($this as $key => $value){
            if($key !== 'primaryKey' && $key !== 'tableName' && $key !== 'timestampsEnabled'){
                $data[$key] = $value;
            }
        }

        return $data;
    }
}
