<?php

use Application\core\Controller;

class CadastroController extends Controller
{
    public function index()
    {
        $this->view('cadastro/index');
    }

    public function cadastrar()
    {
        $usu = $this->model('Usuarios');

        if (isset($_POST['nome'])) {
            $usu->nome = $_POST['nome'];
        }

        if (isset($_POST['sobrenome'])) {
            $usu->sobrenome = $_POST['sobrenome'];
        }

        if (isset($_POST['email'])) {
            $usu->email = strtolower($_POST['email']);
        }

        if (isset($_POST['senha'])) {
            $usu->senha = $_POST['senha'];
        }

        if (isset($_POST['celular'])) {
            $usu->celular = $_POST['celular'];
        }
        $usu->cod_rand = rand(200, 999999999);
        $usu->status = 0;

        $retorno = $usu->buscaEmail();

        if (!$retorno['isError']) {
            if ($retorno[0] == 0) {
                $retorno2 = $usu->cadastraUsuario();
                if ($retorno2[0] > 0) {
                    $retorno3 = $this->enviaEmail($retorno2[1][0]);
                    if (!$retorno3) {
                        $this->view('cadastro/cadastrar', ['<h1>Não foi possível realizar o cadastro. O e-mail informado já esta cadastrado.</h1>',
                            '<p>Você pode tentar <a href="/painel">fazer login</a> ou <a href="/recuperar">recuperar seus dados</a> de acesso.</p>']);
                    } else {
                        $this->view('cadastro/cadastrar', ['<h1>Seu cadastro foi realizado com sucesso.</h1>',
                            '<p>Enviamos uma mensagem para o e-mail informado contendo um link de confirmação.</p>']);
                    }
                } else {
                    $this->view('cadastro/cadastrar', ['<h1>Falha ao inserir email.</h1>',
                        '<p>Não foi possivel cadastrar seu email, por favor, entre em contato com o administrador do site.</p>']);
                }
            }else {
                $this->view('cadastro/cadastrar', ['<h1>O e-mail informado já esta cadastrado.</h1>',
                    '<p>Você pode tentar <a href="/painel">fazer login</a> ou <a href="/recuperar">recuperar seus dados</a> de acesso.</p>']);
            }
            }else {
            $this->view('erro', $retorno);
        }
    }

    public function ativacao($cdu=null,$cda=null){
        if(is_null($cdu) or !is_numeric($cdu) ){
            $this->pageNotFound();
            exit();
        }
        if(is_null($cda) or !is_numeric($cda) ){
            $this->pageNotFound();
            exit();
        }
        $usu = $this->model('Usuarios');

        $retorno = $usu->buscaPorId($cdu);

        if(!$retorno['isError'] and !($retorno[0] == [])){
            if($retorno[0][0]->cod_rand == $cda){
                if($retorno[0][0]->status == 0){
                    $retorno2 = $usu->atualizaStatus($cdu);
                    if(!$retorno2['isError']){
                        if($retorno2[0] > 0){
                            $this->view('cadastro/ativacao','<p>Conta ativada com sucesso!</p><p>Você pode <a href="/painel/" style="text-decoration: underline; color: #f00;">fazer login</a></p>');
                        } else {
                            $this->view('cadastro/ativacao','<p>Algo de errado acontenceu, tente mais tarde ou entre em contato <a href="/contato">contato</a></p>');
                        }
                    }else {
                        $this->view('erro', $retorno2);
                    }
                } else {
                    $this->view('cadastro/ativacao','<p>Esta conta já foi ativada</p><p>Você pode <a href="/painel/" style="text-decoration: underline; color: #f00;">fazer login</a>');
                }
            } else {
                $this->view('cadastro/ativacao','<p>Codigo de ativação errado.</p>');
            }
        } else {
            if(($retorno[0] == array())){
                $this->pageNotFound();
            }else{
                $this->view('erro', $retorno);
            }

        }
    }

    private function enviaEmail($usu)
    {
        $quebra_linha = "\r\n";
        $emailsender = 'ola@servicesweb.xyz';
        $nomeremetente = 'Stark Serviços';
        $emaildestinatario = $usu->email;
        $assunto = 'Confirmação de Cadastro';
        $link = "http://stark.servicesweb.xyz/cadastro/ativacao/" . $usu->id . '/' . $usu->cod_rand;

        $mensagemhtml = 'Estamos muito felizes por você ter criado sua conta, ' . $usu->nome . '!<br/>';
        $mensagemhtml = $mensagemhtml . 'Dados de acesso ao sistema:<br/>';
        $mensagemhtml = $mensagemhtml . 'Login: ' . $usu->email . '<br/>';
        $mensagemhtml = $mensagemhtml . 'Senha: ' . $usu->senha . '<br/><br/>';
        $mensagemhtml = $mensagemhtml . 'Para confirar seu cadastro acesse o link:<br/>';
        $mensagemhtml = $mensagemhtml . "<a href='$link'>$link</a><br/><br/>";
        $mensagemhtml = $mensagemhtml . 'Sucesso!!';

        $headers = 'MINE-Version: 1.1' . $quebra_linha;
        $headers .= 'Content-type: text/html; charset=utf-8' . $quebra_linha;
        $headers .= 'From: ' . $emailsender . $quebra_linha;
        $headers .= 'Return-Path: ' . $emailsender . $quebra_linha;
        $headers .= 'Reply-To: ' . $emailsender . $quebra_linha;

        $success = mail($emaildestinatario, $assunto, $mensagemhtml, $headers, '-r' . $emailsender);

        return $success;
    }
}