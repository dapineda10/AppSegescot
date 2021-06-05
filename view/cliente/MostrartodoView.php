<!--Este formulario permite mostrar todos los clientes creados y en el php hay otro formualrio llamado editarcliente1 
el cual permite modificar el cliente mediante un Modal de bootstrap-->
<h2 class="col-lg-offset-2">Consultar cliente</h2>
<div class="col-lg-10 col-lg-offset-1">
    <table id="tablacliente" class="well display col-lg-8">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Email</th>
                <th>Zona</th>
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
        alert('Cliente editado con exito');
        </script>
        ";
}

echo "
            <div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-lg'>
             <div class='modal-content'>
               <div class='modal-header bg-green'>
                 <h4 class = 'modal-title'>Editar Cliente</h4>
                  <form  id='editarcliente1' method='POST' action='index.php?controller=Cliente&action=modificarbd';>
                <div class='col-md-12 col-md-offset-1 col-lg-10'>
                    <h4>Documento</h4>
                    <input class='form-control' name='codigo' id='codigo' type='hidden'>
                    <input disabled class='form-control' name='codigo1' id='codigo1'>
                </div>
                <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                    <h4>Nombre De Cliente</h4>
                    <input class='form-control' type='textarea' name='nombre' id='nombre' required></div>
                <div class='col-xs-12 col-xs-offset-1 col-lg-10' >
                    <h4>Pagina Web</h4>
                    <input class='form-control' type='text' name='paginaweb' id='paginaweb' id='paginaweb'></div>
                <div class='col-xs-12 col-xs-offset-1 col-lg-10' >
                    <h4>Dirección</h4>
                    <input class='form-control' type='text' name='direccion' id ='direccion' required></div>
                <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                    <h4>E-mail</h4>
                    <input class='form-control' type='text' name='email' id='email' required></div>
                <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                    <h4>Zona Cliente</h4>
                    <p>*Solo datos númericos</p>
                    <input class='form-control' type='textarea' name='zonacliente'  id='zonacliente' required></div>
                <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                    <h4>Ciudad</h4>
                    <input class='form-control' type='textarea' name='ciudad' id='ciudad' required></div>
                <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                    <h4>País</h4>
                    <input class='form-control' type='textarea' name='pais' id='pais' required></div>
                <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                    <h4>Telefono</h4>
                    <input class='form-control' type='textarea' name='telefono' id='telefono' required></div>
                <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                    <h4>Contraseña</h4>
                    <input class='form-control' type='textarea' name='password' id='password' required></div>
                <div class='col-xs-12 col-lg-12 form-group' style='margin-top: 10px;'>
                    <input class='btn btn-success col-lg-4 col-lg-offset-1' value='Actualizar' id='submit' type='submit'/>
                    <button type='button' class='btn btn-danger col-lg-4 col-lg-offset-1' data-dismiss='modal'>Cancelar</button>
                </div>
            </form>
            </div>
                 </div>
                 </div>
                 </div>";

    echo "
             <div class='modal fade' id='Modalborrarcliente' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
             <div class='modal-dialog modal-md'>
             <div class='modal-content'>
             <div class='modal-header bg-green'>    
             <h3 class='col-lg-12 col-lg-offset-2'>¿Está seguro qué desea eliminar?</h3>
             <input type='hidden' id='input_delete'></input>
             <a style='margin-top:20px' id='btneliminar' data-id='' class='btn btn-danger col-lg-4 col-lg-offset-1'>Eliminar</a>   
             <a style='margin-top:20px' class='btn btn-info col-lg-4 col-lg-offset-2' data-dismiss='modal'>Cancelar</a>
             </div>
             </div>
             </div>
             </div>";
?>