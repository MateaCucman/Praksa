<?php
namespace Matea\Praksa;
use Matea\Praksa\Interfaces\RequestInterface;

class Router
{
    static private $routes = [];

    static public function addRoute($url, $method, $cb)
    {
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
            $uri = $request->getUri();
            $uriParts = explode('/', $uri);
            $uriLast = $uriParts[sizeof($uriParts)-1];
            $urlParts = explode('/', $route['url']);
            if(strpos(':', $urlParts[sizeof($urlParts)-1])==0){
                $urlParts[sizeof($urlParts)-1]  = str_replace($urlParts[sizeof($urlParts)-1], $uriLast, $urlParts[sizeof($urlParts)-1]);
            }
            $urlNew = implode('/', $urlParts);
            $route['url'] = $urlNew;
            if (($route['method'] === $request->getMethod()) && ('/Praksa' . $route['url'] === $uri)) {
                return call_user_func($route['cb'], $request, $uriLast);
                
            }
        }
        echo "404 Not Found";
        return null;
    }
}