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
        if($request->getAttr('name')){
            $product->name = $request->getAttr('name');
        }
        if($request->getAttr('type')){
            $product->type = $request->getAttr('type');
        }
        
        $product->update($request->getAttr('id'), $product->toArray());

        return new Response($product->name . ', ' . $product->type);
    }

    static public function indexActionPost($request): Response
    {
        $product = Product::find($request->getAttr('id'));
        $product->delete($request->getAttr('id'));
        return new Response($product->name . ' deleted');
    }

    static public function indexJsonAction($request): JsonResponse
    {
        $product = Product::select([$request->getAttr('id')]);
        return new JsonResponse($product);
    }

    static public function indexJsonActionPost($request): JsonResponse
    {
        $product = new Product();
        $data = $request->getAttrs();
        foreach($data as $key => $value){
            $product->$key = $value;
        }

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
            foreach($queryParams as $key => $value){
                $product->$key = $value;
            };
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
        
        return new HtmlResponse($twig->render('index', ['name' => $product->name]));
    }

    static public function indexHtmlActionPost($request): HtmlResponse
    {
        $product = Product::find($request->getAttr('id'));
        $product->softDelete($request->getAttr('id'));

        $loader = new \Twig\Loader\arrayLoader([
            'index' => '<h2>Product: {{ name }} deleted at {{ deleted_at }}!</h2>',
        ]);
        $twig = new \Twig\Environment($loader);
        
        return new HtmlResponse($twig->render('index', ['name' => $product->name, 'deleted_at' => $product->deleted_at]));
    }
}