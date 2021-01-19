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
    <title>Stark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!--boot-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <style>
        .login {
                width: 100%;
                border-radius: 4px;

                padding: 10px;
            }

			.fundo {
                background-color: #1E90FF;
                color: white;
                border-width: 0;
				padding-top: 20px;
				padding-bottom: 20px;

            }

    </style>
</head>
<body>


<div class="row">
    <div class="col-sm-12 centralizado">
       <center><h1 class="fundo">Não consegue acessar sua conta?</h1></center>
    </div>
</div>

<div class="container" style="margin-bottom: 50px">
    <div class="col-sm-12 voltar" style="background-color:transparent">
        <a href="javascript:void(0)" onClick="history.go(-1);
                        return false;">Voltar</a>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-4 offset-sm-4 login">
            <form action="/recuperar/recuperarSenha" method="post">
                <div class="form-group">
                    <label for="input_email">Digite seu e-mail:</label>
                    <input type="email" class="form-control" id="input_email" name="email" aria-describedby="emailHelp" placeholder="Digite um e-mail cadastrado" required>
                </div>
                <button type="submit" class="btn btn-primary">Recuperar acesso</button>
            </form>
        </div>
    </div>
</div>


<script src="/assets/js/bootstrap.min.js"></script>

</body>
</html>