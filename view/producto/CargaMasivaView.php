<form  enctype="multipart/form-data" id="crearproduct"  method="POST" action="<?php echo'index.php?controller=Producto&action=CargaMasiva';?>">
    <div class="col-lg-10 col-lg-offset-1 panel panel-default">
        <h1 class="panel-body" style="text-align: center">Carga masiva</h1>
        <div class="col-lg-10 col-lg-offset-1 panel panel-default">
            <br>
            <div class="col-lg-12"><label class="col-lg-12">Seleccine una acción y suba el archivo:</label></div>
            <br>
            <div class="col-lg-12">
                <br>
                <div class="col-lg-4 col-lg-offset-2">
                    <select class="form-control" id="accion" name="accion" required="Seleccione una opción">
                        <option value=""> Seleccione una opción</option>
                        <option value="insertar" >Insertar o actualizar producto</option>
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <input type="file" class="form-control-file" accept=".csv" name="archivo" id="exampleFormControlFile1" required>
                </div>
            </div>
            <div class="form-group col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4" style="margin-top: 10px;">
                <button type="submit" class="col-lg-10 col-md-4 btn btn-primary mb-2">Subir</button>
            </div>
        </div>
    </div>
</form>

