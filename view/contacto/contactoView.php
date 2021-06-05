<html>
    <body>
        <div class=" container col-xs-12 col-lg-10 col-lg-offset-1  well">
				<?php
           if (isset($error)) {
            echo "
			<div class='container col-xs-12 col-lg-12'>
			<div class='alert alert-danger col-lg-4 col-lg-offset-4 id = 'passincorrecta'>$error</div>
			</div>
			";
        }
        ?>
            <div style="text-align: center"><h2>Crear un contacto</h2></div>
            <br>
            <form id="crearcontacto" method="POST" action="<?php echo "index.php?controller=Contacto&action=crearcontacto"; ?>">
                <div class="row">
                    <div  class="col-xs-12 col-lg-5"> 
                        <p>Codigo de Contacto</p>
                        <input type="text" class="form-control" id="cp_nit" name="con_codigo" required>
                        <p>Nombre Completo</p>
                        <input type="text" class="form-control" id="con_nombreCompleto"  name="con_nombreCompleto" required>
                        <p>Telefono</p>
                        <input type="text" class="form-control" id="con_telefono"  name="con_telefono" required>
                        <p>Correo electronico</p>
                        <input type="text" class="form-control" id="con_email"  name="con_email" required>
                        <p>Cargo</p>
                        <input type="text" class="form-control" id="con_cargo"  name="con_cargo"> 
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        <p>Estado civil</p>
                        <select class="form-control" name="con_estadoCivil">
                            <option id="con_estadoCivil" value="Soltero">Soltero</option>
                            <option id="con_estadoCivil" value="Casado">Casado</option>
                            <option id="con_estadoCivil" value="Unionlibre">Unión libre</option>
                            <option id="con_estadoCivil" value="Divorciado">Divorciado</option>
                            <option id="con_estadoCivil" value="Otro">Otro</option>
                        </select>
                        
                        <p>Profesión</p>
                        <input type="text" class="form-control" id="con_profesion"  name="con_profesion">
                        <p>Fecha de Nacimiento</p>
                        <input type="date" class="form-control" id="con_fechaNacimiento"  name="con_fechaNacimiento">
                        <br>
                        <p>Tipo de Contacto</p>
                         <input type="radio" name="checkradiocontacto" id="1" onclick="checkin(1)" value="1">Cliente y cliente potencial
                         <input type="radio" name="checkradiocontacto" id="2" onclick="checkin(2)" value="2">Proveedor
                        <!--Combobox de cliente-->
                        <div id="cliente2" class="foraneas" >    
                            <br>
                            <input id ="cmbCliente"  class="form-control" placeholder="Cliente y cliente potencial"/>
                            <input id ="cmbClienteSel" name="cli_documento"  type="text" class="hidden"/>  
                        </div>
                        
                        <!--Combobox de Proveedor-->
                        <div id="Proveedor2" class="foraneas">
                                <br>
                                <input id ="cmbProveedor"  class="form-control" placeholder="Proveedor"/> 
                                <input id ="cmbProveedorSel" name="pro_nit"   type="text" class="hidden"/>  
                        
                        </div>
                    </div>
                    <input type="submit" class=" btn btn-primary col-xs-12 col-lg-6 col-lg-offset-3" style="margin-top: 20px;">
                </div>
            </form>
        </div>
    </body>
</html>