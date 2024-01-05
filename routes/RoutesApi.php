<?php

namespace routes;

use core\Router;

// Carrega as dependências do Composer
require_once __DIR__ . '/../vendor/autoload.php';

$router = new \core\Router;


class RoutesApi{

    public static function configureRoutes(Router $router){
        // Rota Principal  https://cmacademia.com
        //$router->addRoute('', 'public\Cliente', 'home', 'GET');
        $router->addRoute('', 'webControllers\public\Cliente', 'home', 'GET');
        $router->addRoute('details', 'webControllers\public\Cliente', 'details', 'GET');

    }


    public static function configureRouteApi(Router $router){
        // AUTENTICAÇÃO COM JWT
        $router->addRoute('login', 'authenticationControllers\Login', 'login', 'POST');
        // ROTAS PRIVADAS E COM ACESSO RESTRITO
        $router->addRoute('allclientes', 'apiControllers\private\TesteBancoDados', 'clientes1', 'GET');



        $router->addRoute('post/{postId}/comment/{commentId}', 'apiControllers\public\Comment', 'show', 'GET');
        $router->addRoute('user/{id}', 'apiControllers\public\User', 'show', 'GET');
    }
}


// Configura as rotas usando a classe API
RoutesApi::configureRoutes($router);
RoutesApi::configureRouteApi($router);

// Dispare o roteamento
try {
    $router->dispatch();
} catch (\Exception $e) {
    // Tratar erros de forma centralizada
    echo "Erro: " . $e->getMessage();
}
