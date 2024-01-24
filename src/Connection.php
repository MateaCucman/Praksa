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
        $result = $conn->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchAssocAll (string $query, array $params): array
    {
        $conn = $this->connection->prepare($query);
        $conn->execute($params);
        $result = $conn->fetchall(\PDO::FETCH_ASSOC);
        return $result;
    }

    // Isprobala sam insert na bazi i radi, ali svaki redak mi duplo doda,
    // ne znam kako da riješim taj problem

    public function insert (string $tableName, array $values)
    {
        $conn = $this->connection;
        $conn->beginTransaction();

        $sth = $conn->prepare("INSERT INTO $tableName (name, type) VALUES (:name, :type);");
        if(isset($values[0])) {
            foreach($values as $value){
                $sth->execute($value);
            }
        } else {
            $sth->execute($values);
        }
        return $conn->commit();
    }

    // U update metodi sam pokušala sve vrijednosti koje se update-aju staviti u jedan string, a uvjete u drugi 
    // i ukloniti im s kraja ', ', ali ne funkcionira :(
    // Ne znam kako napraviti da se može update-ati više vrijednosti odjednom uz više uvjeta
    // u slučaju kada ne znamo koliko će vrijednosti i uvjeta biti.
    // Trebam li uo uopće tako raditi ili trebam uzeti fiksne stupce?

    public function update (string $tableName, array $values, array $conditions)
    {
        $conn = $this->connection;
        $conn->beginTransaction();

        $placeholders = [];
        $vals = '';
        $conds = '';

        $sth = $conn->prepare("UPDATE $tableName SET ? WHERE ?;");
        
        foreach($values as $key => $value){
            $vals .= "$key = $value, ";
        }
        foreach($conditions as $key => $value){
            $conds .= "$key = $value, ";
        }

        $vals = substr($vals, 0, -2);
        $conds = substr($conds, 0, -2);
        
        array_push($placeholders, $vals, $conds);

        $sth->execute($placeholders);
        return $conn->commit();
    }
}