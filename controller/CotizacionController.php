<?php

class CotizacionController extends ControladorBase {

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

//Buscar todos los datos de las cotizaciones que están en estado de venta vendida o cerrada
    public function mostrardatoscotizacionvendida() {
        $buscarcotizacion = new Cotizacion($this->adapter);
        $buscarcot = $buscarcotizacion->buscartodocotizacion();
        echo json_encode($buscarcot);
    }

//Buscar todos los datos de las cotizaciones que están en estado de venta pendiente
    public function mostrardatoscotizacionpendiente() {
        $buscarcotizacion = new Cotizacion($this->adapter);
        $buscarcot = $buscarcotizacion->buscartodocotizacionpendiente();
        echo json_encode($buscarcot);
    }

//Autocompletar datos al momento buscar en la tabla de cotización
    public function buscador() {
        $buscarproducto = new Producto($this->adapter);
        if (isset($_GET['term'])) {
            $terminoConsulta = $_GET['term'];
            $buscarproducto = $buscarproducto->buscartodo1($terminoConsulta);
            echo json_encode($buscarproducto);
        }
    }

//Esta función se usa para buscar los datos y enviarlos por JSON para el datatable de jquery usado en buscar
//producto para cotizar
    public function buscador2() {
        $buscarproducto = new Producto($this->adapter);
        $buscarproducto = $buscarproducto->buscartodo();
        echo json_encode($buscarproducto);
    }

    public function index() {
//Creamos el objeto $cotizaciones
//Conseguimos todas las cotizaciones (se utiliza metodo de (entidadbase) )
        $cotizaciones = new Cotizacion($this->adapter);
        $allusers = $cotizaciones->getAll();
        $ultcod = $cotizaciones->ConsultarUltimoCodigo();

//Creamos el objeto $cliente
//Conseguimos todas las cotizaciones (se utiliza metodo de (entidadbase) )
        $contacto = new Contacto($this->adapter);
        $allcontac = $contacto->getAll();

// Cargamos la vista index y le pasamos valores
        $this->view("cotizacion/cotizacion", array(
            "allusers" => $allusers,
            "allcontac" => $allcontac,
            "ultcod" => $ultcod
        ));
    }

    public function crear() {
//Variable de sesión
        $sesionusuario = $_SESSION['documento'];
//Variable para fecha
        $fechaactual = date("Y") . "-" . date("m") . "-" . date("d");
//Si algún dato de los que necesita es POST entonces:
        if (isset($_POST["cot_codigoCotizacion"])) {
//Creamos una COTIZACION
            $cotizaciones = new Cotizacion($this->adapter);
            $cotizaciones->setCot_codigoCotizacion($_POST["cot_codigoCotizacion"]);
            $cotizaciones->setCon_codigo($_POST["con_codigo"]);
            $cotizaciones->setCot_validez($_POST["cot_validez"]);
            $cotizaciones->setCot_tiempoEntrega($_POST["cot_tiempoEntrega"]);
            $cotizaciones->setCot_lugarEntrega($_POST["cot_lugarEntrega"]);
            $cotizaciones->setCot_formaPago($_POST["cot_formaPago"]);
            $cotizaciones->setCot_fechaCotizacion($_POST["cot_fechaCotizacion"]);
            $cotizaciones->setCot_quien_crea($sesionusuario);
            $cotizaciones->setCot_fechacreacion($fechaactual);
            $cotizaciones->setCot_tipocotizacion($_POST["cot_tipocotizacion"]);
            $cotizaciones->setCot_estadoventa($_POST["cot_estadoventa"]);
            $save = $cotizaciones->save();
        }
        $this->redirect("Cotizacion", "index");
//echo "SQL> " . $query;
    }

//
    public function agregarproducto() {
        $codigocotizacion = $_SESSION['cot_codigoCotizacion'];
        $codigoproducto = $_POST["prd_CodigoProducto"];
        $precioventa = $_POST["cot_precioVenta"];
        $cantidad = $_POST["cot_cantdad"];
        $codigounico = $_POST["prd_codigo"];
        $sesionusuario = $_SESSION['documento'];
//objeto de ProductoCotizacion
        echo $_SESSION['cot_codigoCotizacion'];
        $Productocotizacion = new ProductoCotizacion($this->adapter);
        $Productocotizacion->setcot_codigoCotizacion($codigocotizacion);
        $Productocotizacion->setPrd_codigoProducto($codigoproducto);
        $Productocotizacion->setcot_cantdad($cantidad);
        $Productocotizacion->setcot_precioVenta($precioventa);
        $Productocotizacion->setPrd_codigo($codigounico);
        $Productocotizacion->setPrc_usuario_crea($sesionusuario);
        $save = $Productocotizacion->save();
    }

