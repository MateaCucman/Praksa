<?php
namespace Matea\Praksa;

use Matea\Praksa\Response;

$router->addRoute('/', function (Request $request) 
{
    $home = $request->getParams('home');
    $response = new Response("$home");
    return $response;
});

$router->addRoute('/todos', function (Request $request) 
{
    $todo = $request->getParams('todo');
    $response = new Response("$todo");
    return $response;
});
