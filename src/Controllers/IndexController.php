<?php
namespace Matea\Praksa\Controllers;

use Matea\Praksa\Responses\Response;
use Matea\Praksa\Responses\JsonResponse;
use Matea\Praksa\Responses\HtmlResponse;
use Matea\Praksa\Connection;
use Matea\Praksa\Product;
use Twig;

class IndexController
{
    static public function indexAction($request): Response
    {
        $a = $request->getAttrs();
        $product = Product::find(end($a));
        $product->attributes = $request->getAttrs();
        $product->update();

        return new Response('Regular response');
    }

    static public function indexJsonAction($request): JsonResponse
    {
        $query = 'SELECT id, name 
        FROM products 
        WHERE id > :id 
            AND type = :type 
        LIMIT 20';

        $placeholders = ['id' => $request->getAttr('id'), 'type' => $request->getAttr('type')];

        $pdo = Connection::getInstance()->fetchAssocAll($query, $placeholders);
        
        return new JsonResponse($pdo);
    }

    static public function indexJsonActionPost($request): JsonResponse
    {
        $product = new Product();
        $product->attributes = $request->getAttrs();
        $queryParams = $request->getParams();
        
        if($queryParams){
            $arrayOfParams = [];
            for($i = 0; $i < count($queryParams[key($queryParams)]); $i++){
                $Params = [];
                foreach($queryParams as $key => $param){
                    $Params[$key] = $param[$i];
                }
                array_push($arrayOfParams, $Params);
            }
            $product->attributes = $arrayOfParams;
        }

        $product->save();
        return new JsonResponse($product->toarray());
    }

    static public function indexHtmlAction($request): HtmlResponse
    {
        $query = 'SELECT id, name FROM products WHERE id = ?';

        $pdo = Connection::getInstance()->fetchAssoc($query, [$request->getAttr('id')]);
        
        $loader = new \Twig\Loader\arrayLoader([
            'index' => '<h2>Product: {{ name }}!</h2>',
        ]);
        $twig = new \Twig\Environment($loader);
        
        return new HtmlResponse($twig->render('index', ['name' => $pdo['name']]));
    }
}