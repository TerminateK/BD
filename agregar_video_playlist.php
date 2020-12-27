<?php
    include_once ("Conexion.php");
    session_start();

    if(isset($_SESSION['ID_Cuenta'])){
        $video = $_REQUEST['id_video'];
        $lista = $_REQUEST['id_lista'];
        $create = 'INSERT INTO lista_video (id_video,id_lista) VALUES (?,?)';
        $agregar = $pdo->prepare($create);
        $agregar->execute(array($video,$lista));
        // header("Location:mostrarlistas.php?id_video=$lista");

    }




?>