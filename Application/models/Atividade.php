<?php


namespace Application\models;

use Application\core\Database;
use PDOException;
use PDO;

class Atividade
{
    private $id;
    private $id_modulos_usuarios;
    private $atividade;
    private $situacao;
    private $data_hora;


    /**
     * @param $id_modulos_usuarios
     * @param $atividade
     * @param $situacao
     * @param $data_hora
     * @return array
     */
    public function gravaAtividade($id_modulos_usuarios, $atividade, $situacao, $data_hora )
    {
        try {
            $conn = new Database();
            $result = $conn->executarQuery("CALL sp_grava_atividade(:id_modulo_usuario, :atividade, :situacao, :datahora)", array(
                ':id_modulo_usuario' => $id_modulos_usuarios,
                ':atividade' => $atividade,
                ':situacao' => $situacao,
                ':datahora' => $data_hora
            ));

            $retorno = [$result->rowCount(), 'isError' => false];
        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $id_modulo_usuario
     * @return array
     */
    public function buscaAtividadesModuloUsuario($id_modulo_usuario){
        try {
            $conn = new Database();
            $result = $conn->executarQuery("CALL sp_busca_atividades_modulo_usuario(:id_modulo_usuario)", array(
                ':id_modulo_usuario' => $id_modulo_usuario
            ));

            $retorno = [$result->fetchAll(PDO::FETCH_CLASS, 'Application\\models\\Atividade'), 'isError' => false];
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