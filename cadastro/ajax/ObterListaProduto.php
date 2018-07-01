<?php

include '../../connection/connection.php';


// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600);
// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);
//Cria a sessão e verifica se o usuário está logado
session_start();
if (!isset($_SESSION['logado'])) {
	header("Location: ./Projeto/login.php?erro_login=1");
}

$nomeCategoria = $_POST['data'];

if($nomeCategoria == "Populares"){
	$scriptCategory = "SELECT * FROM `meal` WHERE enablePop = 1";
	$result = $conn->query($scriptCategory);
} else {
	$scriptCategory = "SELECT * FROM `category` WHERE name = '".$_POST['data']."' ";
	$resultCategory = $conn->query($scriptCategory);
$category = $resultCategory->fetch_object();

$scriptSQL = "SELECT * FROM `meal` WHERE id_category = ".$category->id_category;
$result = $conn->query($scriptSQL);
}

//echo $scriptCategory;
while ($vetor = $result->fetch_object()) {
    //$photo = "./Imagens/" . $vetor->src_photo;
    ?>
    <a id="listItem" href="./EditarProduto.php?editar=1&id=<?php echo $vetor->id_meal; ?>" class="list-group-item"><?php echo $vetor->name; ?></a>
    <?php
}
?>
