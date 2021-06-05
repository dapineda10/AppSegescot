<?php

class ClienteController extends ControladorBase {

//danny
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

    public function index() {
//Creamos el objeto cliente
        $cliente = new cliente($this->adapter);
//Conseguimos todos los clientespotenciales (se utiliza metodo de (entidadbase) )
        $allusers = $cliente->getAll();

//Cargamos la vista index y le pasamos valores
        $this->view("cliente/indexcliente", array(
            "allusers" => $allusers
        ));
    }

//Index número tres para mostrar cliente potencial
    public function index3() {
        //Cargamos la vista index y le pasamos valores
        $this->view("clientepotencial/indexclientepotencial");
    }

    public function crearcliente() {
//Si algún dato de los que necesita es POST entonces:
        $fechaactual = date("Y") . "-" . date("m") . "-" . date("d");
        if (isset($_POST["cli_documento"])) {
//Creamos un cliente o cliente potencial
            $cliente = new cliente($this->adapter);
            $cliente->setCli_documento($_POST["cli_documento"]);
            $cliente->setCli_paginaWeb($_POST["cli_paginaWeb"]);
            $cliente->setCli_direccion($_POST["cli_direccion"]);
            $cliente->setCli_email($_POST["cli_email"]);
            $cliente->setCli_zonaCliente($_POST["cli_zonaCliente"]);
            $cliente->setCli_ciudad($_POST["cli_ciudad"]);
            $cliente->setCli_nombre($_POST["cli_nombre"]);
            $cliente->setCli_pais($_POST["cli_pais"]);
            $cliente->setCli_telefono($_POST["cli_telefono"]);
            $cliente->setCli_password($_POST["cli_password"]);
            $cliente->setCli_tipocliente($_POST["cli_tipocliente"]);
            $cliente->setCli_antes_cliente_potencial($_POST["cli_antes_cliente_potencial"]);
            //Si el cliente es potencial entonces que se llene el campo Cli_fecha_ingreso_potencial
            if ($_POST["cli_tipocliente"] == 1) {
                $cliente->setCli_fecha_ingreso_potencial($fechaactual);
                $cliente->setCli_fecha_ingreso('null');
            } else {
                $cliente->setCli_fecha_ingreso_potencial('null');
                $cliente->setCli_fecha_ingreso($fechaactual);
            }
            $savecliente = $cliente->savecliente();
        }
        //Dependiendo del tipo de cliente que ingrese se redirecciona al formulario si es 0 es cliente de la empresa y si es 1 es cliente potencial
        if ($_POST["cli_tipocliente"] == 0) {
            $this->redirect("cliente", "index");
        } else {
            $this->redirect("cliente", "index3");
        }
    }

    public function consultarcliente() {
        $clienteconsultar = new cliente($this->adapter);
        $selectfiltro = isset($_POST['filtro']) ? $_POST['filtro'] : "";
        if (isset($_POST["documento_consultar"])) {
            $allusers = $clienteconsultar->getAll();
//variable para guardar vector de getBy
            $id = $_POST["documento_consultar"];
            if ($id == "") {
                $valor = $clienteconsultar->getAll();
            } else {
//Conseguimos el metodo getby el cual me envia un vector y debo guardar en una variable
                $valor = $clienteconsultar->getBy($selectfiltro, $id);
            }
//Cargamos la vista index y le pasamos valores
            $this->view("cliente/Mostrartodo", array(
                "clientefiltro" => $valor,
                "allusers" => $allusers,
                "documento_consultar" => $id
            ));
        } else if (isset($_GET["documento_consultar"])) {
            $allusers = $clienteconsultar->getAll();
//variable para guardar vector de getBy
            $id = $_GET["documento_consultar"];
//Conseguimos el metodo getby el cual me envia un vector y debo guardar en una variable
            $valor = $clienteconsultar->getBy('cli_documento', $id);
//Cargamos la vista index y le pasamos valores
            $this->view("cliente/Mostrartodo", array(
                "clientefiltro" => $valor,
                "allusers" => $allusers,
                "mensajes" => "El cliente ha sido modificado con exito",
                "documento_consultar" => $id
                    )
            );
        } else {
            $valor = $clienteconsultar->getAll();
            $this->view("cliente/Mostrartodo", array(
                "cliente" => null,
                "documento_consultar" => "",
                "clientefiltro" => $valor,
            ));
        }
    }

//Datos de la lista de clientes, tabla dinamica
    public function mostrardatos() {
        $buscarcliente = new Cliente($this->adapter);
        $buscarcliente = $buscarcliente->buscartodocliente();
        echo json_encode($buscarcliente);
    }

//mostrar datos de la tabla de datos dinamica,mostrar cliente potencial de la tabla de cliente
    public function mostrardatoscp() {
        //Consulta de cliente potencial sobre la tabla de cliente
        $buscarclientepotencial = new cliente($this->adapter);
        $buscarcp = $buscarclientepotencial->buscartodoclientepotencial();
        echo json_encode($buscarcp);
    }

