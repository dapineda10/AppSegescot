<?php
$cliente = new Cliente($this->adapter);
$allcliente = $cliente->getAll();

//print_r($valor);
?>

<div class="container">
    <div class="col-lg-10 col-lg-offset-1 well"><div class="well text-center"><h3>Servicio al cliente</h3></div>
        <div class="">
            <form id="cons_servicio" method="POST" action="index.php?controller=Serviciocliente&action=consultarservicios">
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
                <div><input  class="btn btn-success" type="submit" id="consultar" name="consultar" value="Consultar" >
                    <a class='btn btn-danger' data-target='#ModalServicio' data-toggle='modal' data-id='$serviciocliente->ser_ticket' href='#' style='margin-top: 1px;'>Nuevo</a></div>

            </form>
        </div><br>
        <div class="col-lg-12">
            <form id="ser_ticket" name="cons_servicio" method="POST" action="index.php?controller=Serviciocliente&action=consultarestado">
                <?php
                $consultarservicio = isset($consultarservicio->ser_fechaInicial) ? $consultarservicio->ser_fechaInicial : "";
                $consultarservicio = isset($consultarservicio->ser_estado) ? $consultarservicio->ser_estado : "";
                $consultarservicio = isset($consultarservicio->ser_fechaFin) ? $consultarservicio->ser_fechaFin : "";
                $consultarservicio = isset($consultarservicio->ser_descripcion) ? $consultarservicio->ser_descripcion : "";
                $consultarservicio = isset($consultarservicio->cli_documento) ? $consultarservicio->cli_documento : "";
                $consultarservicio = isset($consultarservicio->ser_tipoSoporte) ? $consultarservicio->ser_tipoSoporte : "";
                $consultarservicio = isset($consultarservicio->ser_ticket) ? $consultarservicio->ser_ticket : "";
                ?>
                <div class="col-lg-1"><strong>Estado:</strong></div>
                <div class="col-lg-3">
                    <select class="form-control " id="ser_estado" name="ser_estado">
                        <option value="Cerrado" name="Cerrado">Cerrado</option>
                        <option value="Pendiente" name="Pendiente">Pendiente</option>
                        <option value="En proceso" name="En proceso">En proceso</option>
                    </select>
                </div>
                <div class="col-lg-2"><input  class="form-control " type="submit" id="consultar" >
                </div>

            </form></div><br><br><br>


        <div class="row well ">

            <div class="col-xs-2"><strong>Ticket</strong></div>
            <div class="col-xs-2"><strong>Estado</strong></div>
            <div class="col-xs-2"><strong>tipo</strong></div>
            <div class="col-xs-4"><strong>Cliente</strong></div>
            <div class="col-xs-2"><strong>Acciones</strong></div>
        </div>
        <div class="row">

            <?php
            if ($valor == null) {
                if (isset($allusers)) {
                    foreach ($allusers as $serviciocli) { //recorremos el array de objetos y obtenemos el valor de las propiedades 
                        ?>
                        <div class="accordion-container">
                            <a href="Javascript:void();" class="accordion-titulo">
                                <div class="col-xs-2"><?php echo $serviciocli->ser_ticket . ""; ?> </div> 
                                <div class="col-xs-2"> <?php echo $serviciocli->ser_estado . ""; ?> </div> 
                                <div class="col-xs-2"> <?php echo $serviciocli->ser_tipoSoporte . ""; ?> </div>
                                <div class="col-xs-2"> <?php echo $serviciocli->cli_documento . ""; ?></div> 
                                <br>
                                <span class="toggle-icon"></span></a>
                            <div class="accordion-content">
                                <div class="container col-xs-7 col-xs-offset-3 col-lg-6 col-lg-offset-3" >
                                    <form id="editar" method="POST" action="index.php?controller=Serviciocliente&action=modificarbd">
                                        <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                            <h2 class="col-xs-10 col-xs-offset-1 col-lg-12">Editar</h2>
                                        </div>
                                        <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                            <h4>Ticket</h4>
                                            <input class="form-control" type="hidden" id="ser_ticket"name="ser_ticket" value="<?php echo $serviciocli->ser_ticket . ""; ?>">
                                            <input class="form-control" disabled id="ser_ticket"name="ser_ticket" value="<?php echo $serviciocli->ser_ticket . ""; ?>">
                                        </div>
                                        <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                            <h4>Creado</h4>
                                            <input class="form-control" type="hidden" id="ser_fechaInicial" name="ser_fechaInicial" value="<?php echo $serviciocli->ser_fechaInicial . ""; ?>">
                                            <input class="form-control" disabled id="ser_fechaInicial" name="ser_fechaInicial" value="<?php echo $serviciocli->ser_fechaInicial . ""; ?>">
                                        </div>
                                        <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                            <h4>Cliente</h4>
                                            <input class="form-control" type="hidden"  id="cli_documento" name="cli_documento" placeholder="Nombre" value="<?php echo $serviciocli->cli_documento . ""; ?>">
                                            <input class="form-control" disabled type="text"  id="cli_documento" name="cli_documento" placeholder="Nombre" value="<?php echo $serviciocli->cli_documento . ""; ?>">
                                        </div>
                                        <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                            <h4>Estado</h4>
                                            <input class="form-control" type="text"   id="ser_estado" name="ser_estado" value="<?php echo $serviciocli->ser_estado . ""; ?>">
                                        </div>
                                        <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                            <h4>Tipo de soporte</h4>
                                            <input class="form-control" type="hidden"  id="ser_tipoSoporte" name="ser_tipoSoporte" value="<?php echo $serviciocli->ser_tipoSoporte . ""; ?>">
                                            <input class="form-control" disabled  id="ser_tipoSoporte" name="ser_tipoSoporte" value="<?php echo $serviciocli->ser_tipoSoporte . ""; ?>">
                                        </div>
                                        <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                            <h4>Descripcion</h4>
                                            <textarea class="form-control" type="textarea" id="ser_descripcion" name="ser_descripcion"><?php echo $serviciocli->ser_descripcion . ""; ?></textarea>
                                        </div>

                                        <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                            <h4>Fin del caso</h4>
                                            <input class="form-control" type="date"  id="ser_fechaFin" name="ser_fechaFin" value="<?php echo $serviciocli->ser_fechaFin . ""; ?>">
                                        </div>

                                        <div class="col-xs-12 col-xs-offset-1 col-lg-5 form-group" style="margin-top: 10px;">
                                            <input class="form-control  btn btn-success"  value="Guardar" type="submit" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                }
            } else {

                foreach ($valor as $val) { //recorremos el array de objetos y obtenemos el valor de las propiedades 
                    ?>
                    <div class="accordion-container">
                        <a href="Javascript:void(0);" class="accordion-titulo">
                            <div class="col-xs-2"> <?php echo $val->ser_ticket . ""; ?> </div>
                            <div class="col-xs-2"> <?php echo $val->ser_estado . "  "; ?> </div> 
                            <div class="col-xs-2"> <?php echo $val->ser_tipoSoporte . "  "; ?> </div> 
                            <div class="col-xs-2"> <?php echo $val->cli_documento . "  "; ?> </div> 
                            <br>
                            <span class="toggle-icon"></span></a>
                        <div class="accordion-content">
                            <div class="container col-xs-7 col-xs-offset-3 col-lg-6 col-lg-offset-3">
                                <form id="editar" method="POST" action="index.php?controller=Serviciocliente&action=modificarbd">
                                    <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                        <h2 class="col-xs-10 col-xs-offset-1 col-lg-12">Editar</h2>
                                    </div>
                                    <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                        <h4>Ticket</h4>
                                        <input class="form-control" type="hidden" id="ser_ticket"name="ser_ticket" value="<?php echo $val->ser_ticket . ""; ?>">
                                        <input class="form-control" disabled id="ser_ticket"name="ser_ticket" value="<?php echo $val->ser_ticket . ""; ?>">
                                    </div>
                                    <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                        <h4>Creado</h4>
                                        <input class="form-control" type="hidden" id="ser_fechaInicial" name="ser_fechaInicial" value="<?php echo $val->ser_fechaInicial . ""; ?>">
                                        <input class="form-control" disabled id="ser_fechaInicial" name="ser_fechaInicial" value="<?php echo $val->ser_fechaInicial . ""; ?>">
                                    </div>
                                    <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                        <h4>Cliente</h4>
                                        <input class="form-control" type="hidden"  id="cli_documento" name="cli_documento" placeholder="Nombre" value="<?php echo $val->cli_documento . ""; ?>">
                                        <input class="form-control" disabled type="text"  id="cli_documento" name="cli_documento" placeholder="Nombre" value="<?php echo $val->cli_documento . ""; ?>">
                                    </div>
                                    <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                        <h4>Estado</h4>
                                        <input class="form-control" type="text"   id="ser_estado" name="ser_estado" value="<?php echo $val->ser_estado . ""; ?>">
                                    </div>
                                    <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                        <h4>Tipo de soporte</h4>
                                        <input class="form-control" type="hidden"  id="ser_tipoSoporte" name="ser_tipoSoporte" value="<?php echo $val->ser_tipoSoporte . ""; ?>">
                                        <input class="form-control" disabled  id="ser_tipoSoporte" name="ser_tipoSoporte" value="<?php echo $val->ser_tipoSoporte . ""; ?>">
                                    </div>
                                    <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                        <h4>Descripcion</h4>
                                        <textarea class="form-control" type="textarea" id="ser_descripcion" name="ser_descripcion"><?php echo $val->ser_descripcion . ""; ?></textarea>
                                    </div>

                                    <div class="col-xs-12 col-xs-offset-1 col-lg-10">
                                        <h4>Fin del caso</h4>
                                        <input class="form-control" type="date"  id="ser_fechaFin" name="ser_fechaFin" value="<?php echo $val->ser_fechaFin . ""; ?>">
                                    </div>

                                    <div class="col-xs-12 col-xs-offset-1 col-lg-5 form-group" style="margin-top: 10px;">
                                        <input class="form-control  btn btn-success"  value="Guardar" type="submit" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>   


        </div>
    </div>

    <?php
    echo "
             <div class='modal fade' id='ModalServicio' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
              <div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header bg-green'>
            <div class='container col-xs-7 col-xs-offset-3 col-lg-6 col-lg-offset-3'>
                <form id='editar' method='POST' action='index.php?controller=Serviciocliente&action=crearservicios'>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h2 class='col-xs-10 col-xs-offset-1 col-lg-12'>Nuevo servicio</h2>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Ticket*</h4>";
    $resultado = $serviciocli->ser_ticket + 1;
    echo "
                        <input id='ser_ticket' type='hidden' name='ser_ticket' class='form-control'  value='$resultado'>
                        <input id='ser_ticket' disabled name='ser_ticket' class='form-control'  value='$resultado'>                        
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Creado*</h4>
                            <input type='date' class='form-control' id='ser_fechaInicial'name='ser_fechaInicial' value=''>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>";
//Combobox de Cliente
    echo "       <div id='cli_documento' >    
                          <p >Cliente</p>
                        <select  id='cli_documento' name='cli_documento' class='form-control selcls'>";
//var_dump($allusers);
    if ($allcliente != '') {
        foreach ($allcliente as $item) {
            echo "<option value='$item->cli_documento'>$item->cli_nombre</option>";
        }
    }
    echo "    
                        </select>
                        </div>                   </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Estado*</h4>
                        <input class='form-control' type='text'   id='ser_estado' name='ser_estado' value='Pendiente'>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Tipo de soporte</h4>
                        <select class='form-control' type='text'  id='ser_tipoSoporte' name='ser_tipoSoporte'>
                         <option value='Abierto'>Relamación</option>
                         <option value='Abierto'>Consultar</option>
                         <option value='Abierto'>Soporte</option>
                         <option value='Abierto'>Otros</option>
                        </select>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Descripcion*</h4>
                        <textarea class='form-control' type='textarea' id='ser_descripcion' name='ser_descripcion' placeholder='Observaciones' value=''></textarea>
                    </div>
                    <div class='col-xs-12 col-xs-offset-1 col-lg-10'>
                        <h4>Cerrar caso</h4>
                        <input class='form-control' type='date'  id='ser_fechaFin' name='ser_fechaFin' >
                    </div>
                    
                    <div class='col-xs-12 col-xs-offset-1 col-lg-5 form-group' style='margin-top: 10px;'>
                        <input id='guardar_ticket' class='form-control  btn btn-success'  value='Guardar' type='submit' />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

             </div>";
    ?>
</div>