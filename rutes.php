<?php
class Router{
    private $routes = [];
    
    public function addRoute($url, $method, $cb){
        $this->routes[] = [
            'url' => $url,
            'method' => strtoupper($method),
            'cb' => $cb
        ];
     }

    public function resolve($url, $method, RequestInterface $request)
    {
        foreach ($this->routes as $route) {
            if ($route['url'] === $url && $route['method'] === strtoupper($method)) {
                $cb = $route['cb'];
                $cb($request);
                return;
            }
        }
        echo "404 Not Found";
    }
}