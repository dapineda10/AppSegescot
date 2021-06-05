<div class="container  col-xs-12 col-lg-6 col-lg-offset-3 well ">
    <div class="col-xs-12 col-lg-12"><h3 style="text-align: center">Crear proveedor</h3></div>
    <div class="">
        <form class="col-xs-12 col-lg-12" action="index.php?controller=Proveedor&action=crearproveedor" method="POST">
            <div class="form-group"><input class="form-control" type="text" name="pro_nit" placeholder="Nit"></div>
            <div class="form-group"><input class="form-control" type="text"  name="pro_Nombre" placeholder="Nombre"></div>
            <div class="form-group"><input class="form-control" type="text" name="pro_emailEmpresa" placeholder="Correo electronico"></div>
            <div class="form-group"><input class="form-control" type="text" name="pro_paginaWeb" placeholder="Página web"></div>
            <div class="form-group"><input class="form-control" type="text" name="pro_direccion" placeholder="Dirección"></div>
            <div class="form-group"><input  class="form-control" type="text" name="pro_telefono" placeholder="Telefono"></div>
            <div class="form-group"><input class="form-control" type="text" name="pro_pais" placeholder="País"></div>
            <div class="form-group"><input class="form-control" type="text" name="pro_ciudad" placeholder="Ciudad"></div>
            <div><button class="btn-success form-control" type="submit">Crear</button></div>
        </form>
    </div>

</div>
