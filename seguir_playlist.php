<?php
include_once ("Conexion.php");
session_start();

if(isset($_SESSION['ID_Cuenta'])){
    $cuenta = $_SESSION['ID_Cuenta'];
    $lista = $_REQUEST['id_lista'];
    $query = $pdo->query("SELECT * FROM seguidos_lista WHERE id_lista = '$lista' and id_cuenta = '$cuenta'")->fetch();

    if ($query) {
        header("Location:myprofile.php?");
    }
    $create = 'INSERT INTO seguidos_lista (id_cuenta,id_lista) VALUES (?,?)';
    $agregar = $pdo->prepare($create);
    $agregar->execute(array($cuenta,$lista));
    header("Location:myprofile.php");

}




