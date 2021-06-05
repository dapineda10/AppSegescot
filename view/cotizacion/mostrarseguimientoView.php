<!--Este formulario permite mostrar todas los proveedores creados-->
<div><h2 class="col-lg-offset-2">Consultar seguimientos</h2></div>
<div class="col-lg-10 col-lg-offset-1">
    <table id="tablaseguimientocotizacion" class="well display col-lg-8">
        <thead>
            <tr>
                <th>Ticket</th>
                <th>Cotizacion</th>
                <th>Cliente</th>
                <th>Fecha registro</th>
                <th>Fecha compromiso</th>
                <th>Editar</th>
            </tr>
        </thead>
    </table>
</div>

<?php
if (isset($mensajes)) {
    echo "
        <script>
        alert('Seguimiento editado con exito');
        </script>
        ";
}
 echo"
            <div class='modal fade' id='myModalseguimiento1' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                         <div class='modal-content'>
                           <div class='modal-header bg-green'>
            <div class='container col-xs-7 col-xs-offset-3 col-lg-8 col-lg-offset-2'>
                <form id='editarseguimiento' method='POST' action='index.php?controller=Seguimiento&action=modificarbd'>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h2 class='col-xs-10 col-xs-offset-1 col-lg-12'>Editar Seguimiento</h2>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Código seguimiento</h4>
                        <input class='form-control' disabled id='seg_ticket' name='seg_ticket'>
                        <input class='form-control' type='hidden' id='seg_ticket1' name='seg_ticket'>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Fecha de registro</h4>
                        <input class='form-control' type='hidden'  id='seg_fechaRegistro' hidden name='seg_fechaRegistro'>
                        <input class='form-control' type='text'  id='seg_fechaRegistro1' disabled name='seg_fechaRegistro'>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Usuario</h4>
                        <input class='form-control' type='hidden'  id='usu_documento' name='usu_documento'>
                        <input class='form-control' type='text' disabled  id='usu_documento1' name='usu_documento'>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Código cotización</h4>
                        <input class='form-control' type='hidden'   id='cot_codigoCotizacionseguimiento' name='cot_codigoCotizacion'>
                        <input class='form-control' type='text' disabled  id='cot_codigoCotizacionseguimiento1' name='cot_codigoCotizacion'>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Fecha de compromiso</h4>
                        <input class='form-control' type='date'  id='seg_fechacompromiso' name='seg_fechacompromiso'>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Comentario</h4>
                        <textarea class='form-control' type='textarea' id='seg_comentario' name='seg_comentario'></textarea>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-5 form-group' style='margin-top: 10px;'>
                        <input class='form-control  btn btn-success' id='editarseguimientomodal' value='Guardar' type='submit' />
                    </div>
                </form>
           
                    </div>
                             </div>
                             </div>
                             </div>

            </div>";
        ?>