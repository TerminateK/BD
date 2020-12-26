<?php
    include_once("Conexion.php");
    session_start();

    $id_video = $_REQUEST['id_video'];
    if(isset($_SESSION['ID_Cuenta'])){

        $id_cuenta = $_SESSION['ID_Cuenta'];
        if($_POST){
            $texto = $_POST['texto'];
            $create = 'INSERT INTO comentarios (id_video,fecha_creacion,id_cuenta,texto) VALUES (?,?,?,?)';
            $agregar = $pdo->prepare($create);
            $day = date("Y/m/d");
            $agregar->execute(array($id_video,$day,$id_cuenta,$texto));
            header("Location:display_video.php?id_video=$id_video");

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
            <input type="text" REQUIRED name ="texto" placeholder="Escriba su comentario" value=""/></br>

            <input type="submit" value="Enviar"</br>
        </form>
        <?php
    }
    else{
        echo 'No se ha registrado datos';
        ?>
        <form action="display_video.php?id_video=<?php echo $id_video ?>" method="POST">
            <button type="submit" class="btn btn-primary"><i class="fa fa-user-circle" aria-hidden="true"></i> Devolverse al video</button>
        </form>

        <?php
    }
    ?>
</center>
</body>
</head>
</html>
