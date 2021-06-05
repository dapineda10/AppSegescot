<div id="tabs" class="col-lg-10 well">
    <ul class="list-inline">
        <li><a href="#tabs-1" id="tabsquery">Información de despacho</a></li>
        <li><a href="#tabs-2" id="tabsquery2" >Productos</a></li>
        <li><a href="#tabs-3" id="tabsquery3" >Despachar</a></li>
    </ul>

    <div id="tabs-1" class="container col-xs-12 col-xs-offset-1 col-lg-10 col-lg-offset-1 frmscroll">
        <h1 class="col-lg-12">Nuevo despacho</h1>
        <form method="POST" action="index.php?controller=Despacho&action=creardespacho">
            <?php
            $valor = new Despacho($this->adapter);
            $datos = $valor->getAll();
            if (isset($datos)) {
                foreach ($datos as $despacho) {
                    $des_CodigoDespacho = isset($despacho->des_CodigoDespacho) ? $despacho->des_CodigoDespacho : "";
                }
            }
            ?>
            <div class="col-xs-10 col-lg-10"><h4>Cod. Despacho:</h4></div>
            <div class="col-xs-10 col-lg-10"><input type="text" class="form-control" value="<?php
                                                    $codigo = $despacho->des_CodigoDespacho + 1;
                                                    echo $codigo;
                                                    ?>" name="des_CodigoDespacho" disabled></div>
            <div class="col-xs-10 col-lg-10"><h4>Fecha:</h4></div>
            <div class="col-xs-10 col-lg-10"><input class="form-control" type="date" name="des_FechaEnvio"></div>
            <div class="col-xs-10 col-lg-10"><h4>Transportadora:</h4></div>
            <div class="col-xs-10 col-lg-10"><input type="text" class="form-control" name="des_Transportadora"></div>    
            <div class="col-xs-10 col-lg-10"><h4>Orden/contrato:</h4></div>
            <div class="col-xs-10 col-lg-10"><input type="text" class="form-control" name="des_Contrato_Oc"></div>
            <div class="col-xs-10 col-lg-10"><h4>N° Guía:</h4></div>
            <div class="col-xs-10 col-lg-10"><input type="text" class="form-control"  name="des_NumeroGuia"></div>
            <div class="col-xs-10 col-lg-10"><h4>Cant. Cajas:</h4></div>
            <div class="col-xs-10 col-lg-10"><input type="text" class="form-control"  name="des_CantidadCajas"></div>
            <div class="col-xs-10 col-lg-10"><h4>N° Factura:</h4></div>
            <div class="col-xs-10 col-lg-10"><input type="text" class="form-control" name="des_Numfactura"></div>
            <div class="form-group">
                <div class="col-xs-10 col-lg-10"><h4>Cliente:</h4></div>
                <div class="col-xs-10 col-lg-10">
                    <select name="cli_documento" class="form-control selcls">
                        <?php
                        //var_dump($allusers);
                        if ($allusers != "") {
                            foreach ($allusers as $item) {
                                echo "<option value='$item->cli_documento'>$item->cli_nombre</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-10 col-lg-10"><h4>Quién realiza el despacho:</h4></div>
                <div class="col-xs-10 col-lg-10">
                    <select class="form-control selcls" name="usu_documento">
                        <?php
                        //var_dump($allusers);
                        if ($allusuario != "") {
                            foreach ($allusuario as $usu) {
                                echo "<option value='$usu->usu_documento'>$usu->usu_documento</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-10 col-lg-10"><h4>Observaciones:</h4></div>
                <div class="col-xs-10 col-lg-10"><textarea class="form-control" type="textarea" name="des_ObservacionesEnvio"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class ="col-xs-10 col-lg-6 col-lg-offset-2"><input class="btn btn-success col-lg-12" type="submit" name="enviarcrear" ></div>
            </div>
        </form>
    </div>
    <div id="tabs-2" >
        <table id="tabladespachos" class="display col-lg-12">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Presentación</th>
                    <th>Numero de cajas</th>
                    <th>Tiempo garantia</th>                     
                    <th>Cantidad</th>
                    <th>Acción</th>
                </tr>
            </thead>
        </table>

    </div>
    <div id="tabs-3" >
        <table id="tabladespachos2" class="display col-lg-12">
            <thead>
                <tr>
                    <th>Codigo despacho</th>
                    <th>Producto</th>
                    <th>Numero de cajas</th>
                    <th>Tiempo garantia</th>                    
                    <th>Cantidad</th>
                </tr>
            </thead>
        </table>

    </div>
</div>