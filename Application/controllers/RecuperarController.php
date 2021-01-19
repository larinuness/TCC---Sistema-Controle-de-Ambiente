<?php

use Application\core\Controller;

class RecuperarController extends Controller
{

    public function index()
    {
        $this->view('recuperar/index');
    }

    public function recuperarSenha(){
        if(isset($_POST['email'])){
            $email = $_POST['email'];
        }

        $usu = $this->model('Usuarios');

        $retorno = $usu->buscaEmail($email);

        if(!$retorno['isError']){
            if($retorno[0] >= 1){
                $retorno2 = $this->enviaEmail($retorno[1][0]);
                if($retorno2){
                    $this->view('recuperar/recuperarSenha','<h1>Enviamos um e-mail para você contendo seus dados de acesso ao sistema.</h1>');
                } else {
                    $this->view('recuperar/recuperarSenha','<h1>Ocorreu um erro ao enviar o email, <br/>por favor, tente mais ou entre em <a href="/contato/">contato com o administrador do site</a></h1>');
                }
            } else {
                $this->view('recuperar/recuperarSenha','<h1>Email não encontrado, por favor,<a href="/cadastro/"> cadastre-se</a></h1>');
            }
        } else {
            $this->view('erro',$retorno);
        }
    }

    /**
     * @param \Application\models\Usuarios $usu
     * @return bool
     */
    public function enviaEmail($usu){
        $quebra_linha = "\r\n";
        $emailsender = 'ola@servicesweb.xyz';
        $nomeremetente = 'Kaá Serviços';
        $emaildestinatario = $usu->email;
        $assunto = 'Recuperação de Senha';

        $mensagemhtml = 'Olá, ' . $usu->nome . '<br/>'.
        'Conforme solicitado, estamos enviando seus dados de acesso:<br/>'.
        'Login: ' . $usu->email . '<br/>'.
        'Senha: ' . $usu->senha . '<br/>';

        $headers = 'MINE-Version: 1.1' . $quebra_linha .
        'Content-type: text/html; charset=utf-8' . $quebra_linha.
        //$headers .= 'Content-type: text/plain; charset=iso-8859-1' . $quebra_linha;
        'From: ' . $emailsender . $quebra_linha .
        'Return-Path: ' . $emailsender . $quebra_linha .
        'Reply-To: ' . $emailsender . $quebra_linha;

        //mail($emaildestinatario, $assunto, $mensagemhtml, $headers, '-r'.$emailsender);
        return mail($emaildestinatario, $assunto, $mensagemhtml, $headers, '-r' . $emailsender);
    }
}