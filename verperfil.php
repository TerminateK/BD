<?php
include_once 'Conexion.php';
session_start();

$idcuenta = $_GET["id_cuenta"];
$seguidores = 'select p as id, num as n from (select @p1:='.$idcuenta.' p) parm , bd.n_seguidores;';
$nseg = $pdo->prepare($seguidores);
$nseg->execute();
$Rnseg = $nseg->fetchAll();

$cuent = 'SELECT * FROM bd.cuenta WHERE id_cuenta = '.$idcuenta.'';
$cuen = $pdo->prepare($cuent);
$cuen->execute();
$cuenta = $cuen->fetchAll();

$per = 'SELECT * FROM bd.cuenta, bd.persona WHERE cuenta.id_cuenta = '.$idcuenta.' AND cuenta.id_persona = persona.id_persona';
$pers = $pdo->prepare($per);
$pers->execute();
$persona = $pers->fetchAll();

$sig = 'SELECT * FROM bd.seguidos where '.$_SESSION['ID_Cuenta'].' = seguidos.id_cuenta_seguidor and '.$idcuenta.' = seguidos.id_cuenta_seguida';
$sigu = $pdo->prepare($sig);
$sigu->execute();
$sigue = $sigu->fetchAll();


$video = 'SELECT * FROM bd.video WHERE video.id_cuenta = '.$idcuenta.' ';
$mivideo = $pdo->prepare($video);
$mivideo->execute();
$resultadoVideo = $mivideo->fetchAll();

$list = 'SELECT * FROM bd.lista_reproduccion WHERE lista_reproduccion.id_cuenta = '.$idcuenta.' ';
$lista = $pdo->prepare($list);
$lista->execute();
$listaVideo = $lista->fetchAll();


$segui = 'SELECT * FROM `bd`.`seguidos`, bd.cuenta WHERE bd.seguidos.id_cuenta_seguidor = '.$idcuenta.' and bd.cuenta.id_cuenta = bd.seguidos.id_cuenta_seguida ';
$seguid = $pdo->prepare($segui);
$seguid->execute();
$seguidos = $seguid->fetchAll();


