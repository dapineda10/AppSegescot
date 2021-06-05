<!--Layout del menú principal de usuarios-->
<html>
    <head>
        <title>User</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/menucss.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/jquery.js" type="text/javascript"></script>
        <script src="js/javascript-jquery.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!--Font Awesome para insertar iconos desde internet -->
        <!--<script src="https://use.fontawesome.com/033bcd6d1a.js"></script>-->
    <noscript><h1>Debes activar el uso de JavaScript para que puedas ver todo el contenido</h1></noscript> 
</head>
<body>
    <div class="container col-lg-12 ">
        <div class="col-lg-offset-10 glyphicon glyphicon-user ">
            <?php
            if (isset($_SESSION['nombre'])) {
                echo $_SESSION['nombre'] . "  " . "  " . '<i class="fa fa-user-circle" aria-hidden="true"></i>';
            }
            ?>
        </div>

        <div class="row">
            <div class="col-xs-5 col-md-2" ><img src="images/segescott.png" alt=""/></div>
            <div class="col-lg-9" style="margin-top: 60px">
                <ul class="nav nav-pills nav-justified" >
                    <li class="active "><a href="index.php?controller=User_login&action=inicio" class="glyphicon glyphicon-home"></a></li>
                    <li><a href="index.php?controller=Cliente&action=perfil">Perfil</a></li>
                    <li><a href="#">Productos</a></li>
                    <li class="dropdown">
                    <li> <a href="index.php?controller=User_login&action=logoutsesion"><div class=" glyphicon glyphicon-off"></div></a></li>
                    </li>
                </ul>
            </div> 
        </div>
    </div>
    <div class="col-md-2" style=" margin-top: 70px">
        <ul class="nav nav-pills nav-stacked ">
            <li><a href="index.php?controller=Serviciocliente&action=index"><i class="fa fa-list-alt fa-fw"></i>Servicio al cliente</a></li>
            <li class=""><a href=""><i class="fa fa-list-alt fa-fw"></i>Mis Contactos</a></li>
        </ul>
    </div>

    <?php
    require_once 'view/' . $vista . 'View.php';
    ?> 
</body>
</html>


