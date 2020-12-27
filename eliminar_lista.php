<?php
include_once('Conexion.php');
session_start();

if(isset($_SESSION['ID_Cuenta'])) {
    $id = $_SESSION['ID_Cuenta'];
    $id_borrar = $_REQUEST['id_lista'];
    $consulta = "DELETE FROM lista_reproduccion where id_lista=  '$id_borrar'";
    $querl = $pdo->prepare($consulta);
    $querl->execute();
    header("Location:mostrarlistas.php?id_cuenta=$id");
}
?>


