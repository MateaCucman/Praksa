<?php
require_once 'vendor/autoload.php';
require_once 'routes.php';

use Matea\Praksa\Request;
use Matea\Praksa\Router;
use Matea\Praksa\Connection;

$request = new Request();

$response = Router::resolve($request);
$response->send();