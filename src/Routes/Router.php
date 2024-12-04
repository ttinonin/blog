<?php

namespace App\Routes;

class Router {
    private $routes = [];

    public function __construct()
    {
      session_start();
    }

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

    private function parseRoute(string $routePath, string $currentPath): ?array {
      $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $routePath);
      $pattern = "#^{$pattern}$#";
  
      if (preg_match($pattern, $currentPath, $matches)) {
          return array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
      }
  
      return null;
    }

    private function loadController($controller) {
      [$class, $function] = $controller;
        
      $controllerInstance = new $class;
    
      $controllerInstance->{$function}();
    }

    /**
     * Load the desired controller for the route
     * 
     * @return void
     */
    public function run() { 
        $name = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $name = $this->normalizeName($name);
        $method = strtoupper($_SERVER['REQUEST_METHOD']);

        foreach ($this->routes as $route) {
          $params = $this->parseRoute($route['path'], $name);
          if ($params) {
            $key = array_keys($params)[0];
            $value = array_values($params)[0];
            
            $_GET[$key] = $value;

            $this->loadController($route['controller']);
          }

          if (
            !preg_match("#^{$route['path']}$#", $name) ||
            $route['method'] !== $method
          ) {
            continue;
          }

          $this->loadController($route['controller']);
        }
        
    }
}