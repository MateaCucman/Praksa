<?php
namespace Matea\Praksa\Controllers;

use Matea\Praksa\Responses\Response;
use Matea\Praksa\Responses\JsonResponse;
use Matea\Praksa\Responses\HtmlResponse;
use Matea\Praksa\Connection;
use Twig;

class IndexController extends Connection
{
    static public function indexAction($request): Response
    {
        if($request->getMethod() === 'POST'){
            Connection::getInstance()->insert('products', $request->getAttrs());
        }
        
        // $values = ['name' =>'product1', 'type' => 'b'];
        // $conditions = ['id' => 97];
        // Connection::getInstance()->update('products', $values, $conditions);

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

    static public function indexHtmlAction($request): HtmlResponse
    {
        $query = 'SELECT id, name FROM products WHERE id = ?';

        $pdo = Connection::getInstance()->fetchAssoc($query, [$request->getAttr('id')]);
        
        $loader = new \Twig\Loader\ArrayLoader([
            'index' => '<h2>Product: {{ name }}!</h2>',
        ]);
        $twig = new \Twig\Environment($loader);
        
        return new HtmlResponse($twig->render('index', ['name' => $pdo['name']]));
    }
}