<html>
    <head>
        <title>Modificar Producto</title>
    </head>
    <body>

        <!--Editar-->        
        <div class="container col-lg-6 col-lg-offset-3">
            <form id="editarprod" method="POST" action="<?php echo 'index.php?controller=Proveedor&action=modificarbd'; ?>">
                <h1>Editar Proveedor</h1>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Nit</h4>
                    <input class="form-control" type="text" name="pro_nit" disabled value="<?php echo $valor->pro_nit; ?>">
                    <input class="form-control" type="hidden" name="pro_nit" value="<?php echo $valor->pro_nit; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Nombre</h4>
                    <input  type="text" class="form-control" name="pro_Nombre"  value="<?php echo $valor->pro_Nombre; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Pagina Web</h4>
                    <input  type="text" class="form-control" name="pro_paginaWeb"  value="<?php echo $valor->pro_paginaWeb; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Email</h4>
                    <input  type="text" class="form-control" name="pro_emailEmpresa"  value="<?php echo $valor->pro_emailEmpresa; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Dirección</h4>
                    <input type="textarea" class="form-control" name="pro_direccion"  value="<?php echo $valor->pro_direccion; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Telefono</h4>
                    <input type="textarea" class="form-control" name="pro_telefono"  value="<?php echo $valor->pro_telefono; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Pais</h4>
                    <input type="textarea" class="form-control" name="pro_pais"  value="<?php echo $valor->pro_pais; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Ciudad</h4>
                    <input type="textarea" class="form-control" name="pro_ciudad"  value="<?php echo $valor->pro_ciudad; ?>">
                </div>
                <div class="col-xs-12 col-xs-offset-1 col-lg-5 form-group" style="margin-top: 10px;">
                    <input value="Guardar" class="col-lg-8 btn btn-success col-lg-offset-2" type="submit"/>
                </div>
            </form>

            <div class="col-xs-12 col-xs-offset-1 col-lg-5" style="margin-top: 10px;">
                <form  id="editarproveedor" method="POST" action="<?php echo 'index.php?controller=Proveedor&action=volverproveedor'; ?>">
                    <input class="btn btn-primary col-lg-8" value="volver" type="submit"/>
                </form>
            </div>
        </div>
    </body>
</html>

