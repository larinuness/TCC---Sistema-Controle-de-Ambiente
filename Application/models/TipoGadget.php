<?php


namespace Application\models;

use Application\core\Database;
use PDOException;
use PDO;

class TipoGadget
{
    private $id;
    private $tipo;


    public function buscaTipoGadget(){
        try {
            $conn = new Database();

            $result = $conn->executarQuery('CALL sp_busca_tipo_modulo');

            $retorno = [$result->fetchAll(PDO::FETCH_CLASS,'Application\\models\\TipoGadget'),'isError'=>false];

        } catch (PDOException $ex) {
            $retorno = ['erro'=>$ex->getCode(),'mensagem'=>$ex->getMessage(),'isError'=>true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function buscaTipoGadgetUsuario($id){
        try {
            $conn = new Database();

            $result = $conn->executarQuery('CALL sp_busca_tipo_modulo_usuario(:id)',array(
                ':id'=>$id
            ));

            $retorno = [$result->fetchAll(PDO::FETCH_CLASS,'Application\\models\\TipoGadget'),'isError'=>false];

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