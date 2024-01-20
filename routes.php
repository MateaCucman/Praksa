<?php
namespace Matea\Praksa;

use Matea\Praksa\Responses\Response;
use Matea\Praksa\Responses\JsonResponse;
use Matea\Praksa\Controllers\IndexController;

Router::addRoute('/', 'get', function (Request $request) 
{
    return new Response("home");
});

Router::addRoute('/products', 'get', function (Request $request) 
{
    return new JsonResponse(
        [
            'data' => "products"
        ]);
});

Router::addRoute('/products/:id', 'get', function (Request $request) 
{
    return new Response("product_" . $request->getAttr('id'));
});

Router::addRoute('/products/:id/:type', 'get', function (Request $request) 
{
    return new JsonResponse(
        [
            "product_id" => $request->getAttr('id'), 
            "type" => $request->getAttr('type')
        ]);
});

Router::addRoute('/reg', 'get', function (Request $request)
{ 
    return IndexController::indexAction();
});

Router::addRoute('/json', 'get', function (Request $request)
{ 
    return IndexController::indexJsonAction();
});