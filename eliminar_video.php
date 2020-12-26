<?php
include_once('Conexion.php');
session_start();

    if(isset($_SESSION['ID_Cuenta'])) {
        $id_borrar = $_REQUEST['id_video'];
        $consulta = "DELETE FROM video where id_video=  '$id_borrar'";
        $querl = $pdo->prepare($consulta);
        $querl->execute();
        header('Location:index.php');
    }
?>