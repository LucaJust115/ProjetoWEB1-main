<?php

class Router
{
    private $routes = [];

    public function add($method, $path, $callback)
    {
        // Ajusta o caminho da rota para suportar parâmetros dinâmicos
        $path = preg_replace('/\{(\w+)\}/', '(\d+)', $path);
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => "#^" . $path . "$#",
            'callback' => $callback
        ];
    }

    public function dispatch($requestedPath)
    {
        $requestedMethod = strtoupper($_SERVER["REQUEST_METHOD"]);
        $pdo = $this->getDatabaseConnection();

        // Itera pelas rotas para verificar a correspondência
        foreach ($this->routes as $route) {
            if (
                $route['method'] === $requestedMethod &&
                preg_match($route['path'], $requestedPath, $matches)
            ) {
                array_shift($matches); // Remove o primeiro item (caminho completo)

                $callback = $route['callback'];

                // Verificar se o callback é válido
                if (is_callable($callback)) {
                    // Callback direto (função anônima ou função global)
                    return call_user_func_array($callback, $matches);
                } elseif (is_array($callback) && count($callback) === 2) {
                    // Callback para um controlador/método
                    $controller = new $callback[0]($pdo);
                    return call_user_func_array([$controller, $callback[1]], $matches);
                } else {
                    http_response_code(500);
                    echo "Erro: Callback inválido.";
                    return;
                }
            }
        }

        // Nenhuma rota encontrada
        http_response_code(404);
        echo "404 - Página não encontrada";
    }

    private function getDatabaseConnection()
    {
        try {
            // Configurar o banco de dados corretamente
            $pdo = new PDO('mysql:host=localhost;dbname=api_db', 'root', 'unigran');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            http_response_code(500);
            echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
            exit;
        }
    }
}
