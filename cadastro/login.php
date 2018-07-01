<?php
$erro_login = 0;
if (isset($_POST['inputUser'])) {

    include('../connection/connection.php');

    $user = addslashes($_POST['inputUser']);
    $senha = addslashes($_POST['inputPassword']);

    $string_query = "SELECT *
                           FROM Login 
                           WHERE user='" . $user . "' 
                             and senha=MD5('" . $senha . "')
                           LIMIT 1;";



    if ($result = $conn->query($string_query)) {
        if ($result->num_rows > 0) {

            $obj = $result->fetch_object();

            // server should keep session data for AT LEAST 1 hour
            ini_set('session.gc_maxlifetime', 3600);
            // each client should remember their session id for EXACTLY 1 hour
            session_set_cookie_params(3600);

            session_start();
            $_SESSION['logado'] = 1;
            $_SESSION['id_usuario'] = $obj->id_usuario;

            $result->close();

            header("Location: ./ListaCadastro.php");
        } else {
            $erro_login = 1;
        }
    } else {
        die("Error: %s\n" . $mysqli->error);
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <footer>
    </footer>
    <head>
        <meta charset="utf-8">
        <title>Cardig - O seu cardápio Digital</title>
        <link rel="shortcut icon" type="image/png" href="../Imagens/logo.png">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../js/bootstrap.min.js">

        <style>
            .form-group {
                width: 100%;
                padding: 10px;
                margin: auto;
                font-size: 16px;
            }

            .form-group button {
                font-size: 18px;
            }

            .btn {
                background-color: orange;
                color: white;
            }
        </style>
    </head>
    <body>


        <nav class="navbar navbar-expand-sm my-nav">
            <a class="navbar-brand">
                <img src="../Imagens/logo.png" class="float-right" width="8%" height="8%" alt="Pepitos">
            </a>
        </nav>



        <br><br>
        <div class="container">
            <form class="text-center" action="login.php" method="POST">
<?php
if ($erro_login == 1) {
    echo '<div class="alert alert-danger">
							<strong>Erro no login!</strong><br>
							Insira usuário e senha novamente.</div>';
}
?>
                <h1 class="h3 mb-3">Login</h1>
                <div class="form-group row justify-content-center">
                    <label for="loginUser" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-form-label">Username</label>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <input type="text" class="form-control" name="inputUser" placeholder="Username" pattern=".{4,10}" required autofocus>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="loginPassword" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-form-label">Senha</label>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <input type="password" class="form-control" name="inputPassword" placeholder="4 a 10 caracteres" pattern=".{4,10}" required>
                    </div>
                </div>
                <div class="form-group row justify-content-end">
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <button type="submit" class="btn">Entrar</button>
                    </div>
                </div>				
            </form>
        </div>


        <br><br>

        <footer class="page-footer" pt-4 mt-4>
            <div class="footertexto py-3" style="position: fixed;">
                © 2018 Cardig. All rights reserved.
            </div>
        </footer>

    </body>
</html>