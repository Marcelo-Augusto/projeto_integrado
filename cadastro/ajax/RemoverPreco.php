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

$id = $_POST['id'];

$scriptSQL = "DELETE FROM `price` WHERE `id_price` = " . $id . ";";
mysqli_query($conn, $scriptSQL);
$index = mysqli_insert_id($conn);
?>

