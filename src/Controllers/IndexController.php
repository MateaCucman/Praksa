<?php
namespace Matea\Praksa\Controllers;

use Matea\Praksa\Responses\Response;
use Matea\Praksa\Responses\JsonResponse;
use Matea\Praksa\Responses\HtmlResponse;
use Matea\Praksa\Connection;
use Twig;

class IndexController extends Connection
{
    static public function conn(): void
    {
        $pdo = Connection::getInstance();
        $conn = $pdo->connectToDb();
        
        $unbufferedResult = $conn->query("SELECT col_name FROM some_table");
        foreach ($unbufferedResult as $row) {
            echo $row['col_name'] . PHP_EOL;
        }
    }

    static public function indexAction(): Response
    {
        static::conn();
        return new Response('Regular response');
    }

    static public function indexJsonAction(): JsonResponse
    {
        static::conn();
        return new JsonResponse(['data' => 'Json response']);
    }

    static public function indexHtmlAction($request): HtmlResponse
    {
        static::conn();
        $loader = new \Twig\Loader\ArrayLoader([
            'index' => '<h1>Product {{ id }}!</h1>',
        ]);
        $twig = new \Twig\Environment($loader);
        
        return new HtmlResponse($twig->render('index', ['id' => $request->getAttr('id')]));
    }
}