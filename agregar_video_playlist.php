<?php
    include_once ("Conexion.php");
    session_start();

    if(isset($_SESSION['ID_Cuenta'])){
        $video = $_REQUEST['id_video'];
        $lista = $_REQUEST['id_lista'];
        $query = $pdo->query("SELECT * FROM lista_video WHERE id_lista = '$lista' and id_video = '$video'")->fetch();

        if ($query) {
            header("Location:mostrarlistas.php?id_video=$lista");
        }
        $create = 'INSERT INTO lista_video (id_video,id_lista) VALUES (?,?)';
        $agregar = $pdo->prepare($create);
        $agregar->execute(array($video,$lista));
        header("Location:mostrarlistas.php?id_video=$lista");

    }




?>