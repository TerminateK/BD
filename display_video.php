<?php

include_once 'Conexion.php';
session_start();


$idvideo = $_GET["id_video"];
$video = 'SELECT * FROM bd.video WHERE id_video = '.$idvideo.'';
$mivideo = $pdo->prepare($video);
$mivideo->execute();
$resultadoVideo = $mivideo->fetchAll();


$cuent = 'SELECT * FROM bd.cuenta WHERE id_cuenta = '.$resultadoVideo[0]['id_cuenta'].'';
$cuen = $pdo->prepare($cuent);
$cuen->execute();
$cuenta = $cuen->fetchAll();



$updvistas = 'UPDATE bd.video SET n_vistas = n_vistas + 1 WHERE video.id_video = '.$idvideo.'';
$updateV = $pdo->prepare($updvistas);
$updateV->execute();


if (isset($_GET['like'])) {
    if(isset($_SESSION['ID_Cuenta'])) {
        $verLike = 'select * from (select @p1:='.$idvideo.', @p2:='.$_SESSION['ID_Cuenta'].') parm , bd.tiene_like;';
        $verLikes = $pdo->prepare($verLike);
        $verLikes->execute();
        $num = $verLikes->fetchAll();
        if ($num == null) {
            $crearLike = 'INSERT INTO bd.like (id_cuenta, id_video, tipo_like) values ('.$_SESSION['ID_Cuenta'].', '.$idvideo.', '.$_GET['like'].')';
            $crear = $pdo->prepare($crearLike);
            $crear->execute();
            echo'<script type="text/javascript"> alert("Eleccion guardada");</script>';
        }

        elseif ($num[0]['tipo_like'] == $_GET['like']) { #Si apreta like/dislike y ya tiene
            echo'<script type="text/javascript"> alert("No puedes darle like/dislike dos veces!");</script>';
        }
        elseif ($num[0]['tipo_like'] != $_GET['like']) { #Cambiar el tipo de like
            if ($num[0]['tipo_like'] == 0) {
                $upL = 'UPDATE bd.like SET bd.like.tipo_like = 1 WHERE id_video = '.$idvideo.' and bd.like.id_cuenta = '.$_SESSION['ID_Cuenta'].'';
                $upLike = $pdo->prepare($upL);
                $upLike->execute();


            }
            else {
                $upL = 'UPDATE bd.like SET bd.like.tipo_like = 0 WHERE id_video = '.$idvideo.' and bd.like.id_cuenta = '.$_SESSION['ID_Cuenta'].'';
                $upLike = $pdo->prepare($upL);
                $upLike->execute();
            }
            echo'<script type="text/javascript"> alert("Has cambiado tu eleccion!");</script>';
        }


    }

}


$n_like = 'select count(*) as num from bd.like where bd.like.id_video = '.$idvideo.' and bd.like.tipo_like = 0;';
$nlikes = $pdo->prepare($n_like);
$nlikes->execute();
$numlikes = $nlikes->fetchAll();

$n_dlike = 'select count(*) as num from bd.like where bd.like.id_video = '.$idvideo.' and bd.like.tipo_like = 1;';
$ndlikes = $pdo->prepare($n_dlike);
$ndlikes->execute();
$numdislikes = $ndlikes->fetchAll();

?>


<!doctype html>
<html>
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Yap!tube</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="Index.php">Yap!tube</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tendencias.php">Tendencias</a>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['ID_Cuenta'])): ?>
                        <a class="nav-link enabled" href="subir_imagen.php" tabindex="-1" aria-disabled="false">Subir video</a>
                    <?php else: ?>
                        <a class="nav-link enabled" href="login.php" tabindex="-1" aria-disabled="false">Inicie sesión para subir video</a>
                    <?php endif ?>
                </li>
            </ul>
            <form class="d-flex" method="get" action="buscar.php?">
                <input class="form-control me-2" name="data"  type="search" placeholder="Search" aria-label="Search">
                <button href="buscar.php?data=search" class="btn btn-outline-light" type="submit">Buscar</button>
            </form>
        </div>
    </div>
</nav>


<div id="wrapper">
    <div class="overlay"></div>

    <!-- Sidebar -->
    <nav class="navbar navbar-inverse fixed-top" id="sidebar-wrapper" role="navigation">
        <ul class="nav sidebar-nav">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <!-- NOMBRE DE USUARIO -->
                    <?php if (isset($_SESSION['ID_Cuenta'])): ?>
                    <a href="myprofile.php"><?php echo $_SESSION['username'] ?></a></div></div>
                        <?php if($_SESSION['Tipo_Persona'] == 1): ?>
                            <p style="color:white;" style="text-align:center">Tipo: Ciudadano</p>
                        <?php  elseif( $_SESSION['Tipo_Persona'] == 2 ): ?>
                            <p style="color:white;" style="text-align:center">Tipo: Heroe</p>
                        <?php else: ?>
                            <p style="color:white;" style="text-align:center">Tipo: Villano</p>
                        <?php endif ?>

                    <?php else: ?>
                        <li><a href="login.php">Iniciar Sesión</a></li>
                    <?php endif ?>
            <li class="dropdown">
                <a href="#works" class="dropdown-toggle"  data-toggle="dropdown"> Listas de reproducción <span class="caret"></span></a>
                <ul class="dropdown-menu animated fadeInLeft" role="menu">
                    <div class="dropdown-header">Dropdown heading</div>
                    <li><a href="#pictures">Pictures</a></li>
                    <li><a href="#videos">Videeos</a></li>
                    <li><a href="#books">Books</a></li>
                    <li><a href="#art">Art</a></li>
                    <li><a href="#awards">Awards</a></li>
                </ul>
            </li>
            <?php
            if (isset($_SESSION['ID_Cuenta'])): ?>
                <li><a href="logout.php">Salir</a></li>
            <?php endif ?>
        </ul>
    </nav>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <button type="button" class="hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
            <span class="hamb-top"></span>
            <span class="hamb-middle"></span>
            <span class="hamb-bottom"></span>
        </button>
        <div class="container">
            <div class="row" >
                <div class="col-6" >
                    <h1><?php echo $resultadoVideo[0]['titulo'] ?></h1>
                    <img class="card-img-top" src="data:image/jpg;base64,<?php echo base64_encode($resultadoVideo[0]['img']) ?>" alt="Card image cap">

                    <a href="verperfil.php?id_cuenta=<?php echo $cuenta[0]['id_cuenta']?>">  <?php echo $cuenta[0]['username'] ?></a></div></div>
                    <p>Descripcion: <?php echo $resultadoVideo[0]['descripcion'] ?></p>

                    <a>Me gusta: <?php echo $numlikes[0]['num']?></a>
                    <a>- No me gusta: <?php echo $numdislikes[0]['num']?></a>
                    <?php if (isset($_SESSION['ID_Cuenta'])): ?>
                        <button type="button" class="btn btn-success" onClick="location.href='display_video.php?id_video=<?php echo $idvideo ?>&like=0'">Me gusta</button>
                        <button type="button" class="btn btn-success" onClick="location.href='display_video.php?id_video=<?php echo $idvideo ?>&like=1'">No me gusta</button>
                    <?php else: ?>
                        <button type="button" class="btn btn-success" onClick="location.href='login.php'">Me gusta</button>
                        <button type="button" class="btn btn-success" onClick="location.href='login.php'">No me gusta</button>
                    <?php endif ?>
                    <a>Número de vistas: <?php echo $resultadoVideo[0]['n_vistas'] ?></a>
                </div>


            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->



<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="toggle.js"></script>
<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
-->
</body>
</html>