<?php

use Application\core\Controller;

class InterfaceController extends Controller
{

    public function index()
    {
        $this->pageNotFound();
    }

    /**
     * @param $valor
     * @param $mod
     * @param $atividade
     */
    private function envia($valor = null, $mod = null, $atividade = null)
    {
        if (!isset($valor) or !is_numeric($valor)) {
            $this->pageNotFound();
            exit();
        }

        if (!isset($mod) or !is_numeric($mod)) {
            $this->pageNotFound();
            exit();
        }
        if (!isset($atividade) or !is_string($atividade)) {
            $this->pageNotFound();
            exit();
        }

        date_default_timezone_set('America/Sao_Paulo');

        $datahora = date('Y-m-d H:i:s');

        $gadget = $this->model('Gadget');

        $retorno = $gadget->alterarValor($valor, $datahora, $mod);

        if (!$retorno['isError']) {
            if ($retorno[0] == 1) {
                $usuGad = $this->model('UsuariosGadgets');

                $retorno2 = $usuGad->buscaPrimeiroUsuarioGadget($mod);

                if (!$retorno2['isError']) {
                    $id_modulo_usuario = $retorno2[0][0]->id;

                    $situacao = 1;

                    $atv = $this->model('Atividade');

                    $retorno3 = $atv->gravaAtividade($id_modulo_usuario, $atividade, $situacao, $datahora);

                    if (!$retorno3['isError']) {
                        if ($retorno3[0] == 1) {
                            $this->view('interface/enviaTemperatura', 'Valor atualizado');
                        } else {
                            $this->view('interface/enviaTemperatura', 'Valor não foi atualizado');
                        }
                    } else {
                        http_response_code(500);
                    }
                } else {
                    http_response_code(500);
                }
            }
        } else {
            http_response_code(500);
        }
    }

    /**
     * @param $umid
     * @param $mod
     */
    public function enviaUmidade($umid = null, $mod = null)
    {
        $atividade = "Umidade: $umid %";
        $this->envia($umid, $mod, $atividade);
    }

    /**
     * @param  $temp
     * @param  $mod
     */
    public function enviaTemperatura($temp = null, $mod = null)
    {
        $atividade = "Temperatura: $temp ºC";
        $this->envia($temp, $mod, $atividade);
    }

    /**
     * @param $sit
     * @param $mod
     */
    public function enviaTomada($sit = null, $mod = null)
    {
        if (!isset($sit) or !is_numeric($sit)) {

            header("HTTP/1.1 404");

            $this->pageNotFound();

            exit();
        }

        if (!isset($mod) or !is_numeric($mod)) {

            header("HTTP/1.1 404");

            $this->pageNotFound();

            exit();
        }

        $gad = $this->model('Gadget');

        $retorno = $gad->buscaGadget($mod);

        if (!$retorno['isError']) {

            if ($retorno[0][0]->situacao == $sit) {
                if ($sit == 1) {
                    $this->view('interface/escutador', "ligar");

                } else {
                    $this->view('interface/escutador', "desligar");
                }

            } else {

                if ($retorno[0][0]->situacao == 1) {

                    $this->view('interface/escutador', "ligar");

                } else {

                    $this->view('interface/escutador', "desligar");
                }

            }

        } else {
            http_response_code(500);
        }
    }
}
