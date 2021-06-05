<link rel="stylesheet" href="css/themes/pace-theme-center-circle.css"/>
<script data-pace-options='{"ghostTime": 2000}' src="js/pace.js"/></script>

<div id="tabs" class="col-lg-12 well frmscroll">
    <ul class="list-inline">
        <li><a href="#tabs-1" id="tabsquery">Información de contacto</a></li>
        <li><a href="#tabs-2" id="tabsquery2" >Cotizar</a></li>
        <li><a href="#tabs-3" id="tabsquery3" >Cotización</a></li>
    </ul>
    <div id="tabs-1" class="container col-lg-10 col-lg-offset-2 col-xs-10 col-xs-offset-2">
        <form method="POST" action="<?php echo "index.php?controller=Cotizacion&action=crear"; ?>">
            <div class="divcontorno col-xs-12 col-xs-offset-2 col-lg-10" tabindex="0" data-toggle="tooltip" data-placement="right" title="Código de cotización">
                <input type="hidden" class="form-control"  name='cot_codigoCotizacion' value="<?php
                if ($ultcod != "") {
                    foreach ($ultcod as $cat) {
                        if ($cat->valor == "") {
                            echo "1";
                        } else {
                            echo $cat->valor;
                        }
                    }
                } else {
                    echo "1";
                }
                ?>"  />

                <input type="text" id="codigocotizacion" class="form-control codigocoti"  value="<?php
                if ($ultcod != "") {
                    foreach ($ultcod as $cat) {

                        if ($cat->valor == "") {
                            echo "1";
                        } else {

                            echo $cat->valor;
                        }
                    }
                } else {
                    echo "1";
                }
                ?>" disabled>
            </div>
            <div class="divcontorno col-xs-12 col-lg-10" tabindex="0" data-toggle="tooltip" title="Tipo de cotización" required>
                <select class="form-control" name='cot_tipocotizacion'>
                    <option value='Licitacion'>Licitacion</option>
                    <option value='Cotizacionacliente'>Cotizacion a cliente</option>
                </select>
            </div>
            <div class="divcontorno col-xs-12 col-lg-10"><input type="number" class="form-control" name="cot_validez" placeholder="Validez cotización (días)" tabindex="0" data-toggle="tooltip" title="Validez cotización" required></div>
            <div class="divcontorno col-xs-12 col-lg-10"><input type="number" class="form-control" name="cot_tiempoEntrega" placeholder="Tiempo de entrega(días)" tabindex="0" data-toggle="tooltip" title="Tiempo de entrega" required></div>
            <div class="divcontorno col-xs-12 col-lg-10"><input type="text" class="form-control" name="cot_lugarEntrega" placeholder="Lugar de entrega" tabindex="0" data-toggle="tooltip" title="Lugar de entrega" required></div>
            <div class="divcontorno col-xs-12 col-xs-offset-2 col-lg-10"><input type="text" class="form-control" name="cot_formaPago" placeholder="Forma de pago" tabindex="0" data-toggle="tooltip" title="Forma de pago" required></div>
            <div class="divcontorno col-xs-12 col-lg-10"><input type='date' class="form-control datepicker" name="cot_fechaCotizacion" placeholder="Fecha vencimiento" tabindex="0" data-toggle="tooltip" title="Fecha de vencimiento" required></div>
            <div class="divcontorno col-xs-12 col-lg-10">
                <input id = "inputOne" placeholder = "Nombre contacto" tabindex="0" data-toggle="tooltip" title="Nombre de contacto" required/>
                <input type="hidden" class="form-control" id="input2" name='con_codigo' placeholder = "Documento"/>
            </div>
            <div class="col-xs-10 col-xs-offset-2 col-lg-10"><br><input type="submit" class="btn btn-primary col-xs-10 col-lg-6 col-lg-offset-1" value="Crear"></div>
        </form>
    </div>
    <!--Busqueda cotizacion-->
    <div id="tabs-2" >
        <table id="tablacotizaciones" class="display col-lg-12">
            <tfoot>
                <tr>
                    <td></td>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Proveedor</th>
                    <td>Costo</td>
                    <th>Categoría</th>
                    <td>Porcentaje ganancia (%)</td>
                    <td>Precio Fijo</td>
                    <td></td>
                    <td>Cantidad</td>
                    <td>Acción</td>
                </tr>
            </tfoot>
        </table>


    </div>
    <div id="tabs-3" >
        <div class="col-lg-12">
            <div class="col-lg-12 ">
                <div class="form-group"><h4>Cargar cotizacion</h4></div>
            </div>
            <div class="col-lg-6">
                <div class="col-lg-10"><input type="text" id="codigocotizacioncargar" class="form-control codigocotizacioncargar" name="cot_codigoCotizacion" placeholder="Coloque aquí el código de su cotización"></div>
                <div class="col-lg-2"><button class="btn btn-danger btn-sm" id="cargarcotizacion">Cargar cotización</button></div>
            </div>
            <div class="col-xs-2 col-xs-offset-1">
                <a href ="index.php?controller=Cotizacion&action=reportexcel" target="_blank" class="btn btn-success">Generar excel <i class="glyphicon glyphicon-file"></i></a>
            </div>
            <div class="col-lg-12 col-lg-offset-4"><h3>Productos cotizados</h3></div>
            <br>
            <table id="cotizadorfinal" class="table table-striped">
                <tr>
                    <th class="tablacotfinal col-lg-2">Producto</th>
                    <th class="tablacotfinal col-lg-2">Precio de venta sin iva</th>
                    <th class="tablacotfinal col-lg-1">Presentación</th>
                    <th class="tablacotfinal col-lg-2">Cantidad</th>
                    <th class="tablacotfinal col-lg-2">Iva</th>
                    <th class="tablacotfinal col-lg-2">Acción</th>

                </tr>
                <tr>
                    <td id="productoclass" class="col-lg-2"></td>
                    <td id="precioclass" class="col-lg-2"></td>
                    <td id="presentacionclass" class="col-lg-1"></td>
                    <td id="cantidadclass" class="col-lg-2"></td>
                    <td id="ivaclass" class="col-lg-2"></td>
                    <td id="accion" class="col-lg-2"></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!--Modal para acpetar agregar producto -->
<?php
echo "
             <div class='modal fade' id='ModalAceptarAggPro' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
             <div class='modal-dialog modal-md'>
             <div class='modal-content'>
             <div class='modal-header bg-green'>    
             <h3 class='col-lg-8 col-lg-offset-2'>Este producto ya existe ¿Está seguro que desea agregarlo?</h3>
             
             <a style='margin-top:20px' id='btnagregarcoti' data-id='' data-dismiss='modal' class='btn btn-danger col-lg-4 col-lg-offset-1'>Agregar</a>
             <a style='margin-top:20px' class='btn btn-info col-lg-4 col-lg-offset-2' data-dismiss='modal'>Cancelar</a>
             </div>
             </div>
             </div>
             </div>";
?>