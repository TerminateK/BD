<?php
include_once('Conexion.php');
session_start();

    if(isset($_SESSION['ID_Cuenta'])) {
        $id = $_SESSION['ID_Cuenta'];
        $id_borrar = $_REQUEST['id_video'];
        $consulta = "DELETE FROM video where id_video=  '$id_borrar'";
        $querl = $pdo->prepare($consulta);
        $querl->execute();

        $CONSULTA2 = "Select count(*) as cantidad from video where id_cuenta = '$id'";
        $resultado2 = $pdo->query($CONSULTA2)->fetch();
        echo $resultado2['cantidad'];
        if($resultado2['cantidad'] == 0){
            $consulta3 = "UPDATE bd.cuenta SET bd.cuenta.tipo_cuenta = 0 WHERE bd.cuenta.id_cuenta ='$id'";
            $resultado3 = $pdo->prepare($consulta3);
            $resultado3->execute();
            header('Location:myprofile.php');
        }

        header('Location:myprofile.php');
    }
?>