    public function buscarcotizacion() {
//asignar codigo de cotización a variable de sessión
        $codicoti = $_POST['cot_codigoCotizacion'];
////$codicoti = $_POST['cot_codigoCotizacion'];
        $_SESSION['cot_codigoCotizacion'] = $codicoti;
//retornar consulta para condición al hacer una cotización        
        $obtenerdatos = new ProductoCotizacion($this->adapter);
        $obtener = $obtenerdatos->obtenerdatos($codicoti);
        echo json_encode($obtener);
    }

    public function eliminarproducto() {
        $codiprod = $_POST['prd_codigo'];
        //$codigoauto = $_POST['prd_codigo'];
        //echo $codiprod;
        $obtenerdatos = new ProductoCotizacion($this->adapter);
        $obtener = $obtenerdatos->eliminarproducto($codiprod);
//        echo json_encode($obtener);
    }

    public function consultaproductocotizacion() {
        $codiprod = $_POST['prd_codigo'];

        $buscarproducto = new ProductoCotizacion($this->adapter);
        $buscarproducto = $buscarproducto->buscartodoproductocotizacion($codiprod);
        echo json_encode($buscarproducto);
    }

    //Este metodo se unsa para hacer la consulta de todas las cotizaciones

    public function consultarcotizacion() {
        $cotizaciones = new Cotizacion($this->adapter);
        //Conseguimos todos los las cotizaciones 

        if (isset($_POST["cons_cotizacion"]) && $_POST["cons_cotizacion"] != "") {
            //variable para guardar vector de getById
            $id = (int) $_POST["cons_cotizacion"];
            //Conseguimos el metodo getbyid el cual me envia un vector y debo guardar en una variable
            $valor = $cotizaciones->getById("cot_codigoCotizacion", $id);
            //Cargamos la vista index y le pasamos valores
            $allusers = $valor;
        } else {
            $valor = NULL;
            $allusers = $cotizaciones->getAll();
        }
        $this->view("cotizacion/mostrarcotizacion", array(
            "allusers" => $allusers,
            "valor" => $valor
                //$cotizaciones = $cotizaciones->consultar()   
        ));
    }

    //Este metodo se usa para hacer la modificacion de una cotizacion que se carga en el modal
    public function modificarbd() {

        $cotizacion = new Cotizacion($this->adapter);
        //setear todos los campos
        if (isset($_POST["cot_codigoCotizacion"])) {
            //creamos una cotizacion
            $cotizacion->setCot_codigoCotizacion($_POST["cot_codigoCotizacion"]);
            $cotizacion->setCon_codigo($_POST["con_codigo"]);
            $cotizacion->setCot_validez($_POST["cot_validez"]);
            $cotizacion->setCot_tiempoEntrega($_POST["cot_tiempoEntrega"]);
            $cotizacion->setCot_lugarEntrega($_POST["cot_lugarEntrega"]);
            $cotizacion->setCot_formaPago($_POST["cot_formaPago"]);
            $cotizacion->setCot_fechaCotizacion($_POST["cot_fechaCotizacion"]);
            $cotizacion->setCot_estadoventa($_POST["cot_estadoventa"]);
            $update = $cotizacion->updatecotizacion();
        }
        $this->redirect("Cotizacion", "consultarcotizacion&cot_codigoCotizacion=" . $cotizacion->getcot_codigoCotizacion());
    }

