<?php
namespace Matea\Praksa;
use Matea\Praksa\Interfaces\RequestInterface;

class Router
{
    static private array $routes = [];

    static public function get(string $url, object|array $cb): void
    {
        self::$routes[] = [
            'url' => $url,
            'method' => 'GET',
            'cb' => $cb
        ];
    }

    static public function post(string $url, object|array $cb): void
    {
        self::$routes[] = [
            'url' => $url,
            'method' => 'POST',
            'cb' => $cb
        ];
    }

    static public function resolve(Request $request): ?object
    {
        $uri = $request->getUri();
        foreach (self::$routes as $route) {
            $url = $route['url'];
            $params = self::resolveParams($uri, $url);
            $uriNew = self::resolveQuery($uri);
            
            if(self::routeMatch($url, $uriNew, $params) && $route['method'] == $request->getMethod()){
                $request->setAttr($params);
                return call_user_func($route['cb'], $request);
            }
        }
        echo '404 Not Found';
        return null;
    }

    static protected function resolveQuery(string $uri): string
    {
        
        $uriParts = explode('/', $uri);
        for($i=0; $i<count($uriParts); $i++){
            if(str_contains($uriParts[$i], '?')){
                $uriParts[$i] = substr($uriParts[$i], 0, strpos($uriParts[$i], '?'));
            }
        }
        return implode('/', $uriParts);
    }

    static protected function resolveParams(string $uri, string $url): array
    {
        $uriParts = explode('/', $uri);
        $urlParts = explode('/', $url);
        $params = [];
        if(count($uriParts) === count($urlParts)){
            for($i = 0; $i < count($uriParts); $i++){
                preg_match('/:(\w+)/', $urlParts[$i], $matches);
                array_shift($matches);
                if($matches){
                    $params[$matches[0]] = $uriParts[$i];
                }
            }
        }
        return $params;  
    }

    static protected function routeMatch(string $url, string $uri, array $params): bool
    {
        foreach($params as $key =>$value){
            $url = str_replace(':' . $key, $value, $url);
        }
        return $url === $uri;
    }
}