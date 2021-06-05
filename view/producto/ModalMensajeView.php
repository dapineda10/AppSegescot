<script>
    jsFunction();
</script>

<div class='modal fade' id='MyModalMensaje' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-green'>
                <div class='container col-lg-6 col-lg-offset-3'>
                    <h1 style="text-align: center"> <?php echo $respuesta?></h1>
                </div>
                    <a id="volverMasivo" style='margin-top:20px' class='btn btn-info col-lg-4 col-lg-offset-1' data-dismiss='modal'>Volver a subir</a>
                    <a id="log" style='margin-top:20px' class='btn btn-danger col-lg-4 col-lg-offset-2' data-dismiss='modal'>Descargar Log</a>
            </div>
        </div>
    </div>
</div>