<?php

include_once 'Conexion.php';
session_start();
if($_POST) {
    $user=$_POST['usuario'];
    $pw=$_POST['contrasena'];

    $sql="SELECT * FROM cuenta WHERE username = '$user'";
    $sentencia=$pdo->prepare($sql);
    $sentencia->execute(array($user));
    $resultado=$sentencia->fetch();
    if ($resultado) {
        echo"Ya existe ese usuario";
    }
    elseif(empty($user)){
        echo 'No se han ingresado datos';
    }
    else {

        $create = 'INSERT INTO cuenta (username,contrasena,fecha_creacion,id_persona,tipo_cuenta) VALUES (?,?,?,?,?)';
        $agregar = $pdo->prepare($create);
        $day = date("Y/m/d");
        $valor = 0;
        $agregar->execute(array($user,$pw,$day,$_SESSION['ID_Persona'],$valor));
        $sentencia=$pdo->prepare($sql);
        $sentencia->execute(array($user));
        $resultado=$sentencia->fetch();
        $_SESSION['id_cuenta'] = $resultado['id_cuenta'];
        $_SESSION['username'] = $user;
        $_SESSION['Tipo_cuenta'] = $resultado['tipo_cuenta'];
        header("location:index.php");
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

    <title>Crear cuenta </title>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <h3>Crear cuenta de usuario</h3>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                            <input type="text" name="usuario" placeholder="Usuario">
                        </div>
                        <div class="form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                <input type="text" name="contrasena" placeholder="Contraseña">
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
