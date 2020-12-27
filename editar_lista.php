<?php
include_once 'Conexion.php';
session_start();

if(isset($_SESSION['ID_Cuenta'])) {
    $id = $_REQUEST['id_lista'];
    $query = $pdo->query("SELECT * FROM lista_reproduccion WHERE id_lista = '$id'")->fetch();
    $lista = $query['id_lista'];


    if ($_POST) {
        $nombre_nuevo = $_POST['texto'];
        if(empty($_POST['texto'])) {
            header("Location:mostrarlistas.php?id_lista=$id");
        }
        else{
            $consulta = "UPDATE bd.lista_reproduccion SET bd.lista_reproduccion.titulo = '$nombre_nuevo' WHERE bd.lista_reproduccion.id_lista ='$id'";
            $querl = $pdo->prepare($consulta);
            $querl->execute();
            header("Location:mostrarlistas.php?id_lista=$id");

        }
    }

}
?>

<!DOCTYPE html>
<html>
<head>
<body>
    <?php if(isset($_SESSION['ID_Cuenta'])){?>
        <form action = '#' method = "POST" enctype="multipart/form-data">
            <h3> Nombre  Actual:  <?php echo $query['titulo']; ?></h3>
            <h4> Si no desea cambiar, dejar en blanco</h4>
            <input type="text"  name ="texto" placeholder="Modificar nombre" value=""/>
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
</body>
</head>
</html>