if(isset($_GET['seguir'])) {
    $seguir = $_GET['seguir'];
    if ($seguir == 1) {
        $insertar = 'INSERT INTO bd.seguidos (id_cuenta_seguidor, id_cuenta_seguida) VALUES ('.$_SESSION['ID_Cuenta'].', '.$idcuenta.')';
        $insert = $pdo->prepare($insertar);
        $insert->execute();
        header("Location: verperfil.php?id_cuenta=$idcuenta");

    }
    else {
        $del = 'DELETE FROM bd.seguidos WHERE seguidos.id_cuenta_seguidor = '.$_SESSION['ID_Cuenta'].' and seguidos.id_cuenta_seguida ='.$idcuenta.'';
        $delete = $pdo->prepare($del);
        $delete->execute();
        header("Location: verperfil.php?id_cuenta=$idcuenta");

    }

}



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
                    <a class="nav-link" aria-current="page" href="Index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tendencias.php">Tendencias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link enabled" href="subir_imagen.php" tabindex="-1" aria-disabled="false">Subir video</a>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['ID_Cuenta'])): ?>

                        <a class="nav-link enabled" href="crear_lista.php" tabindex="-1" aria-disabled="false">Crear Lista</a>
                    <?php else: ?>
                        <a class="nav-link enabled" href="login.php" tabindex="-1" aria-disabled="false">Inicie sesión para crear lista</a>
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

            <?php if(isset($_SESSION['ID_Cuenta'])): ?>
                <li class="dropdown">
                    <a href="mostrarlistas.php?id_cuenta=<?php echo $_SESSION['ID_Cuenta'] ?>" class="dropdown-toggle"  data-toggle="dropdown"> Listas de reproducción <span class="caret"></span></a>
                </li>
            <?php endif ?>
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
            <div class="row">
                <div class="col-12">
                    <h1>Perfil</h1>

                    <div class="container">
                        <div class="content">
                            <div class="profile-header">
                                <div class="profile-header-cover"></div>
                                <div class="profile-header-content">
                                    <div class="profile-header-img">
                                    </div>
                                    <div class="profile-header-info">
                                        <h4 class="m-t-sm"> <?php echo $cuenta[0]['username'] ?> </h4>

                                        <?php if($_SESSION['Tipo_Persona'] == 1): ?>
                                            <p style="color:black;" style="text-align:center">Tipo: Ciudadano</p>
                                        <?php  elseif( $_SESSION['Tipo_Persona'] == 2 ): ?>
                                            <p style="color:black;" style="text-align:center">Tipo: Heroe</p>
                                        <?php else: ?>
                                            <p style="color:black;" style="text-align:center">Tipo: Villano</p>
                                        <?php endif ?>
                                        <p class="m-b-sm">
                                            <?php if($cuenta[0]['tipo_cuenta'] == 0): ?>
                                                <p style="color:black;" style="text-align:center">Cuenta normal</p>
                                            <?php else: ?>
                                                <p style="color:black;" style="text-align:center">Creador de contenido</p>
                                            <?php endif ?>
                                        </p>
                                        <p>Seguidores: <?php echo $Rnseg[0]["n"] ?> </p>
                                        <?php if($_SESSION['ID_Cuenta'] != $idcuenta): ?>

                                            <?php if($sigue == null): ?>
                                                <button type="button" class="btn btn-success" onClick="location.href='verperfil.php?id_cuenta=<?php echo $idcuenta ?>&seguir=1'">Seguir</button>


                                            <?php else: ?>
                                                <button type="button" class="btn btn-success" onClick="location.href='verperfil.php?id_cuenta=<?php echo $idcuenta ?>&seguir=2'">Dejar de seguir</button>
                                            <?php endif ?>

                                        <?php else: ?>
                                            <?php echo "Este es tu perfil!" ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <?php if($cuenta[0]['tipo_cuenta'] == 1): ?>

                            <h5 class="card-header">Videos</h5>
                            <div class="card-body">

                                <div class="row" >
                                    <div class="col-1"> </div>
                                    <?php foreach ($resultadoVideo as $dato): ?>
                                        <div class="col-2">
                                            <img class="card-img-top" src="data:image/jpg;base64,<?php echo base64_encode($dato['img']) ?>" alt="Card image cap">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo $dato['titulo'] ?></h5>
                                                    <p class="card-text"><?php echo $dato['descripcion'] ?></p>
                                                    <a href="display_video.php?id_video=<?php echo $dato['id_video']?>" class="btn btn-primary">Ver video</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <h1>No posee videos</h1>
                        <?php endif ?>
                    </div>
                    <div class="card">
                        <?php if($listaVideo == null): ?>
                            <h1>No posee listas de reproduccion</h1>

                        <?php else: ?>
                            <h5 class="card-header">Listas de reproduccion</h5>


                            <div class="card-body">
                                <div class="row" >
                                    <div class="col-1"> </div>
                                    <?php foreach ($resultadoVideo as $dato): ?>
                                        <div class="col-2">
                                            <img class="card-img-top" src="data:image/jpg;base64,<?php echo base64_encode($dato['img']) ?>" alt="Card image cap">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo $dato['titulo'] ?></h5>
                                                    <p class="card-text"><?php echo $dato['descripcion'] ?></p>
                                                    <a href="display_video.php?id_video=<?php echo $dato['id_video']?>" class="btn btn-primary">Ver video</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif ?>

                    </div>

                    <div class="card">
                        <?php if($seguidos == null): ?>
                            <h1>No sigue a nadie</h1>
                        <?php else: ?>
                            <h5 class="card-header">Seguidos</h5>
                            <div class="card-body">
                                <div class="row" >
                                    <div class="col-1"> </div>
                                    <?php foreach ($seguidos as $dato): ?>
                                        <div class="col-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 href="verperfil.php?id_cuenta=<?php echo $dato['id_cuenta']?>" class="card-title"><?php echo $dato['username'] ?></h5>
                                                    <?php if($_SESSION['Tipo_Persona'] == 1): ?>
                                                        <p style="color:black;" style="text-align:center">Tipo: Ciudadano</p>
                                                    <?php  elseif( $_SESSION['Tipo_Persona'] == 2 ): ?>
                                                        <p style="color:black;" style="text-align:center">Tipo: Heroe</p>
                                                    <?php else: ?>
                                                        <p style="color:black;" style="text-align:center">Tipo: Villano</p>
                                                    <?php endif ?>

                                                    <a href="verperfil.php?id_cuenta=<?php echo $dato['id_cuenta']?>" class="btn btn-primary">Ver perfil</a>





                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif ?>

                    </div>

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