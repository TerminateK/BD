<?php
    include_once('Conexion.php');
    session_start();

    if(isset($_SESSION['ID_Cuenta'])) {
        $id_borrar = $_REQUEST['id_comentario'];
        $query = $pdo->query("SELECT * FROM comentarios WHERE id_comentario = '$id_borrar'")->fetch();
        $id_video = $query['id_video'];
        $consulta = "DELETE FROM comentarios where id_comentario=  '$id_borrar'";
        $querl = $pdo->prepare($consulta);
        $querl->execute();
        header("Location:display_video.php?id_video=$id_video");
}
?>



