<?php

class ReportesController extends ControladorBase {

//Los dos atributos conectar y adapter sirven para hacer la conexion de la base de datos
    public $conectar;
    public $adapter;

    public function __construct() {
        parent::__construct();
//Se crea un objeto de tipo (conectar)
        $this->conectar = new Conectar();
        $this->adapter = $this->conectar->conexion();
//Se utiliza el objeto de tipo conectar para llamar una función del (controladorbase) 
//que es el que ejecuta la conexión
    }
   
       public function mostrarReportes() {
       
           
        $this->view("reportes/mostrarreportes", array(
            "allusers" => ""
            
                //$cotizaciones = $cotizaciones->consultar()   
        ));
    }



    public function reportecantidadcotizaciones() {

        header("Content-Type: application/octet-stream");
        header('Content-Disposition: attachment; filename="Cantidad De Cotizacion.xls"');


        $cotizaciones = new Reportes($this->adapter);

        $alluserscotizacion = $cotizaciones->cantidaddecotizaciones();


        //Encabezado de cotización
        if (isset($alluserscotizacion)) {
            foreach ($alluserscotizacion as $cotizaciones1) { //recorremos el array de objetos y obtenemos el valor de las propiedades
                $html = '
            
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
   <body>
    <style="border: 1px solid black">

    <table class="col-lg-10" style="border: 1px solid black" width="950">
    <th colspan="6" style="background-color:#2b4899;"><h2 style="color:white">Reporte Cantidad de cotizaciones</h2></th>
    </table>
    <table class="bpmTopnTail col-lg-12"  width="1000" >
     <thead>
        <tr>
            <th style="border: 1px solid black">ITEM</th>
            <th style="border: 1px solid black">Código de cotización</th>
            <th style="border: 1px solid black">Fecha de cotización</th>
            <th style="border: 1px solid black">Tipo de cotización</th>
            <th style="border: 1px solid black">Lugar de entrega</th>
            <th style="border: 1px solid black">Estado de venta</th>
        </tr>
    </table>
    </thead>
    </div>';
            }
        }
        if (isset($alluserscotizacion)) {
            $i = 0;
            $ivatotal = 0;
            $ivatotal2 = 0;
            $preciosubtotal = 0;
            $preciototal = 0;
            foreach ($alluserscotizacion as $cotizaciones) { //recorremos el array de objetos y obtenemos el valor de las propiedades                
                $i = $i + 1;
                $html .= '
                    <thead>
                    <table class="bpmTopnTail col-lg-12" width="1000">
        <tr>
                        <td style="border: 1px solid black;text-align:center ">' . $i . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cotizaciones->cot_codigoCotizacion . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cotizaciones->cot_fechacreacion . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cotizaciones->cot_tipocotizacion . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cotizaciones->cot_lugarEntrega . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cotizaciones->cot_estadoventa . '</td>
        </tr>
        </table>
        </thead>';
            }
        }
        echo $html;
    }
    //Consulta en la tabla reportes
    public function consultarReportes() {           
           $reportes = new Reportes($this->adapter);
             $valor = $reportes->consultarreportes();
             echo json_encode($valor);
    }
    
