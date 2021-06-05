<div><h2 class="col-lg-offset-2">Consultar productos</h2></div>
<div class="col-lg-10 col-lg-offset-1">
    <table id="tablaproducto" class="well display col-lg-8">
        <tfoot>
            <tr>
                <th>Código producto</th>
                <th>Categoría</th>
                <th>Nombre</th>
                <th>Nombre proveedor</th>
                <td>Editar</td>
                <td>Eliminar</td>
            </tr>
        </tfoot>
    </table>
</div>

<?php
/* Consulta de combo de categoria */
$categoria = new Categoria($this->adapter);
$allcategoria = $categoria->getAll();

//Mostrar mensaje de editar
if (isset($mensajes)) {
    
}

//Modal para editar productos
echo"
<div class='modal fade' id='myModalProducto' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
      <div class='modal-content'>
        <div class='modal-header bg-green'>
          <div class='container col-lg-12'>
            <form id='editarprod' method='POST' action='index.php?controller=Producto&action=modificarbd'>
               <h1>Editar Producto</h1>
    <div class='form-group col-lg-10 col-lg-offset-1'>
       <h4>Codigo único</h4>
    <input class='form-control' name='prd_codigoProducto' id='prd_codigoProducto' type=hidden>
    <input class='form-control' id='prd_codigoProducto1' disabled>
    </div>
    <div class='form-group col-lg-10 col-lg-offset-1'>
        <h4>Categoría</h4>
    <select name='cat_idCategoria' id='cat_idCategoria'  class='form-control selcls'> ";
if ($allcategoria != '') {
    foreach ($allcategoria as $item) {
        if ($valor->cat_idCategoria != $item->cat_idCategoria) {
            echo "<option value='$item->cat_idCategoria'>$item->cat_nombre</option>";
        } else {
            echo "<option value='$item->cat_idCategoria' selected>$item->cat_nombre</option>";
        }
    }
}
echo "  </select>                   
        </div>
       <div class='col-xs-12 col-xs-offset-1 col-lg-10' id='proveedordiv'>
        <h4>Proveedor(lista desplegable)</h4>
        <input class='form-control'  id='Proveedorproducto' type='text'  placeholder='Proveedor'>
        <input class='form-control'  id='Proveedorproducto1' type='hidden' name='pro_nit' placeholder='Proveedor'>
        </div>
       <div class='form-group col-lg-10 col-lg-offset-1'>
           <h4>Divisa</h4>
           <input  type='text' class='form-control' name='prd_tipoDivisa' id='prd_tipoDivisa'>
       </div>
       <div class='form-group col-lg-10 col-lg-offset-1'>
           <h4>Costo</h4>
           <p>*Solo datos númericos</p>
           <input type='textarea' class='form-control' name='prd_costo' id='prd_costo'  >
       </div>
       <div class='form-group col-lg-10 col-lg-offset-1'>
           <h4>Precio Fijos</h4>
           <p>Solo datos númericos</p>
           <div>
                                <input type='hidden' name='prdPrecios' id='prdPrecios'>
                                <div id='main_precio'>
                                    <input type='button' id='btAdd' value='Añadir Precio' class='bt btn-success' />
                                    <input type='button' id='btRemove' value='Eliminar Precio' class='bt-disable' disabled />
                                    <input type='button' id='btRemoveAll' value='Eliminar Todo' class='bt-disable' disabled /><br />
                                </div>
                                <div id='precios_container'>
                                    <!--<input class='input precios form-control' id='precio1' placeholder='Precio 1' type='text'>-->
                                </div>
                            </div>
           
       </div>
       <div class='form-group col-lg-10 col-lg-offset-1'>
           <h4>Tipo De Presentación</h4>
           <input type='textarea' class='form-control' name='prd_tipoPresentacion' id='prd_tipoPresentacion'>
       </div>
       <div class='form-group col-lg-10 col-lg-offset-1'>
           <h4>Nombre Del Producto</h4>
           <input type='textarea' class='form-control' name='prd_nombre' id='prd_nombre'>
       </div>
       <div class='form-group col-lg-10 col-lg-offset-1'>
           <h4>Descripción</h4>
           <input type='textarea' class='form-control' name='prd_descripcion' id='prd_descripcion'>
       </div>
       <div class='form-group col-lg-10 col-lg-offset-1'>
           <h4>Foto</h4>
           <img id='prd_foto' src='$nombre_archivo'>
       </div>
       </div>
       <div class='form-group col-lg-10 col-lg-offset-1'>
           <h4>Iva</h4>
           <p>*Solo datos númericos</p>
           <input type='textarea' class='form-control' name='prd_iva' id='prd_iva'>
       </div>
       <div class='col-xs-12 col-xs-offset-1 col-lg-5 form-group' style='margin-top: 10px;'>
           <input value='Guardar' class='col-lg-8 btn btn-success col-lg-offset-2' type='submit' onclick='GetTextValue()'/>
                </div>

            </form>
        </div>
    </div>
        </div>
    </div>
</div>";

//Modal de eliminar
echo "
             <div class='modal fade' id='ModalborrarProducto' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
             <div class='modal-dialog modal-md'>
             <div class='modal-content'>
             <div class='modal-header bg-green'>    
             <h3 class='col-lg-12 col-lg-offset-2'>¿Está seguro qué desea eliminar?</h3>
             <input type='hidden' id='input_delete_producto'></input>
             <a style='margin-top:20px' id='btneliminar2' data-id='' data-dismiss='modal' class='btn btn-danger col-lg-4 col-lg-offset-1'>Eliminar</a>
             <a style='margin-top:20px' class='btn btn-info col-lg-4 col-lg-offset-2' data-dismiss='modal'>Cancelar</a>
             </div>
             </div>
             </div>
             </div>";
?>