<?php

class SeguimientoController extends ControladorBase {

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

    //Consulta datos de seguimiento
    public function mostrardatosseg() {
        $buscarseguimiento = new seguimiento($this->adapter);
        $buscarseg = $buscarseguimiento->buscartodoseguimiento();
        echo json_encode($buscarseg);
    }
    
    //Crea datos en tabla seguimiento
    public function crearseguimiento() {
        $sesionusuario = $_SESSION['documento'];
        $seguimiento = new seguimiento($this->adapter);
        if (isset($_POST["cot_codigoCotizacion"])) {
            //Guardar seguimiento en bd
            $seguimiento->setCot_codigoCotizacion($_POST["cot_codigoCotizacion"]);
            $seguimiento->setSeg_fechaRegistro(date("Y/m/d"));
            $seguimiento->setUsu_documento($sesionusuario );
            $seguimiento->setSeg_fechacompromiso($_POST["seg_fechacompromiso"]);
            $seguimiento->setSeg_comentario($_POST["seg_comentario"]);
            $saveseguimiento = $seguimiento->saveseguimiento();        
        }
        $this->redirect("Cotizacion", "consultarcotizacion");
    }
    
    /*
    //Consulta datos del seguimiento, un sólo cajetin
    public function consultarseguimiento() {
        $cotizaciones = new seguimiento($this->adapter);
        //Conseguimos todos los las cotizaciones 
        if (isset($_POST["seg_cotizacion"]) && $_POST["seg_cotizacion"]!="") {
            //variable para guardar vector de getById
            $id = (int) $_POST["seg_cotizacion"];
            //Conseguimos el metodo getbyid el cual me envia un vector y debo guardar en una variable
            $valor = $cotizaciones->getById("cot_codigoCotizacion", $id);
            //Cargamos la vista index y le pasamos valores
            $allusers = $valor;
        } else {
            $valor = NULL;
            $allusers = $cotizaciones->getAll();
        }
        $this->view("cotizacion/mostrarseguimiento", array(
            "allusers" => $allusers,
            "valor" => $valor
                //$cotizaciones = $cotizaciones->consultar()   
        ));
    }*/
    
    public function consultarseg() {
        $seguimiento = new seguimiento($this->adapter);
        $selectfiltro = isset($_POST['filtro']) ? $_POST['filtro'] : "";
        if (isset($_POST["seg_consultar"])) {
            $allusers = $seguimiento->getAll();
            //variable para guardar vector de getBy
            $id = $_POST["seg_consultar"];
            if ($id == "") {
                $valor = $seguimiento->getAll();
            } else {
                //Conseguimos el metodo getby el cual me envia un vector y debo guardar en una variable
                $valor = $seguimiento->getBy($selectfiltro, $id);
            }
            //Cargamos la vista index y le pasamos valores
            $this->view("cotizacion/mostrarseguimiento", array(
                "segumientofiltro" => $valor,
                "allusers" => $allusers,
                "seg_consultar" => $id
            ));
        } else if (isset($_GET["seg_consultar"])) {
            $allusers = $seguimiento->getAll();
            //variable para guardar vector de getBy
            $id = $_GET["seg_consultar"];
            //Conseguimos el metodo getby el cual me envia un vector y debo guardar en una variable
            $valor = $seguimiento->getBy('cot_codigoCotizacion', $id);
            //Cargamos la vista index y le pasamos valores
            $this->view("cotizacion/mostrarseguimiento", array(
                "segumientofiltro" => $valor,
                "allusers" => $allusers,
                "mensajes" => "El cliente ha sido modificado con exito",
                "seg_consultar" => $id
            ));
        } else {
            $valor = $seguimiento->getAll();
            $this->view("cotizacion/mostrarseguimiento", array(
            "segumientofiltro" => $valor,
            "seg_consultar" => null
//           "mensajes" => "No es posible",
            ));
        }
    }
    
    
    //modificar datos
        //Este metodo se usa para hacer la modificacion de una cotizacion que se carga en el modal
    public function modificarbd() {

        $seguimiento = new seguimiento($this->adapter);
        //setear todos los campos
        if (isset($_POST["seg_ticket"])) {
            //Editar el seguimiento
            $seguimiento->setSeg_ticket($_POST["seg_ticket"]);
            $seguimiento->setSeg_comentario($_POST["seg_comentario"]);
            $seguimiento->setSeg_fechacompromiso($_POST["seg_fechacompromiso"]);
            $update = $seguimiento->updateseguimiento();
        } 
        $this->view("cotizacion/mostrarseguimiento");
    }
    
    
}