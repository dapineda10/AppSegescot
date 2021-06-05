<?php

class ContactoController extends ControladorBase {

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
        //Creamos el objeto $contacto
        $cliente = new cliente($this->adapter);
        $allcliente = $cliente->getAll();

        $proveedor = new proveedor($this->adapter);
        $allproveedor = $proveedor->getAll();

        // Cargamos la vista index y le pasamos valores
        $this->view("contacto/contacto", array(
            "allcliente" => $allcliente,
            "allproveedor" => $allproveedor
        ));
    }

    public function crearcontacto() {
        if (isset($_POST["con_codigo"])) {
            if (isset($_POST['checkradiocontacto'])) {
                $captura = $_POST['checkradiocontacto'];
                $captura1 = "NULL";
                $captura2 = "NULL";
                $captura3 = "NULL";
                if ($captura == 1) {
                    $captura1 = $_POST['cli_documento'];
                } else if ($captura == 2) {
                    $captura2 = $_POST['pro_nit'];
                }
                $crearcontacto = new Contacto($this->adapter);
                $crearcontacto->setCon_codigo($_POST["con_codigo"]);
                $crearcontacto->setPro_nit($captura2);
                $crearcontacto->setCli_documento($captura1);
                $crearcontacto->setCon_estadoCivil($_POST["con_estadoCivil"]);
                $crearcontacto->setCon_cargo($_POST["con_cargo"]);
                $crearcontacto->setCon_telefono($_POST["con_telefono"]);
                $crearcontacto->setCon_profesion($_POST["con_profesion"]);
                $crearcontacto->setCon_nombreCompleto($_POST["con_nombreCompleto"]);
                $crearcontacto->setCon_fechaNacimiento($_POST["con_fechaNacimiento"]);
                $crearcontacto->setCon_email($_POST["con_email"]);
                $save = $crearcontacto->save();
                $this->redirect("Contacto", "index");
            } else {
                $cliente = new cliente($this->adapter);
                $allcliente = $cliente->getAll();

                $proveedor = new proveedor($this->adapter);
                $allproveedor = $proveedor->getAll();

                // Cargamos la vista index y le pasamos valores
                $this->view("contacto/contacto", array(
                    "allcliente" => $allcliente,
                    "allproveedor" => $allproveedor,
                    "error" => "Debe seleccionar una opción de Tipo de contacto"
                ));
            }
        } else {
            $this->view("contacto/contacto", array(
                "error1" => "Debe ingresar un contacto"
            ));
            //$this->redirect("Contacto", "crearcontacto");
        }
    }
/*
    public function mostrarcontacto() {
        $contacto = new Contacto($this->adapter);
        $id = (int) $_POST["id"];
        $vectorAll = array();
        $valor = $contacto->getById($id, "con_codigo");
        $vectorAll[] = $valor;
        echo json_encode($valor);
    }*/
    
    public function mostrarcontacto() {
     $buscarcontacto = new Contacto($this->adapter);
        $buscarcon = $buscarcontacto->buscartodocontacto();
        echo json_encode($buscarcon);
    }

    public function modificar() {
        //Creamos el objeto cliente
        $contacto = new Contacto($this->adapter);
        if (isset($_GET["id"])) {
            //variable para guardar vector de getById
            $id = (int) $_GET["id"];
        }
        //Conseguimos el metodo getbyid el cual me envia un vector y debo guardar en una variable
        $valor = $contacto->getById($id, "cli_documento");
        //Cargamos la vista index y le pasamos valores

        $this->view("cliente/indexcliente", array(
            "cliente" => $valor
        ));
    }

    public function modificarbd() {
        //setear todos los campos

        if (isset($_POST["codigo"])) {
            //Creamos un cliente
            $contacto = new Contacto($this->adapter);
            $contacto->setCon_codigo($_POST["codigo"]);
            $contacto->setCon_estadoCivil($_POST["estadoCivil"]);
            $contacto->setCon_cargo($_POST["cargo1"]);
            $contacto->setCon_telefono($_POST["telefono"]);
            $contacto->setCon_profesion($_POST["profesion"]);
            $contacto->setCon_nombreCompleto($_POST["nombre"]);
            $contacto->setCon_fechaNacimiento($_POST["fechaNacimiento"]);
            $contacto->setCon_email($_POST["correo"]);
            $update = $contacto->update();
        } else {
            echo 'no entra';
        }
        $this->redirect("contacto", "consultarcontacto&documento_consultar=" . $contacto->getCon_codigo());
    }

    public function consultarcontacto() {
        $contacto = new contacto($this->adapter);
        $selectfiltro = isset($_POST['filtro']) ? $_POST['filtro'] : "";
            if (isset($_POST["con_consultar"])) {
                $allusers = $contacto->getAll();
                //variable para guardar vector de getBy
                $id = $_POST["con_consultar"];
                if ($id == "") {
                    $valor = $contacto->getAll();
                } else {
                    //Conseguimos el metodo getby el cual me envia un vector y debo guardar en una variable
                    $valor = $contacto->getBy($selectfiltro, $id);
                }
                //Cargamos la vista index y le pasamos valores
                $this->view("contacto/MostrarTodoContacto", array(
                    "contactofiltro" => $valor,
                    "allusers" => $allusers,
                    "con_consultar" => $id
                ));
        } else if (isset($_GET["con_consultar"])) {
            $allusers = $contacto->getAll();
            //variable para guardar vector de getBy
            $id = $_GET["con_consultar"];
            //Conseguimos el metodo getby el cual me envia un vector y debo guardar en una variable
            $valor = $contacto->getBy('cp_nit', $id);
            //Cargamos la vista index y le pasamos valores
            $this->view("contacto/MostrarTodoContacto", array(
                "contactofiltro" => $valor,
                "allusers" => $allusers,
                "mensajes" => "El cliente ha sido modificado con exito",
                "con_consultar" => $id
            ));
        } else {
            $valor = $contacto->getAll();
            $this->view("contacto/MostrarTodoContacto", array(
                "contactofiltro" => $valor,
                "con_consultar" => null
            ));
        }
    }
        public function borrar() {
        if (isset($_GET["id"])) {
            $id = (int) $_GET["id"];

            $contacto = new Contacto($this->adapter);
            $resp =$contacto->deleteById("con_codigo", $id);
        }
            if ($resp == 1) {
                $vec_res = array("Mensaje" => "Exito al borrar");
            } else if ($resp == 1451) {
                $vec_res = array("Mensaje" => "El contacto no se puede eliminar ya que tiene otras tablas asociadas");
            } else {
                $vec_res = array("Mensaje" => "Hubo un error al borrar");
            }
            echo json_encode($vec_res);
        }
}
