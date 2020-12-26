<?php
    include('Conexion.php');
    session_start();
    if($_POST) {
        $titulo = $_POST['titulo'];

        $descripcion = $_POST['descripcion'];
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);

        $create = 'INSERT INTO video (titulo,fecha_creacion,descripcion,categoria,id_cuenta,n_vistas,img) VALUES (?,?,?,?,?,?,?)';
        $agregar = $pdo->prepare($create);
        $day = date("Y/m/d");
        $valor = 0;
        $agregar->execute(array($titulo,$day,$descripcion,$_SESSION['Tipo_Persona'],$_SESSION['ID_Cuenta'],$valor,$imagen));
        header('Location:myprofile.php');
    }


?>






<!DOCTYPE html>
<html>
<head>
<body>
    <center>
        <form action = '#' method = "POST" enctype="multipart/form-data">
            <input type="text" REQUIRED name ="titulo" placeholder="Inserte el nombre del video" value=""/></br>
            <input type="text" REQUIRED name ="descripcion" placeholder="Inserte una descripcion" value=""/></br>

            <input type ='file'  name="imagen"/></br>
            <input type="submit" value="Enviar"</br>
        </form>
    </center>
</body>
</head>
</html>

