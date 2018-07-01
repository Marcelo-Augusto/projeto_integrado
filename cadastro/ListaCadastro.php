<?php
include('../connection/connection.php');

// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600);
// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);
//Cria a sessão e verifica se o usuário está logado
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: ../cadastro/login.php?erro_login=1");
}


if (isset($_GET[excluir])) {
    $scriptSQL = "DELETE FROM `autores` WHERE `autores`.`id_Autor` = " . $_GET['id'] . ";";
    $result = $conn->query($scriptSQL);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Lista de produtos por categoria</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../css/cadastro.css"/>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../js/bootstrap.min.js">

        <script>
            var category_id;
        </script>

    </head>
    <body>

        <nav class="navbar navbar-expand-sm my-nav">
            <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                <ul class="navbar-nav mr-auto">
                    <a class="navbar-brand" href="ListaCadastro.php">
                        <img src="./Imagens/logo.png" class="float-left" width="80px" alt="Cardig">
                    </a>
                </ul>
            </div>
            <div class="navbar-collapse collapse w-100 order-2 dual-collapse2" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../cadastro/sair.php">SAIR</a>
                    </li>
                </ul>
            </div>					 
        </nav>

        <br>

        <div class="container">
            <div class="row d-flex flex-row justify-content-center">
                <div class="col-lg-5">
                    <div class="text-center">
                        <select class="form-control" id="sel1">
                            <?php
                            $resultCategory = $conn->query("SELECT * FROM `category`");
                            $numero = 0;
                            $nome;
                            while ($category = $resultCategory->fetch_object()) {
                                ?>
                                <option>
                                    <?php
                                    echo $category->name;
                                    if ($numero == 0) {
                                        $nome = $category->name;
                                        $category_id = $category->id_category;
                                        if ($category->name == "Populares") {
                                            $scriptSQL = "SELECT * FROM `meal` WHERE enablePop = 1";
                                        } else {
                                            $scriptSQL = "SELECT * FROM `meal` WHERE id_category = " . $category->id_category;
                                        }
                                        $result = $conn->query($scriptSQL);
                                        $numero_registros = $result->num_rows;
                                        $numero = 1;
                                    }
                                    ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div id="botaoNovoProduto">
                    </div>
                </div>
            </div>

            <br>

            <div id="lista_produto" class="list-group">
                <?php
                while ($vetor = $result->fetch_object()) {
                    //$photo = "./Imagens/" . $vetor->src_photo;
                    ?>
                    <a id="listItem" href="./EditarProduto.php?editar=1&id=<?php echo $vetor->id_meal; ?>" class="list-group-item"><?php echo $vetor->name; ?></a>
                    <?php
                }
                ?>
            </div> 
        </div> 

        <!--footer-->
        <br><br>
        <footer class="mojFooter">
            <div class="footertexto py-3">
                © 2018 Cardig. All rights reserved.
            </div>
        </footer>

    </body>

    <script>
        function getUrl() {
            var url = "./CadastroProduto.php?name_category=" + category_id;
            return url;
        }

        $(document).ready(function (e) {
            var url = getUrl();
            $('#create').attr('href', url);
        });



        $('#sel1').on('change', function () {
            var selected = $('#sel1').val();
            category_id = selected;
            //alert(selected);
            var url = getUrl();
            if (selected == "Populares") {
                $("#create").remove();
            } else {
                createbutton();
                $('#create').attr('href', url);
            }
            $.ajax({
                type: "POST",
                url: "./ajax/ObterListaProduto.php",
                data: {"data": selected},
                success: function (data)
                {
                    //alert(data);
                    document.getElementById("lista_produto").innerHTML = data;
                    //utilizar o dado retornado para alterar algum dado da tela.
                }
            });
        });

        $('#create').click(function (e) {
            var selected = $('#sel1').val();
            if (selected == "Populares") {
                return false;
            } else {
                return true;
            }

        });


        function createbutton() {
            var element = "<a id=\"create\" href=\"javascript:getUrl();\" class=\"btn btn-default\" style=\"display: nome;\" >Criar novo produto</a>";

            document.getElementById("botaoNovoProduto").innerHTML = element;

        }

    </script>

</html>