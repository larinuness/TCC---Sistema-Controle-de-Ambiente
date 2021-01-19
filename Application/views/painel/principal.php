<?php
//verifica existência de cookie
date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION['usuario'])) {
    if (isset($data['usuario'])) {
        $_SESSION['usuario'] = $data['usuario'];
    } else {
        header('Location: /painel');
    }
}

header('Content-Type: text/html; charset=utf-8');
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
    <link rel="stylesheet" href="/assets/css/estilo_painel.css"/>

    <link rel="shortcut icon" href="/logo.ico" type="image/x-icon"/>
    <title>Stark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!--boot-->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" media="screen"/>

    <script src="/assets/js/jquery-3.3.1.min.js"></script>


    <link rel="stylesheet" href="/assets/fontawesome/css/solid.css">
    <link rel="stylesheet" href="/assets/fontawesome/css/fontawesome.css">

    <style>
        body {

            background-image: linear-gradient(to top, white, #87CEEB);
            height: 95%;
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
            padding-top: 60px;
            margin-top: 10px;
            padding-bottom: 60px;
        }

        a, a:hover {
            text-decoration: none;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="col-sm-16 voltar" style="background-color:transparent">
        <a href="/painel/sair" style="margin-right:110px">Sair</a>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-8 offset-sm-2 centralizado">
            <h1>Olá, <?= $_SESSION['usuario']->nome ?></h1>
        </div>
    </div>
</div>
<center>
    <div class="container">
        <div class="caixa row">

            <div class="col-lg-3 col-md-6 col-sm-12 centralizado">
                <a href="/configuracao">
                    <img src="/assets/img/configuracoes.png">
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 centralizado">
                <a href="/notificacao">
                    <img src="/assets/img/sino.png">
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 centralizado">
                <a href="/gadget">
                    <img src="/assets/img/gadget.png">
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 centralizado">
                <a href="/relatorio">
                    <img src="/assets/img/grafico-de-barras.png">
                </a>
            </div>
        </div>
    </div>
</center>


<script src="/assets/js/bootstrap.min.js"></script>

</body>