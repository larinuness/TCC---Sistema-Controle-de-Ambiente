<?php

namespace Application\core;

use PDO;
use PDOStatement;

class Database extends PDO
{
    // configuração do banco de dados
    private $db_name = 'u739432952_kaa';
    private $db_user = 'u739432952_admin';
    private $db_password = 'ZpuR98isK4JX';
    private $db_host = '45.132.241.222';

    // armazena a conexão
    private $conn;

    public function __construct()
    {
        // Quando essa classe é instanciada, é atribuido a variável $conn a conexão com o db
        $this->conn = new PDO('mysql:host=' . $this->db_host . ';dbname=' . $this->db_name, $this->db_user, $this->db_password);
    }

    /**
     * @param PDOStatement $stmt
     * @param $key
     * @param $value
     */
    private function setParameters($stmt, $key, $value)
    {
        $stmt->bindParam($key, $value);
    }

    /**
     * @param PDOStatement $stmt
     * @param array $parameters
     */
    private function mountQuery($stmt, $parameters)
    {
        foreach ($parameters as $key => $value) {
            $this->setParameters($stmt, $key, $value);
        }
    }

    /**
     * @param $query
     * @param array $parameters
     *
     * @return PDOStatement
     */
    public function executarQuery($query, array $parameters = [])
    {
        $this->conn->prepare("SET NAMES 'utf8'")->execute();
        $this->conn->prepare("SET character_set_connection=utf8")->execute();
        $this->conn->prepare('SET character_set_client=utf8')->execute();
        $this->conn->prepare('SET character_set_results=utf8')->execute();
        $stmt = $this->conn->prepare($query);
        $this->mountQuery($stmt, $parameters);
        $stmt->execute();
        return $stmt;
    }

}