<?php


namespace Application\models;

use Application\core\Database;
use PDOException;

class Login
{
    private $id;
    private $email;
    private $senha;

    /**
     * @param $email
     * @param $senha
     * @param $id
     *
     * @return array|bool
     */
    public function confimarLogin($email,$senha, &$id){
        try {
            $conn = new Database();

            $result = $conn->executarQuery('CALL SP_LOGIN(:email, :senha)', [
                ':email' => $email,
                ':senha' => $senha
            ]);

            $id = $result->fetchColumn(0);

            $retorno = $result->rowCount() > 0;

        } catch (PDOException $ex) {
            $retorno = ['erro'=>$ex->getCode(),'mensagem'=>$ex->getMessage(),'isError'=>true];
        } finally {
            return $retorno;
        }
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

}