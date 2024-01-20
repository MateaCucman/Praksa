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
        $uri = $request->getUri();
        foreach (self::$routes as $route) 
        {
            $url = $route['url'];
            $pomArr = self::resolveParams($uri, $url);
            //echo $url . '<br>';
            if(self::routeMatch($url, $uri, $pomArr))
            {
                $request->setAttr($pomArr);
                return call_user_func($route['cb'], $request);
            }
        }
        echo "404 Not Found";
        return null;
    }

    static protected function resolveParams($uri, $url)
    {
        $uriParts = explode('/', $uri);
        $urlParts = explode('/', $url);
        $params = [];
        if(count($uriParts) === count($urlParts))
        {
            for($i = 0; $i<count($uriParts); $i++)
            {
                preg_match('/:(\w+)/', $urlParts[$i], $matches);
                array_shift($matches);
                if($matches)
                {
                    $pomVar = $matches[0];
                    $params[$pomVar] = $uriParts[$i];
                }
            }
        }
        return $params;  
    }

    static protected function routeMatch($url, $uri, $pomArr)
    {
        //print_r($pomArr);
        foreach($pomArr as $key =>$value)
        {
            $url = str_replace(':' . $key, $value, $url);
            //echo $value;
        }
        //echo($url. '<br>');
        return $url === $uri;
    }
}