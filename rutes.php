<?php
class Router
{
    private $routes = [];

    public function addRoute($url, $method, $cb)
    {
        $this->routes[] = [
            'url' => $url,
            'method' => strtoupper($method),
            'cb' => $cb
        ];
     }

    public function resolve(RequestInterface $request)
    {
        foreach ($this->routes as $route) 
        {
            if (str_contains($_SERVER['REQUEST_URI'], $route['url']) && $route['method'] === strtoupper($_SERVER['REQUEST_METHOD'])) {

                $cb = $route['cb'];
                $cb($request);
                return;
            }
        }
        echo "404 Not Found";
    }
}