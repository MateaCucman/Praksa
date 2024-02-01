<?php
namespace Matea\Praksa;

use Matea\Praksa\Responses\Response;
use Matea\Praksa\Responses\JsonResponse;
use Matea\Praksa\Controllers\IndexController;

Router::get('/', function (Request $request): Response
{
    return new Response('home');
});

Router::get('/products', function (Request $request): JsonResponse
{
    return new JsonResponse(
        [
            'data' => 'products'
        ]);
});

Router::get('/products/:id', function (Request $request): Response
{
    return new Response('product_' . $request->getAttr('id'));
});

Router::get('/products/:id/:type', function (Request $request): JsonResponse
{
    return new JsonResponse(
        [
            'product_id' => $request->getAttr('id'), 
            'type' => $request->getAttr('type')
        ]);
});

Router::get('/selectMany/:type/:id', [IndexController::class, 'indexJsonAction']);

Router::get('/selectOne/:id', [IndexController::class, 'indexHtmlAction']);

Router::post('/update/:name/:type/:id', [IndexController::class, 'indexAction']);

Router::post('/insertOne/:name/:type', [IndexController::class, 'indexJsonActionPost']);

Router::post('/insertMany/products', [IndexController::class, 'indexJsonActionPost']);
