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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link href="/assets/css/bootstrap.css" rel="stylesheet" media="screen"/>
    <script src="/assets/js/bootstrap.js"></script>

    <script src="/assets/js/jquery-3.3.1.min.js"></script>

    <link href="/assets/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/brands.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/solid.css" rel="stylesheet">

    <script defer src="/assets/fontawesome/js/brands.js"></script>
    <script defer src="/assets/fontawesome/js/solid.js"></script>
    <script defer src="/assets/fontawesome/js/fontawesome.js"></script>

    <link href="/assets/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="/assets/js/bootstrap-toggle.min.js"></script>

    <script type="text/javascript" src="/assets/js/ajax.js"></script>

    <style>

        body {
            background-image: linear-gradient(to top, white, #87CEEB);
            height: 100%;
            margin: 0;
            background-repeat: no-repeat;
            background-attachment: fixed;
            width: auto;
        }

        .g_box {
            padding: 0.8em;
        }

        .gadget {
            background-color: #e1e1e1;
            padding: 1em;
            text-align: center;
            min-height: 11em;
        }

        .g_nome {
            text-align: center;
            font-size: 1.2em;
            font-family: Arial, sans-serif;
        }

        #temp_val {
            font-size: 1.1em;
        }

        #temp_ult {
            font-size: 0.8em;
            margin: 0;
            padding: 0;
        }

        .caixa {
            background-color: white;
            width: 900px;
            height: auto;
            border-style: solid;
            border-color: white;
            border-radius: 15px;
            padding-top: 60px;
            margin-top: 10px;
        }

        h1 {
            color: white;
        }
    </style>

</head>
<body>

<div class="container">
    <div class="col-sm-12 voltar" style="background-color:transparent">
        <a href="/gadget">Voltar</a>
    </div>
</div>


<center>
    <?= $data[0] ?>
    <?= $data[1] ?>
</center>

</body>
</html>