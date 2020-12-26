<?php
include_once('Conexion.php');
session_start();

if(isset($_SESSION['ID_Cuenta'])) {
    $id = $_REQUEST['id_comentario'];
    $query = $pdo->query("SELECT * FROM comentarios WHERE id_comentario = '$id'")->fetch();
    $video = $query['id_video'];

    if ($_POST) {
        $comentario_nuevo = $_POST['texto'];
        if(empty($_POST['texto'])) {
            header("Location:display_video.php?id_video=$video");
        }
        else{
            $consulta = "UPDATE bd.comentarios SET bd.comentarios.texto = '$comentario_nuevo' WHERE bd.comentarios.id_comentario ='$id'";
            $querl = $pdo->prepare($consulta);
            $querl->execute();
            header("Location:display_video.php?id_video=$video");

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
        <form action = '#' method = "POST" enctype="multipart/form-data">
            <h3> Comentario  Actual:  <?php echo $query['texto']; ?></h3>
            <h4> Si no desea cambiar, dejar en blanco</h4>
            <input type="text"  name ="texto" placeholder="Modificar comentario" value=""/>
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