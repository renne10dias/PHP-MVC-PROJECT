<?php

namespace settings\jwt;

use settings\database\Database;
use Dotenv\Dotenv;
use Firebase\JWT\JWT;

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__FILE__, 3));
$dotenv->load();

class Auth{

    public function login($email, $senha){
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
                return $usuario;
            } else {
                return null; // Email ou senha incorretos
            }
        } catch (\PDOException $e) {
            // Tratamento de erro específico para falha na busca de clientes
            // ou erro na conexão com o banco de dados
            throw new \PDOException('Erro ao listar usuários: ' . $e->getMessage());
        }
    }


    public function authentication($email, $senha){
        $usuario = $this->login($email, $senha);
        
        if ($usuario) {
            $payload = [
                'exp' => time() + 3600,
                'iat' => time(),
                'sub' => $usuario['id'],       // ID do usuário
                'role' => $usuario['role'],  // Funções do usuário
                'email' => $usuario['email'],  // Endereço de e-mail do usuário
                // ... outros dados necessários
            ];
        
            return JWT::encode($payload, $_ENV['KEY'], 'HS256');
        } else {
            return null; // Email ou senha incorretos
        }
    }
    
    
}
