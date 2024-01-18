<?php
namespace Matea\Praksa;

use Matea\Praksa\Response;

Router::addRoute('/', 'get', function (Request $request) 
{
    return new Response("home");
});

Router::addRoute('/products', 'get', function (Request $request) 
{
    return new Response("products");
});

Router::addRoute('/products/:id', 'get', function (Request $request, $id) 
{
    return new Response("product " . $id);
});
