<?php

namespace Matea\Praksa;

class Connection 
{
    static private ?Connection $instance = null;
    public \PDO $connection;

    protected function __construct() 
    {
        $host = 'localhost';
        $dbname = 'praksa';
        $username = 'matea';
        $password = '';
        $this->connection = new \PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
        $this->connection->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    protected function __clone() {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Connection
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function fetchAssoc (string $query, array $params): array
    {
        $conn = $this->connection->prepare($query);
        $conn->execute($params);
        return $conn->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAssocAll (string $query, array $params): array
    {
        $conn = $this->connection->prepare($query);
        $conn->execute($params);
        
        return $conn->fetchall(\PDO::FETCH_ASSOC);
    }

    public function insert (string $tableName, array $values): void
    {
        $conn = $this->connection;
        if(is_array($values[key($values)])) {
            $valuesKeys = array_keys($values);
            $placeholder = implode(',', array_fill(0, count($valuesKeys), '?'));
            $placeholders = [];
            $valuesValues = [];
            
            foreach($values as $values_){
                foreach($values_ as $value){
                    array_push($valuesValues, $value);
                }
            }

            $placeholders = implode('), (', array_fill(0, count($values['name']), $placeholder));
            
        } else {
            $valuesKeys = array_keys($values);
            $valuesValues = array_values($values);

            $placeholders = implode(',', array_fill(0, count($values), '?'));
        }
        $columnNames = implode(',', $valuesKeys);

        $statement = $conn->prepare("INSERT INTO $tableName ($columnNames) VALUES ($placeholders);");

        $statement->execute($valuesValues);
    }

    public function update (string $tableName, array $values, array $conditions): void
    {
        $conn = $this->connection;

        $placeholders = [];
        $setValues = [];
        $whereValues = [];

        foreach($values as $key => $value){
            array_push($setValues, "$key = '$value'");
        }
        $setValues = implode(', ', $setValues);

        foreach($conditions as $key => $value){
            array_push($whereValues, "$tableName.$key = '$value'");
        }
        $whereValues = implode(', ', $whereValues);

        $statement = $conn->prepare("UPDATE $tableName SET $setValues WHERE $whereValues;");

        $statement->execute();
    }

    public function delete($query, $id)
    {
        $conn = $this->connection;
        $statement = $conn->prepare($query);
        $statement->execute($id);
    }
}