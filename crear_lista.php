<?php
include('Conexion.php');
session_start();
if($_POST) {
    $titulo = $_POST['titulo'];
    $id = $_SESSION['ID_Cuenta'];


    $create = 'INSERT INTO lista_reproduccion (id_cuenta, titulo) VALUES (?,?)';
    $agregar = $pdo->prepare($create);
    $agregar->execute(array($id, $titulo));
    header('Location:mostrarlistas.php?id_cuenta='.$id.'');

}


?>





<!DOCTYPE html>
<html>
<head>
<body>
<center>
    <?php if(isset($_SESSION['ID_Cuenta'])){?>
        <form action = '#' method = "POST" enctype="multipart/form-data">
            <input type="text" REQUIRED name ="titulo" placeholder="Inserte el nombre de la lista" value=""/></br>

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