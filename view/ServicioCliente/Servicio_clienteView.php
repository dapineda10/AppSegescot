<!--Para crear los requerimientos de servicio por parte de un cliente a la empresa prestadora
se genera un ticket para el cliente mientras se soluciona su problema, en el combo Tipo de servicio
se encuentra la información de los tipos de servicios brindados-->
<div class="container" >
    <div class="row">

        <div class="col-lg-5 well"><div class="well">Crear Servicio</div>

            <form method="POST" action="<?php echo "index.php?controller=Serviciocliente&action=crearservicio"; ?>">
                <div class="col-lg-6">Fecha de creación <input  class="form-control" name="ser_fechaInicial" type="text" id="fecha" value="<?php echo date("y/m/d"); ?>"readonly="readonly" ></div>
                <div class="col-lg-6">Estado inicial<input class="form-control" type="text" value="Pendiente" id="" readonly="readonly" name="ser_estado" /></div>
                <div class="col-lg-6">Documento o NIT <input class="form-control" type="text" value="<?php
                    if (isset($_SESSION['documento'])) {
                        echo $_SESSION['documento'] . "" . "";
                    }
                    ?>" id=""  name="cli_documento" readonly="readonly"  /></div>
                <div class="col-lg-12" >Tipo de servicio
                    <select class="form-control" name="ser_tipoSoporte"> 
                        <option>Consulta</option>
                        <option>Servicio Técnico</option>
                        <option>Reclamación</option>
                        <option>Otro</option>
                    </select></div>
                <div class="col-lg-12">Descripción<textarea class="form-control" rows="10"  type="" value="mama" id=""  name="ser_descripcion" ></textarea></div>
                <div class=" col-lg-12" style="margin-top:10px">
                    <button type="submit" onclick="buton();" class="form-control btn-success">Enviar</button></div>
            </form>

        </div>
        <div class="col-lg-5 well"><div class="well">Mis Soportes</div>
            <div class="">
                <form id="cons_servicio" method="POST" action="<?php echo "index.php?controller=Serviciocliente&action=index"; ?>">
                    <?php
                    $consultarservicio = isset($consultarservicio->ser_fechaInicial) ? $consultarservicio->ser_fechaInicial : "";
                    $consultarservicio = isset($consultarservicio->ser_estado) ? $consultarservicio->ser_estado : "";
                    $consultarservicio = isset($consultarservicio->ser_fechaFin) ? $consultarservicio->ser_fechaFin : "";
                    $consultarservicio = isset($consultarservicio->ser_descripcion) ? $consultarservicio->ser_descripcion : "";
                    $consultarservicio = isset($consultarservicio->cli_documento) ? $consultarservicio->cli_documento : "";
                    $consultarservicio = isset($consultarservicio->ser_tipoSoporte) ? $consultarservicio->ser_tipoSoporte : "";
                    $consultarservicio = isset($consultarservicio->ser_ticket) ? $consultarservicio->ser_ticket : "";
                    ?>
                    <div class="col-xs-12 col-lg-8" ><input class="form-control" type="text" name="cons_servicio"  placeholder="Consultar"></div>
                    <div><input  class="btn btn-success" type="submit" id="consultar" name="consultar" value="Consultar" ></div>
                </form>
            </div><br><br>

            <div class="row well ">

                <div class="col-xs-2"><strong>Ticket</strong></div>
                <div class="col-xs-2"><strong>Estado</strong></div>
                <div class="col-xs-2"><strong>tipo</strong></div>
                <div class="col-xs-2"><strong>Observaicion</strong></div>
            </div>
            <div class="row">
                <div class="well">
                    <?php
                    if ($valor == null) {
                        if (isset($allusers)) {
                            foreach ($allusers as $serviciocli) { //recorremos el array de objetos y obtenemos el valor de las propiedades 
                                ?> <div class="col-xs-2"> <?php echo $serviciocli->ser_ticket . "  "; ?> </div> <?php
                                ?> <div class="col-xs-2"> <?php echo $serviciocli->ser_estado . "  "; ?> </div> <?php
                                ?> <div class="col-xs-2"> <?php echo $serviciocli->ser_tipoSoporte . "  "; ?> </div> <?php
                                ?> <div class="col-xs-2"> <?php echo $serviciocli->ser_descripcion . "  "; ?> </div> <?php
                                ?> <br>
                                <div class="col-xs-12 col-lg-12">
                                    <a href = "<?php echo "index.php?controller=#&action=#r"; ?>&id=<?php echo $serviciocli->cp_nit; ?>" class="btn btn-danger">eliminar</a>
                                    <a href="index.php?controller=#&action=#&id=<?php echo $serviciocli->cp_nit; ?>" class="btn btn-info">Modificar</a>
                                </div>
                                <br>
                                <br>
                                <hr/>
                                <?php
                            }
                            ?>
                            <?php
                        }
                    } else {
                        ?> <div class="col-xs-2"> <?php echo $valor->ser_ticket . ""; ?> </div> <?php
                        ?> <div class="col-xs-2"> <?php echo $valor->ser_estado . "  "; ?> </div> <?php
                        ?> <div class="col-xs-2"> <?php echo $valor->ser_fechaFin . " "; ?> </div> <?php
                        ?> <div class="col-xs-2"> <?php echo $valor->ser_descripcion . "  "; ?> </div> <?php
                        ?> <div class="col-xs-2"> <?php echo $valor->ser_tipoSoporte . "  "; ?> </div> <?php
                        ?> <div class="col-xs-2"> <?php echo $valor->cli_documento . "  "; ?> </div> <?php
                        ?> <div class="col-xs-2"> <?php echo $valor->ser_tipoSoporte . "  "; ?> </div> <?php
                        ?><br>
                        <div class="col-xs-2">
                            <a href = "<?php echo "index.php?controller=Serviciocliente&action=borrar"; ?>&id=<?php echo $clientepot->cp_nit; ?>" class="btn btn-danger">eliminar</a>
                            <a href="index.php?controller=Serviciocliente&action=modificar&id=<?php echo $clientepot->ser_ticket; ?>" class="btn btn-info">Modificar</a>
                        </div>


                        <?php
                    }
                    ?>  
                </div>
            </div>



        </div>


    </div>
</div>