<?php

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
    <link rel="stylesheet" href="/assets/css/estilo_painel.css"/>
    <link rel="shortcut icon" href="/logo.ico" type="image/x-icon"/>
    <title>Stark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!--boot-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha256-+BEKmIvQ6IsL8sHcvidtDrNOdZO3C9LtFPtF2H0dOHI=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link href="/assets/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/brands.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/solid.css" rel="stylesheet">

    <script defer src="/assets/fontawesome/js/brands.js"></script>
    <script defer src="/assets/fontawesome/js/solid.js"></script>
    <script defer src="/assets/fontawesome/js/fontawesome.js"></script>

    <link href="/assets/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="/assets/js/bootstrap-toggle.min.js"></script>

    <style>
        .error {
            color: red;
        }

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
            width: 80%;
            height: auto;
            border-style: solid;
            border-color: white;
            border-radius: 15px;
            padding-top: 10px;
            margin-top: 10px;
            padding-bottom: 60px;
        }

        h1 {
            color: white;
        }

        .btn{
            cursor: pointer !important;
        }
    </style>

    <script>

        /**
         * Função para enviar os dados
         */

        function mudaTomada(x, y) {

            // Declaração de Variáveis
            let modulo_usuario = x;
            let modulo = y;
            let s = $("#c_tomada_" + y).prop("checked")? 1 : 0;


            $.ajax({
                url: "/gadget/mudaTomada/" + modulo_usuario + "/" + modulo + "/" + s,
                method: "GET"
            });

        }

        function pegarHorarioUmid(x) {

            let result = $("#umid_ult_" + x);

            $.ajax({
                url: "/gadget/horario/" + x,
                method: "GET"
            })
                .done(function (html) {
                    result.text(html);
                });
        }

        function pegaUmidade(x) {

            // Declaração de Variáveis
            let result = $("#umid_val_" + x);

            $.ajax({
                url: "/gadget/valor/" + x,
                method: "GET"
            })
                .done(function (html) {
                    result.text(html+"%");
                    pegarHorarioUmid(x);
                });
        }

        function pegarHorarioTemp(x) {

            let result = $('#temp_ult_'+x);

            $.ajax({
                url: "/gadget/horario/" + x,
                method: "GET"
            })
                .done(function (html) {
                    result.text(html);
                });
        }

        function pegaTemperatura(x) {
            // Declaração de Variáveis
            let result = $('#temp_val_'+x);

            $.ajax({
                url: "/gadget/valor/" + x,
                method: "GET"
            })
                .done(function (html) {
                    result.text(html+"° C");
                    pegarHorarioTemp(x);
                });
        }

        function statusTomada(x) {
            let tomada = $('#c_tomada_'+x);
            let situacao = tomada.prop("checked")? 1 : 0;

            $.ajax({
                url: "/interface/enviaTomada/"+ situacao +"/" + x,
                method: "GET"
            })
                .done(function (html) {
                    let atual_sit = html === 'ligar' ? 1 : 0;
                    if (situacao !== atual_sit){
                        if(atual_sit === 1){
                            tomada.prop("checked", true);
                        } else {
                            tomada.prop("checked", false);
                        }
                    }
                });
        }

        function atualizar_temp(x) {
            setTimeout(function () {
                pegaTemperatura(x);
            }, 100);
            setTimeout(function () {
                atualizar_temp(x);
            }, 4900);
        }

        function atualizar_umid(x) {
            setTimeout(function () {
                pegaUmidade(x);
            }, 100);
            setTimeout(function () {
                atualizar_umid(x);
            }, 4900);
        }

        function atualizar_tomada(x){
            setTimeout(function () {
                statusTomada(x);
            }, 5000);
        }

        function excluir(x){
            if(confirm("Deseja realmente excluir o gadget?")){
                x.submit();
            }
        }

        function update_modal(x) {
            let gad = x.children;
            let apelido = document.getElementById("_apelido");
            let tipo_gadget = document.getElementById("_tipo_gadget");
            let hidden_tipo_gadget = document.getElementById("hidden_tipo_gadget");
            let id_gadget = document.getElementById("_id_gadget");
            let hidden_id_gadget = document.getElementById("hidden_id");
            apelido.value = gad[0].innerText.trimStart();
            tipo_gadget.selectedIndex = gad[0].children[0].classList.contains("fa-plug") ? 2 :(gad[0].children[0].classList.contains("fa-water")? 3 : 1);
            hidden_tipo_gadget.value = gad[0].children[0].classList.contains("fa-plug") ? 2 :(gad[0].children[0].classList.contains("fa-water")? 3 : 1);
            id_gadget.value = gad[1].value;
            hidden_id_gadget.value = gad[1].value;
        }

    </script>

