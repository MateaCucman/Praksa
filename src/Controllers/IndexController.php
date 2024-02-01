<?php
namespace Matea\Praksa\Controllers;

use Matea\Praksa\Responses\Response;
use Matea\Praksa\Responses\JsonResponse;
use Matea\Praksa\Responses\HtmlResponse;
use Matea\Praksa\Product;
use Twig;

class IndexController
{
    static public function indexAction($request): Response
    {
        $product = Product::find($request->getAttr('id'));
        $product->attributes = $request->getAttrs();
        $product->update();

        return new Response('Regular response');
    }

    static public function indexJsonAction($request): JsonResponse
    {
        $params = array_filter($request->getAttrs(), function($key){
            return $key == 'id' || $key == 'type';
        }, ARRAY_FILTER_USE_KEY);
        
        $product = Product::select($params);
        return new JsonResponse($product);
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
                $arrayOfParams[] = $Params;
            }
            $product->attributes = $arrayOfParams;
        }

        $product->save();
        return new JsonResponse($product->toarray());
    }

    static public function indexHtmlAction($request): HtmlResponse
    {
        $product = Product::find($request->getAttr('id'));
        $loader = new \Twig\Loader\arrayLoader([
            'index' => '<h2>Product: {{ name }}!</h2>',
        ]);
        $twig = new \Twig\Environment($loader);
        
        return new HtmlResponse($twig->render('index', ['name' => $product->attributes['name']]));
    }
}