    //Reportes Para Clientes
     public function reporteclientes() {

        header("Content-Type: application/octet-stream");
        header('Content-Disposition: attachment; filename="Clientes.xls"');


        $cotizaciones = new Reportes($this->adapter);

        $alluserscotizacion = $cotizaciones->clientes();


        //Encabezado de cotización
        if (isset($alluserscotizacion)) {
            foreach ($alluserscotizacion as $cotizaciones1) { //recorremos el array de objetos y obtenemos el valor de las propiedades
                $html = '
            
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
   <body>
    <style="border: 1px solid black">

    <table class="col-lg-10" style="border: 1px solid black" width="950">
    <th colspan="7" style="background-color:#2b4899;"><h2 style="color:white">Clientes</h2></th>
    </table>
    <table class="bpmTopnTail col-lg-12"  width="1000" >
     <thead>
        <tr>
            <th style="border: 1px solid black">ITEM</th>
            <th style="border: 1px solid black">Documento</th>
            <th style="border: 1px solid black">Nombre</th>
            <th style="border: 1px solid black">Ciudad</th>
            <th style="border: 1px solid black">Telefono</th>
            <th style="border: 1px solid black">Correo</th>
            <th style="border: 1px solid black">Fecha de Ingreso</th>
        </tr>
    </table>
    </thead>
    </div>';
            }
        }
        if (isset($alluserscotizacion)) {
            $i = 0;
           
            foreach ($alluserscotizacion as $cotizaciones) { //recorremos el array de objetos y obtenemos el valor de las propiedades                
                $i = $i + 1;
                $html .= '
                    <thead>
                    <table class="bpmTopnTail col-lg-12" width="1000">
        <tr>
                        <td style="border: 1px solid black;text-align:center ">' . $i . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cotizaciones->cli_documento . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cotizaciones->cli_nombre . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cotizaciones->cli_ciudad . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cotizaciones->cli_telefono . '</td>
                            <td style="border: 1px solid black;text-align:center">' . $cotizaciones->cli_email . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cotizaciones->cli_fecha_ingreso  . '</td>
        </tr>
        </table>
        </thead>';
            }
        }
        echo $html;
    }
     //Reportes Para Clientes Potenciales
     public function reporteclientespotenciales() {

        header("Content-Type: application/octet-stream");
        header('Content-Disposition: attachment; filename="Clientes Potenciales.xls"');


        $clipotenciales= new Reportes($this->adapter);

        $allclientespotenc= $clipotenciales->clientespotenciales();


        //Encabezado de cotización
        if (isset($allclientespotenc)) {
            foreach ($allclientespotenc as $clipotenciales) { //recorremos el array de objetos y obtenemos el valor de las propiedades
                $html = '
            
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
   <body>
    <style="border: 1px solid black">

    <table class="col-lg-10" style="border: 1px solid black" width="950">
    <th colspan="7" style="background-color:#2b4899;"><h2 style="color:white">Clientes Potenciales</h2></th>
    </table>
    <table class="bpmTopnTail col-lg-12"  width="1000" >
     <thead>
        <tr>
            <th style="border: 1px solid black">ITEM</th>
            <th style="border: 1px solid black">Documento</th>
            <th style="border: 1px solid black">Nombre</th>
            <th style="border: 1px solid black">Ciudad</th>
            <th style="border: 1px solid black">Telefono</th>
            <th style="border: 1px solid black">Correo</th>
            <th style="border: 1px solid black">Fecha de Ingreso</th>
        </tr>
    </table>
    </thead>
    </div>';
            }
        }
        if (isset($allclientespotenc)) {
            $i = 0;
           
            foreach ($allclientespotenc as $clientespotenciaes) { //recorremos el array de objetos y obtenemos el valor de las propiedades                
                $i = $i + 1;
                $html .= '
                    <thead>
                    <table class="bpmTopnTail col-lg-12" width="1000">
        <tr>
                        <td style="border: 1px solid black;text-align:center ">' . $i . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $clientespotenciaes->cli_documento . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $clientespotenciaes->cli_nombre . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $clientespotenciaes->cli_ciudad . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $clientespotenciaes->cli_telefono . '</td>
                            <td style="border: 1px solid black;text-align:center">' . $clientespotenciaes->cli_email . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $clientespotenciaes->cli_fecha_ingreso_potencial   . '</td>
        </tr>
        </table>
        </thead>';
            }
        }
        echo $html;
    }
	
	
	    
    
      //Reportes Para Clientes Potenciales
     public function ReporteProductosPendientes() {

        header("Content-Type: application/octet-stream");
        header('Content-Disposition: attachment; filename="Productos Pendientes.xls"');


        $cargaMasiva= new CargaMasiva($this->adapter);

        $allProductosPendiente= $cargaMasiva->ProductosPendientes();


        //Encabezado de cotización
        if (isset($allProductosPendiente)) {
            foreach ($allProductosPendiente as $cargaMasiva) { //recorremos el array de objetos y obtenemos el valor de las propiedades
                $html = '
            
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
   <body>
    <style="border: 1px solid black">

    <table class="col-lg-10" style="border: 1px solid black" width="930">
    <th colspan="5" style="background-color:#2b4899;"><h2 style="color:white">Productos pendientes</h2></th>
    </table>
    <table class="bpmTopnTail col-lg-12"  width="1000" >
     <thead>
        <tr>
            <th style="border: 1px solid black">ITEM</th>
            <th style="border: 1px solid black">CÓDIGO</th>
            <th style="border: 1px solid black">ESTADO</th>
            <th style="border: 1px solid black">FECHA Y HORA</th>
            <th style="border: 1px solid black">ERROR</th>
        </tr>
    </table>
    </thead>
    </div>';
            }
        }
        if (isset($allProductosPendiente)) {
            $i = 0;
           
            foreach ($allProductosPendiente as $cargaMasivaDatos) { //recorremos el array de objetos y obtenemos el valor de las propiedades                
                $i = $i + 1;
                $html .= '
                    <thead>
                    <table class="bpmTopnTail col-lg-12" width="1000">
        <tr>
                        <td style="border: 1px solid black;text-align:center ">' . $i . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cargaMasivaDatos->prd_codigo . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cargaMasivaDatos->ppe_tipo . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cargaMasivaDatos->ppe_fecha . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cargaMasivaDatos->ppe_motivo . '</td>
        </tr>
        </table>
        </thead>';
            }
        }
        echo $html;
    }

}