</head>
<body>
<div class="container" style="background-color: rgba(0,0,0,0.3);">

</div>
<div class="container visible">

</div>
<div class="container">
    <div class="col-sm-12 voltar" style="background-color:transparent">
        <a href="/painel/principal" style="margin-right:10px">Voltar</a>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-8 offset-sm-2 centralizado">
            <h1>Gadgets</h1>
        </div>
    </div>
</div>

<center>
    <div class="caixa">
        <div class="container">
            <div class="row">
                <!--<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 cursos pct_ess_sr">
                        <input type="checkbox" checked data-toggle="toggle" data-on="Hello<br>World" data-off="Goodbye<br>World">
                        http://www.bootstraptoggle.com/
                </div>-->
                <?php
                foreach ($data[0] as $modulo) {
                    switch ($modulo[0]->id_tipo_modulo) {
                        case 1:
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-12 g_box p-2">
                                <div class="gadget" id="gadget<?= $modulo[0]->id ?>"
                                     style="border-radius:10px">
                                    <p class="g_nome text-capitalize btn"
                                       onclick="update_modal(document.getElementById('gadget<?= $modulo[0]->id ?>'));"
                                       data-toggle="modal" data-target="#gadget">
                                        <span class="fa fa-thermometer-half"></span>
                                        <?= $modulo[0]->apelido ?>
                                    </p>
                                    <input type="hidden" id="id" value="<?= $modulo[0]->id_gadget ?>">
                                    <p id="temp_val_<?= $modulo[0]->id ?>">--.--</p>
                                    <p id="temp_ult_<?= $modulo[0]->id ?>">Localizando...</p>
                                </div>
                                <script>atualizar_temp(<?= $modulo[0]->id ?>);</script>
                            </div>
                            <?php
                            break;
                        case 2:
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-12 g_box p-2">
                                <div class="gadget" id="gadget<?= $modulo[0]->id ?>"
                                     style="border-radius:10px">
                                    <p class="g_nome text-capitalize btn"
                                       onclick="update_modal(document.getElementById('gadget<?= $modulo[0]->id ?>'));"
                                       data-toggle="modal" data-target="#gadget">
                                        <span class="fa fa-plug"></span>
                                        <?= $modulo[0]->apelido ?>
                                    </p>
                                    <input type="hidden" id="id" value="<?= $modulo[0]->id_gadget ?>">
                                    <div class="form-group">
                                            <input type="checkbox" id="c_tomada_<?= $modulo[0]->id ?>"
                                                   onchange="mudaTomada(<?= $modulo[1]->id . ',' . $modulo[0]->id ?>);" <?php
                                            if ($modulo[0]->situacao == 1) {
                                                echo 'checked';
                                            }
                                            ?> data-toggle="toggle" data-on="Ligado" data-off="Desligado">
                                    </div>
                                </div>
                                <script>atualizar_tomada(<?= $modulo[0]->id ?>);</script>
                            </div>
                            <?php
                            break;
                        case 3:
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-12 g_box p-2">
                                <div class="gadget" id="gadget<?= $modulo[0]->id ?>"
                                     style="border-radius:10px">
                                    <p class="g_nome text-capitalize btn"
                                       onclick="update_modal(document.getElementById('gadget<?= $modulo[0]->id ?>'));"
                                       data-toggle="modal" data-target="#gadget">
                                        <span class="fa fa-water"></span>
                                    <?= $modulo[0]->apelido ?>
                                    </p>
                                    <input type="hidden" id="id" value="<?= $modulo[0]->id_gadget ?>">
                                    <p id="umid_val_<?= $modulo[0]->id ?>">--.--</p>
                                    <p id="umid_ult_<?= $modulo[0]->id ?>">Localizando...</p>
                                </div>
                                <script>atualizar_umid(<?= $modulo[0]->id ?>);</script>
                            </div>
                            <?php
                            break;
                    }
                }
                ?>

                <div class="col-lg-4 col-md-6 col-sm-12 g_box p-2 btn" data-toggle="modal" data-target="#adicionar_gadget">
                    <div class="gadget" style="border-radius:10px">
                        <p class="g_nome">Adicionar novo Gadget:</p>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 g_box">
                                <img class="mx-auto" style="width: 20%;" src="/assets/img/plus.png">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div id="adicionar_gadget" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-md">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <h4>Selecione o novo dispositivo a ser adicionado</h4>
                                <br/>
                                <form id="add_gadget" name="add_gadget" action="/gadget/adicionarGadget" method="post">
                                    <div class="form-group">
                                        <label for="apelido">Apelido:</label>
                                        <input type="text" class="form-control" id="apelido" placeholder="Apelido"
                                               name="apelido" maxlength="15" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tipo_gadget">Tipo do Gadget:</label>
                                        <select class="form-control" id="tipo_gadget" name="tipo_gadget" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            foreach ($data[1] as $opt){
                                                ?>
                                                <option value="<?= $opt->id ?>"><?= $opt->tipo?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_gadget">Id:</label>
                                        <input type="text" class="form-control" id="id_gadget"
                                               placeholder="Id do gadget" name="id_gadget" minlength="6" maxlength="6" required>
                                        <small>Digite o numero com 6 digitos que veio junto ao seu gadget</small>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" form="add_gadget" >Adicionar</button>
                                <button type="reset" form="add_gadget" class="btn btn-danger" data-dismiss="modal">
                                    Cancelar
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <div id="gadget" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-md">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <h4 style="text-align: center">Alterar dados do Gadget</h4>
                                <br/>
                                <form id="u_gadget" name="u_gadget" action="/gadget/alterarGadget" method="post">
                                    <div class="form-group">
                                        <label for="apelido">Apelido:</label>
                                        <input type="text" class="form-control" id="_apelido" name="apelido" maxlength="15" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tipo_gadget">Tipo do Gadget:</label>
                                        <select class="form-control" id="_tipo_gadget" name="tipo_gadget" disabled>
                                            <option value="">Selecione</option>
                                            <?php
                                            foreach ($data[1] as $opt){
                                            ?>
                                            <option value="<?= $opt->id ?>"><?= $opt->tipo?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <input type="hidden" id="hidden_tipo_gadget" name="tipo_gadget" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="id_gadget">Id:</label>
                                        <input type="number" class="form-control" id="_id_gadget"
                                               placeholder="Id do gadget" name="id_gadget" readonly>
                                    </div>
                                </form>
                                <form id="excluir_gadget" name="excluir_gadget" action="/gadget/excluirGadget"
                                      method="post">
                                    <input type="hidden" id="hidden_id" name="id_gadget">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" form="u_gadget">Salvar</button>
                                <button type="button" class="btn btn-warning"
                                        onclick="excluir(document.getElementById('excluir_gadget'));">Excluir
                                </button>
                                <button type="reset" form="add_gadget" class="btn btn-danger" data-dismiss="modal">
                                    Sair
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $('#id_gadget').mask('######');

                $('#add_gadget').validate({
                    rules:{
                        apelido: 'required',
                        tipo_gadget: 'required',
                        id_gadget: {
                            required: true,
                            maxlength: 6,
                            max: 999999,
                            min: 100000,
                            minlength:6
                        }
                    },
                    messages: {
                        apelido: 'Por favor, insira o apelido',
                        tipo_gadget: 'Por favor, selecione um gadget',
                        id_gadget: 'Por favor, insira um id'
                        }
                    });
                });
        </script>

</body>
</html>