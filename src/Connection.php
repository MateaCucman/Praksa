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

    public function insert (string $tableName, array $params): void
    {
        $conn = $this->connection;
        $key = key($params);
        $paramsKeys = [];
        $paramsValues = [];
        $placeholders = '';

        if(is_array($params[$key])) {
            $paramsKeys = array_keys($params);
            $placeholder = implode(',', array_fill(0, count($paramsKeys), '?'));
            $placeholders = implode('), (', array_fill(0, count($params[$key]), $placeholder));

            for($i = 0; $i < count($params[$key]); $i++){
                foreach($params as $value){
                    $paramsValues[] = $value[$i];
                }
            }
        } else {
            $paramsKeys = array_keys($params);
            $paramsValues = array_values($params);

            $placeholders = implode(',', array_fill(0, count($params), '?'));
        }
        $columnNames = implode(',', $paramsKeys);

        $statement = $conn->prepare("INSERT INTO $tableName ($columnNames) VALUES ($placeholders);");
        
        $statement->execute($paramsValues);
    }

    public function update (string $tableName, array $values, array $conditions): void
    {
        $conn = $this->connection;

        $setValues = [];
        $whereValues = [];

        foreach($values as $key => $value){
            $setValues[] = "$key = '$value'";
        }
        $setValues = implode(', ', $setValues);

        foreach($conditions as $key => $value){
            $whereValues[] = "$tableName.$key = '$value'";
        }
        $whereValues = implode(', ', $whereValues);

        $statement = $conn->prepare("UPDATE $tableName SET $setValues WHERE $whereValues;");

        $statement->execute();
    }

    public function delete(string $tableName, array $id): void
    {
        $conn = $this->connection;
        $key = key($id);
        $value = $id[$key];
        $query = "DELETE FROM $tableName WHERE $tableName.$key = $value";
        $statement = $conn->prepare($query);
        $statement->execute();
    }
}