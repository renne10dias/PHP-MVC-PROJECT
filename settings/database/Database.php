<?php

namespace settings\Database;

class Database{
    protected $connection;

    private static $instance;

    private const HOST = 'database-1.ctlv8mfxmsqi.sa-east-1.rds.amazonaws.com';
    private const DATABASE = 'academia';
    private const USERNAME = 'admin';
    private const PASSWORD = 'academia123labex';


    private function __construct(){
        $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DATABASE;
        try {
            $this->connection = new \PDO($dsn, self::USERNAME, self::PASSWORD);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Erro na conexão com o banco de dados ou Banco de dados indisponivel');
            //throw new \RuntimeException('Erro na conexão com o banco de dados: ' . $e->getMessage());
        }
    }


    public static function getInstance(){
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function getConnection(){
        return $this->connection;
    }


    public function __destruct(){
        // Fechar a conexão quando o objeto é destruído
        $this->connection = null;
    }


}
