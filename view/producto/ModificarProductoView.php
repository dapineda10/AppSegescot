<html>
    <head>
        <title>Modificar despacho</title>
    </head>
    <body>

        <!--Editar-->        
        <div class="container well col-lg-6 col-lg-offset-3">
            <form id="editarprod" method="POST" action="<?php echo 'index.php?controller=Producto&action=modificarbd'; ?>">
                <h1>Editar Producto</h1>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Codigo</h4>
                    <input class="form-control" type="text" name="prd_codigoProducto" disabled value="<?php echo $valor->prd_codigoProducto; ?>">
                    <input class="form-control" type="hidden" name="prd_codigoProducto" value="<?php echo $valor->prd_codigoProducto; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Categoría</h4>
                    <select name="cat_idCategoria" value="<?php echo $valor->cat_idCategoria; ?>" class="form-control selcls">
                        <?php
                        //var_dump($allusers);
                        if ($allcategoria != "") {
                            foreach ($allcategoria as $item) {
                                if ($valor->cat_idCategoria != $item->cat_idCategoria) {
                                    echo "<option value='$item->cat_idCategoria'>$item->cat_nombre</option>";
                                } else {
                                    echo "<option value='$item->cat_idCategoria' selected>$item->cat_nombre</option>";
                                }
                            }
                        }
                        ?>
                    </select>                   
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Nit Proveedor</h4>
                    <input  type="text" class="form-control" name="pro_nit"  value="<?php echo $valor->pro_nit; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Divisa</h4>
                    <input  type="text" class="form-control" name="prd_tipoDivisa"  value="<?php echo $valor->prd_tipoDivisa; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Costo</h4>
                    <p>*Solo datos númericos</p>
                    <input type="textarea" class="form-control" name="prd_costo"  value="<?php echo $valor->prd_costo; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Tipo De Presentación</h4>
                    <input type="textarea" class="form-control" name="prd_tipoPresentacion"  value="<?php echo $valor->prd_tipoPresentacion; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Nombre Del Producto</h4>
                    <input type="textarea" class="form-control" name="prd_nombre"  value="<?php echo $valor->prd_nombre; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Descripción</h4>
                    <input type="textarea" class="form-control" name="prd_descripcion"  value="<?php echo $valor->prd_descripcion; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Foto</h4>
                    <input type="textarea" class="form-control" name="prd_foto"  value="<?php echo $valor->prd_foto; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Iva</h4>
                    <p>*Solo datos númericos</p>
                    <input type="textarea" class="form-control" name="prd_iva"  value="<?php echo $valor->prd_iva; ?>">
                </div>
                <div class="col-xs-12 col-xs-offset-1 col-lg-5 form-group" style="margin-top: 10px;">
                    <input value="Guardar" class="col-lg-8 btn btn-success col-lg-offset-2" type="submit"/>
                </div>
            </form>

            <div class="col-xs-12 col-xs-offset-1 col-lg-5" style="margin-top: 10px;">
                <form  id="editarproducto" method="POST" action="<?php echo 'index.php?controller=Producto&action=volverproducto'; ?>">
                    <input class="btn btn-primary col-lg-8" value="volver" type="submit"/>
                </form>
            </div>
        </div>
    </body>
</html>

