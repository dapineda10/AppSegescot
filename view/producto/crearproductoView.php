        <div class="container col-xs-12 col-lg-10 col-lg-offset-1">
            <div class="text-center"><h1>Crear Producto</h1></div>
            <div class="well">
                <form  enctype="multipart/form-data" id="crearproduct"  method="POST" action="<?php echo'index.php?controller=Producto&action=crearproducto'; ?>">
                    <div class="row">
                        <div class="col-xs-12 col-lg-5 col-lg-offset-1">
                            <div><p>Código de Producto</p></div>
                            <div><input type="text" class="form-control" id="prd_codigoProducto"  name="prd_codigoProducto" required></div>
                            <label style = "display:none" id= "ProductoRepetido">Este producto ya existe</label>

                            <div><p>Categoria</p></div>
                            <div><select type="text" id="cat_idCategoria"  name="cat_idCategoria" class="form-control selcls" required>
                                    <?php
                                    //var_dump($allusers);
                                    if ($allCat != "") {
                                        foreach ($allCat as $cat) {
                                            echo "<option value='$cat->cat_idCategoria'>$cat->cat_nombre</option>";
                                        }
                                    }
                                    ?> 
                                </select></div>

                            <div> <p>Proovedor</p></div>
                            <div><select type="text" id="pro_nit"  name="pro_nit" class="form-control selcls">
                                    <?php
                                    //var_dump($allusers);
                                    if ($allProv != "") {
                                        foreach ($allProv as $proveedor) {
                                            echo "<option value='$proveedor->pro_nit'>$proveedor->pro_Nombre</option>";
                                        }
                                    }
                                    ?>
                                </select></div>
                            <div><p>Tipo de Divisa</p></div>
                            <div><input class="form-control" type="text" id="Dprd_tipoDivisaocumento"  name="prd_tipoDivisa"required></div>
                            <div> <p>Costo</p></div>
                            <div>
                                <input class="form-control" type="text" id="Dprd_CostoProducto"  name="prd_costo" required>
                            </div>
                            <div> <p>Precios Fijos</p></div>
                            <div>
                                <input type="hidden" name="prdPrecios" id="prdPrecios">
                                <div id="main_precio">
                                    <input type="button" id="btAdd" value="Añadir Precio" class="bt btn-success" />
                                    <input type="button" id="btRemove" value="Eliminar Precio" class="bt-disable" disabled />
                                    <input type="button" id="btRemoveAll" value="Eliminar Todo" class="bt-disable" disabled /><br />
                                </div>
                                <div id="precios_container">
                                    <input class="input precios form-control" id="precio1" placeholder="Precio 1" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-5">
							<div><p>Presentación del producto</p></div>
                            <div> <input class="form-control" type="text" id="prd_costo"  name="prd_tipoPresentacion" required></div>
                            <div> <p>Nombre</p></div>
                            <div> <input class="form-control" type="text" id="prd_nombre"  name="prd_nombre" required></div>
                            <div> <p>Descripcion</p></div>
                            <textarea type='textarea' class='form-control' name='prd_descripcion' id='prd_descripcion required'></textarea>
                             <div><p>iva</p></div>
                            <div><select type="text" id="prd_iva"  name="prd_iva" class="form-control selcls" required>
                                    <option values="0"></option>
                                    <option values="0">0</option>
                                    <option values="19">19</option>
                                </select></div>
                            <!--agregar imagen-->
                            <form enctype="multipart/form-data">     
                            
                                <label for="foto">Seleccione una Foto</label>
                                <input name="foto" type="file" class="file" multiple=true data-preview-file-type="any">
                            
                            </form>
							<br>
                            <input type="submit" class="btn btn-success col-lg-10 col-lg-offset-1 col-xs-10 col-xs-offset-1" onclick="GetTextValue()">
                        </div>
                    </div>
            </div>

        </div>
    </div>