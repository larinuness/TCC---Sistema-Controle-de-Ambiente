<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Open Graph -->
    <meta property="og:title" content="Stark" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://stark.servicesweb.xyz/" />
    <meta property="og:image" content="#" />
    <meta property="og:image" content="#" />
    <meta property="og:site_name" content="Stark" />
    <meta property="og:description" content="TCC" />

    <meta charset="utf-8" />
    <link rel="stylesheet" href="/assets/css/estilo_geral.css" />
    <link rel="shortcut icon" href="/logo.ico" type="image/x-icon" />
    <!--link rel="stylesheet" href="css/estilo_recuperar_senha.css" /-->
    <title>Stark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!--boot-->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" media="screen" />

    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <style>
        .login {
            width: 100%;
            border-radius: 4px;

            padding: 10px;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="col-sm-12 voltar">
        <a href="javascript:void(0)" onClick="history.go(-1); return false;">< Voltar</a>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12 text-center">
            <?= $data ?>
        </div>
    </div>
</div>

<script src="/assets/js/bootstrap.min.js"></script>

</body>
</html>