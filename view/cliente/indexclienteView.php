<!--Este formulario permite crear un cliente, la contraseña que se le asigna en este formulario es la que se usa
para ingresar al modulo de servicio al cliente, igualmente el mismo nombre de usuario-->
<div class=" col-lg-8 col-lg-offset-2 panel panel-primary">
    <div class="panel-heading">CREAR UN CLIENTE</div>
    <div class="panel-body container col-xs-12 col-lg-offset-1 col-lg-10">
            <form method="POST" class="col-lg-offset-2" action="<?php echo "index.php?controller=cliente&action=crearcliente"; ?>" >
                <div class="divcontorno col-xs-12 col-xs-offset-2 col-lg-10" tabindex="0" data-toggle="tooltip" title="Sólo datos numericos">
                    <input  type="number" class="form-control" name="cli_documento" id="cli_documento" placeholder="Nit o documento*" required>
                    <label style = "display:none" id= "ClienteRepetido">Este cliente ya existe</label>
                </div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text"  class="form-control" name="cli_nombre" required placeholder="Nombre de cliente"></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text" class="form-control" name="cli_direccion" required placeholder="Dirección*"></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text" class="form-control" name="cli_telefono" required placeholder="Telefono*"></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text" class="form-control" name="cli_email" required placeholder="Correo Electronico*"></div>
                <div class="divcontorno col-xs-12 col-xs-offset-2 col-lg-10" tabindex="0" data-toggle="tooltip" title="Sólo datos numericos"><input  type="number" class="form-control" name="cli_zonaCliente" placeholder="Zona ubicación de cliente*" required></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text" class="form-control" name="cli_paginaWeb" placeholder="Pagina Web"></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text" class="form-control" name="cli_pais" required placeholder="País*"></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text"  class="form-control" name="cli_ciudad" required placeholder="Ciudad*"></div>
                <div class="divcontorno col-xs-12 col-lg-10"><input type="text" class="form-control" name="cli_password" required placeholder="Contraseña*"></div>
                <!--Se envía value 0 para saber que es un cliente normal y no un cliente potencial, sirve como marca-->
                <input type="hidden" name="cli_tipocliente" value="0">
                <input type="hidden" name="cli_antes_cliente_potencial" value="0">
                <div class="col-xs-10 col-xs-offset-2 col-lg-10"><br><input type="submit" class="btn btn-primary col-xs-10 col-lg-6 col-lg-offset-1" name="enviarcliente" id="btnAddClient" value="Crear"></div>
            </form>
    </div>
</div>
