<?php
if (isset($_SESSION['datosvector']) && $_SESSION['datosvector']) {
?>
    <html>    
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">            
            <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
            <script src="js/jquery-1.12.4.js"></script>
            <!--libreria jquery
            <script src="js/jquery.js" type="text/javascript"></script>-->
            <!--libreria AUTOCOMPLETE COMBO-->
            <script src="js/core.js" type="text/javascript"></script>
            <script src="js/jquery.easy-autocomplete.min.js" type="text/javascript"></script>
            <link href="css/easy-autocomplete.min.css" rel="stylesheet" type="text/css"/>
            <!--termina prueba-->
            <!--css de jquery ui -->
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <!--Estilos de css personalizados-->
            <link href="css/menucss.css" rel="stylesheet" type="text/css"/>
            <!--Estilos de bootstrap-->
            <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
            <!--js de jquery ui por medio de CDN-->
           <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
             <script src="js/jquery-ui.js"></script>
            <!--js personalizado-->
            <script src="js/javascript-jquery.js" type="text/javascript"></script>
            <!--js de bootstrap-->
            <script src="js/bootstrap.min.js" type="text/javascript"></script>
            <!--Font Awesome inserta los iconos -->
            <script src="https://use.fontawesome.com/033bcd6d1a.js"></script>
            <!--SmartMenus jQuery plugin para el menú principal-->
            <script src="js/jquery.smartmenus.js" type="text/javascript"></script>
            <script src="js/jquery.smartmenus.bootstrap.js" type="text/javascript"></script>
            <!--DATATABLE-->
            <script src="js/jquery.dataTables.js" type="text/javascript"></script>
            <link href="js/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
            <!--FIN DATATABLE-->
            <!--Jquery ui, quitar en caso de que no funcione, es solo prueba-->
            <script src="js/jquery-ui.js" type="text/javascript"></script>
            <script src="js/jquery-ui.min.js" type="text/javascript"></script>
            <script src="js/jquery-ui-1.9.2.custom.min.js" type="text/javascript"></script>
            <!--FIN JQUERY ui-->
            <!--Librearias para adjuntar fotografias-->
            <link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css">
            <script src="js/fileinput.js" type="text/javascript"></script>
            <!--logo encabezado-->
            <link href="images/segescot.png" rel="icon" type="image/png">
        </head>  
        <body id="body-style" style="background-repeat: no-repeat; background-position:center center; width: 100%; background-size: cover; background-color: rgba(214,222,222);">
            <!-- Navbar -->
            <div class="navbar navbar-inverse" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Segescot</a>
                </div>
                <div class="navbar-collapse collapse">
                    <!-- Left nav -->
                    <ul class="nav navbar-nav">
                        <li><a href="#">Cliente<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="index.php?controller=Cliente&action=crearcliente">Crear</a></li>
                                <li><a href="index.php?controller=Cliente&action=consultarcliente">Mostrar todo</a></li>
                            </ul>
                        </li>
                        <!--
                        <li><a href="#">Despacho<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="index.php?controller=Despacho&action=indexcrear">Crear</a></li>
                                <li><a href="index.php?controller=Despacho&action=consultardespacho">Mostrar todo</a></li>
                            </ul>
                        </li>-->
                        <li><a href="#">Cotizaciones<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="index.php?controller=Cotizacion&action=index">Crear</a></li>
                                <li><a href="index.php?controller=Cotizacion&action=consultarcotizacion">Mostrar todo</a></li>
                                <li><a href="index.php?controller=Seguimiento&action=consultarseg">Mostrar seguimientos</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Cliente potencial<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="index.php?controller=cliente&action=index3">Crear y consultar</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- Right nav -->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="#">Producto<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Crear</a><span class="caret"></span>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="index.php?controller=Producto&action=index">Producto</a></li>
                                        <li><a href="index.php?controller=categoria&action=crearcategoria">Categoría</a></li>
                                    </ul>
                                </li>
                                <li><a href="index.php?controller=Producto&action=consultarproducto">Mostrar todo</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Proveedor<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="index.php?controller=Proveedor&action=index">Crear</a></li>
                                <li><a href="index.php?controller=Proveedor&action=consultarproveedor">Mostrar todo</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Contacto<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="index.php?controller=Contacto&action=index">Crear</a></li>
                                <li><a href="index.php?controller=Contacto&action=consultarcontacto">Mostrar todo</a></li>
                            </ul>
                        </li>
						<li><a href="#">Más<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
				<li><a href="index.php?controller=Usuario&action=registrarUsuario">Administrar usuarios</a></li>
                                <li><a href="index.php?controller=Reportes&action=mostrarReportes">Reportes</a></li>
                                <?php
                                if($_SESSION['tipo'] == "6"){
                                    
                               
                                ?>
                                <li><a href="index.php?controller=Reportes&action=mostrarReportesSistema">Reportes Sistema</a></li>
                                    <?php
                                     }
                                     
                                     ?>
								<li><a href="index.php?controller=Producto&action=CargaMasivaView">Carga masiva</a></li>
                                <li><a href="index.php?controller=Login&action=logout">Cerrar sesión</a></li>
                                  
                                
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!--menu desplegable Horizonal-->

            <div id="nombreusuario" class="col-xs-7 col-xs-offset-3 col-lg-3 col-lg-offset-5">
                <?php
                if (isset($_SESSION['nombre'])) {
                    echo $_SESSION['nombre'] . "  " . "  " . '<i class="fa fa-user-circle" aria-hidden="true"></i>';
                }
              
                ?>
            </div>            
            <!--<div id="vertical" class="container col-lg-2">
                <br>
                <ul id="navigation">
                <li class="servicioalcliente"><a id="Servicioalcliente" href="index.php?controller=Serviciocliente&action=consultarservicios" title="Servicio al cliente"><span>Servicio al cliente  <i class="fa fa-users" style="font-size:1px;"></i></span></a></li>
                    <li class="usuario"><a href="index.php?controller=Usuario&action=registrarUsuario" title="Administrar Usuario"><span>Administrar Usuario  <i class="fa fa-user-circle-o"></i></span></a></li>
                    <li class="cerrarsesion"><a id="movercerrar" href="index.php?controller=Login&action=logout" title="Contact"><span>Cerrar Sesión<i class="fa fa-sign-out"></i></span></a></li>
                </ul>
            </div> -->
            <?php
            require_once 'view/' . $vista . 'View.php';
            ?>      
        </body> 
        <?php
    } else {
      
     
      /*echo"<div class = 'well'>
        <div class = 'col-xs-12 col-lg-12 text text-center text-danger'>Sesión expirada</div>
        </div>
        </html>";*/
        $this->redirect("Login", "login");
    }
    ?>
    