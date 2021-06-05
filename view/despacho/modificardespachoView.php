<!--Este formulario permite mostrar todos los clientes creados y en el php hay otro formualrio llamado editarcliente1 
el cual permite modificar el cliente mediante un Modal de bootstrap-->

<div class="col-lg-10">
    <table id="tabladespacho" class="well display col-lg-8 col-lg-offset-1">
        <thead>
            <tr>
                <th>Código despacho</th>
                <th>Contrato</th>
                <th>Factura</th>
                <th>Cliente</th>
                <th>Observaciones</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
    </table>
</div>

<?php
if (isset($mensajes)) {
    echo "
        <script>
        alert('Despacho editado con exito');
        </script>
        ";
}

 echo "
        <!-------Editar Despacho------->
            <div class='modal fade' id='ModalDespacho' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-lg'>
             <div class='modal-content'>
               <div class='modal-header bg-green'>
        <div class='container col-lg-10 col-lg-offset-1'>
            <form id='editardespacho' method='POST' action='index.php?controller=Despacho&action=modificarbd'>
                <h1 class='col-lg-offset-3'>Edite su Despacho</h1>
                <div class='form-group col-lg-10 col-lg-offset-1'>
                  <h4>Codigo despacho</h4>
                  <input class='form-control' name='codigodespacho' id='codigodespacho' type='hidden'>
                  <input class='form-control' id='codigodespacho1' disabled>
                </div>
                <div class='form-group col-lg-10 col-lg-offset-1'>
                  <h4>Fecha de envío</h4>
                  <input class='form-control' type='date' name='fechaenvio' id='fechaenvio'>
                </div>
                <div class='form-group col-lg-10 col-lg-offset-1'>
                  <h4>Transportadora</h4>
                  <input  type='text' class='form-control' name='transportadora' id='transportadora'>
                </div>
                <div class='form-group col-lg-10 col-lg-offset-1'>
                  <h4>Observaciones</h4>
                  <input  type='text' class='form-control' name='ObservacionesEnvio' id='ObservacionesEnvio'>
                </div>
                <div class='form-group col-lg-10 col-lg-offset-1'>
                  <h4>Orden de compra o contrato</h4>
                  <input type='textarea' class='form-control' name='contrato' id='contrato' >
                </div>
                <div class='form-group col-lg-10 col-lg-offset-1'>
                  <h4>Número de guía</h4>
                  <input type='textarea' class='form-control' name='NumeroGuia' id='NumeroGuia'  >
                </div>
                <div class='form-group col-lg-10 col-lg-offset-1'>
                  <h4>Cantidad de cajas</h4>
                  <p>*Solo datos númericos</p>
                  <input type='textarea' class='form-control' name='CantidadCajas' id='CantidadCajas' >
                </div>
                <div class='form-group col-lg-10 col-lg-offset-1'>
                  <h4>Número de factura</h4>
                  <input type='textarea' class='form-control' name='Numfactura' id='Numfactura' >
               </div>
               <div class='form-group col-lg-12 col-lg-offset-1'>
                  <h4>Cliente(Lista desplegable)</h4>
                  <input class='col-lg-12' name='cli_documento' id='clienteeasy' >
               </div>
            <div class='form-group col-lg-12 col-lg-offset-1'>    
                    <h4>Usuario quien realiza despacho (Lista desplegable)</h4>
                    <input class='form-control col-lg-12' name='usu_documento' id='usuarioeasy' >
              </div>
                <div class='col-xs-12 col-xs-offset-1 col-lg-12 form-group'>
                    <input value='Guardar' class='col-lg-4 col-lg-offset-1 btn btn-success' type='submit'/>
                <button type='button' class='btn btn-danger col-lg-4 col-lg-offset-1' data-dismiss='modal'>Cancelar</button>
	        </div>
            </form>
          </div>
            </div>
            </div>
                 </div>
                 </div>";

    echo "
             <div class='modal fade' id='ModalborrarDespachop' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
             <div class='modal-dialog modal-md'>
             <div class='modal-content'>
             <div class='modal-header bg-green'>    
             <h3 class='col-lg-12 col-lg-offset-2'>¿Está seguro qué desea eliminar?</h3>
             <input type='hidden' id='input_delete2'></input>
             <a style='margin-top:20px' id='btneliminar5' data-id='' data-dismiss='modal' class='btn btn-danger col-lg-4 col-lg-offset-1'>Eliminar</a>
             <a style='margin-top:20px' class='btn btn-info col-lg-4 col-lg-offset-2' data-dismiss='modal'>Cancelar</a>
             </div>
             </div>
             </div>";
?>