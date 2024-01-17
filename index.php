<?php
require_once 'vendor/autoload.php';

use Matea\Praksa\Request;
use Matea\Praksa\Router;

$request = new Request();

$router = new Router();

require_once 'routes.php';

$response = $router->resolve($request);
$response->send();
?>
