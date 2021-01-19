<?php

use Application\core\Controller;

class PainelController extends Controller
{
    public function index($param=0)
    {
        switch ($param){
            case 1:
                $this->view('painel/index',['erro'=>1]);
                break;
            case 2:
                $this->view('painel/index',['erro',2]);
                break;
            default:
                $this->view('painel/index');
        }

    }

    function principal()
    {
        session_start();
        $email = '';
        $senha = '';
        $id = 0;
        if(!isset($_SESSION['usuario'])) {
            if (isset($_POST['email'])) {
                $email = $_POST['email'];
            }
            if (isset($_POST['senha'])) {
                $senha = $_POST['senha'];
            }
            $Login = $this->model('Login');
            $result = $Login->confimarLogin($email, $senha, $id);
            if ($result) {
                $Usuario = $this->model('Usuarios');
                $retorno = $Usuario->buscaPorId($id);

                if(!$retorno['isError']) {
                    $this->view('painel/principal', ['usuario' => $retorno[0][0]]);
                }else {
                    $this->view('erro',$retorno);
                }
            } else {
                header('Location: /painel/index/1');
                $this->view('painel/index', ['erro' => 1]);
            }
        }else{
            $this->view('painel/principal',['usuario'=> [$_SESSION['usuario']]]);
        }
    }

    function sair(){
        $this->limparSession();
        header('Location: /painel/');
    }
}