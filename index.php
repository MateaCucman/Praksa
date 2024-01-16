<?php
require __DIR__ . '/vendor/autoload.php';
require_once 'rutes.php';
require_once 'req.php';
require_once 'res.php';

$request = new Request();

$router = new Router();

$router->addRoute('/', 'GET', function (RequestInterface $request) 
{
    $name = $request->get('name');
    $response = new Response("$name");
    $response->send();
});

$router->addRoute('/', 'POST', function (RequestInterface $request) 
{
    if($request->is_set('name')){
        $name = $request->post('name');
        $response = new Response("$name");
        $response->send();
    }
});

$router->resolve($request);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="get" action="">
    <label for="name">get:</label>
    <input type="text" name="name" id="name">
    <input type="submit" Value="submit">
</form>

<form method="post">
    <label for="name">post:</label>
    <input type="text" name="name" id="name">
    <input type="submit" Value="submit">
</form>
</body>
</html>

