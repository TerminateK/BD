<?php
include_once('Conexion.php');
session_start();

if(isset($_SESSION['ID_Cuenta'])) {
    $id = $_REQUEST['id_cuenta'];
    $query = $pdo->query("SELECT * FROM cuenta WHERE id_cuenta = '$id'")->fetch();


    if ($_POST) {
        $nombre_nuevo = $_POST['nombre'];
        $contrasena_nueva = $_POST['contrasena'];

        if(empty($_POST['nombre'])){
            if (empty($_POST['contrasena'])){
               header('Location:myprofile.php');
            }
            else{
                $consulta = "UPDATE bd.cuenta SET bd.cuenta.contrasena = '$contrasena_nueva' WHERE bd.cuenta.id_cuenta ='$id'";
                $querl = $pdo->prepare($consulta);
                $querl->execute();
                header('Location:myprofile.php');

            }
        }
        else{
            if (empty($_POST['contrasena'])){
                $consulta = $consulta = "UPDATE bd.cuenta SET bd.cuenta.username = '$nombre_nuevo' WHERE bd.cuenta.id_cuenta ='$id'";
                $querl = $pdo->prepare($consulta);
                $querl->execute();
                header('Location:myprofile.php');
            }
            else{
                $consulta = "UPDATE bd.cuenta SET bd.cuenta.username = '$nombre_nuevo', bd.cuenta.contrasena = '$contrasena_nueva' WHERE bd.cuenta.id_cuenta ='$id'";
                $querl = $pdo->prepare($consulta);
                $querl->execute();
                header('Location:myprofile.php');
            }

        }

    }
}
?>

<!DOCTYPE html>
<html>
<head>
<body>
<center>
    <?php if(isset($_SESSION['ID_Cuenta'])){?>
        <form action = 'myprofile.php' method = "POST" enctype="multipart/form-data">
            <h3> Nombre Actual:  <?php echo $query['username']; ?></h3>
            <h4> Si no desea cambiar, dejar en blanco</h4>
            <input type="text"  name ="nombre" placeholder="Cambiar username" value=""/>
            <h3> Contrasena actual:  <?php echo $query['contrasena']; ?></h3>
            <h4> Si no desea cambiar, dejar en blanco</h4>
            <input type="text"  name ="contrasena" placeholder="Cambiar contraseña" value=""/></br>
            <input type="submit" value="Enviar"</br>
        </form>
        <?php
    }
    else{
        echo 'No se ha registrado datos';
        ?>
        <form action="Index.php" method="POST">
            <button type="submit" class="btn btn-primary"><i class="fa fa-user-circle" aria-hidden="true"></i> Devolverse al Inicio</button>
        </form>
        <?php
    }
    ?>
</center>
</body>
</head>
</html>