<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Open Graph -->
    <meta property="og:title" content="Stark" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://stark.servicesweb.xyz" />
    <meta property="og:image" content="#" />
    <meta property="og:image" content="#" />
    <meta property="og:site_name" content="Stark" />
    <meta property="og:description" content="TCC" />
    <meta charset="utf-8" />

    <link rel="shortcut icon" href="/logo.ico" type="image/x-icon" />
    <title>Stark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!--boot-->
    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/assets/css/estilo_geral.css" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" media="screen" />

    <style>

        body {
            background-color: white;
        }

        .fundo {
            background-color: #1E90FF;
            color: white;
            border-width: 0
        }

        .bt_acessar {
            width: 50%;
            font-size: 2.3em;
            margin-top: 0.7em;
            margin-bottom: 0.7em;
            padding-top: 0.9em;
            padding-bottom: 0.9em;
            background-color: #1E90FF;
            border-radius: 15px;
        }

        .bt_cadastre {
            width: 30%;
            min-width: 150px;
            font-size: 1.2em;
            margin-top: 0.7em;
            margin-bottom: 0.7em;
            padding-top: 1em;
            padding-bottom: 1em;
            border-radius: 15px;
        }

        .navbar-nav > li >a{
            color: red;
        }

        .navbar-nav > li:hover >a,
        .navbar-nav > li.active >a{
            color: blueviolet;
        }

    </style>
</head>
<body>
<?php include 'menu.php'; ?>

<div style="text-align: center;">
    <h1 class="fundo" style="padding:20px;margin-bottom:40px">Bem Vindo</h1>
</div>

<div class="container">

    <div class="row">
        <div class="col-sm-12 text-center" style="margin-bottom:20px">
            <h1 style="color:#808080">Controle ambientes, próximos ou distantes à você.</h1>
            <center><img src="/assets/img/logo.png" style="padding-bottom:10px;"></center>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 centralizado">
            <button type="button" onclick="location.href='painel'" class="btn btn-info btn-lg bt_acessar">Acessar</button>
        </div>
        <div class="col-sm-12 centralizado">
            <button type="button" onclick="location.href='cadastro'" class="btn btn-secondary btn-lg bt_cadastre">Cadastre-se</button>
        </div>
    </div>
</div>

</body>
</html>
