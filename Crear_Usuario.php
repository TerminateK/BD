<?php

include_once 'conexion.php';

if($_POST) {
    $user=$_POST['usuario'];
    $pw=$_POST['contrasena'];
    $mail=$_POST['mail'];
    $tel=$_POST['telefono'];
    $name=$_POST['nombre'];
    $last=$_POST['apellido'];
    $sql="SELECT * FROM personas WHERE Usuario = ?";
    $sentencia=$pdo->prepare($sql);
    $sentencia->execute(array($user));
    $resultado=$sentencia->fetch();
    if ($resultado) {
        echo"Ya existe ese usuario";
    }
    else {
        $create = 'INSERT INTO personas (Usuario,Contrasena,Mail,Telefono,Nombre,Apellido) VALUES (?,?,?,?,?,?)';
        $agregar = $pdo->prepare($create);
        $agregar->execute(array($user,$pw,$mail,$tel,$name,$last));
        $sentencia=$pdo->prepare($sql);
        $sentencia->execute(array($user));
        $resultado=$sentencia->fetch();
        $create_usuario='INSERT INTO usuarios (ID_P) VALUES (?)';
        $agregar_usuario= $pdo->prepare($create_usuario);
        $agregar_usuario->execute(array($resultado["ID_P"]));
        header("location:index.php");
    }
}
?>