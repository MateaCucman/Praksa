<?php

namespace Matea\Praksa;
use Matea\Praksa\Singleton;
class Connection extends Singleton
{
    static public function connectToDb(): \PDO
    {
        $pdo = new \PDO("mysql:host=localhost;dbname=some_db", 'root', '');
        $pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}