<?php
    include_once('Conexion.php');
    session_start();

    if(isset($_SESSION['ID_Cuenta'])) {
        $id = $_REQUEST['id_video'];
        $query = $pdo->query("SELECT * FROM video WHERE id_video = '$id'")->fetch();


        if ($_POST) {
            $titulo_nuevo = $_POST['titulo'];
            $descripcion_nueva = $_POST['descripcion'];
            if (empty($_FILES['imagen']['tmp_name'])) {

                if(empty($_POST['titulo'])){
                    if (empty($_POST['descripcion'])){
                        header('Location:index.php');
                    }
                    else{
                        $consulta = "UPDATE bd.video SET bd.video.descripcion = '$descripcion_nueva' WHERE bd.video.id_video ='$id'";
                        $querl = $pdo->prepare($consulta);
                        $querl->execute();

                    }
                }
                else{
                    if (empty($_POST['descripcion'])){
                        $consulta = "UPDATE bd.video SET bd.video.titulo = '$titulo_nuevo' WHERE bd.video.id_video ='$id'";
                        $querl = $pdo->prepare($consulta);
                        $querl->execute();

                    }
                    else{
                        $consulta = "UPDATE bd.video SET bd.video.descripcion = '$descripcion_nueva',  bd.video.titulo = '$titulo_nuevo' WHERE bd.video.id_video ='$id'";
                        $querl = $pdo->prepare($consulta);
                        $querl->execute();

                    }

                }

            }
            else{
                $imgg = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
                if(empty($_POST['titulo'])){
                    if (empty($_POST['descripcion'])){
                        $consulta = "UPDATE bd.video SET bd.video.img = '$imgg' WHERE bd.video.id_video ='$id'";
                        $querl = $pdo->prepare($consulta);
                        $querl->execute();
                    }
                    else{
                        $consulta = "UPDATE bd.video SET bd.video.descripcion = '$descripcion_nueva',bd.video.img = '$imgg' WHERE bd.video.id_video ='$id'";
                        $querl = $pdo->prepare($consulta);
                        $querl->execute();

                    }
                }
                else{
                    if (empty($_POST['descripcion'])){
                        $consulta = "UPDATE bd.video SET bd.video.titulo = '$titulo_nuevo', bd.video.img = '$imgg' WHERE bd.video.id_video ='$id'";
                        $querl = $pdo->prepare($consulta);
                        $querl->execute();

                    }
                    else{
                        $consulta = "UPDATE bd.video SET bd.video.descripcion = '$descripcion_nueva',  bd.video.titulo = '$titulo_nuevo', bd.video.img = '$imgg' WHERE bd.video.id_video ='$id'";
                        $querl = $pdo->prepare($consulta);
                        $querl->execute();

                    }

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
            <h3> Titulo actual:  <?php echo $query['titulo']; ?></h3>
            <input type="text"  name ="titulo" placeholder="Editar titulo" value=""/>
            <h3> Descripcion actual:  <?php echo $query['descripcion']; ?></h3>
            <input type="text"  name ="descripcion" placeholder="Editar descripcion" value=""/></br>
            <img class="card-img-top" src="data:image/jpg;base64,<?php echo base64_encode($query['img']) ?>" alt="Card image cap">
            <input type ='file'  name="imagen"/></br></br>
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