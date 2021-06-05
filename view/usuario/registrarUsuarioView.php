<div id="tabs" class="col-lg-10 col-lg-offset-1 well">
    <ul class="list-inline">
        <li><a href="#tabs-1" id="tabsquery" >Consultar usuarios</a></li>
        <li><a href="#tabs-2" id="tabsquery2">Crear usuario</a></li>
    </ul>
    <div id="tabs-1" class="col-lg-12">
        <table id="tablausuarios" class="well display col-lg-12 col-lg-offset-1">
        <thead>
            <tr>
                <th>Dócumento</th>
                <th>Nombre</th>
                <th>Fecha de nacimiento</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Editar</th>
            </tr>
        </thead>
    </table>
        </div>
    <div id="tabs-2" class="col-lg-8 col-lg-offset-2">
        <form method="POST" action="<?php echo "index.php?controller=Usuario&action=registrarUsuario"; ?>">
            <div class="col-lg-8 col-lg-offset-3"><h3>Registrar un nuevo usuario</h3></div>
            <div class="col-lg-12">
                <input type='number' class="form-control" name="usu_documento" placeholder="Documento"></div>
            <div class="col-lg-12">
                <input class="form-control" name="usu_nombre" placeholder="Nombre"></div>
            <div class="col-lg-12">Fecha de Nacimiento
                <input type="date" class="form-control" name="usu_fechaNacimiento" ></div>
            <div class="col-lg-12">
                <input class="form-control" name="usu_password"  type="password" placeholder="Contraseña"></div>
            <div class="col-lg-12">
                <input type='number' class="form-control" name="usu_telefono" placeholder="Teléfono"></div>
            <div class="col-lg-12">
                <input class="form-control" name="usu_nombreUsuario" placeholder="Nombre de usuario"></div>
            <div class="col-lg-12">
                <input class="form-control" name="usu_direccion" placeholder="Dirección"></div>
            <div class="col-lg-12">
                <input class="form-control" name="usu_email" placeholder="Email"></div>
            <!--Crear roles-->
            <div class="col-lg-12"> Rol
            <select type="text" id="rol_idRol"  name="rol_idRol" class="form-control selcls" required>
                    <?php
                    if ($allRol != "") {
                        foreach ($allRol as $rol) {
                            echo "<option value='$rol->rol_idRol'>$rol->rol_tipoRol</option>";
                        }
                    }
                    ?> 
                </select></div>

            <div class="col-lg-12"><input class="form-control btn-success" type="submit"> </div>

        </form>
    </div>
    </div>
    
<?php
if (isset($mensajes)) {
    echo "
        <script>
        alert('Usuario editado con exito');
        </script>
        ";
}
 echo "
            <div class='modal fade' id='myModalusuarios' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-lg'>
             <div class='modal-content'>
               <div class='modal-header bg-green'>
            <h1 class ='modal-title' style='text-align:center'>Editar Usuario</h1><br>
            <form  id='editarusuario' method='POST' action='index.php?controller=Usuario&action=modificarbd';>
            <div class='form-group'>
            <p>Dócumento</p>
            <input type='hidden' id='usu_documento' class='form-control codigocoti' name='usu_documento'>
            <input type='text' disabled id='usu_documento2' class='form-control codigocoti' name='usu_documento'>
            </div>
            <div class='form-group'><p>Nombre de usuario</p>
            <input type='text' class='form-control' name='usu_nombre' id='usu_nombre'></div>
            <div class='form-group'><p>Fecha de nacimiento</p>
            <input type='date' class='form-control' name='usu_fechaNacimiento' id='usu_fechaNacimiento'></div>
            <div class='form-group'><p>Contraseña</p>
            <input type='password' class='form-control' name='usu_password' id='usu_password'></div>
            <div class='form-group'><p>Telefono</p>
            <input type='text' class='form-control' name='usu_telefono' id='usu_telefono'></div>
            <div  class='form-group'><p>Nombre de usuario</p>
            <input type='text' class='form-control datepicker' name='usu_nombreUsuario' id='usu_nombreUsuario'></div>
            <div  class='form-group'>
            <p>Direccion</p>
            <input type='text' class='form-control datepicker' name='usu_direccion' id='usu_direccion'></div>
            <div  class='form-group'>
            <p>Direccion</p>
            <input type='text' class='form-control datepicker' name='usu_email' id='usu_email'></div>
            <br>
            <input class='btn btn-success form-control' type='submit'>
            </form>
            </div>
                 </div>
                 </div>
                 </div>
                 </div>
        ";
 ?>