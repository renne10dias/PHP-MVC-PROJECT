<?php

namespace settings\JWT;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Dotenv\Dotenv;
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__FILE__, 3));
$dotenv->load();


class TokenHandler{

    public static function extractTokenFromRequest(){
        // Lógica para extrair o token da requisição, dependendo de como ele é enviado (cabeçalho, cookie, etc.)
        return isset($_SERVER['HTTP_AUTHORIZATION']) ? str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']) : null;
    }

    public static function extractTokenFromRequest1(){
        // Verificar se a chave 'Authorization' está presente no cabeçalho da requisição
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            http_response_code(401); // Não autorizado
            echo json_encode(array('message' => 'Token de autorização não fornecido.'));
            exit;
        }

        $authorizationHeader = $headers['Authorization'];

        // Verificar se o cabeçalho começa com "Bearer"
        if (strpos($authorizationHeader, 'Bearer') !== 0) {
            http_response_code(401); // Não autorizado
            echo json_encode(array('message' => 'Esquema de autenticação inválido. Utilize o esquema Bearer.'));
            exit;
        }

        // Extrair o token removendo "Bearer" e espaços em branco
        $token = trim(substr($authorizationHeader, 6));

        return $token;
    }




    
    public static function validateUserRole($token, $userRole){
        try {
            // Verifique se o token não é nulo antes de tentar decodificar
            if ($token !== null) {
                $decodedToken = JWT::decode($token, new Key($_ENV['KEY'], 'HS256'));
    
                // Exemplo simples, ajuste conforme sua lógica específica
                return isset($decodedToken->role) && $decodedToken->role === $userRole;
            } else {
                // Token nulo, não pode ser validado
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
    
    


}
