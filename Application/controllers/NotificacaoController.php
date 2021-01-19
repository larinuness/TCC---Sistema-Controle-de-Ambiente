<?php

use Application\core\Controller;

class NotificacaoController extends Controller
{
    public function index()
    {
        session_start();
        if (isset($_SESSION['usuario'])) {//&& $_SESSION['kaa_session_validity'] > date("d-m-Y h:i:s P")) {
            $id_usuario = $_SESSION['usuario']->id;
        } else {
            header('Location: /painel/');
        }

        if (isset($_POST["opt_notif"])) {
            $opt_notif = $_POST["opt_notif"];
        } else {
            $opt_notif = 1;
        }

        if (isset($_POST["pg"])) {
            $pag = $_POST["pg"];
        } else {
            $pag = 1;
        }

        if (isset($_POST["itens"])) {
            $itens = $_POST["itens"];
        } else {
            $itens = 9;
        }

        $VwAtividade = $this->model('VwAtividades');
        $retorno = $VwAtividade->buscarAtividadesUltimo($id_usuario,$pag,$itens,$opt_notif);
        $retorno2 = $VwAtividade->totalPaginasUltimo($itens,$id_usuario,$opt_notif);
        if(!$retorno['isError'] && !$retorno2['isError']){
            $this->view('notificacao/index',['atividades'=>$retorno[0],
                'opt_notif' => $opt_notif,
                'pag' => $pag,
                'itens' => $itens,
                'tot_paginas' => $retorno2['tot_paginas']]);
        }else{
            $this->view('erro', $retorno);
        }

    }

}