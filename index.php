<?php
require __DIR__ . '/vendor/autoload.php';
require_once 'rutes.php';
require_once 'req.php';
require_once 'res.php';


$request = new Request(['user_id' => 123], ['name' => 'John']);

$router = new Router();

$router->addRoute('/user', 'GET', function (RequestInterface $request) {
    $userId = $request->get('user_id');
    $response = new Response("ID: $userId <br>");
    $response->send();
});

$router->addRoute('/post', 'POST', function (RequestInterface $request) {
    $name = $request->post('name');
    $response = new Response("Name: $name");
    $response->send();
});

$router->resolve('/user', 'GET', $request);

$router->resolve('/post', 'POST', $request);