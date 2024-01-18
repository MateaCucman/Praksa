<?php
namespace Matea\Praksa;
use Matea\Praksa\Interfaces\RequestInterface;

class Router
{
    static private $routes = [];

    static public function addRoute($url, $method, $cb)
    {
        $url = 
        self::$routes[] = [
            'url' => $url,
            'method' => strToUpper($method),
            'cb' => $cb
        ];
     }

    static public function resolve(Request $request)
    {
        foreach (self::$routes as $route) 
        {
            if (($route['method'] === $request->getMethod()) && ('/Praksa' . $route['url'] === $request->getUri())) {
                return call_user_func($route['cb'], $request);
                
            }
        }
        echo "404 Not Found";
        return null;
    }
}