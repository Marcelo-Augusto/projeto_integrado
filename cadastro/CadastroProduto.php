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

if (isset($_POST[salvar_dados])) {

    if (isset($_FILES["file"]["type"])) {
        $validextensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["file"]["name"]);
        $file_extension = end($temporary);

        if (in_array($file_extension, $validextensions)) {
            if ($_FILES["file"]["error"] > 0) {
                
            } else {

                $novoNome = uniqid(time()) . '.' . $file_extension;
                $destino = '../Imagens/' . $novoNome;
                $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable

                move_uploaded_file($sourcePath, $destino); // Moving Uploaded file
            }
        }
    }

    $scriptSQL = "INSERT INTO `cardapio`.`meal` (`name`, `description`, `src_photo`, `enable`, `id_category`) VALUES ( '" . $_POST[nome] . "', '" . $_POST[descricao] . "', '" . $novoNome . "', '1', '" . $_POST[id_category] . "');";
    mysqli_query($conn, $scriptSQL);
    $index = mysqli_insert_id($conn);
    $name_category = $_POST[name_category];

    header("location: ./EditarProduto.php?editar=1&id=" . $index);
} else {
    $name_category = $_GET[name_category];
    $scriptCategory = "SELECT * FROM `category` WHERE name = '" . $name_category . "' ";
    $resultCategory = $conn->query($scriptCategory);
    $category = $resultCategory->fetch_object();
    $id_category = $category->id_category;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastrar novo produto</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../css/cadastro.css"/>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../js/bootstrap.min.js">

    </head>
    <body>

        <nav class="navbar navbar-expand-sm my-nav">
            <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                <ul class="navbar-nav mr-auto">
                    <a class="navbar-brand" href="ListaCadastro.php">
                        <img src="./Imagens/logo.png" width="80px" alt="Cardig">
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



        <?php
        if (!isset($index)) {
            ?>
            <div class="container">

                <form name="form" class="form-horizontal" action="./CadastroProduto.php" method="post" enctype="multipart/form-data">
                    <div class="text-center">
                        <h2>Cadastrar novo produto</h2>
                        <p>Preencha os campos abaixo para cadastrar um novo produto.</p>
                    </div>
                    <div class="form-group">
                        <label for="usr">Nome do produto:</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Insira o nome do produto aqui" required="">
                    </div>
                    <div class="form-group">
                        <label for="comment">Descrição do produto:</label>
                        <textarea type="text" name="descricao" class="form-control" rows="5" id="description" value="" placeholder="Insira a descrição do produto aqui"></textarea>
                    </div>
                    <div class="form-group">
                        <img id="meal_photo" class="img-rounded" width="304" height="236">
                        <br>
                        <label for="comment">Selecionar Imagem:</label>
                        <input type="file" name="file" id="file" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" value="<?php echo $id_category; ?>" id="id_category" name="id_category">
                        <input type="hidden" value="<?php echo $name_category; ?>" id="name_category" name="name_category">
                    </div>
                    <br>
                    <div class="row float-right">
                        <a href="javascript:history.back()" class="btn btn-link">Cancelar</a>
                        <button type="submit" class="btn btn-secondary" name="salvar_dados" value="Salvar">Salvar</button>
                    </div>

                </form>
            </div>
            <?php
        } else {
            ?>

            <div class="container text-center">
                <h2>O produto <?php echo $_POST[nome]; ?> foi cadastrado com sucesso! </h2>
                <p>Um novo produto foi cadastrado. Selecione uma das opções abaixo.</p>
                <br>
                <div class="text-center">
                    <a href="./ListaCadastro.php" class="btn btn-default">Lista de produtos</a>
                    <a href="./CadastroProduto.php?name_category=<?php echo $name_category; ?>" class="btn btn-default">Cadastrar novo produto</a>
                </div>
            </div>

            <?php
        }
        ?>

        <!--footer-->
        <br><br>
        <footer class="mojFooter">
            <div class="footertexto py-3">
                © 2018 Cardig. All rights reserved.
            </div>
        </footer>

    </body>

    <script>

        $(document).ready(function (e) {
            // Function to preview image after validation
            $(function () {
                $("#file").change(function () {
                    var file = this.files[0];
                    var imagefile = file.type;
                    var match = ["image/jpeg", "image/png", "image/jpg"];
                    if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
                    {
                        $('#meal_photo').attr('src', 'noimage.png');
                        $("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                        return false;
                    }
                    else
                    {
                        var reader = new FileReader();
                        reader.onload = imageIsLoaded;
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });
            function imageIsLoaded(e) {
                $('#meal_photo').attr('src', e.target.result);
                $('#meal_photo').attr('width', '250px');
                $('#meal_photo').attr('height', '230px');
            }

        });
    </script>
</html>










