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

if (isset($_POST[editar_dados])) {

    $scriptSQL = "SELECT * FROM `meal` where `id_meal`=" . $_POST[id_meal] . ";";
    $result = $conn->query($scriptSQL);
    $vetor = $result->fetch_object();

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


    if (isset($_POST[enable]) && $_POST[enable] == '1') {
        $enable = '1';
    } else {
        $enable = '0';
    }

    if (isset($_POST[enablePop]) && $_POST[enablePop] == '1') {
        $enablePop = 1;
    } else {
        $enablePop = 0;
    }
    
    echo 'enable: '.$enable.' post: '.$_POST[enable];
    echo '<br>enablePop: '.$enablePop.' post: '.$_POST[enablePop];

    if (isset($_POST[photo_change]) && $_POST[photo_change] != "") {
        if (isset($vetor->src_photo) && $vetor->src_photo != "") {
            $file = "../Imagens/" . $vetor->src_photo;
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    if (!isset($novoNome) || $novoNome == "") {
        $novoNome = $vetor->src_photo;
    }

    $scriptSQL = "UPDATE `meal` SET `name` = '" . $_POST[nome] . "', `description` = '" . $_POST[descricao] . "', `src_photo` = '" . $novoNome . "', `enable` = '" . $enable . "', `enablePop` = '" . $enablePop . "' WHERE `id_meal` = " . $_POST[id_meal] . ";";
    mysqli_query($conn, $scriptSQL);

    $scriptSQL = "SELECT * FROM `meal` where `id_meal`=" . $_POST[id_meal] . ";";
    $result = $conn->query($scriptSQL);
    $vetor = $result->fetch_object();

    $atualizado = 'true';
} else if (isset($_POST[remover_produto])) {

    $scriptSQL = "SELECT * FROM `meal` where `id_meal`=" . $_POST[id_meal] . ";";
    $result = $conn->query($scriptSQL);
    $vetor = $result->fetch_object();

    if (isset($vetor->src_photo) && !empty($vetor->src_photo)) {
        $file = "../Imagens/" . $vetor->src_photo;
        if (file_exists($file)) {
            unlink($file);
        }
    }

    $scriptPrice = "DELETE FROM `price` WHERE `id_meal` = " . $_POST[id_meal] . ";";
    $result = $conn->query($scriptPrice);

    $scriptSQL = "DELETE FROM `meal` WHERE `id_meal` = " . $_POST[id_meal] . ";";
    $result = $conn->query($scriptSQL);
    $deleted = 'true';
} else if (isset($_GET['editar'])) {
    $scriptSQL = "SELECT * FROM `meal` where `id_meal`= " . $_GET[id] . " ;";
    $result = $conn->query($scriptSQL);
    $vetor = $result->fetch_object();
} else {
    $scriptSQL = "SELECT * FROM `meal` where `id_meal`=27;";
    $result = $conn->query($scriptSQL);
    $vetor = $result->fetch_object();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Editar cadastro de um produto</title>
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


        <div class="container">

            <?php
            if (isset($deleted)) {
                ?>
                <div class="text-center">
                    <h2>O produto <?php echo $_POST[nome]; ?> foi deletado com sucesso! </h2>
                    <p>Clique no botão abaixo para ir para a lista de produtos.</p>
                    <br>
                    <a href="./ListaCadastro.php" class="btn btn-default">Lista de produtos</a>
                </div>
                <?php
            } else {
                ?>
                <form name="form" class="form-horizontal" action="./EditarProduto.php" method="post" enctype="multipart/form-data">
                    <div class="text-center">
                        <h2>Editar produto</h2>
                        <p>Altere os campos abaixo para atualizar o cadastro produto.</p>
                    </div>
                    <div class="form-group">
                        <label for="usr">Nome do produto:</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $vetor->name; ?>" required="" placeholder="Insira o nome do produto">
                    </div>
                    <div class="form-group">
                        <label for="comment">Descrição do produto:</label>
                        <textarea type="text" name="descricao" class="form-control" rows="5" id="description" placeholder="Insira a descrição do produto"><?php echo $vetor->description; ?></textarea>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label><input id="enablePop" name="enablePop" type="checkbox" value="1"
                                <?php
                                if ($vetor->enablePop == 1) {
                                    echo "checked";
                                }
                                ?>                                                                          
                                          > Adicionar aos populares</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label><input id="enable" name="enable" type="checkbox" value="1"
                                <?php
                                if ($vetor->enable == '1') {
                                    echo "checked";
                                }
                                ?>                                                                          
                                          > Tornar produto visível</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <img id="meal_photo" src="../Imagens/<?php echo $vetor->src_photo; ?>" class="img-rounded" width="304" height="236">
                        <br>
                        <label for="comment">Selecionar Imagem:</label>
                        <input type="file" name="file" id="file" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="photo_change" name="photo_change">
                        <input type="hidden" value="<?php echo $vetor->id_meal; ?>" id="id_meal" name="id_meal">
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row d-flex flex-row justify-content-flex-start">
                                <div class="col-sm-3">
                                    <label for="usr">Preço do produto:</label>
                                    <input type="text" class="form-control" id="value" name="value" placeholder="Insira o preço do produto">
                                </div>
                                <div class="col-sm-7">
                                    <label for="usr">Descrição do preço:</label>
                                    <input type="text" class="form-control" id="price_description" name="price_description" placeholder="Insira a descrição do preço">
                                </div>
                                <div class="col-sm-2">
                                    <div class="text-center">
                                        <span class="pull-right"><div class="btn btn-secondary" id="buttonAdd" onclick="adicionarPreco()">Adicionar</div></span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <ul id="price_list" class="list-group">
                                <?php
                                $price_query = "SELECT * FROM `price` WHERE `id_meal` = " . $vetor->id_meal . " ";
                                $result_price = $conn->query($price_query);
                                while ($price = $result_price->fetch_object()) {
                                    ?>
                                    <li id="price_item<?php echo $price->id_price; ?>" class="list-group-item">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <p><b id="b<?php echo $price->id_price; ?>"><?php echo 'R$' . number_format($price->price, 2, ',', '.'); ?></b></p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p><b><?php echo $price->description; ?></b></p>
                                            </div>

                                            <div class="col-sm-2">
                                                <span class="pull-right">
                                                    <div class="form-group">
                                                        <div class="checkbox">
                                                            <label><input id="enable_price" name="enable_price" type="checkbox" value="<?php echo $price->enable; ?>"
                                                                <?php
                                                                if ($price->enable == '1') {
                                                                    echo "checked";
                                                                }
                                                                ?>
                                                                          onchange="setPriceVisibility(<?php echo $price->id_price; ?>, this)" > Tornar preço visível</label>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="col-sm-2">
                                                <span class="pull-right"><div class="btn btn-danger" onclick="removerPreco(<?php echo $price->id_price; ?>)">Remover</div></span>
                                            </div>
                                        </div> 
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul> 
                        </div>
                    </div>

                    <br>

                    <div class="text-center float-right">
                        <a href="javascript:history.back();" class="btn btn-default">Cancelar</a>
                        <button type="submit" class="btn btn-danger" name="remover_produto" value="remover">Remover</button>
                        <button type="submit" class="btn btn-secondary" name="editar_dados" value="editar">Salvar</button>
                    </div>
                </form>
                <br>
                <br>
                <?php
            }
            ?>
        </div>
        <?php
        if (isset($atualizado)) {
            ?>
            <script>
                alert("Produto atualizado com sucesso!");
            </script>
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
                $('#photo_change').attr('value', 'true');
            }

        });

        function adicionarPreco() {

            var id = $('#id_meal').val();
            var p = $('#value').val();
            var price_description = $('#price_description').val();
            var price = p.replace(",", ".");
            if (price == "" || isNaN(price) || price <= 0) {
                alert("Insira um preço correto!");
            } else {
                $.ajax({
                    type: "POST",
                    url: "./ajax/CadastroNovoPreco.php",
                    data: {"id": id, "price": price, "price_description": price_description},
                    success: function (data)
                    {
                        console.log(data);
                        $("#price_list").append(data);
                        $('#value').val("");
                        $('#price_description').val("");
                    }
                });
            }
        }

        function removerPreco(index) {
            //alert("remover preco");
            $("#price_item" + index).remove();
            $.ajax({
                type: "POST",
                url: "./ajax/RemoverPreco.php",
                data: {"id": index},
                success: function (data) {
                }
            });
        }

        function setPriceVisibility(index, element) {
            var value = element.value;
            if (value == '1') {
                $(element).attr('value', '0');
                value = '0';
            } else {
                $(element).attr('value', '1');
                value = '1';
            }
            $.ajax({
                type: "POST",
                url: "./ajax/AlterarVisibilidadeDoPreco.php",
                data: {"id": index, "value": value},
                success: function (data) {
                }
            });
        }

        function numberToReal(index, numero) {
            var numero = numero.toFixed(2).split('.');
            numero[0] = "R$ " + numero[0].split(/(?=(?:...)*$)/).join('.');
            var price = numero.join(',');
            //alert("numero: "+price);
            document.getElementById("b" + index).innerHTML = price;
            return price;
        }
        
    </script>
</html>










