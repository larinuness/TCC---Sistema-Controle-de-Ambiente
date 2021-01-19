<?php


namespace Application\models;

use Application\core\Database;
use PDO;
use PDOException;

class VwRelatorio
{
    private $label;
    private $data_hora;
    private $valor;

    /**
     * @param $id
     * @param $tipo_relatorio
     * @param $tipo_modulo
     * @return array
     */
    public function buscaLabelsCharts($id, $tipo_relatorio, $tipo_modulo){
        try {
            $conn = new Database();
            $result = $conn->executarQuery("CALL sp_charts_labels(:id, :tipo_relatorio,:tipo_modulo)", array(
                ':id' => $id,
                ':tipo_relatorio' => $tipo_relatorio,
                ':tipo_modulo' => $tipo_modulo
            ));
            $retorno = [$result->fetchAll(PDO::FETCH_CLASS, 'Application\\models\\VwRelatorio'), 'isError' => false];
        }catch(PDOException $ex){
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $id
     * @param $tipo_relatorio
     * @param $tipo_modulo
     * @return array
     */
    public function buscaDatasetCharts($id, $tipo_relatorio, $tipo_modulo){
        try {
            $conn = new Database();
            $result = $conn->executarQuery("CALL sp_charts_dataset(:id, :tipo_relatorio,:tipo_modulo)", array(
                ':id' => $id,
                ':tipo_relatorio' => $tipo_relatorio,
                ':tipo_modulo' => $tipo_modulo
            ));
            $retorno = [$result->fetchAll(PDO::FETCH_CLASS, 'Application\\models\\VwRelatorio'), 'isError' => false];
        }catch(PDOException $ex){
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