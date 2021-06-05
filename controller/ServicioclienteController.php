<?php

class ServicioclienteController extends ControladorBase {

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

    public function crearservicio() {
        //Si algún dato de los que necesita es POST entonces:
        if (isset($_POST["cli_documento"])) {
            //Creamos un servicio
            $serviciocliente = new Serviciocliente($this->adapter);
            //$serviciocliente->setSer_ticket($_POST["ser_ticket"]);
            $serviciocliente->setSer_fechaInicial($_POST["ser_fechaInicial"]);
            $serviciocliente->setSer_estado($_POST["ser_estado"]);
            //$serviciocliente->setSer_fechaFin($_POST["ser_fechaFin"]);
            $serviciocliente->setSer_descripcion($_POST["ser_descripcion"]);
            $serviciocliente->setCli_documento($_POST["cli_documento"]);
            $serviciocliente->setSer_tipoSoporte($_POST["ser_tipoSoporte"]);


            $saveservicio = $serviciocliente->saveservicio();
        }
        $this->redirect("Serviciocliente", "index");
    }

    public function crearservicios() {
        //Si algún dato de los que necesita es POST entonces:
        if (isset($_POST["ser_ticket"])) {
            //Creamos un servicio
            $serviciocliente = new Serviciocliente($this->adapter);
            //$serviciocliente->setSer_ticket($_POST["ser_ticket"]);
            $serviciocliente->setSer_fechaInicial($_POST["ser_fechaInicial"]);
            $serviciocliente->setSer_estado($_POST["ser_estado"]);
            $serviciocliente->setSer_fechaFin($_POST["ser_fechaFin"]);
            $serviciocliente->setSer_descripcion($_POST["ser_descripcion"]);
            $serviciocliente->setCli_documento($_POST["cli_documento"]);
            $serviciocliente->setSer_tipoSoporte($_POST["ser_tipoSoporte"]);
            $saveservicio = $serviciocliente->saveservicio();
        }
        $this->redirect("Serviciocliente", "consultarservicios");
    }

    public function index() {
        $this->layout = "user_layout";
        //Creamos el objeto clientepotencial
        $consultarservicio = new Serviciocliente($this->adapter);
        $valor = NULL;
        //Conseguimos todos los clientespotenciales (se utiliza metodo de (entidadbase) )
        if (isset($_POST["cons_servicio"])) {
            //variable para guardar vector de getById
            $id = (int) $_POST["cons_servicio"];
            //Conseguimos el metodo getbyid el cual me envia un vector y debo guardar en una variable
            $valor = $consultarservicio->getById($id, "ser_ticket");
            //Cargamos la vista index y le pasamos valores
        }
        $serviciocliente = new Serviciocliente($this->adapter);
        $allusers = $consultarservicio->getAll();
        //Cargamos la vista index y le pasamos valores
        $this->view("ServicioCliente/Servicio_cliente", array(
            "allusers" => $allusers,
            "Serviciocliente" => $valor,
            "valor" => $valor
        ));
    }

    public function consultarservicio() {
        $this->layout = "user_layout";
        $serviciocliente = new Serviciocliente($this->adapter);
        $this->view("ServicioCliente/Servicio_cliente", array(
            "Serviciocliente" => $valor,
        ));
    }

    public function consultarservicios() {
        $servicios = new Serviciocliente($this->adapter);
        
        //Conseguimos todos los clientespotenciales (se utiliza metodo de (entidadbase) )
        if (isset($_POST["cons_servicio"]) && $_POST["cons_servicio"]!="") {
            //variable para guardar vector de getById
            $id = (int) $_POST["cons_servicio"];
            //Conseguimos el metodo getbyid el cual me envia un vector y debo guardar en una variable
            $valor = $servicios->getBy("ser_ticket", $id);
            //Cargamos la vista index y le pasamos valores
            $allusers = NULL;
        } else {
            $valor = NULL;
            $allusers = $servicios->getAll();
        }
        $this->view("ServicioCliente/Mostrarmodificarservicio", array(
                "allusers" => $allusers,
                "valor" => $valor
            ));
    }

    public function consultarestado() {
        $estado = new Serviciocliente($this->adapter);
        $valor = NULL;

        if (isset($_POST["ser_estado"])) {
            $tipoestado = ($_POST["ser_estado"]);
            $consultarestado = $estado->consultarestado($tipoestado);
        }
        $this->view("ServicioCliente/Mostrarmodificarservicio", array(
            "allusers" => null,
            "valor" => $consultarestado
        ));
    }

    public function mostrardatoservicio() {
        $serviciomostrar = new Serviciocliente($this->adapter);
        $id = (int) $_POST["id"];
        $valor = $serviciomostrar->getById($id, "ser_ticket");
        echo json_encode($valor);
    }

    public function modificarbd() {

        $serviciocliente = new Serviciocliente($this->adapter);
        //setear todos los campos
        if (isset($_POST["ser_ticket"])) {
            //creamo un servicio
//            $serviciocliente = new Serviciocliente($this->adapter);
            $serviciocliente->setSer_ticket($_POST["ser_ticket"]);
            $serviciocliente->setSer_fechaInicial($_POST["ser_fechaInicial"]);
            $serviciocliente->setCli_documento($_POST["cli_documento"]);
            $serviciocliente->setSer_estado($_POST["ser_estado"]);
            $serviciocliente->setSer_tipoSoporte($_POST["ser_tipoSoporte"]);
            $serviciocliente->setSer_descripcion($_POST["ser_descripcion"]);
            $serviciocliente->setSer_fechaFin($_POST["ser_fechaFin"]);
            $update = $serviciocliente->updateservicio();
        } $this->redirect("Serviciocliente", "consultarservicios");
    }

}