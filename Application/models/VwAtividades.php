<?php


namespace Application\models;

use Application\core\Database;
use PDO;
use PDOException;

class VwAtividades
{
    private $id_usuario;
    private $nome;
    private $sobrenome;
    private $id_modulo;
    private $tipo;
    private $id_tipo_modulo;
    private $apelido;
    private $id_atividade;
    private $atividade;
    private $data_hora;
    private $itens;
    private $paginas;

    /**
     * @param $id_usuario
     * @param $pag
     * @param $itens
     * @param $opt_notif
     * @return array
     */
    public function buscarAtividades($id_usuario, $pag, $itens, $opt_notif)
    {
        try {
            $conn = new Database();
            switch ($opt_notif) {
                case 1:
                    $busca = 'sp_busca_atividades_usuario';
                    break;
                case 2:
                    $busca = 'sp_busca_atividades_modulo';
                    break;
            }
            $result = $conn->executarQuery("CALL $busca(:id_usuario,:pag,:itens)", array(
                ':id_usuario' => $id_usuario,
                ':pag' => $pag,
                ':itens' => $itens
            ));
            $retorno = [$result->fetchAll(PDO::FETCH_CLASS, 'Application\\models\\VwAtividades'), 'isError' => false];
        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }

    }

    /**
     * @param $id_usuario
     * @param $pag
     * @param $itens
     * @param $opt_notif
     * @return array
     */
    public function buscarAtividadesUltimo($id_usuario, $pag, $itens, $opt_notif)
    {
        try {
            $conn = new Database();
            switch ($opt_notif) {
                case 1:
                    $busca = 'sp_busca_atividades_usuario_last';
                    break;
                case 2:
                    $busca = 'sp_busca_atividades_modulo_last';
                    break;
            }
            $result = $conn->executarQuery("CALL $busca(:id_usuario,:pag,:itens)", array(
                ':id_usuario' => $id_usuario,
                ':pag' => $pag,
                ':itens' => $itens
            ));
            $retorno = [$result->fetchAll(PDO::FETCH_CLASS, 'Application\\models\\VwAtividades'), 'isError' => false];
        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }

    }

    /**
     * @param $itens
     * @param $id_usuario
     * @param $tipo_not
     * @return array
     */
    public function totalPaginas($itens, $id_usuario, $tipo_not)
    {
        try {
            $conn = new Database();
            $result = $conn->executarQuery("SELECT get_tot_paginas(:itens,:id_usuario,:tipo_not) as tot_paginas", array(
                ':itens' => $itens,
                ':id_usuario' => $id_usuario,
                ':tipo_not' => $tipo_not
            ));
            $retorno = ['tot_paginas' => $result->fetchColumn(0), 'isError' => false];
        } catch (PDOException $ex) {
            $retorno = ['erro' => $ex->getCode(), 'mensagem' => $ex->getMessage(), 'isError' => true];
        } finally {
            return $retorno;
        }
    }

    /**
     * @param $itens
     * @param $id_usuario
     * @param $tipo_not
     * @return array
     */
    public function totalPaginasUltimo($itens, $id_usuario, $tipo_not)
    {
        try {
            $conn = new Database();
            $result = $conn->executarQuery("SELECT get_tot_paginas_last(:itens,:id_usuario,:tipo_not) as tot_paginas", array(
                ':itens' => $itens,
                ':id_usuario' => $id_usuario,
                ':tipo_not' => $tipo_not
            ));
            $retorno = ['tot_paginas' => $result->fetchColumn(0), 'isError' => false];
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