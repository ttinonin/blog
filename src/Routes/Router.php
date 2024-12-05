<?php

namespace App\Routes;

use App\Routes\Middlewares\MiddlewareManager;

class Router {
    private $routes = [];
    private $middleware_manager;

    public function __construct()
    {
      session_start();

      $this->middleware_manager = new MiddlewareManager();
    }

    /**
     * Add a new route
     * 
     * @param string $method HTTP Method
     * @param string $name Route name
     * @param mixed[] $controller Route controller
     * @return void
     */
    public function add($method, $name, $controller, $middlewares = []) {
        $name = $this->normalizeName($name);

        $this->routes[] = [
            'path' => $name,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => $middlewares
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

    private function parseRoute(string $routePath, string $currentPath) {
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

    private function middleware($middlewares) {
      if(empty($middlewares)) {
        return;
      }

      foreach($middlewares as $middleware) {
        $condition = $this->middleware_manager->load($middleware);

        if($condition === true) {
          continue;
        }

        http_response_code(401);
        Redirect::redirect($condition["redirect"], ["error" => $condition["message"]]);
      }
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
          if($route['method'] !== $method) {
            continue;
          }
          
          
          $params = $this->parseRoute($route['path'], $name);
          if ($params) {
            $key = array_keys($params)[0];
            $value = array_values($params)[0];
            
            $_GET[$key] = $value;
            
            $this->middleware($route["middlewares"]);
            $this->loadController($route['controller']);
          }
          
          if (
            !preg_match("#^{$route['path']}$#", $name)
          ) {
            continue;
          }

          $this->middleware($route["middlewares"]);

          $this->loadController($route['controller']);
        }
        
    }
}