    public function mostrardatos() {
        $cotizacion = new Cotizacion($this->adapter);
        $id = (int) $_POST["id"];
        $valor = $cotizacion->getById($id, "cot_codigoCotizacion");
        echo json_encode($valor);
    }

    public function borrar() {
        if (isset($_GET["id"])) {
            $id = (int) $_GET["id"];

            $cotizacion = new Cotizacion($this->adapter);
            $resp = $cotizacion->deleteById("cot_codigoCotizacion", $id);
        }
        if ($resp == 1) {
            $vec_res = array("Mensaje" => "Exito al borrar");
        } else if ($resp == 1451) {
            $vec_res = array("Mensaje" => "No se puede eliminar ya que tiene otras tablas asociadas");
        } else {
            $vec_res = array("Mensaje" => "Hubo un error al borrar");
        }
        echo json_encode($vec_res);
    }

//metodo para buscar en el combo de crear corización
    public function buscarcontacto() {
        $contacto = new Contacto($this->adapter);
        $allcontac = $contacto->buscarcontactocotizacion();
        echo json_encode($allcontac);
    }

    public function consultarPreciosFijos() {
        // Funcion que recibe el código de un producto y consulta en la tabla productoprecio, los precios asociados a ese producto
        $obtener = array("msg" => "error");
        $codicoti = isset($_POST['prd_CodigoProducto']) ? $_POST['prd_CodigoProducto'] : -1;
        if ($codicoti != -1) {
            //retornar los precios de un producto específico        
            $obtenerdatos = new ProductoPrecio($this->adapter);
            $obtener = $obtenerdatos->obtenerdatos($codicoti);
        }
        echo json_encode($obtener);
    }

