<html>
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
    <style>

        body {
            background-color: white;
        }

        .fundo {
            background-color: #1E90FF;
            color: white;
            border-width: 0;

        }
    </style>
</head>
<body>

<?php
if (!is_numeric($data[0])) {
    echo $data[0];
} else {
    ?>
    <center>
        <h1 class="fundo">Altere sua senha abaixo:</h1>
    </center>

    <div class="container">
        <div class="row">
            <div class="col-sm-4 offset-sm-4 login">
                <form action="/recuperar/atualizarSenha" method="post">
                    <div class="form-group">
                        <label for="senha">Nova senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha"
                               placeholder="Nova Senha" required>
                    </div>
                    <div class="form-group">
                        <label for="repetir_senha">Nova senha:</label>
                        <input type="password" class="form-control" id="repetir_senha" name="repetir_senha"
                               placeholder="Repetir Nova Senha" required>
                    </div>
                    <input type="hidden" name="id" value="<?= $data[0] ?>">
                    <button type="submit" class="btn btn-primary">Alterar senha</button>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>

</body>
</html>