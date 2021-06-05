<html>
    <head>
        <title>Modificar despacho</title>
    </head>
    <body>

        <!--Editar-->        
        <div class="container well col-lg-6 col-lg-offset-3">
            <form id="editardespacho" method="POST" action="<?php echo 'index.php?controller=Despacho&action=modificarbd'; ?>">
                <h1>Edite su Despacho</h1>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Codigo despacho</h4>
                    <input  type="text" disabled class="form-control" name="des_CodigoDespacho" id="des_CodigoDespacho">
                    <input  type="hidden" class="form-control" name="des_CodigoDespacho"  id="des_CodigoDespacho">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Fecha de envío</h4>
                    <input class="form-control" type="text" name="des_FechaEnvio" value="<?php echo $valor->des_FechaEnvio; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Transportadora</h4>
                    <input  type="text" class="form-control" name="des_Transportadora"  value="<?php echo $valor->des_Transportadora; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Observaciones</h4>
                    <input  type="text" class="form-control" name="des_ObservacionesEnvio"  value="<?php echo $valor->des_ObservacionesEnvio; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Orden de compra o contrato</h4>
                    <input type="textarea" class="form-control" name="des_Contrato_Oc"  value="<?php echo $valor->des_Contrato_Oc; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Número de guía</h4>
                    <input type="textarea" class="form-control" name="des_NumeroGuia"  value="<?php echo $valor->des_NumeroGuia; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Cantidad de cajas</h4>
                    <p>*Solo datos númericos</p>
                    <input type="textarea" class="form-control" name="des_CantidadCajas"  value="<?php echo $valor->des_CantidadCajas; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Número de factura</h4>
                    <input type="textarea" class="form-control" name="des_Numfactura"  value="<?php echo $valor->des_Numfactura; ?>">
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">
                    <h4>Cedula o Nit de cliente</h4>

                    <select name="cli_documento" value="<?php echo $valor->cli_documento; ?>" class="form-control selcls">
                        <?php
                        //var_dump($allusers);
                        if ($allclient != "") {
                            foreach ($allclient as $item) {
                                if ($valor->cli_documento != $item->cli_documento) {
                                    echo "<option value='$item->cli_documento'>$item->cli_nombre</option>";
                                } else {
                                    echo "<option value='$item->cli_documento' selected>$item->cli_nombre</option>";
                                }
                            }
                        }
                        ?>
                    </select>                   
                </div>
                <div class="form-group col-lg-10 col-lg-offset-1">    
                    <h4>Usuario quien realiza despacho</h4>
                    <select name="usu_documento" value="<?php echo $valor->usu_documento; ?>" class="form-control selcls">
                        <?php
                        //var_dump($allusers);
                        if ($allusuario != "") {
                            foreach ($allusuario as $item) {
                                if ($valor->usu_documento != $item->usu_documento) {
                                    echo "<option value='$item->usu_documento'>$item->usu_nombre</option>";
                                } else {
                                    echo "<option value='$item->usu_documento' selected>$item->usu_nombre</option>";
                                }
                            }
                        }
                        ?>
                    </select>                    
                </div>
                <div class="col-xs-12 col-xs-offset-1 col-lg-5 form-group" style="margin-top: 10px;">
                    <input value="Guardar" class="col-lg-8 btn btn-success col-lg-offset-2" type="submit"/>
                </div>
            </form>

            <div class="col-xs-12 col-xs-offset-1 col-lg-5" style="margin-top: 10px;">
                <form  id="editardespacho" method="POST" action="<?php echo 'index.php?controller=Despacho&action=volverdespacho'; ?>">
                    <input class="btn btn-primary col-lg-8" value="volver" type="submit"/>
                </form>
            </div>
        </div>
    </body>
</html>

