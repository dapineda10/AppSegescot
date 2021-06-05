<!--CrearClientePotencial-->
<div class="col-lg-12">
    <div class="text-center col-lg-4" id="divcrearclientepotencial"><h3>Crear cliente potencial</h3>
        <form id="formcliente" method="POST" class="col-lg-offset-2" action="<?php echo "index.php?controller=cliente&action=crearcliente"; ?>" >
            <div class="col-xs-12 col-lg-12">
                <div class="divcontorno col-xs-12 col-xs-offset-2 col-lg-10"><input  type="text" class="form-control" name="cli_documento" placeholder="Nit o documento*" required></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text"  class="form-control" name="cli_nombre" placeholder="Nombre de cliente*" required></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text" class="form-control" name="cli_direccion" placeholder="Dirección" required></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text" class="form-control" placeholder="Telefono" name="cli_telefono" required></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text" class="form-control" name="cli_email" placeholder="Correo Electronico" required></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input  type="number" class="form-control" name="cli_zonaCliente" placeholder="Zona ubicación de cliente" required></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text" class="form-control" name="cli_paginaWeb" placeholder="Pagina Web(opcional)"></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text" class="form-control" name="cli_pais" placeholder="País" required></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text"  class="form-control" name="cli_ciudad" placeholder="Ciudad" required></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text" class="form-control" name="cli_password" placeholder="Contraseña" required><br></div>
                <!--Se envía value 1 para saber que es un cliente potencial, sirve como marca-->
                <input type="hidden" name="cli_tipocliente" value="1">
                <input type="hidden" name="cli_antes_cliente_potencial" value="1">
                <div class="divcontorno col-xs-12 col-lg-12"><input type="submit" class="btn btn-primary col-xs-12 col-lg-8 col-lg-offset-1" name="enviarclientepotencial" value="Crear"><br></div>
            </div>
        </form>
        <br>

    </div>
    <!--Este formulario permite mostrar todas los proveedores creados-->
    <div class="col-lg-8">
        <h2 class="col-lg-offset-4">Consultar cliente potencial</h2>
        <table id="tablaclientepotencial" class="well display col-lg-10">
            <thead>
                <tr>
                    <th>Nit</th>
                    <th>Nombre cliente</th>
                    <th>Ciudad</th>
                    <th>Telefono</th>
                    <th style="text-align: center">Editar</th>
                    <th style="text-align: center">Eliminar</th>
                    <th style="text-align: center">Pasar a cliente</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<?php
if (isset($mensajes)) {
    echo "
        <script>
        alert('Cliente potencial editado con exito');
        </script>
        ";
}
echo "
            <div class='modal fade' id='myModalCp' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
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
                    <!--Se envía value 1 para saber que es un cliente potencial, sirve como marca-->
                <input type='hidden' name='cli_tipocliente' value='1'>
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
             <div class='modal fade' id='ModalborrarclientPot' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
             <div class='modal-dialog modal-md'>
             <div class='modal-content'>
             <div class='modal-header bg-green'>    
             <h3 class='col-lg-12 col-lg-offset-2'>¿Está seguro qué desea eliminar?</h3>
             <input type='hidden' id='input_delete_cp'></input>
             <a style='margin-top:20px' id='btneliminarcp' data-id='' data-dismiss='modal' class='btn btn-danger col-lg-4 col-lg-offset-1'>Eliminar</a>
             <a style='margin-top:20px' class='btn btn-info col-lg-4 col-lg-offset-2' data-dismiss='modal'>Cancelar</a>
             </div>
             </div>
             </div>
             </div>";


echo "
             <div class='modal fade' id='Modalpasaracliente' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
             <div class='modal-dialog modal-md'>
             <div class='modal-content'>
             <div class='modal-header bg-green'>    
             <h3 class='col-lg-12 col-lg-offset-2'>¿Está seguro qué desea pasar este cliente?</h3>
             <input type='hidden' id='documento'></input>
             <input type='hidden' id='tipocliente'></input>
             <a style='margin-top:20px' id='btnpasarcliente' data-id='' data-dismiss='modal' class='btn btn-danger col-lg-4 col-lg-offset-1'>Pasar</a>
             <a style='margin-top:20px' class='btn btn-info col-lg-4 col-lg-offset-2' data-dismiss='modal'>Cancelar</a>
             </div>
             </div>
             </div>
             </div>";
?>
