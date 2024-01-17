<?php
namespace Matea\Praksa;
use Matea\Praksa\Interfaces\RequestInterface;

class Router
{
    private $routes = [];

    public function addRoute($url, $cb)
    {
        $this->routes[] = [
            'url' => $url,
            'cb' => $cb
        ];
     }

    public function resolve(Request $request)
    {
        foreach ($this->routes as $route) 
        {
            if (str_contains($request->getUri(), '/Praksa' . $route['url'])) {

                $cb = $route['cb'];
                return $cb($request);;
            }
        }
        echo "404 Not Found";
    }
}