    public function reportexcel() {

        header("Content-Type: application/octet-stream");
        header('Content-Disposition: attachment; filename="Cotizacion"' . $_SESSION['cot_codigoCotizacion'] . '.xls"');


        $cotizaciones = new Cotizacion($this->adapter);


        $sesion = $_SESSION['cot_codigoCotizacion'];
        $alluserscotizacion = $cotizaciones->consultacotizacion($sesion);


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

    <table class="col-lg-10" style="border: 1px solid black" width="1000">
    <th colspan="7" style="background-color:#2b4899;"><h2 style="color:white">OFERTA COMERCIAL No.' . $cotizaciones1->cot_codigoCotizacion . '</h2></th>
    <table class="col-lg-12" style="border: 1px solid black" width="1000">    
    </table>
    <table class="col-lg-8" style="border: 1px solid black" width="200">
    <tr>
    <th style="background-color:#48ae4d;border: 1px solid black; text-align:center"><p>Fecha:</p></th>
    <td style="border: 1px solid;text-align:center"><p>' . $cotizaciones1->cot_fechacreacion . '</p></td>
    <th style="background-color:#48ae4d;border: 1px solid black; text-align:center"><p>Forma de pago:</p></th>
    <td style="border: 1px solid;text-align:center"><p>' . $cotizaciones1->cot_formaPago . '</p></td>
    <td><img width="95" style="margin-left: 60px" src="http://biosolutions.segescot.com/Uploads/imgcorporativas/logocorporativo.png"/></td>
    <td style="width:95px"></td>
    <td><img width="95" high="95" style="margin-top: 60px" src="http://biosolutions.segescot.com/images/segescot.png"/> </td>
    </tr>
    <tr>
    <th style="background-color:#48ae4d;border: 1px solid black;text-align:center"><p>Señores:</p></th>
    <td style="border: 1px solid black; text-align:center"><p>' . $cotizaciones1->cli_nombre . '</p></td>
    <th style="background-color:#48ae4d;border: 1px solid black;text-align:center"><p>Lugar de entrega:</p></th>
    <td style="border: 1px solid black; text-align:center"><p>' . $cotizaciones1->cot_lugarEntrega . '</p></td>
    </tr>
    <tr>
    <th style="background-color:#48ae4d;border: 1px solid black;text-align:center"><p>Contacto:</p></th>
    <td style="border: 1px solid black; text-align:center"><p>' . $cotizaciones1->con_nombreCompleto . '</p></td>
    <th style="background-color:#48ae4d;border: 1px solid black; text-align:center"><p>Tiempo entrega(días):</p></th>
    <td style="border: 1px solid black; text-align:center"><p>' . $cotizaciones1->cot_tiempoEntrega . '</p></td>     
    </tr>
    <tr>
    <th style="background-color:#48ae4d;border: 1px solid black;text-align:center"><p>Teléfono:</p></th>
    <td style="border: 1px solid black; text-align:center"><p>' . $cotizaciones1->con_telefono . '</p></td>
    <th style="background-color:#48ae4d;border: 1px solid black;text-align:center"><p>Validez de oferta(días):</p></th>
    <td style="border: 1px solid black; text-align:center"><p>' . $cotizaciones1->cot_validez . '</p></td>
    </tr>
    <tr>
    <th style="background-color:#48ae4d;border: 1px solid black;text-align:center"><p>E-mail:</p></th>
    <td style="border: 1px solid black; text-align:center"><p>' . $cotizaciones1->con_email . '</p></td>
    <th style="background-color:#48ae4d;border: 1px solid black;text-align:center"><p>E-mail/Telf::</p></th>
    <td style="border: 1px solid black; text-align:center"><p>info@biosolutions.com.co</p></td>
    </tr>
    <table>
    <table class="bpmTopnTail col-lg-12" style="border: 1px solid black" width="1000" >
     <thead>
        <tr style="border: 1px solid black">
            <th style="border: 1px solid black">ITEM</th>
            <th style="border: 1px solid black">DESCRIPCIÓN</th>
            <th style="border: 1px solid black">CANT</th>
            <th style="border: 1px solid black">VALOR UNITARIO</th>
            <th style="border: 1px solid black">IVA UNITARIO</th>
            <th style="border: 1px solid black">TOTAL</th>
            <th style="border: 1px solid black">IMAGEN ILUSTRATIVA</th>
            <th style="border: 1px solid black; background-color:#FC6655">PROVEEDOR</th>
            <th style="border: 1px solid black; background-color:#FC6655">CODIGO DE PRODUCTO</th>
            <th style="border: 1px solid black; background-color:#FC6655">COSTO DE PRODUCTO</th>
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
                    <table class="bpmTopnTail col-lg-12" style="border: 1px solid black" width="1000">
        <tr>
                        <td style="border: 1px solid black;text-align:center ">' . $i . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cotizaciones->prd_descripcion . '</td>
                        <td style="border: 1px solid black;text-align:center">' . $cotizaciones->cot_cantdad . '</td>
                        <td style="border: 1px solid black;text-align:center">' . '$' . $preciosubtotal1 = $cotizaciones->cot_precioVenta . '</td>
                        <td style="border: 1px solid black">' . '$' . $ivatotal2 = str_replace(".", ",", ($cotizaciones->prd_iva * $cotizaciones->cot_precioVenta) / 100) . '</td>
                        <td style="border: 1px solid black;text-align:center">' . '$' . $subtotalsolo1 = str_replace(".", ",", ((($cotizaciones->prd_iva * $cotizaciones->cot_precioVenta) / 100) + $cotizaciones->cot_precioVenta) * $cotizaciones->cot_cantdad) . '</td>
                        <td style="border: 1px solid black;text-align:center"><img width="13px"; height="19" src="http://biosolutions.segescot.com/Uploads/Productos/' . $cotizaciones->prd_foto . '"/></td>
                        <td style="border: 1px solid black; background-color:#FC6655;text-align:center ">' . $cotizaciones->pro_Nombre . '</td>
                        <td style="border: 1px solid black; background-color:#FC6655;text-align:center">' . $cotizaciones->prd_codigoProducto . '</td>
                        <td style="border: 1px solid black; background-color:#FC6655;text-align:center">' . '$' . str_replace(".", ",", $cotizaciones->prd_costo) . '</td>
        </tr>
        </table>
        </thead>';
                $ivatotal = ((($cotizaciones->prd_iva * $cotizaciones->cot_precioVenta) / 100) * $cotizaciones->cot_cantdad) + $ivatotal;
                $preciosubtotal = $cotizaciones->cot_precioVenta * $cotizaciones->cot_cantdad + $preciosubtotal;
                $preciototal = $ivatotal + $preciosubtotal;
            }
        }

        $html .= '    
            <table>
            <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th style="border: 1px solid black; background-color:#48ae4d">Subtotal</th>
            <th style="border: 1px solid black">' . '$' . str_replace(".", ",", $preciosubtotal) . '</th>
           </tr>
            <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th style="border: 1px solid black; background-color:#48ae4d">Iva</th>
            <th style="border: 1px solid black">' . '$' . str_replace(".", ",", $ivatotal) . '</th>
           </tr>
           <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th style="border: 1px solid black; background-color:#48ae4d">Total</th>
            <th style="border: 1px solid black">' . '$' . str_replace(".", ",", $preciototal) . '</th>
           </tr>
           </table>
           </tbody>
            </table>
            <table>
    <table class="bpmTopnTail col-lg-12" style="border: 1px solid black" width="1000" >
       <thead>
       <th colspan="6" style="border: 1px solid black"><p>RESUMEN OFERTA ECONÓMICA</p></h2></th>
        <tr style="border: 1px solid black">
            <th style="border: 1px solid black">ITEM</th>
            <th style="border: 1px solid black">NOMBRE</th>
            <th style="border: 1px solid black">CANT</th>
            <th style="border: 1px solid black">VALOR UNITARIO</th>
            <th style="border: 1px solid black">IVA UNITARIO</th>
            <th style="border: 1px solid black">TOTAL</th>
        </tr>
       </thead>
    </table>';

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
                    <table class="bpmTopnTail col-lg-12" style="border: 1px solid black" width="1000">
        <tr>
                        <td style="border: 1px solid black">' . $i . '</td>
                        <td style="border: 1px solid black">' . $cotizaciones->prd_nombre . '</td>
                        <td style="border: 1px solid black">' . $cotizaciones->cot_cantdad . '</td>
                        <td style="border: 1px solid black">' . '$' . $preciosubtotal1 = $cotizaciones->cot_precioVenta . '</td>
                        <td style="border: 1px solid black">' . '$' . $ivatotal2 = str_replace(".", ",", ($cotizaciones->prd_iva * $cotizaciones->cot_precioVenta) / 100) . '</td>
                        <td style="border: 1px solid black">' . '$' . $subtotalsolo1 = str_replace(".", ",", ((($cotizaciones->prd_iva * $cotizaciones->cot_precioVenta) / 100) + $cotizaciones->cot_precioVenta) * $cotizaciones->cot_cantdad) . '</td>
        </tr>
        </table>
        </thead>';
                $ivatotal = str_replace(".", ",", ((($cotizaciones->prd_iva * $cotizaciones->cot_precioVenta) / 100) * $cotizaciones->cot_cantdad) * $cotizaciones->cot_cantdad + $ivatotal);
                $preciosubtotal = str_replace(".", ",", $preciosubtotal1 + $preciosubtotal);
                $preciototal = str_replace(".", ",", ($ivatotal * $cotizaciones->cot_cantdad ) + $preciosubtotal);
            }
        }

        $html.='
        
        <table>   
        </table> 

        <table> 
           <tr rowspan="6">
           <td colspan="6">
           <h4>Trabajamos con esmero y calidad para ofertar las soluciones mas ajustadas a tus necesidades, estaré feliz de negociar la oferta con ustedes y llegar a acuerdos sobre las condiciones y precios inicialmente contenidos en esta oferta. 
           Siéntete libre de llamar o escribir para resolver cualquier inquietud.  www.biosolutions.com.co info@biosolutions.com.co 315 562 0236</h4>
           <td>
           </tr> 
     
           <tr rowspan="6">
           <td colspan="6">
           <h4> CONDICIONES PARA DEVOLUCIÓN Y CAMBIO DE PRODUCTOS 
           En los siguientes casos se acepta la devolución de un producto enviado, siempre y cuando no se haya importado de manera específica para ustedes:
           1. Equivocación en el envío por nuestra parte: Producto equivocado, Cantidad errada, Dirección de envío incorrecta, Error en la facturación. BIOSOLUTIOS ASUMIRÁ EL COSTO DE RECOGIDA Y REENVIO.
           2. Solicitud de producto equivocado por parte del cliente: El producto no debe abrirse, el empaque debe estar en perfecto estado y sin ninguna marca, enviar soporte escrito explicando los motivos de la devolución y responsabilizándose por mantener las condiciones de almacenamiento y transporte del producto, Los gastos de envío y condiciones de transporte adecuados serán asumidos por el cliente, y debe enviarse a las instalaciones de BIOSOLUTIONS antes de 5 días posteriores a la recepción del producto.
           3. No conformidad con el producto: Si se trata de reclamación por empaque o condiciones de temperatura fuera de rango, debe enviarse a BIOSOLUTIONS por escrito su No conformidad y comunicarse con su asesor o a la línea (6-8875300) para ser atendido.  Si se verifica que las condiciones de almacenamiento y uso corresponden a las definidas por el fabricante, y la No conformidad tiene lugar, entonces tomaremos las acciones correctivas y BIOSOLUTIONS asumirá los costos de recolección y posible cambio del producto.
           4. Si usted no está de acuerdo con la temperatura, o estado del producto y lo registró en la guía de transporte como CONTENIDO NO VERIFICADO.
           NO ACEPTAMOS LA DEVOLUCIÓN DE PRODCUTO EN LOS SIGUIENTES CASOS:
           1. Después de 72 horas de haber recibido el producto.
           2. Por no seguir los procedimientos enunciados arriba.
           3. Si usted devuelve el producto en malas condiciones de empaque y temperatura.
           4. Si no se siguieron las condiciones de almacenamiento y utilización descritas por el fabricante en sus instalaciones.
           5. Productos controlados por la Subdirección de Control y Fiscalización de Sustancias Químicas y Estupefacientes del Min. Defensa y el Derecho.
           6. Si usted ha utilizado una cantidad superior al 40% del producto despachado.
           7. Si el producto devuelto es un equipo importado y cumple con las condiciones de la cotización y orden de compra o contrato.
           8. Si en la guía de transporte usted no registra si el empaque está averiado, o evidencia contenido faltante.</h4>
           <td>
           </tr>   
           
           <tr rowspan="6">
           <td colspan="6">
           <h4>POLITICAS DE FLETES Y TRANSPORTE DE MERCANCIAS - Por favor tenga en cuenta que:
           1. Para pedidos mínimos de $120.000 a entregar en la ciudad de Manizales, Biosolutions Ltda, cubre los gastos de entrega. 
           2. Para pedidos superiores a $250.000 BIOSOLUTIONS cubre los gastos de transporte y seguro de envío de mercancías.
           3. Si su pedido es inferior a $250.000 el envío se realizará a través de nuestra transportadora aliada con pago contra entrega.
           4. Los tiempos de entrega están sujetos a lo tiempos establecidos por el transportador.
           5. Para productos refrigerados, Biosolutions realiza envío hasta el miércoles para ciudades con tiempos de entrega de 1 a 2 días. 
           Para ciudades con tiempos de entrega superiores, o para envío los días jueves o viernes, solicitamos autorización escrita por parte del cliente en la que asuma el riesgo y responsabilidad sobre el producto despachado.</h4>
           <td>
           </tr>           
           </table>
           </body>
        </html>';

        echo $html;
    }

}
