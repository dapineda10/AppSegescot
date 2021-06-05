<div id="tabs" class="col-lg-12 well frmscroll">
    <ul class="list-inline">
        <li><a href="#tabs-1" id="tabsquery">Cotizaciones vendidas o cerradas</a></li>
        <li><a href="#tabs-2" id="tabsquery2" >Cotizaciones pendientes por cerrar</a></li>
    </ul>
    <div id="tabs-1" class="container col-lg-10 col-lg-offset-1">
        <!--Este formulario permite mostrar todas las cotizaciones creadas, cerradas o vendidas-->
        <div><h2 class="col-lg-offset-2">Consultar cotización</h2></div>
        <div class="col-lg-10 col-lg-offset-1">
            <table id="tablacotizaciones1" class="well display col-lg-8">
                <thead>
                    <tr>
                        <th>Código cotización</th>
                        <th>Lugar de entrega</th>
                        <th>Nombre cliente</th>
                        <th>Fecha vencimiento</th>
                        <th>Estado</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <th>Seguimiento</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    
    <!--Esta lista muestra todas las cotizaciones pendientes por cerrar-->
    <div id="tabs-2" class="container col-lg-10 col-lg-offset-1">
        <!--Este formulario permite mostrar todas las cotizaciones creadas y en el php hay otro formualrio-->
        <div class="col-lg-10 col-lg-offset-1">
            <table id="tablacotizaciones2" class="well display col-lg-8">
                <thead>
                    <tr>
                        <th>Código cotización</th>
                        <th>Lugar de entrega</th>
                        <th>Nombre cliente</th>
                        <th>Fecha vencimiento</th>
                        <th>Estado</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <th>Seguimiento</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
 <?php
        if (isset($mensajes)) {
            echo "
        <script>
        alert('Cotización editada con exito');
        </script>
        ";
        }
        echo "
            <div class='modal fade' id='myModalCotizacion' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-lg'>
             <div class='modal-content'>
               <div class='modal-header bg-green'>
            <h1 class ='modal-title' style='text-align:center'>Editar Cotización</h1><br>
            <form  id='editarcotizacion' method='POST' action='index.php?controller=Cotizacion&action=modificarbd';>
            <div class='form-group'>Codigo de Cotizacion</div>
            <div><input type='hidden' id='cot_codigoCotizacion' class='form-control codigocoti' name='cot_codigoCotizacion'></div>
            <div><input type='text' disabled id='cot_codigoCotizacion1' class='form-control codigocoti' name='cot_codigoCotizacion'></div>
            <br>
            <div class='form-group' class='col-lg-12'>Contacto(Lista desplegable)
            <input id = 'inputcontactoeditar' placeholder = 'Nombre contacto'/></div>
            <input type='hidden' class='form-control' id='inputcontactoeditar2' name='con_codigo' placeholder = 'Nit de proveedor'/>
            <div class='form-group'><p>Días de validez de la cotizacion</p></div>
            <div><input type='number' class='form-control' name='cot_validez' id='cot_validez'></div>
            <div class='form-group'><p>Tiempo de Entrega</p></div>
            <div><input type='number' class='form-control' name='cot_tiempoEntrega' id='cot_tiempoEntrega'></div>
            <div class='form-group'><p>Lugar de entrega</p></div>
            <div><input type='text' class='form-control' name='cot_lugarEntrega' id='cot_lugarEntrega'></div>
            <div class='form-group'><p>Forma de pago</p></div>
            <div><input type='text' class='form-control' name='cot_formaPago' id='cot_formaPago'></div>
            <div  class='form-group'><p>Fecha de vencimiento de cotizacion</p></div>
            <div><input type='date' class='form-control datepicker' name='cot_fechaCotizacion' id='cot_fechaCotizacion1'></div>
            <div  class='form-group'><p>Estado de cotización</p>
            <select class='form-control' name='cot_estadoventa' id='cot_estadoventaselect'>
            <option value='Pendiente'>Pendiente</option>
            <option value='Cerrada'>Cerrada</option>
            <option value='Vendida'>Vendida</option>
            </select>
            </div>
            <br>
            <input class='btn btn-success form-control' type='submit'>
            </form>
            </div>
                 </div>
                 </div>
                 </div>
                 </div>
        ";
        echo "
             <div class='modal fade' id='Modalborrarcotizacion' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
             <div class='modal-dialog modal-md'>
             <div class='modal-content'>
             <div class='modal-header bg-green'>    
             <h3 class='col-lg-12 col-lg-offset-2'>¿Está seguro qué desea eliminar?</h3>
             <input type='hidden' id='input_delete_cotizacion'></input>
             <a style='margin-top:20px' id='btneliminarContizacion' data-id='' class='btn btn-danger col-lg-4 col-lg-offset-1'>Eliminar</a>   
             <a style='margin-top:20px' class='btn btn-info col-lg-4 col-lg-offset-2' data-dismiss='modal'>Cancelar</a>
             </div>
             </div>
             </div>
             </div>";


//Seguimiento a cotizaciones        
        echo "
   <div class='modal fade' id='Modalseguimiento1' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
           <div class='modal-content'>
              <div class='modal-header bg-green'>
                 <h1 class ='modal-title col-md-offset-4 col-lg-offset-4 col-md-offset-4 col-lg-offset-4'>Crear seguimiento a cotización</h1><br>
     <form  id='seguimientocotizacion' method='POST' action='index.php?controller=Seguimiento&action=crearseguimiento';>
      <div class='col-md-4 col-lg-4'>
         <div class='col-md-6 col-lg-6 form-group'><p>Código de cotización</p></div>
         <div class='col-md-6 col-lg-6'>
         <input class='form-control' disabled name='cot_codigoCotizacion' id='cot_codigoCotizacionseguimiento'>
         <input type='hidden' class='form-control' name='cot_codigoCotizacion' id='cot_codigoCotizacionseguimiento1'>       
         <input type='hidden' class='form-control' name='usu_documento' id='usu_documentocrea'></input>
         </div>
      </div>
      <div class='col-md-8 col-lg-8'>
      <div class=' col-md-10 col-lg-10'>
       <div class='col-md-4 col-lg-4 form-group'><p>Fecha Compromiso</p></div>
       <div class='col-md-6 col-lg-6'><input type='date' class='form-control' name='seg_fechacompromiso' id='seg_fechacompromiso'></div>
      </div>
      </div>
      <div class='col-md-12 col-lg-12'>      
       <div class='col-md-2 col-lg-2 form-group'><p>Comentario</p></div>
       <div class='col-md-8 col-lg-8'><textarea  class='form-control' name='seg_comentario' id='seg_comentario'></textarea></div>
      </div>
      <div class='col-md-6 col-lg-6 col-md-offset-4 col-lg-offset-4'>
      <div class=' col-md-10 col-lg-'10>
      <br>
      <input class='btn btn-success form-control' type='submit'></div>
      </div>
      </div>
      </div>
      
    </form>
            </div>
                 </div>
                 </div>
                 </div>
                 </div>";
        ?>