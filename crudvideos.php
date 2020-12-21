<?php

include_once 'Conexion.php';

?>

[html]<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>PHP CRUD usando PDO y Bootstrap/Modal</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/custom.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/font-awesome.css">
</head>
<body>
<div class="container">
    <h1 class="page-header text-center">PHP CRUD usando PDO</h1>
    <div class="row">
        <div class="col-sm-12">
            <a href="#addnew" class="btn btn-primary" data-toggle="modal"><span class="fa fa-plus"></span> Nuevo</a>
            <?php
            session_start();
            if(isset($_SESSION['message'])){
                ?>
                <div class="alert alert-dismissible alert-success" style="margin-top:20px;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php

                unset($_SESSION['message']);
            }
            ?>
            <table class="table table-bordered table-striped" style="margin-top:20px;">
                <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Dirección</th>
                <th>Acción</th>
                </thead>
                <tbody>
                <?php
                // incluye la conexión
                include_once('connection.php');

                $database = new Connection();
                $db = $database->open();
                try{
                    $sql = 'SELECT * FROM members';
                    foreach ($db->query($sql) as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['firstname']; ?></td>
                            <td><?php echo $row['lastname']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td>
                                <a href="#edit_<?php echo $row['id']; ?>" class="btn btn-success btn-sm" data-toggle="modal"><span class="fa fa-edit"></span> Editar</a>
                                <a href="#delete_<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" data-toggle="modal"><span class="fa fa-trash"></span> Eliminar</a>
                            </td>
                            <?php include('edit_delete_modal.php'); ?>
                        </tr>
                        <?php
                    }
                }
                catch(PDOException $e){
                    echo "There is some problem in connection: " . $e->getMessage();
                }

                //cerrar conexión
                $database->close();

                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('add_modal.php'); ?>
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script src="bootstrap/js/custom.js"></script>
</body>
</html>[/html]