    public function modificar() {
//Creamos el objeto cliente
        $cliente = new cliente($this->adapter);
        if (isset($_GET["id"])) {
//variable para guardar vector de getById
            $id = (int) $_GET["id"];
        }
//Conseguimos el metodo getbyid el cual me envia un vector y debo guardar en una variable
        $valor = $cliente->getById($id, "cli_documento");
//Cargamos la vista index y le pasamos valores

        $this->view("cliente/Mostrartodo", array(
            "cliente" => $valor
        ));
    }

    public function modificarbd() {
//setear todos los campos
        if ($_POST["codigo"]) {
            $cliente = new cliente($this->adapter);
//Creamos un cliente
            $cliente->setCli_documento($_POST["codigo"]);
            $cliente->setCli_paginaWeb($_POST["paginaweb"]);
            $cliente->setCli_direccion($_POST["direccion"]);
            $cliente->setCli_email($_POST["email"]);
            $cliente->setCli_zonaCliente($_POST["zonacliente"]);
            $cliente->setCli_ciudad($_POST["ciudad"]);
            $cliente->setCli_nombre($_POST["nombre"]);
            $cliente->setCli_pais($_POST["pais"]);
            $cliente->setCli_telefono($_POST["telefono"]);
            $cliente->setCli_password($_POST["password"]);
            $update = $cliente->update();
        }
        //Validar si viene tipo 1 y si es así enviar a la primera vista, sino a la segunda
        if ($_POST["cli_tipocliente"] == 1) {
            $this->redirect("cliente", "index3");
        } else {
            $this->redirect("cliente", "consultarcliente&documento_consultar=" . $cliente->getCli_documento());
        }
//header("Location:index.php?controller=" . $controlador . "&action=" . $accion);
    }

    public function modificarbdpasarcliente() {
//setear todos los campos
        if (isset($_GET["documento"])) {
            $cliente = new cliente($this->adapter);
//Creamos un cliente
            $cliente->setCli_documento($_GET["documento"]);
            $cliente->setCli_tipocliente($_GET["tipocliente"]);
            $update = $cliente->updatpasarcliente();
        }
        $this->redirect("cliente", "index3");
    }

    public function index2() {
//Creamos el objeto cliente
        $cliente = new cliente($this->adapter);
        $valor = NULL;
//Conseguimos todos los clientes (se utiliza metodo de (entidadbase) )
        if (isset($_POST["id"])) {
//variable para guardar vector de getById
            $id = (int) $_POST["id"];
//Conseguimos el metodo getbyid el cual me envia un vector y debo guardar en una variable
            $valor = $cliente->getById($id, "cli_documento");
//Cargamos la vista index y le pasamos valores
        }
        $allusers = $cliente->getAll();

//Cargamos la vista index y le pasamos valores
        $this->view("cliente/Mostrartodo", array(
            "allusers" => $allusers,
            "cliente" => $valor
        ));
    }

//Borrar un cliente
    public function borrar() {

        if (isset($_GET["id"])) {
            $id = (int) $_GET["id"];
            $cliente = new Cliente($this->adapter);
            $resp = $cliente->deleteById("cli_documento", $id);
            if ($resp == 1) {
                $vec_res = array("Mensaje" => "Exito al borrar");
            } else if ($resp == 1451) {
                $vec_res = array("Mensaje" => "El cliente no se puede eliminar ya que tiene otras tablas asociadas");
            } else {
                $vec_res = array("Mensaje" => "Hubo un error al borrar  $resp");
            }
            echo json_encode($vec_res);
        }
//  $this->redirect("cliente", "consultarcliente&documento_consultar=" . $cliente->getCli_documento());
    }

    public function perfil() {
        $this->layout = "user_layout";
        //$this->view("userCliente/inicio");
        //Creamos el objeto
        $cliente = new Cliente($this->adapter);
        //Conseguimos todos los clientes (se utiliza metodo de (entidadbase) )
        $allusers = $cliente->getAll();

        //Cargamos la vista index y le pasamos valores
        $this->view("userCliente/perfil", array(
            "allusers" => $allusers
        ));
    }

//metodo para buscar cliente, para combo de contacto
    public function buscarcliente() {
        $cliente = new cliente($this->adapter);
        $allclient = $cliente->buscartodocliente1();
        echo json_encode($allclient);
    }

}
