<?php
require_once 'vendor/autoload.php';
require_once 'routes.php';

use Matea\Praksa\Request;
use Matea\Praksa\Router;
use Matea\Praksa\Connection;

$request = new Request();

$response = Router::resolve($request);
$response->send();

$values = [
    ['name' => 'product1', 'type' => 'a'],
    ['name' => 'product2', 'type' => 'b'],
    ['name' => 'product3', 'type' => 'a'],
];
$values2 = ['name' => 'product1', 'type' => 'a'];

// Connection::getInstance()->insert('products', $values);

$values3 = ['type' => 'a'];
$conditions = ['id' => 77];
// Connection::getInstance()->update('products', $values3, $conditions);