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
    <meta property="og:description" content="TCC & Projeto de Laboratório de Engenharia de Software"/>

    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/assets/css/estilo_geral.css"/>
    <link rel="shortcut icon" href="/logo.ico" type="image/x-icon"/>
    <title>Stark</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no, user-scalable=no">
    <!--boot-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
            integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
            integrity="sha256-+BEKmIvQ6IsL8sHcvidtDrNOdZO3C9LtFPtF2H0dOHI=" crossorigin="anonymous"></script>

    <style>
        .error {
            color: red;
        }

        body {
            background-color: white;
        }

        .fundo {
            background-color: #1E90FF;
            color: white;
            border-width: 0;
            text-align: center;
        }

        .margem {
            border: 2px dashed #1E90FF;
            padding-top: 10px;
            margin-left: 20px;
            margin-right: 20px;
            padding-bottom: 10px;
            margin-top: 60px;
            margin-bottom: 60px;
            border-radius: 10px;
        }

        h1 {
            padding-top: 1em;
            padding-bottom: 1em;
            background-color: #9370DB;
            color: white;
        }

    </style>
</head>
<body>


<h1 class="fundo">Preencha os campos abaixo com seus dados para realizar o cadastro no sistema.</h1>


<div class="container" style="margin-bottom: 50px">
    <div class="col-sm-12 voltar" style="background-color:transparent">
        <a href="javascript:void(0)" onClick="history.go(-1);
                        return false;">Voltar</a>
    </div>
</div>
<div class="margem">
    <div class="container">
        <form id="f_cadastro" action="/cadastro/cadastrar" method="post">
            <div class="row">
                <div class="col-md-6">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                </div>
                <div class="col-md-6">
                    <label class="col-" for="sobrenome">Sobrenome:</label>
                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome"
                           required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="celular">Celular:</label>
                    <input type="text" class="form-control" id="celular" name="celular" placeholder="Celular" required>
                </div>
                <div class="col-md-6">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="senha">Senha:</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
                </div>
                <div class="col-md-6">
                    <label for="c_senha">Confirmar senha:</label>
                    <input type="password" class="form-control" id="c_senha" name="c_senha"
                           placeholder="Senha novamente"
                           required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <button type="submit" class="btn-primary form-control" style="margin-top: 1em;margin-bottom: 1em;">
                        Realizar cadastro
                    </button>
                </div>
            </div>

        </form>


        <!--<script src="/assets/js/bootstrap.min.js"></script>-->
        <script>
            $(document).ready(function () {
                $('#celular').mask("+55 (00) 00000-0000");

                $("#f_cadastro").validate({
                    rules: {
                        nome: {
                            required: true,
                            maxlength: 40
                        },
                        sobrenome: {
                            required: true,
                            maxlength: 60
                        },
                        senha: {
                            required: true,
                            minlength: 5
                        },
                        c_senha: {
                            required: true,
                            minlength: 5,
                            equalTo: "#senha"
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        celular: "required"

                    },
                    messages: {
                        nome: {
                            required: "Por favor, insira seu nome",
                            maxlength: "O campo suporta 40 caracteres"
                        },
                        sobrenome: {
                            required: "Por favor, insira seu sobrenome",
                            maxlength: "O campo suporta 60 caracteres"
                        },
                        senha: {
                            required: "Por favor, forneca uma senha",
                            minlength: "Sua senha deve ter no mínimo 5 caracteres"
                        },
                        c_senha: {
                            required: "Por favor, forneca uma senha",
                            minlength: "Sua senha deve ter no mínimo 5 caracteres",
                            equalTo: "As senhas não esta iguais"
                        },
                        email: "Digite um e-mail válido",
                        base: "É necessário informar a numeração de uma base para realizar o cadastro",
                        celular: "É necessário um número de telefone"
                    }
                });
            });
        </script>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
            integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
            crossorigin="anonymous"></script>
</div>

</body>
</html>