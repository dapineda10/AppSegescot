<!--Este formulario permite mostrar todas las cotizaciones creadas y en el php hay otro formualrio-->
<h2 class="col-lg-offset-2">Consultar contactos</h2>
<div class="col-lg-10 col-lg-offset-1">
    <table id="tablacontacto" class="well display col-lg-8 ">
        <tfoot>
            <tr>
                <th>Codigo Contacto</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Profesión</th>
                <th>Correo Electronico</th>
                <td>Editar</td>
                <td>Eliminar</td>
            </tr>
        </tfoot>
    </table>
</div>

<?php
if (isset($mensajes)) {
    echo "
        <script>
        alert('Contacto editada con exito');
        </script>
        ";
}
//Modal de modificar
    echo "        <div class='modal fade' id='myModalContacto' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-lg'>
                        <div class='modal-content'>
                            <div class='modal-header bg-green'>
                                <div class='container col-xs-12 col-lg-12'>
                                    <form id='editar' method='POST' action='index.php?controller=Contacto&action=modificarbd'>
                                        <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                                            <h1 class='col-xs-10 col-xs-offset-1 col-lg-12'>Editar</h1>
                                        </div>
                                        <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                                            <h4>Codigo</h4>
                                            <input class='form-control' type='hidden' id='codigo' name='codigo' placeholder='Codigo' >
                                            <input class='form-control' type='text' id='codigo1' placeholder='Codigo' disabled>
                                        </div>
                                        <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                                            <h4>Nombre</h4>
                                            <input class='form-control'  id='nombre' type='text' name='nombre' placeholder='Nombre' >
                                        </div>
                                        <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                                            <h4>Telefono</h4>
                                            <input class='form-control'  id='telefono' type='text' name='telefono' placeholder='telefono'>
                                        </div>
                                        <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                                            <h4>Profesion</h4>
                                            <input class='form-control'  id='profesion' type='text' name='profesion' placeholder='profesion'>
                                        </div>
                                        <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                                            <h4>Email</h4>
                                            <input class='form-control'  id='correo' type='text' name='correo' placeholder='correo'>
                                        </div>
                                        <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                                            <h4>Estado civil</h4>
                                        <select class='form-control' name='estadoCivil' id='estadoCivil'>
                                              <option value='Soltero'>Soltero</option>
                                              <option value='Casado'>Casado</option>
                                              <option value='Unionlibre'>Unión libre</option>
                                              <option value='Divorciado'>Divorciado</option>
                                              <option value='Otro'>Otro</option>
                                         </select>
                                        </div>
                                        <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                                            <h4>Cargo</h4>
                                            <input class='form-control'  id='cargo1' type='text' name='cargo1' placeholder='cargo'>
                                        </div>
                                        <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                                            <h4>Fecha nacimiento</h4>
                                            <input class='form-control'  id='fechaNacimiento' type='date' name='fechaNacimiento' placeholder='fechaNacimiento'>
                                        </div>
                                        <div class='col-xs-12 col-xs-offset-1 col-lg-10' id='clientediv'>
                                            <h4>Cliente(lista desplegable)</h4>
                                            <input class='form-control'  id='clientecombo' type='text'  placeholder='cliente'>
                                            <input class='form-control'  type='text'  id='clientecombo1' name='cli_documento' placeholder='cliente'>
                                        </div>
                                        <div class='col-xs-12 col-xs-offset-1 col-lg-10' id='proveedordiv'>
                                            <h4>Proveedor(lista desplegable)</h4>
                                            <input class='form-control'  id='Proveedor' type='text'  placeholder='Proveedor'>
                                            <input class='form-control'  id='Proveedor1' type='hidden' name='pro_nit' placeholder='Proveedor'>
                                        </div>
                <div class='col-xs-12 col-xs-offset-1 col-lg-5 form-group' style='margin-top: 10px;'>
                        <input class='form-control  btn btn-success'  value='Guardar' type='submit' />
                                   </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
        echo "
             <div class='modal fade' id='ModalborrarContacto' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
             <div class='modal-dialog modal-md'>
             <div class='modal-content'>
             <div class='modal-header bg-green'>    
             <h3 class='col-lg-12 col-lg-offset-2'>¿Está seguro qué desea eliminar?</h3>
             <input type='hidden' id='input_delete_contacto'></input>
             <a style='margin-top:20px' id='btneliminarcontacto' data-id='' data-dismiss='modal' class='btn btn-danger col-lg-4 col-lg-offset-1'>Eliminar</a>
             <a style='margin-top:20px' class='btn btn-info col-lg-4 col-lg-offset-2' data-dismiss='modal'>Cancelar</a>
             </div>
             </div>
             </div>
             </div>";
 
?>
