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

    <script src="/assets/js/jquery-3.3.1.min.js"></script>

    <script src="/assets/js/jquery.mask.min.js"></script>

    <script src="/assets/js/jquery.validate.min.js"></script>
    <style>

    </style>
</head>
<body>

<div class="container">
    <div class="col-sm-12 voltar" style="background-color:transparent">
        <a href="javascript:void(0)" onClick="history.go(-1); return false;">Voltar</a>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12 text-center">
            <?= $data[0] ?>
            <?= $data[1] ?>
        </div>
    </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>