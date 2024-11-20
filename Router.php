<?php

class Router //Implementação de um Router para gerenciar requisições da API
{
    
    private $routes = [];

    public function add($method, $path, $callback)
    {
        $path = preg_replace('/\{(\w+)\}/', '(\d+)', $path);
        $this->routes[] = ['method' => $method, 'path' => "#^" . $path . "$#", 'callback' => $callback];
    }

    public function dispatch($requestedPath)
    {
        $requestedMethod = $_SERVER["REQUEST_METHOD"];
        echo curl_version()['version'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestedMethod && preg_match($route['path'], $requestedPath, $matches)) {
                if (isset($matches[0])) {
                    array_shift($matches);
                    return call_user_func($route['callback'], ...$matches);
                } else {
                    echo "404 - Parâmetro não encontrado";
                    return;
                }
            }
        }
        echo "404 - Página não encontrada";
    }
}
