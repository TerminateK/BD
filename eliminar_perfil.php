<?php
include_once('Conexion.php');
session_start();

if(isset($_SESSION['ID_Cuenta'])) {
    $id_borrar = $_SESSION['ID_Cuenta'];
    $consulta = "DELETE FROM cuenta where id_cuenta=  '$id_borrar'";
    $querl = $pdo->prepare($consulta);
    $querl->execute();
    header('Location:logout.php');
}
?>



