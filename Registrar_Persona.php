<?php

include_once 'Conexion.php';
session_start();
if($_POST) {
    $user=$_POST['usuario'];
    $pw=$_POST['contrasena'];

    $sql="SELECT * FROM persona WHERE nombre = '$user' and tipo_persona = '$pw'";
    $sentencia=$pdo->prepare($sql);
    $sentencia->execute(array($user));
    $resultado=$sentencia->fetch();
    if ($resultado) {
        $_SESSION['ID_Persona']= $resultado['id_persona'];
        $_SESSION['Nombre'] = $user;
        $_SESSION['Tipo_Persona'] = $pw;
        header('location:Crear_Usuario.php');
    }
    elseif(empty($user)){
        echo 'No se han ingresado datos';
    }
    else {
        $create = 'INSERT INTO persona (nombre,tipo_persona) VALUES (?,?)';
        $agregar = $pdo->prepare($create);
        $agregar->execute(array($user,$pw));
        $sentencia=$pdo->prepare($sql);
        $sentencia->execute(array($user));
        $resultado=$sentencia->fetch();
        $_SESSION['ID_Persona']= $resultado['id_persona'];
        $_SESSION['Nombre'] = $user;
        $_SESSION['Tipo_Persona'] = $pw;
        header('location:Crear_Usuario.php');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="styles.css">

    <title>Registrar datos de persona </title>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <h3>Ingrese sus datos personales</h3>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                            <input type="text" REQUIRED name="usuario" placeholder="Ingrese su Nombre">
                        </div>
                        <div class="form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                <input type="text" REQUIRED name="contrasena" placeholder="Ingrese su tipo">
                            </div>

                            <br>
                            <button type="submit" class="btn btn-primary">Crear cuenta</button>
                </form>
                <br>
                <br>
                <form action="index.php" method="POST">
                    <button type="submit" class="btn btn-primary">Volver al inicio</button>
                </form>

</body>
</html>
