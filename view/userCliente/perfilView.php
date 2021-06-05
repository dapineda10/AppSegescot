<div class="col-xs-12 col-lg-8"><br><br>
    <form method="POST" action="<?php echo "index.php?controller=Serviciocliente&action=crearservicio"; ?>">
        <div class="col-lg-6">Documento o NIT <input class="form-control" type="text" value="<?php
            if (isset($_SESSION['documento'])) {
                echo $_SESSION['documento'] . "" . "";
            }
            ?>" id=""  name="cli_documento" readonly="readonly"  /></div>
        <div class="col-lg-6">Nombre <input class="form-control" type="text" value="<?php
            if (isset($_SESSION['nombre'])) {
                echo $_SESSION['nombre'] . "" . "";
            }
            ?>" id=""  name="cli_nombre"   /></div>
        <div class="col-lg-6">E-mail <input class="form-control" type="text" value="<?php
            if (isset($_SESSION['email'])) {
                echo $_SESSION['email'] . "" . "";
            }
            ?>" id=""  name="cli_email"  /></div>
        <div class="col-lg-6">Direccion <input class="form-control" type="text" value="<?php
            if (isset($_SESSION['direccion'])) {
                echo $_SESSION['direccion'] . "" . "";
            }
            ?>" id=""  name="cli_direccion"   /></div>
        <div class="col-lg-6">Telefono <input class="form-control" type="text" value="<?php
            if (isset($_SESSION['telefono'])) {
                echo $_SESSION['telefono'] . "" . "";
            }
            ?>" id=""  name="cli_telefono"   /></div>
        <div class="col-lg-6">Pagina Web <input class="form-control" type="text" value="<?php
            if (isset($_SESSION['paginaWeb'])) {
                echo $_SESSION['paginaWeb'] . "" . "";
            }
            ?>" id=""  name="cli_paginaWeb"   /></div>
        <div class="col-lg-6">Ciudad <input class="form-control" type="text" value="<?php
            if (isset($_SESSION['ciudad'])) {
                echo $_SESSION['ciudad'] . "" . "";
            }
            ?>" id=""  name="cli_ciudad"   /></div>
        <div class="col-lg-6">Zona <input class="form-control" type="text" value="<?php
            if (isset($_SESSION['zonaCliente'])) {
                echo $_SESSION['zonaCliente'] . "" . "";
            }
            ?>" id=""  name="cli_zonaCliente"   /></div>
        <div class="col-lg-6">Pais <input class="form-control" type="text" value="<?php
            if (isset($_SESSION['pais'])) {
                echo $_SESSION['pais'] . "" . "";
            }
            ?>" id=""  name="cli_pais"   /></div>
        <div class="col-lg-6">Clave <input class="form-control" type="text" value="<?php
            if (isset($_SESSION['password'])) {
                echo $_SESSION['password'] . "" . "";
            }
            ?>" id=""  name="cli_password"  /></div>
        <div class="col-xs-12 col-lg-6"><br>
        <button type="submit" onclick="buton();" class="form-control btn-success">Actualizar</button>
        </div>
    </form>
</div>