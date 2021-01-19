<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Open Graph -->
    <meta property="og:title" content="Stark"/>
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://stark.servicesweb.xyz/">
    <meta property="og:image" content="#">
    <meta property="og:image" content="#">
    <meta property="og:site_name" content="Stark"/>
    <meta property="og:description" content="TCC">

    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/assets/css/estilo_geral.css">
    <link rel="stylesheet" href="/assets/css/estilo_painel.css">

    <link rel="shortcut icon" href="/logo.ico" type="image/x-icon"/>
    <title>Stark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!--boot-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <script src="/assets/js/jquery-3.3.1.min.js"></script>


    <link rel="stylesheet" href="/assets/fontawesome/css/solid.css">
    <link rel="stylesheet" href="/assets/fontawesome/css/fontawesome.css">


    <link href="/assets/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="/assets/js/bootstrap-toggle.min.js"></script>

    <style>


        body {

            background-image: linear-gradient(to top, white, #87CEEB);

            height: 100%;
			width: auto;
            margin: 0;
            background-repeat: no-repeat;
            background-attachment: fixed;


        }

        .caixa {

            background-color: white;
            width: 80%;
            min-width: 800px;
            height: auto;
            border-style: solid;
            border-color: white;
            border-radius: 15px;
            padding-top: 30px;
            margin-top: 10px;

        }

        h1 {
            text-align: center;
            color: white;
        }
    </style>
    <script>
        let bt_relatorio;

        function exportarRelatorio(tipo_arq) {

            let rel = document.getElementById("grafico").contentWindow.location.href;
            if (rel !== 'about:blank') {
                window.open(rel + "/" + tipo_arq, '_blank');
            }
        }

        function abrirGrafico(tr) {
            bt_relatorio = tr;
            let radios = document.getElementsByName('gadget');
            let gadget = 0;
            for (let i = 0, length = radios.length; i < length; i++) {
                if (radios[i].checked) {
                    // do whatever you want with the checked radio
                    gadget = radios[i].value;
                    // only one radio can be logically checked, don't check the rest
                    break;
                }
            }
            let link = '/relatorio/grafico/' + tr.getAttribute('data-value').toUpperCase() + '/' + gadget.toString();

            $('#grafico').css("visibility","visible");
            window.open(link, 'grafico');
        }

        function mudaGadget() {
            if (bt_relatorio !== null && bt_relatorio !== undefined) {
                bt_relatorio.click();
            }
        }

    </script>
</head>
<body>
<div class="container">
    <div class="col-sm-12 voltar" style="background-color:transparent">
        <a href="/painel/principal" style="margin-right:10px">Voltar</a>
    </div>
</div>


<h1>Relatório de Atividades</h1>


<center>
    <div class="caixa">
        <div class="container">
            <div class="row">
                <div class="col-12 my-2">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <?php
                        $aux = 1;
                        foreach ($data as $modelo){
                        ?>
                        <label class="btn btn-primary <?=$aux==1?'active':''?>">
                            <input type="radio" name="gadget" value="<?= $modelo->id ?>" onchange="mudaGadget()" <?=$aux==1?'checked':''?>><?= $modelo->tipo ?>
                        </label>
                        <?php
                            $aux++;
                        }
                        ?>
                    </div>
                </div>
                <div class="col-12">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <input class="btn btn-primary" type="button" value="Dia" name="tipo_relatorio" data-value="DIA"
                               onClick="abrirGrafico(this)" checked>
                        <input class="btn btn-primary" type="button" value="Mês" name="tipo_relatorio" data-value="MES"
                               onClick="abrirGrafico(this)">
                        <input class="btn btn-primary" type="button" value="Ano" name="tipo_relatorio" data-value="ANO"
                               onClick="abrirGrafico(this)">
                    </div>

                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <input class="btn btn-primary" type="button" value="Baixar relatorio" data-value="CSV"
                                   onClick="exportarRelatorio(this.getAttribute('data-value'))">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <iframe class="" name="grafico" id="grafico" width=650 height=350 style="border: none;visibility: hidden;">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</center>


<script src="/assets/js/bootstrap.min.js"></script>

</body>
</html>