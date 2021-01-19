<?php

namespace Application\models;

use Application\core\Database;
use PDO;
use PDOException;

class Usuarios
{
    private $id;
    private $nome;
    private $sobrenome;
    private $email;
    private $senha;
    private $cod_rand;
    private $status;
    private $celular;

    /**
     * Este método busca todos os usuários armazenados na base de dados
     *
     * @return   array
     */
    public function buscarTodos()
    {
        try {
            $conn = new Database();
            $result = $conn->executarQuery('SELECT * FROM tab_usuarios');

            $retorno = $result->fetchAll(PDO::FETCH_CLASS, "Application\\models\\Usuarios");

        } catch (PDOException $ex) {
            echo $ex->getCode() . ': ' . $ex->getMessage();
        } finally {
            return $retorno;
        }
    }

    /**
     * Este método busca um usuário armazenados na base de dados com um
     * determinado ID
     * @param int $id Identificador único do usuário
     *
     * @return   array
     */
    public function buscaPorId($id)
    {
        try {
            $conn = new Database();
            $result = $conn->executarQuery('CALL SP_BUSCA_USUARIO(:id)', array(
                ':id' => $id
            ));

            $retorno = [$result->fetchAll(PDO::FETCH_CLASS, 'Application\\models\\Usuarios'),'isError'=>false];

        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(),'isError'=>true];
        } finally {
            return $retorno;
        }

    }

    /**
     * @param string $email
     *
     * @return array
     */
    public function buscaEmail($email=null)
    {
        try {

            if (!isset($this->email)) {
                $this->email = $email;
            }
                $conn = new Database();

                $result = $conn->executarQuery("CALL sp_busca_usuario_email(:email)", array(
                    ':email' => $this->email
                ));

                $retorno = [$result->rowCount(), $result->fetchAll(PDO::FETCH_CLASS, 'Application\\models\\Usuarios'), 'isError' => false];
        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @return array
     */
    public function cadastraUsuario()
    {
        try {
            $conn = new Database();

            $result = $conn->executarQuery("CALL sp_cadastra_usuario( :nome, :sobrenome, :email, :senha, :codRand, :status, :celular)", array(
                ':nome' => $this->nome,
                ':sobrenome' => $this->sobrenome,
                ':email' => $this->email,
                ':senha' => $this->senha,
                ':codRand' => $this->cod_rand,
                ':status' => $this->status,
                ':celular' => $this->celular
            ));

            $retorno = [$result->rowCount(), $result->fetchAll(PDO::FETCH_CLASS, 'Application\\models\\Usuarios'), 'isError' => false];
        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function atualizaStatus($id)
    {
        try {
            $conn = new Database();

            $result = $conn->executarQuery("CALL sp_atualiza_status_usuario(1,:id)", array(
                ':id' => $id
            ));

            $retorno = [$result->rowCount(), 'isError' => false];
        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $id
     * @param $cod
     * @return array
     */
    public function atualizaCod($id,$cod){
        try {
            $conn = new Database();

            $result = $conn->executarQuery("UPDATE tab_usuarios SET cod_rand = :cod WHERE id = :id" , array(
                ':cod'=>$cod,
                ':id'=>$id
            ));

            $retorno = [$result->rowCount(), 'isError' => false];
        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $nome
     * @param $sobrenome
     * @param $id
     *
     * @return array
     */
    public function atualizaNomeSobrenome($nome,$sobrenome, $id)
    {
        try {
            $conn = new Database();

            $result = $conn->executarQuery("CALL sp_atualiza_nome_sobrenome(:nome,:sobrenome,:id)", array(
                ':nome' => $nome,
                ':sobrenome' => $sobrenome,
                ':id' => $id
            ));

            $retorno = [$result->rowCount(), 'isError' => false];
        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $email
     * @param $id
     *
     * @return array
     */
    public function atualizaEmail($email,$id)
    {
        try {
            $conn = new Database();

            $result = $conn->executarQuery("CALL sp_atualiza_email(:email,:id)", array(
                ':email' => $email,
                ':id' => $id
            ));

            $retorno = [$result->rowCount(), 'isError' => false];
        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $celular
     * @param $id
     * @return array
     */
    public function atualizaCelular($celular,$id)
    {
        try {
            $conn = new Database();

            $result = $conn->executarQuery("CALL sp_atualiza_celular(:celular,:id)", array(
                ':celular' => $celular,
                ':id' => $id
            ));

            $retorno = [$result->rowCount(), 'isError' => false];
        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $senha
     * @param $id
     * @return array
     */
    public function atualizaSenha($senha,$id)
    {
        try {
            $conn = new Database();

            $result = $conn->executarQuery("CALL sp_atualiza_senha(:senha,:id)", array(
                ':senha' => $senha,
                ':id' => $id
            ));

            $retorno = [$result->rowCount(), 'isError' => false];
        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
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