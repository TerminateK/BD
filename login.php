<?php

include_once("Conexion.php");
session_start();

if($_POST){
    $user=$_POST["usuario"];
    $pw=$_POST["contrasena"];
    $sql="SELECT * FROM cuenta WHERE username = '$user'";
    $sentencia=$pdo->prepare($sql);
    $sentencia->execute(array($user));
    $resultado=$sentencia->fetch();
    if(!$resultado){
        echo"No existe el usuario";
    }
    elseif($pw != $resultado['contrasena']){
        echo "No coinciden las contraseñas";
    }
    else{
        $_SESSION["username"]=$user;
        $_SESSION['ID_Cuenta'] = $resultado['id_cuenta'];
        $_SESSION['Tipo_cuenta'] = $resultado['tipo_cuenta'];
        $id = $resultado['id_persona'];
        $_SESSION['ID_Persona']= $id;

        $stmnt = $pdo->query("SELECT * FROM persona WHERE id_persona = '$id'")->fetch();

        $_SESSION['Tipo_Persona'] = $stmnt['tipo_persona'];
        $_SESSION['Nombre'] = $stmnt['nombre'];
        echo $_SESSION['Nombre'];

        header("location:index.php");
        }
}

?>

<!doctype html>
<html lang="en">
<head>
    <title>Login</title>
    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<title>Login</title>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <h3>Iniciar sesión</h3>
            <div class="card-body">
                <img src="kemonito.jpg" width="300  " height="150">
                <form method="POST">
                    <div class="form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text"  REQUIRED name="usuario" class="form-control" placeholder="Usuario">
                        </div>
                        <div class="form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" REQUIRED name="contrasena" class="form-control" placeholder="Contraseña">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <br>


                <br>
                <form action="Registrar_Persona.php" method="POST">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-user-circle" aria-hidden="true"></i>  Crear Cuenta</button>
                </form>
            </div>




            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>