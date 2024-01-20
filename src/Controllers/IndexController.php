<?php
namespace Matea\Praksa\Controllers;

use Matea\Praksa\Responses\Response;
use Matea\Praksa\Responses\JsonResponse;

class IndexController
{
    static public function indexAction()
    {
        return new Response('Regular response');
    }

    static public function indexJsonAction()
    {
        return new JsonResponse(['data' => 'Json response']);
    }
}