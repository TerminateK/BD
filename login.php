<?php
    require "Conexion.php"
?>


<!DOCTYPE html>
<html lang="en">
    <head type="login">
        <meta charset="utf-8">
        <h1>Bienvenidos</h1>
        <h3> Ingrese sus datos de ciudadano</h3>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <form action="login.php" method="post">
            <input type="text" name="nombre" placeholder="Ingrese su nombre">
            <input type="id" name="id_persona" placeholder= "Ingrese su ID">
            <input type="submit" name="Enviar"
        </form>
    </body>

</html>|