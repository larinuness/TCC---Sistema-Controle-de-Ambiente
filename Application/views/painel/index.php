<?php
session_start();
//verifica existência da sessão;
if (isset($_SESSION['usuario'])) {
    //$u_id = $_SESSION['kaa_user'];
    header('Location: /painel/principal');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Open Graph -->
    <meta property="og:title" content="Stark" />
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://stark.servicesweb.xyz/" />
    <meta property="og:image" content="#">
    <meta property="og:image" content="#">
    <meta property="og:site_name" content="Stark" />
    <meta property="og:description" content="TCC" />

    <meta charset="utf-8">
    <link rel="stylesheet" href="/assets/css/estilo_geral.css">

    <link rel="shortcut icon" href="/logo.ico" type="image/x-icon" />
    <title>Stark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!--boot-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <style>

        body {
            background-color: white;
        }

        .fundo {
            background-color: #1E90FF;
            color: white;
            border-width: 0;

        }

        .login {
            width: 100%;
            border-radius: 4px;
            padding: 10px;
        }

        body {
            background-color: #FFFAFA;
        }

        h1 {
            padding-top: 1em;
            padding-bottom: 1em;
            background-color: #9370DB;
            color: white;
        }

        form {
            border: 2px solid #DCDCDC;
            border-radius: 3px;
            padding: 20px;
            margin-top: 20px;
        }

    </style>
</head>
<body>
<?php include 'menu.php'; ?>
<center>
    <h1 class="fundo">Acesse seu painel de controle</h1>
</center>
<div class="container" >
    <div class="row">
        <div class="col-sm-4 offset-sm-4 login">
            <?php
            if (isset($data['erro'])) {
                echo '<div class="row" style="color:red; text-align: center">';
                echo '<div class="col-sm-12 offset-sm-12" >';
                switch ($data['erro']){
                    case 1:
                        echo 'Falha ao fazer login';
                        break;
                    case 2:
                        echo 'Sessão expirada';
                        break;
                }

                echo ' </div></div>';
            }
            ?>
            <form action="/painel/principal" method="post">
                <div class="form-group">
                    <label for="input_email">
                        E-mail:
                    </label>
                    <input type="email" class="form-control" id="input_email" name="email" aria-describedby="emailHelp" placeholder="Digite seu e-mail" required>
                </div>
                <div class="form-group">
                    <label for="input_senha">
                        Senha:
                    </label>
                    <input type="password" class="form-control" id="input_senha" name="senha" placeholder="Digite sua senha" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    Acessar painel
                </button>
                <button type="button" class="btn btn-secondary"  onclick="location.href = '/recuperar';">
                    Esqueceu sua senha?
                </button>

            </form>
        </div>
    </div>

</div>
<footer>
    <small id="emailHelp" class="form-text text-muted centralizado">
        Não compartilhamos suas informações com terceiros.
    </small>
</footer>
</body>
</html>