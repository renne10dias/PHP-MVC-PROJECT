<?php

// index.php

namespace Router;

use core\Router;
use routes\RoutesApi;

// Carrega as dependências do Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Inicializa a aplicação
$router = new Router;

// Configura as rotas usando a classe RouteManager
$router = RoutesApi::configureRoutes($router);

