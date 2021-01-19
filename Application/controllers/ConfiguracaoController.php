<?php

use Application\core\Controller;

class ConfiguracaoController extends Controller
{
    public function index()
    {
        $this->view('configuracao/index');
    }

    public function alterarCadastro()
    {
        session_start();

        //$usu = $this->model('Usuarios');

        if (isset($_POST['senha_atual']) and $_SESSION['usuario']->senha == $_POST['senha_atual']) {
            if (isset($_POST['n_senha']) and $_POST['senha_atual'] != $_POST['n_senha']) {
                $senha = $_POST['n_senha'];
                $_SESSION['usuario']->senha = $_POST['n_senha'];
            } else {
                $senha = $_POST['senha_atual'];
            }


            if (isset($_POST['nome']) and $_SESSION['usuario']->nome != $_POST['nome']) {
                $nome = $_POST['nome'];
                $_SESSION['usuario']->nome = $_POST['nome'];
            } else {
                $nome = $_SESSION['usuario']->nome;
            }

            if (isset($_POST['sobrenome']) and $_SESSION['usuario']->sobrenome != $_POST['sobrenome']) {
                $sobrenome = $_POST['sobrenome'];
                $_SESSION['usuario']->sobrenome = $_POST['sobrenome'];
            } else {
                $sobrenome = $_SESSION['usuario']->sobrenome;
            }

            $retorno = $_SESSION['usuario']->atualizaNomeSobrenome($nome, $sobrenome, $_SESSION['usuario']->id);

            if (isset($_POST['email']) and $_SESSION['usuario']->email != $_POST['email']) {
                $email = $_POST['email'];
                $_SESSION['usuario']->email = $_POST['email'];
            } else {
                $email = $_SESSION['usuario']->email;
            }

            $retorno2 = $_SESSION['usuario']->atualizaEmail($email, $_SESSION['usuario']->id);

            if (isset($_POST['celular']) and $_SESSION['usuario']->celular != $_POST['celular']) {
                $celular = $_POST['celular'];
                $_SESSION['usuario']->celular = $_POST['celular'];
            } else {
                $celular = $_SESSION['usuario']->celular;
            }

            $retorno3 = $_SESSION['usuario']->atualizaCelular($celular, $_SESSION['usuario']->id);


            $retorno4 = $_SESSION['usuario']->atualizaSenha($senha, $_SESSION['usuario']->id);

            $retNome = "";
            if (!$retorno['isError']) {
                if ($retorno[0] == 1) {
                    $retNome = "<li class='list-group-item'><a href='#' onclick='$(\".list-group\").hide();'>Nome e Sobrenome atualizados</a></li>";
                }
            } else {
                $this->view('erro', $retorno);
                exit();
            }

            $retEmail = "";
            if (!$retorno2['isError']) {
                if ($retorno2[0] == 1) {
                    $retEmail = "<li class='list-group-item'><a href='#' onclick='$(\".list-group\").hide();'>Email atualizado</a></li>";
                }
            } else {
                $this->view('erro', $retorno2);
                exit();
            }

            $retCel = "";
            if (!$retorno3['isError']) {
                if ($retorno3[0] == 1) {
                    $retCel = "<li class='list-group-item'><a href='#' onclick='$(\".list-group\").hide();'>Celular atualizado</a></li>";
                }
            } else {
                $this->view('erro', $retorno3);
                exit();
            }

            $retSenha = "";
            if (!$retorno4['isError']) {
                if ($retorno4[0] == 1) {
                    $retSenha = "<li class='list-group-item'><a href='#' onclick='$(\".list-group\").hide();'>Senha atualizada</a></li>";
                }
            } else {
                $this->view('erro', $retorno4);
                exit();
            }

            echo '<ul class="list-group">' . $retNome . $retEmail . $retCel . $retSenha . '</ul>';
        } else {
            echo '<ul class="list-group"><li class="list-group-item"><a href="#" onclick=\'$(".list-group").hide();\'>Senha incorreta</a></li></ul>';
        }
    }

}