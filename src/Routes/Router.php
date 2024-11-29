<?php

namespace App\Routes;

class Router {
    private $routes = [];

    /**
     * Add a new route
     * 
     * @param string $method HTTP Method
     * @param string $name Route name
     * @param mixed[] $controller Route controller
     * @return void
     */
    public function add($method, $name, $controller) {
        $name = $this->normalizeName($name);

        $this->routes[] = [
            'path' => $name,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => []
        ];
    }

    /**
     * Add '/' to the start and end of route's name
     * 
     * @param string $name Route name
     * @return string
     */
    private function normalizeName($name) { 
        $name = trim($name, '/'); $name = "/{$name}/"; 
        $name = preg_replace('#[/]{2,}#', '/', $name);
        return $name; 
    }

    public function dispatch($name) { 
        $name = $this->normalizeName($name);
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        
        foreach ($this->routes as $route) {
          if (
            !preg_match("#^{$route['path']}$#", $name) ||
            $route['method'] !== $method
          ) {
            continue;
          }
        
          [$class, $function] = $route['controller'];
        
          $controllerInstance = new $class;
        
          $controllerInstance->{$function}();
        }
        
    }
}