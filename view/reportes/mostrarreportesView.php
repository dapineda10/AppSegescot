<!--Este formulario permite mostrar todos los clientes creados y en el php hay otro formualrio llamado editarcliente1 
el cual permite modificar el cliente mediante un Modal de bootstrap-->
<div><h2 class="col-lg-offset-2 col-lg-offset-4">Consultar reportes</h2></div>
<div class="col-lg-8 col-lg-offset-2">
    <table id="tablareportes" class="well display col-lg-2">
        <thead>
            <tr>
                <th>Id</th>
                <th>Reporte</th>
                <th>Descargar</th>
            </tr>
        </thead>
    </table>
</div>

<div class='modal fade' id='Modaldescargar' tabindex='-1' role='dialog' aria-labelledby='Modaldescargar' aria-hidden='true'>
    <div class='modal-dialog modal-md'>
        <div class='modal-content'>
            <div class='modal-header bg-green'>    
                <h3 class='col-lg-12 col-lg-offset-3'>Confirmar descarga</h3>
                <a style='margin-top:20px' id='btndescargar' class='btn btn-danger col-lg-4 col-lg-offset-1'>Descargar</a>
                <a style='margin-top:20px' class='btn btn-info col-lg-4 col-lg-offset-2' data-dismiss='modal'>Cancelar</a>
            </div>
        </div>
    </div>
</div>