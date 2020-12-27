<?php
    include_once ("Conexion.php");
    session_start();

    if(isset($_SESSION['ID_Cuenta'])){
        $video = $_REQUEST['id_video'];
        $lista = $_REQUEST['id_lista'];
        $consulta = "DELETE FROM lista_video where id_lista='$lista' and id_video = '$video'  ";
        $querl = $pdo->prepare($consulta);
        $querl->execute();
        header("Location:mostrarlistas.php?id_lista=$lista");

    }




?>