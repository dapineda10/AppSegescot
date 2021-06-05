<!--Este formulario permite agregar una nueva categoría para un producto, 
está unido con el controlador CataegoriaController-->
<div class="container col-xs-12 col-lg-4 col-lg-offset-4 well">
    <div class="text-center"><h1>Crear Categoría</h1></div>
    <form  id="crearproduct" class="col-xs-12 col-lg-10 col-lg-offset-1" method="POST" action="<?php echo 'index.php?controller=Categoria&action=crearcategoria'; ?>">
        <p>Id Categoría</p>
        <input type="text" id="cat_idCategoria"  name="cat_idCategoria" class="form-control selcls">
        <p>Nombre</p>
        <input type="text" class="form-control" id="cat_nombre"  name="cat_nombre"><br> 
        <p>Descripción</p>
        <textarea type="file" class="form-control" id="cat_descripcion"  name="cat_descripcion" cols="10" rows="5"></textarea>
        <br>
        <div class="col-lg-10 col-lg-offset-2"><input type="submit" class="btn btn-success col-lg-10"></div>
    </form>
</div>
