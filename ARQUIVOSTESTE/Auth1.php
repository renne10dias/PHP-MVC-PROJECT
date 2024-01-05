<?php

namespace Settings\JWT;

use Settings\Database\Database;
use Dotenv\Dotenv;
use Firebase\JWT\JWT;

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__FILE__, 3));
$dotenv->load();

class Auth1{

    public function login($email, $senha){
        // Verificar se o usuário já está autenticado
        if ($this->isUserLoggedIn()) {
            return ["status" => "already_logged_in", "message" => "Usuário já está logado"];
        }

        try {
            // Obtém a instância da conexão
            $db = Database::getInstance();

            // Obtém a conexão PDO
            $connection = $db->getConnection();

            // Consulta de exemplo (ajuste conforme necessário)
            $stmt = $connection->prepare("SELECT * FROM tb_usuario WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                // Se a autenticação for bem-sucedida, gerar o token
                $token = $this->generateToken($email);

                // Armazenar o token em um cookie
                setcookie('jwt_token', $token, time() + 3600, '/'); // Defina a expiração conforme necessário

                return ["status" => "success", "token" => $token];
            } else {
                return ["status" => "error", "message" => "Email ou senha incorretos"];
            }
        } catch (\PDOException $e) {
            // Tratamento de erro específico para falha na busca de clientes
            // ou erro na conexão com o banco de dados
            throw new \PDOException('Erro ao listar usuários: ' . $e->getMessage());
        }
    }

    private function isUserLoggedIn(){
        // Verificar se o token está presente e válido (lógica adicional pode ser necessária)
        return isset($_COOKIE['jwt_token']);
    }

    
    private function generateToken($email){
        $payload = [
            'exp' => time() + 3600, // Expira em 1 hora (ajuste conforme necessário)
            'iat' => time(),
            'email' => $email
        ];

        return JWT::encode($payload, $_ENV['KEY'], 'HS256');
    }
}

