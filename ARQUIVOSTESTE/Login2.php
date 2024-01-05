<?php

namespace App\Controllers\authentication;



use Settings\JWT\Auth1;

header('Content-Type: application/json');

class Login2{

    private $httpCode; // Adicione uma propriedade para armazenar o código HTTP
    public function getHttpCode(){
        return $this->httpCode;
    }



    public function home(){
        http_response_code(200);
        echo json_encode(["status" => "Online Authentication"]);
    }

    

    public function loginTeste(){
        $data = json_decode(file_get_contents("php://input"), true);

        // Verifique se a decodificação do JSON foi bem-sucedida
        if ($data === null) {
            $this->httpCode = 400;
            echo json_encode(['message' => 'Falha na decodificação do JSON.']);
            return;
        }

        // Verifique se os campos obrigatórios estão presentes
        if (!isset($data['email']) || !isset($data['password'])) {
            $this->httpCode = 400;
            echo json_encode(['message' => 'Campos obrigatórios não podem estar vazios.']);
            return;
        }

        $email = $data['email'];
        $password = $data['password'];

        $auth = new Auth1();
        $result = $auth->login($email, $password);

        if ($result['status'] === 'success') {
            // Armazene o token em um cookie
            setcookie('jwt_token', $result['token'], time() + 3600, '/'); // Defina a expiração conforme necessário

            $this->httpCode = 200;
            echo json_encode(["token" => $result['token']]);
        } else {
            $this->httpCode = 401;
            echo json_encode(["error" => "Credenciais incorretas. Verifique seu nome de usuário e senha."]);
        }
}



}
