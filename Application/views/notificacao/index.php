<?php

//verifica existência da sessão;
date_default_timezone_set('America/Sao_Paulo');
if (!isset($_SESSION['usuario'])) {//&& $_SESSION['kaa_session_validity'] > date("d-m-Y h:i:s P")) {
    header('Location: /painel/');
}

if (isset($data["opt_notif"])) {
    $opt_notif = $data["opt_notif"];
} else {
    $opt_notif = 1;
}

if (isset($data["pag"])) {
    $pagina = $data["pag"];
} else {
    $pagina = 1;
}

if (isset($data["itens"])) {
    $itens = $data["itens"];
} else {
    $itens = 9;
}

?>
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

    <meta charset="utf-8">
    <link rel="stylesheet" href="/assets/css/estilo_geral.css">
    <link rel="stylesheet" href="/assets/css/estilo_painel.css">

    <link rel="shortcut icon" href="/logo.ico" type="image/x-icon"/>
    <title>Stark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!--boot-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">



    <link href="/assets/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/brands.css" rel="stylesheet">
    <link href="/assets/fontawesome/css/solid.css" rel="stylesheet">

    <script defer src="/assets/fontawesome/js/brands.js"></script>
    <script defer src="/assets/fontawesome/js/solid.js"></script>
    <script defer src="/assets/fontawesome/js/fontawesome.js"></script>

    <link href="/assets/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="/assets/js/bootstrap-toggle.min.js"></script>
    <style>
        small {
            display: block !important;
            text-align: right;
            padding-top: 0.3em;
        }

        body {
            background-image: linear-gradient(to top, white, #87CEEB);
            height: 100%;
            margin: 0;
            background-repeat: no-repeat;
            background-attachment: fixed;
            width: auto;
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
            padding-bottom: 10px;
        }

        h1 {
            color: white;
        }

    </style>

    <script>
        function changePage(x) {
            let pg = document.getElementById("pg");
            pg.value = x;

            let paginacao = document.getElementById("paginacao");
            paginacao.submit();
        }
    </script>


</head>
<body>
<div class="container">
    <div class="col-sm-12 voltar" style="background-color:transparent">
        <a href="/painel/principal" style="margin-right:10px">Voltar</a>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-8 offset-sm-2 centralizado">
            <h1>Notificações</h1>
        </div>
    </div>
</div>
<center>
    <div class="caixa">
        <div class="container">
            <div class="row">
                <form name="paginacao" id="paginacao" class=" form-inline col-xl-12 col-lg-12 col-md-12 col-sm-12"
                      method="post" action="/notificacao">
                    <input type="hidden" name="pg" id="pg" value="1">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="opt_notif">Tipo de notificação</label>
                        </div>
                        <select class="custom-select" id="opt_notif" name="opt_notif"
                                onchange="document.getElementById('paginacao').submit();">
                            <option value="1" <?= $opt_notif == 1 ? 'selected' : '' ?>>Minhas notificações
                            </option>
                            <option value="2" <?= $opt_notif == 2 ? 'selected' : '' ?>>Todas as notificações
                            </option>
                        </select>
                    </div>
                    <div class="input-group ml-4 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="itens">Total de itens</label>
                        </div>
                        <select class="custom-select" id="itens" name="itens"
                                onchange="document.getElementById('paginacao').submit();">
                            <option value="9" <?= $itens == 9 ? 'selected' : '' ?>>9</option>
                            <option value="12" <?= $itens == 12 ? 'selected' : '' ?>>12</option>
                            <option value="15" <?= $itens == 15 ? 'selected' : '' ?>>15</option>
                            <option value="18" <?= $itens == 18 ? 'selected' : '' ?>>18</option>
                            <option value="21" <?= $itens == 21 ? 'selected' : '' ?>>21</option>
                            <option value="24" <?= $itens == 24 ? 'selected' : '' ?>>24</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="row" id="notif">
                <?php
                //descobrir atividades do usuario
                $atividades = $data['atividades'];
                    foreach ($atividades as $atividade) {
                        //formata horario
                        $t = strtotime($atividade->data_hora);
                        $tipo_modulo = "fa fa-robot";
                        switch ($atividade->ìd_tipo_modulo) {
                            case "1":
                                $tipo_modulo = "fa fa-thermometer-half";
                                break;
                            case "2":
                                $tipo_modulo = "fa fa-plug";
                                break;
                            case "3":
                                $tipo_modulo = "fa fa-water";
                                break;
                        }
                        ?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                            <div class="alert alert-secondary" role="alert">
                                <h4 class="alert-heading">
                                    <a class="text-decoration-none text-capitalize text-dark" href="../gadget">
                                        <span class="<?= $tipo_modulo ?>"></span>
                                        <?= $atividade->apelido ?>
                                    </a>
                                </h4>
                                <p class="text-left">
                                    <?= $atividade->nome . ' ' . $atividade->sobrenome ?>:
                                    <?= $atividade->atividade ?>
                                </p>
                                <small><?= date('d/m/y H:i:s', $t) ?></small>
                            </div>
                        </div>

                        <?php
                    }
                ?>
                <div class="col-sm-12">
                    <?php
                    $tot_paginas = $data['tot_paginas'];
                    ?>
                    <nav aria-label="...">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $pagina == 1?'disabled':'' ?>">
                                <button class="page-link" tabindex="-1" onclick="changePage(1);">
                                    Primeiro
                                </button>
                            </li>
                            <li class="page-item <?= ($pagina == 1)?'disabled':'' ?>">
                                <button class="page-link" tabindex="-1"
                                        onclick="changePage(<?= $pagina - 1 ?>);">
                                    <span aria-hidden="true">&laquo;</span>
                                </button>
                            </li>
                            <?php
                            define('RANGE', 1);
                            if ($pagina == 1) {
                                $range_inicio = 1;
                                $range_fim = $pagina + (RANGE * 2) <= $tot_paginas ? $pagina + (RANGE * 2) : $tot_paginas;
                            } elseif ($pagina == $tot_paginas) {
                                $range_inicio = $pagina - (RANGE * 2) >= 1 ? $pagina - (RANGE * 2) : 1;
                                $range_fim = $tot_paginas;
                            } else {
                                $range_inicio = (($pagina - RANGE) >= 1) ? $pagina - RANGE : 1;
                                $range_fim = (($pagina + RANGE) <= $tot_paginas) ? $pagina + RANGE : $tot_paginas;
                                if ($range_fim - $range_inicio < RANGE * 2 && $tot_paginas > RANGE * 2) {
                                    if ($pagina - $range_inicio < RANGE) {
                                        $range_fim += RANGE - ($pagina - $range_inicio);
                                    }
                                    if ($range_fim - $pagina < RANGE) {
                                        $range_inicio -= RANGE - ($range_fim - $pagina);
                                    }
                                }
                            }
                            for ($i = $range_inicio; $i <= $range_fim; $i++) {

                                ?>
                                <li class="page-item <?= $pagina == $i ? 'active' : ''; ?>">
                                    <button class="page-link" onclick="changePage(<?= $i ?>);">
                                        <?php
                                        echo $i;
                                        if ($pagina == $i) {
                                            ?>
                                            <span class="sr-only">(current)</span>
                                        <?php }
                                        ?>
                                    </button>
                                </li>
                                <?php

                            }
                            ?>
                            <li class="page-item <?= ($pagina == $tot_paginas)?'disabled':'' ?>">
                                <button class="page-link" onclick="changePage(<?= $pagina + 1 ?>);">
                                    <span aria-hidden="true">&raquo;</span>
                                </button>
                            </li>
                            <li class="page-item <?= ($pagina == $tot_paginas)?'disabled':'' ?>">
                                <button class="page-link" tabindex="-1" onclick="changePage(<?= $tot_paginas ?>);">
                                    Ultimo
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    </div>
</center>
</body>
</html>