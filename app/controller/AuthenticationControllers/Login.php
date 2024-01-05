<?php

namespace app\controller\authenticationControllers;

use settings\JWT\Auth;

header('Content-Type: application/json');

class Login{

    private $httpCode; // Adicione uma propriedade para armazenar o código HTTP
    public function getHttpCode(){
        return $this->httpCode;
    }



    

    public function login(){

        $data = json_decode(file_get_contents("php://input"), true);
        // Verifique se a decodificação do JSON foi bem-sucedida
        if ($data === null) {
            $this->httpCode = 400;
            echo json_encode(array('message' => 'Falha na decodificação do JSON.'));
            return;
        }
        // Verifique se os campos obrigatórios estão presentes
        if (!isset($data['email']) || !isset($data['password'])) {
            $this->httpCode = 400;
            echo json_encode(array('message' => 'Campos obrigatórios não podem estar vazios.'));
            return;
        }
        
        $email = $data['email'];
        $password = $data['password'];



        $auth = new Auth();
        $token = $auth->authentication($email, $password);

        if (!empty($token)) {
            $this->httpCode = 200;
            echo json_encode(["token" => $token]);
        } else {
            $this->httpCode = 401;
            echo json_encode(["error" => "Credenciais incorretas. Verifique seu nome de usuário e senha."]);
        }
        
        
    }






    /*
    public function login(){
        $auth = new Auth();
        
        // Lógica de autenticação - exemplo
        $token = $auth->authentication();

        if (!empty($token)) {
            $this->httpCode = 200;
            echo json_encode(["token" => $token]);
        } else {
            $this->httpCode = 200;
            echo json_encode(["status" => "error", "message" => "Erro ao gerar o token"]);
        }
    }
    */


}
