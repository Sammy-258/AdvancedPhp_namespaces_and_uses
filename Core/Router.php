<?php


namespace Core;

class Router{
    protected $routes = [];

    public function get($uri, $controller, $middleware = null){
        $uri = "AdvancedPhp_namespaces_and_uses$uri";
        $this->routes['GET'][$uri] = ['controller'=>$controller, 'middleware'=>$middleware];
    }
    public function post($uri, $controller, $middleware = null){
        $uri = "AdvancedPhp_namespaces_and_uses$uri";
        $this->routes['POST'][$uri] = ['controller'=>$controller, 'middleware'=>$middleware];
    }

    public function direct($uri, $method){
       
        if(array_key_exists($uri, $this->routes[$method])){
            $route = $this->routes[$method][$uri];

            if($route['middleware']){
                Middleware::handle($route['middleware'], function () use ($route) {
                    $this->callAction($route['controller']);
                });
            }else{
                $this->callAction($route['controller']);
            }
        } else{
           echo "Route not found";
        }
    }


    protected function callAction($controller)
    {
        list($controller, $action) = explode('@', $controller);
        $controller = "App\\Controllers\\{$controller}";
        (new $controller)->$action();
    }
}