<?php

include_once 'Conexion.php';
session_start();

$idvideo = $_GET['id_video'];


$lis = 'SELECT * FROM bd.lista_reproduccion WHERE id_cuenta = '.$_SESSION['ID_Cuenta'].'';
$list = $pdo->prepare($lis);
$list->execute();
$listas = $list->fetchAll();


?>



<!DOCTYPE html>
<html>
<head>

</head>

<body>
    <?php if(isset($_SESSION['ID_Cuenta'])): ?>
        <?php if($listas == null): ?>

        <?php else: ?>
            <?php foreach ($listas as $lista): ?>

                <a><?php echo $lista['titulo'] ?></a></br>
                <a href="agregar_video_playlist.php?id_video=<?php echo $idvideo ?>&id_lista=<?php echo $lista['id_lista'] ?>" class="btn btn-primary">Agregar a esta lista</a></br>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
