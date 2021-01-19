<?php

use Application\core\Controller;

class GadgetController extends Controller
{
    public function index()
    {
        session_start();
        if (isset($_SESSION['usuario'])) {
            $id = $_SESSION['usuario']->id;
        } else {
            header('Location: /painel/');
        }

        $usuGad = $this->model('UsuariosGadgets');

        $result = $usuGad->buscaUsuariosGadgets($id);

        $retorno = $this->listarGadgets($result);

        $tipGad = $this->model('TipoGadget');

        $retorno2 = $tipGad->buscaTipoGadget();

        if (!$retorno2['isError']) {

            $this->view('gadget/index', [$retorno, $retorno2[0]]);
        } else {
            $this->view('erro', $retorno2);
        }
    }

    /**
     * @param $moduloUsuario
     * @param $modulo
     * @param $situacao
     */
    public function mudaTomada($moduloUsuario, $modulo, $situacao)
    {
        if ($situacao == 0) {
            $atividade = "Desligou a tomada";
        } else {
            $atividade = "Ligou a tomada";
        }
        date_default_timezone_set('America/Sao_Paulo');
        $datahora = date('Y-m-d H:i:s');

        $Gadget = $this->model('Gadget');
        $retorno = $Gadget->ligarDesligarTomada($situacao, $datahora, $modulo);
        if (!$retorno['isError']) {
            $atv = $this->model('Atividade');;
            $retorno = $atv->gravaAtividade($moduloUsuario, $atividade, $situacao, $datahora);
            if ($retorno['isError']) {
                $this->view('erro', $retorno);
            }
        } else {
            $this->view('erro', $retorno);
        }
    }

    /**
     * @param $modulo
     */
    public function valor($modulo)
    {
        $gad = $this->model('Gadget');
        $retorno = $gad->buscaGadget($modulo);
        if (!$retorno['isError']) {
            $this->view('gadget/valor', $retorno[0]);
        } else {
            $this->view('erro', $retorno);
        }

    }

    /**
     * @param $modulo
     */
    public function horario($modulo)
    {
        $gad = $this->model('Gadget');
        $retorno = $gad->buscaGadget($modulo);
        if (!$retorno['isError']) {
            $this->view('gadget/horario', $retorno[0]);
        } else {
            $this->view('erro', $retorno);
        }

    }

    public function adicionarGadget()
    {
        session_start();
        date_default_timezone_set('America/Sao_Paulo');
        if (isset($_SESSION['usuario'])) {
            $id = $_SESSION['usuario']->id;
        } else {
            header('Location: /painel/sair');
        }

        if (isset($_POST["tipo_gadget"])) {
            $tipo_gadget = $_POST["tipo_gadget"];
        } else {
            $this->view('gadget/adicionarGadget', ['<h1>Erro</h1>', '<h3>Tipo de gadget não definido</h3>']);
            exit();
        }
        if (isset($_POST["id_gadget"]) && is_numeric($_POST["id_gadget"])) {
            $id_gadget = $_POST["id_gadget"];
        } else {
            $this->view('gadget/adicionarGadget', ['<h1>Erro</h1>', '<h3>Id do gadget não definido</h3>']);
            exit();
        }

        if (isset($_POST["apelido"])) {
            $apelido = strtolower($_POST["apelido"]);
        } else {
            $this->view('gadget/adicionarGadget', ['<h1>Erro</h1>', '<h3>Apelido do gadget não definido</h3>']);
            exit();
        }

        $situacao = 1;
        $valor = 0;

        $Gadget = $this->model('Gadget');

        //echo $tipo_gadget.','. $id_gadget.','. $situacao.','. $valor.','. $apelido;

        $retorno = $Gadget->cadastrarGadget($tipo_gadget, $id_gadget, $situacao, $valor, $apelido);

        if (!$retorno['isError']) {
            $retorno2 = $Gadget->buscaGadget($id_gadget);
            if (!$retorno2['isError']) {
                //var_dump($retorno2);
                if (isset($retorno2[0][0])) {
                    $id_modulo = $retorno2[0][0]->id;
                    $usuGad = $this->model('UsuariosGadgets');
                    $retorno3 = $usuGad->gravaUsuariosGadgets($id, $id_modulo);

                    if (!$retorno3['isError']) {
                        $this->view('gadget/adicionarGadget', [$retorno[0] == 1 ? '<h1>Gadget Cadastrado</h1>' : '<h1>Gadget já Cadastrado</h1>',
                            $retorno3[0] == 1 ? '<h3>Gadget Vinculado</h3>' : '<h3>Gadget não foi vinculado, pois já está vinculado ou não foi encontrado</h3>'
                        ]);
                    } else {
                        $this->view('erro', $retorno3);
                    }
                }else{
                    $this->view('gadget/adicionarGadget',['<h1>Gadget não cadastrado</h1>','<h3>O gadget não foi cadastrado por um erro inesperado</h3>']);
                }
            } else {
                $this->view('erro', $retorno2);
            }
        } else {
            $this->view('erro', $retorno);
        }
    }

