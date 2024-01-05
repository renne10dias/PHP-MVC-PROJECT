<?php

namespace app\controller\apiControllers\private;
use app\domain\service\TesteClienteService;
use settings\JWT\TokenHandler;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
header('Content-Type: application/json');



class TesteBancoDados{
                                 
    private $httpCode;
    public function getHttpCode(){
        return $this->httpCode;
    }



    public function clientes(){
        try {
            // Crie uma instância do serviço
            $clienteService = new TesteClienteService();

            // Use o serviço para buscar os clientes
            $clientes = $clienteService->listarUsuarios();

            // Verifique se há clientes
            if (!empty($clientes)) {
                // Dados encontrados, envie como JSON
                $this->httpCode = 200;
                echo json_encode($clientes);
            } else {
                // Nenhum cliente encontrado
                $this->httpCode = 404;
                echo json_encode(["status" => "error", "message" => "Nenhum cliente encontrado"]);
            }
        } catch (\RuntimeException $e) {
            // Tratamento de erro específico para falha na busca de clientes
            $this->httpCode = 500;
            echo json_encode(["message" => $e->getMessage()]);
        }
    }


    public function clientes1(){
        try {
            // Obtenha o token da requisição
            $token = TokenHandler::extractTokenFromRequest1();
    
            // Verifique se o token está presente
            if ($token === null) {
                $this->httpCode = 401;
                echo json_encode(["message" => "Token não fornecido"]);
                return;
            }
    
            // Verifique se o token possui a função de administrador
            if (!TokenHandler::validateUserRole($token, 'admin')) {
                $this->httpCode = 403;
                echo json_encode(["message" => "Acesso não autorizado"]);
                return;
            }
    
            // Crie uma instância do serviço
            $clienteService = new TesteClienteService();
    
            // Use o serviço para buscar os clientes
            $clientes = $clienteService->listarUsuarios();
    
            // Verifique se há clientes
            if (!empty($clientes)) {
                // Dados encontrados, envie como JSON
                $this->httpCode = 200;
                echo json_encode($clientes);
            } else {
                // Nenhum cliente encontrado
                $this->httpCode = 404;
                echo json_encode(["status" => "error", "message" => "Nenhum cliente encontrado"]);
            }
        } catch (\RuntimeException $e) {
            // Tratamento de erro específico para falha na busca de clientes
            $this->httpCode = 500;
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    







    public function home(){
        $this->httpCode = 201;
        echo json_encode(["status" => "Online"]);
    }

    public function teste(){
        http_response_code(300);
        echo json_encode(["status" => "teste"]);
    }



}


