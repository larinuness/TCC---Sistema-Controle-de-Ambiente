<?php


namespace Application\models;


use Application\core\Database;
use PDO;
use PDOException;

class UsuariosGadgets
{
    private $id;
    private $id_modulo;
    private $id_usuario;
    private $verificado;

    /**
     * @param $id
     * @return array
     */
    public function buscaUsuariosGadgets($id)
    {
        try {
            $conn = new Database();
            $result = $conn->executarQuery('CALL sp_busca_modulos_usuario(:id)', array(
                ':id' => $id
            ));
            $retorno = [$result->fetchAll(PDO::FETCH_CLASS, 'Application\\models\\UsuariosGadgets'), 'isError' => false];

        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $mod
     * @return array
     */
    public function buscaPrimeiroUsuarioGadget($mod){
        try {
            $conn = new Database();
            $result = $conn->executarQuery('CALL sp_busca_modulos_usuario_mod(:mod)', array(
                ':mod' => $mod
            ));
            $retorno = [$result->fetchAll(PDO::FETCH_CLASS, 'Application\\models\\UsuariosGadgets'), 'isError' => false];

        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $id
     * @param $id_modulo
     * @return array
     */
    public function gravaUsuariosGadgets($id, $id_modulo)
    {
        try {
            $conn = new Database();
            $result =$conn->executarQuery("CALL sp_grava_modulo_usuario(:id_modulo, :id_usuario)", array(
                ':id_modulo' => $id_modulo,
                ':id_usuario' => $id
            ));

            $retorno = [$result->rowCount(),'isError'=>false];

        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $id_gadget
     * @param $id_usuario
     * @return array
     */
    public function desvinculaGadget($id_gadget, $id_usuario){
        try {
            $conn = new Database();
            $result =$conn->executarQuery("CALL sp_desvincula_modulo(:id_gadget, :id_usuario)", array(
                ':id_gadget' => $id_gadget,
                ':id_usuario' => $id_usuario
            ));

            $retorno = [$result->rowCount(),'isError'=>false];

        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $id_modulo
     * @return array
     */
    public function buscaUsuariosGadgetsMod($id_modulo)
    {
        try {
            $conn = new Database();
            $result = $conn->executarQuery('CALL sp_busca_modulos_usuario_mod(:modulo)', array(
                ':modulo' => $id_modulo
            ));
            $retorno = [$result->fetchColumn(0), 'isError' => false];

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