    public function alterarGadget()
    {
        session_start();
        date_default_timezone_set('America/Sao_Paulo');
        if (isset($_SESSION['usuario'])) {
            $id = $_SESSION['usuario']->id;
        } else {
            header('Location: /painel/sair');
        }

        if (isset($_POST["tipo_gadget"])) {
            $tipo_gadget = (int)$_POST["tipo_gadget"];
        } else {
            $this->view('gadget/alterarGadget', ['<h1>Erro</h1>', '<h3>Tipo de gadget não definido</h3>']);
            exit();
        }
        if (isset($_POST["id_gadget"])) {
            $id_gadget = (int)$_POST["id_gadget"];
        } else {
            $this->view('gadget/alterarGadget', ['<h1>Erro</h1>', '<h3>Id do gadget não definido</h3>']);
            exit();
        }

        if (isset($_POST["apelido"])) {
            $apelido = strtolower($_POST["apelido"]);
        } else {
            $this->view('gadget/alterarGadget', ['<h1>Erro</h1>', '<h3>Apelido do gadget não definido ou invalido</h3>']);
            exit();
        }

        $data_hora = date('Y-m-d H:i:s');

        $gadget = $this->model('Gadget');

        $retorno = $gadget->atualizaApelido($apelido, $id_gadget, $tipo_gadget);

        if (!$retorno['isError']) {
            $retorno2 = $gadget->buscaGadget($id_gadget);
            if (!$retorno2['isError']) {
                $id_modulo = $retorno2[0][0]->id;
                $situacao = $retorno2[0][0]->situacao;

                $usuGad = $this->model('UsuariosGadgets');
                $retorno3 = $usuGad->buscaUsuariosGadgets($id);

                if (!$retorno3['isError']) {
                    $id_modulos_usuarios = 0;
                    foreach ($retorno3[0] as $item) {
                        if ($item->id_modulo == $id_modulo) {
                            $id_modulos_usuarios = $item->id;
                            break;
                        }
                    }

                    $atv = $this->model('Atividade');
                    $atividade = "Apelido: $apelido";
                    $retorno4 = $atv->gravaAtividade($id_modulos_usuarios, $atividade, $situacao, $data_hora);
                    if (!$retorno4['isError']) {
                        $this->view('gadget/alterarGadget', ['<h1>Gadget</h1>', '<h3>Apelido atualizado</h3>']);
                    } else {
                        $this->view('erro', $retorno4);
                    }

                } else {
                    $this->view('erro', $retorno3);
                }
            } else {
                $this->view('erro', $retorno2);
            }
        } else {
            $this->view('gadget/alterarGadget', ['<h1>Erro</h1>', '<h3>Apelido não foi atualizado</h3>']);
        }
    }

    public function excluirGadget()
    {
        session_start();
        date_default_timezone_set('America/Sao_Paulo');
        if (isset($_SESSION['usuario'])) {
            $id = $_SESSION['usuario']->id;
        } else {
            header('Location: /painel/sair');
        }

        if (isset($_POST["id_gadget"])) {
            $id_gadget = (int)$_POST["id_gadget"];
        } else {
            $this->view('gadget/excluirGadget', ['<h1>Erro</h1>', '<h3>Id do gadget não definido</h3>']);
            exit();
        }

        $UsuGad = $this->model('UsuariosGadgets');

        $retorno = $UsuGad->desvinculaGadget($id_gadget, $id);

        if (!$retorno['isError']) {
            $this->view('gadget/excluirGadget', ['<h1>Gadget</h1>', '<h3>Gadget excluido da sua lista</h3>']);
        } else {
            $this->view('erro', $retorno);
        }
    }

    /**
     * @param array $usuGad
     * @return array
     */
    private function listarGadgets($usuGad)
    {
        $Gadget = $this->model('Gadget');
        $gadgetArr = [];
        if (!$usuGad['isError']) {
            foreach ($usuGad[0] as $item) {
                $retorno = $Gadget->buscaGadget($item->id_modulo);
                if (!$retorno['isError']) {
                    array_push($retorno[0], $item);
                    array_push($gadgetArr, $retorno[0]);
                } else {
                    $this->view('erro', $retorno);
                }
            }
        } else {
            $this->view('erro', $usuGad);
        }
        return $gadgetArr;
    }

}