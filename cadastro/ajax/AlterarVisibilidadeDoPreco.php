<?php

include '../../connection/connection.php';

$id = $_POST['id'];
$value = $_POST['value'];

$scriptSQL = "UPDATE `cardapio`.`price` SET `enable` = '" . $value . "' WHERE `price`.`id_price` = " . $id . ";";
mysqli_query($conn, $scriptSQL);
$index = mysqli_insert_id($conn);
?>

