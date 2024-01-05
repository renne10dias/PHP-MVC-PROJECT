<?php

namespace app\domain\service;

use settings\Database\Database;

class TesteClienteService{

    
    public function listarUsuarios(){
        try {
            // Obtém a instância da conexão
            $db = Database::getInstance();

            // Obtém a conexão PDO
            $connection = $db->getConnection();

            // Consulta de exemplo
            $stmt = $connection->query("SELECT * FROM tb_cliente");
            $usuarios = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Retorna os resultados
            return $usuarios;
        } catch (\RuntimeException $e) {
            // Tratamento de erro específico para falha na busca de clientes
            // ou erro na conexão com o banco de dados
            throw new \RuntimeException('Erro ao listar usuários: ' . $e->getMessage());
        }
    }


    
}







