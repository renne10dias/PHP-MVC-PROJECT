<?php

namespace core;

class Router{
    private $routes = [];

    public function addRoute($uri, $controller, $method = 'index', $httpMethod = 'GET'){
        $this->routes[$httpMethod][$uri] = ['controller' => $controller, 'method' => $method];
    }


    public function dispatch(){
        $uri = $this->getCurrentUri();
        $method = $_SERVER['REQUEST_METHOD'];

        try {
            $route = $this->getRoute($uri, $method);

            if ($route) {
                $code = $this->callControllerMethod($route['controller'], $route['method'], $route['params'] ?? []);
                http_response_code($code); // Configura o código HTTP retornado pelo controlador
            } else {
                // Rota não encontrada
                throw new \Exception("Rota não encontrada para o método $method", 404);
            }
        } catch (\Exception $e) {
            // Tratar erros de forma centralizada
            http_response_code($e->getCode() ?: 500); // Código HTTP 500 para erro interno do servidor, se não especificado
            echo "Erro: " . $e->getMessage();
        }
    }


    private function getCurrentUri(){
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $uri = strtok($uri, '?'); // Remove query string, se houver
        return $uri;
    }


    private function getRoute($uri, $httpMethod){
        foreach ($this->routes[$httpMethod] ?? [] as $route => $handler) {
            $pattern = str_replace('/', '\/', $route);
            $pattern = preg_replace('/\{(\w+)\}/', '(?<$1>[^\/]+)', $pattern);

            if (preg_match("/^$pattern$/", $uri, $matches)) {
                unset($matches[0]);
                $handler['params'] = $matches;
                return $handler;
            }
        }

        return null;
    }



    private function callControllerMethod($controller, $method, $params = []){
        // Converta barras invertidas para barras normais para compatibilidade com diferentes sistemas operacionais
        $controllerPath = str_replace('\\', DIRECTORY_SEPARATOR, $controller);

        // Adicione o namespace padrão e o caminho da pasta Controllers
        $class = "\\app\\Controller\\" . $controllerPath;

        if (class_exists($class)) {
            $object = new $class;

            if (method_exists($object, $method)) {
                $reflectionMethod = new \ReflectionMethod($object, $method);
                $reflectionParameters = $reflectionMethod->getParameters();

                $resolvedParams = [];
                foreach ($reflectionParameters as $param) {
                    $paramName = $param->getName();
                    $resolvedParams[] = $params[$paramName] ?? null;
                }

                $reflectionMethod->invokeArgs($object, $resolvedParams);

                // Após a execução do método, retorne o código HTTP configurado no controlador
                return $object->getHttpCode() ?? 200; // Retorna o código HTTP do controlador ou 200 por padrão
            } else {
                // Método não encontrado
                throw new \Exception("Método não encontrado!");
            }
        } else {
            // Controlador não encontrado
            throw new \Exception("Controlador não encontrado!");
        }
    }

    
}
