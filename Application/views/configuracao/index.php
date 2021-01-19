<?php
session_start();

//verifica existência da sessão;
date_default_timezone_set('America/Sao_Paulo');
if (!isset($_SESSION['usuario'])) {//&& $_SESSION['kaa_session_validity'] > date("d-m-Y h:i:s P")) {
    header('Location: /painel/');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Open Graph -->
    <meta property="og:title" content="Stark"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="http://stark.servicesweb.xyz/"/>
    <meta property="og:image" content="#"/>
    <meta property="og:image" content="#"/>
    <meta property="og:site_name" content="Stark"/>
    <meta property="og:description" content="TCC"/>

    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/assets/css/estilo_geral.css"/>

    <link rel="shortcut icon" href="/logo.ico" type="image/x-icon"/>
    <title>Stark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!--boot-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <link href="/assets/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="/assets/js/bootstrap-toggle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha256-+BEKmIvQ6IsL8sHcvidtDrNOdZO3C9LtFPtF2H0dOHI=" crossorigin="anonymous"></script>

    <style>

        .overlay {
            margin: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 100000;
            width: 100%;
            height: 100%;
            position: absolute;
            text-align: center;
            vertical-align: center;
            top: 0;
        }

        body {

            background-image: linear-gradient(to top, white, #87CEEB);

            height: 100%;
            margin: 0;
            background-repeat: no-repeat;
            background-attachment: fixed;
            width: auto;

        }

        h1 {
            color: white;
        }

        .caixa {
            background-color: white;
            width: 80%;
            height: auto;
            border-style: solid;
            border-color: white;
            border-radius: 15px;
            padding-top: 20px;
            margin-top: 10px;
            padding-bottom: 20px;
        }

    </style>
    <script>
        /**
         * Função para enviar os dados
         */

        function alterarCadastro() {

            // Declaração de Variáveis
            let nome = $("#nome").val();
            let sobrenome = $("#sobrenome").val();
            let email = $("#email").val();
            let celular = $("#celular").val();
            let senhaAtual = $("#senha_atual").val();
            let nSenha = $("#n_senha").val();
            let cNSenha = $("#c_n_senha").val();
            let result = document.getElementById("alteracao");


            $("#dadosCadastrais").valid();

            loading = $("#loading");
            $(document).on({
                ajaxStart: function () {
                    loading.show();
                },
                ajaxStop: function () {
                    loading.hide();
                }
            });

            if (senhaAtual !== "") {
                if (nSenha === "") {
                    nSenha = senhaAtual;
                    cNSenha = senhaAtual;
                }

                $.ajax({
                    url: "/configuracao/alterarCadastro/",
                    method: "POST",
                    data: {
                        nome: nome,
                        sobrenome: sobrenome,
                        email: email,
                        celular: celular,
                        senha_atual: senhaAtual,
                        n_senha: nSenha
                    }
                })
                    .done(function (html) {
                        result.innerHTML = html;
                        $('#senha_atual').val("");
                        $('#n_senha').val("");
                        $('#c_n_senha').val("");
                    })
                    .fail(function (jqXHR, textStatus) {
                        result.append(textStatus);
                    });
            }
        }

    </script>

</head>
<body>
<div id="loading" class="overlay" style="display: none">
    <div class="spinner-border" style="position: absolute;top: 50%;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<div class="container">
    <div class="col-sm-12 voltar" style="background-color:transparent">
        <a href="/painel/principal" style="margin-right:20px">Voltar</a>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-8 offset-sm-2 centralizado">
            <center><h1>Configurações</h1></center>
        </div>
    </div>
</div>
<center>
    <div class="caixa">
        <div class="container">
            <h3>Atualizar Cadastro</h3>
            <form id="dadosCadastrais" name="dadosCadastrais">
                <div class="form-row text-center">
                    <div id="alteracao" class="col-sm-12">
                    </div>
                </div>
                <div class="form-row text-left">
                    <div class="col-md-6">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" value="<?= $_SESSION['usuario']->nome ?>" id="nome"
                               name="nome" placeholder="Nome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="sobrenome">Sobrenome:</label>
                        <input type="text" class="form-control" value="<?= $_SESSION['usuario']->sobrenome ?>"
                               id="sobrenome" name="sobrenome" placeholder="Sobrenome" required>
                    </div>
                </div>
                <div class="form-row text-left">
                    <div class="form-group col-md-6">
                        <label for="celular">Celular:</label>
                        <input type="text" class="form-control" value="<?= substr($_SESSION['usuario']->celular, 5) ?>"
                               id="celular" name="celular" placeholder="Celular" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control" value="<?= $_SESSION['usuario']->email ?>" id="email"
                               name="email" placeholder="E-mail" required>
                    </div>

                </div>
                <div class="form-row text-left">
                    <div class="form-group col-md-4">
                        <label for="senha">Senha atual:</label>
                        <input type="password" class="form-control" id="senha_atual" name="senha_atual"
                               placeholder="Senha atual" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="senha">Nova Senha:</label>
                        <input type="password" class="form-control" id="n_senha" name="n_senha" placeholder="Nova Senha"
                        >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="c_senha">Confirmar Nova Senha:</label>
                        <input type="password" class="form-control" id="c_n_senha" name="c_n_senha"
                               placeholder="Confirmar Nova Senha">
                    </div>

                </div>
                <button type="button" class="btn btn-primary" onclick="alterarCadastro()">Alterar Cadastro</button>
            </form>


            <script src="/assets/js/bootstrap.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#celular').mask("+55 (00) 00000-0000");

                    $("#dadosCadastrais").validate({
                        rules: {
                            nome: {
                                required: true
                            },
                            sobrenome: {
                                required: true
                            },
                            senha_atual: {
                                required: true,
                                minlength: 5
                            },
                            n_senha: {
                                minlength: 5
                            },
                            c_n_senha: {
                                minlength: 5,
                                equalTo: "#n_senha"
                            },
                            email: {
                                required: true,
                                email: true
                            },
                            celular: "required"
                        },
                        messages: {
                            nome: "Por favor, insira seu nome",
                            sobrenome: "Por favor, insira seu sobrenome",

                            senha_atual: {
                                required: "Por favor, forneça a senha",
                                minlength: "Sua senha deve ter no mínimo 5 caracteres"
                            },
                            n_senha: {
                                minlength: "Sua senha deve ter no mínimo 5 caracteres"
                            },
                            c_n_senha: {
                                minlength: "Sua senha deve ter no mínimo 5 caracteres",
                                equalTo: "As senhas não estão iguais"
                            },
                            email: "Digite um e-mail válido",
                            celular: "É necessário um número de telefone"
                        }
                    });
                });
            </script>
        </div>
    </div>
</center>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

</body>
</html>