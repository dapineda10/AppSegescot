<!--Este formulario permite mostrar todos los clientes creados y en el php hay otro formualrio llamado editarcliente1 
el cual permite modificar el cliente mediante un Modal de bootstrap-->
<div><h2 class="col-lg-offset-4 col-lg-offset-2">Consultar proveedores</h2></div>
<div class="col-lg-10 col-lg-offset-1">
    <table id="tablaproveedor" class="well display col-lg-8">
        <thead>
            <tr>
                <th>Nit</th>
                <th>Nombre proveedor</th>
                <th>Email</th>
                <th>Ciudad</th>
                <th>Telefono</th>
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
        alert('Proveedor editado con exito');
        </script>
        ";
}
            echo"
            <div class='modal fade' id='myModalproveedor' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                         <div class='modal-content'>
                           <div class='modal-header bg-green'>
            <div class='container col-xs-7 col-xs-offset-3 col-lg-6 col-lg-offset-3'>
                <form id='editar' method='POST' action='index.php?controller=proveedor&action=modificarbd'>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h2 class='col-xs-10 col-xs-offset-1 col-lg-12'>Editar</h2>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Nit</h4>
                        <input class='form-control' disabled id='pro_nit1' name='pro_nit' placeholder='Nit'>
                        <input class='form-control' type='hidden' id='pro_nit2' name='pro_nit' placeholder='Nit'>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Nombre</h4>
                        <input class='form-control' type='text'  id='pro_Nombre' name='pro_Nombre' placeholder='Nombre'>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Pagina Web</h4>
                        <input class='form-control' type='text'   id='pro_paginaWeb' name='pro_paginaWeb' placeholder='Pagina Web'>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Email</h4>
                        <input class='form-control' type='text'  id='pro_emailEmpresa' name='pro_emailEmpresa' placeholder='Telefono' >
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Dirección</h4>
                        <input class='form-control' type='text'  id='pro_direccion' name='pro_direccion' placeholder='Dirección'>
                    </div>
					<div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Telefono</h4>
                        <input class='form-control' type='text'  id='pro_telefono' name='pro_telefono' placeholder='Telefono'>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>País</h4>
                        <input class='form-control' type='text' id='pro_pais' name='pro_pais' placeholder='Pais'>
                    </div>
					 <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Ciudad</h4>
                        <input class='form-control' type='text' id='pro_ciudad' name='pro_ciudad' placeholder='Pais'>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-5 form-group' style='margin-top: 10px;'>
                        <input class='form-control  btn btn-success'  value='Guardar' type='submit' />
                    </div>
                </form>
           
                    </div>
                             </div>
                             </div>
                             </div>

            </div>";

            echo "
             <div class='modal fade' id='ModalborrarProveedor' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
             <div class='modal-dialog modal-md'>
             <div class='modal-content'>
             <div class='modal-header bg-green'>    
             <h3 class='col-lg-12 col-lg-offset-2'>¿Está seguro qué desea eliminar?</h3>
             <input hidden id='input_delete_proveedor'></input>
             <a style='margin-top:20px' id='btneliminar3' data-id='' data-dismiss='modal' class='btn btn-danger col-lg-4 col-lg-offset-1'>Eliminar</a>
             <a style='margin-top:20px' class='btn btn-info col-lg-4 col-lg-offset-2' data-dismiss='modal'>Cancelar</a>
             </div>
             </div>
             </div>
             </div>";
?>