<?php

class ProveedorController extends ControladorBase {

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
        //Creamos el objeto clientepotencial
        $proveedor = new Proveedor($this->adapter);
        //Conseguimos todos los clientespotenciales (se utiliza metodo de (entidadbase) )
        $allusers = $proveedor->getAll();

        //Cargamos la vista index y le pasamos valores
        $this->view("proveedor/CrearProveedor", array(
            "allusers" => $allusers
        ));
    }

    public function index2() {
        //Creamos el objeto clientepotencial
        $proveedor = new Proveedor($this->adapter);
        //Conseguimos todos los clientespotenciales (se utiliza metodo de (entidadbase) )
        $allusers = $proveedor->getAll();

        //Cargamos la vista index y le pasamos valores
        $this->view("proveedor/ModificarProveedor1", array(
            "allusers" => $allusers
        ));
    }

    public function crearproveedor() {
        if (isset($_POST["pro_nit"])) {
            //Creamos un cliente
            $proveedor = new Proveedor($this->adapter);
            $proveedor->setPro_nit($_POST["pro_nit"]);
            $proveedor->setPro_paginaWeb($_POST["pro_paginaWeb"]);
            $proveedor->setPro_Nombre($_POST["pro_Nombre"]);
            $proveedor->setPro_emailEmpresa($_POST["pro_emailEmpresa"]);
            $proveedor->setPro_direccion($_POST["pro_direccion"]);
            $proveedor->setPro_telefono($_POST["pro_telefono"]);
            $proveedor->setPro_pais($_POST["pro_pais"]);
            $proveedor->setPro_ciudad($_POST["pro_ciudad"]);
            $saveproveedor = $proveedor->saveproveedor();
        }
        $this->redirect("proveedor", "index");
    }

    public function modificarproveedor() {
        //Creamos el objeto clientepotencial 
        $proveedor = new Proveedor($this->adapter);
        if (isset($_GET["id"])) {
            //variable para guardar vector de getById
            $id = (int) $_GET["id"];
        }
        //Conseguimos el metodo getbyid el cual me envia un vector y debo guardar en una variable
        $valor = $proveedor->getById($id, "pro_nit");
        //Cargamos la vista index y le pasamos valores
        $this->view("proveedor/ModificarProveedor", array(
            "proveedor" => $valor
        ));
    }
    
    public function modificarbd() {
        $proveedor = new Proveedor($this->adapter);
        //setear todos los campos
        if (isset($_POST["pro_nit"])) {

            //Creamos un clientepotencial
            $proveedor = new Proveedor($this->adapter);
            $proveedor->setPro_nit($_POST["pro_nit"]);
            $proveedor->setPro_paginaWeb($_POST["pro_paginaWeb"]);
            $proveedor->setPro_Nombre($_POST["pro_Nombre"]);
            $proveedor->setPro_emailEmpresa($_POST["pro_emailEmpresa"]);
            $proveedor->setPro_direccion($_POST["pro_direccion"]);
            $proveedor->setPro_telefono($_POST["pro_telefono"]);
            $proveedor->setPro_pais($_POST["pro_pais"]);
            $proveedor->setPro_ciudad($_POST["pro_ciudad"]);
            $updateproveedor = $proveedor->updateproveedor();
        }
        //$this->redirect("Proveedor", "consultarproveedor&prov_consultar=" . $proveedor->getPro_nit());
        $this->redirect("Proveedor", "consultarproveedor");
    }

    public function consultarproveedor() {
        $proveedor = new proveedor($this->adapter);
        $selectfiltro = isset($_POST['filtro']) ? $_POST['filtro'] : "";
        if (isset($_POST["prov_consultar"])) {
            $allusers = $proveedor->getAll();
            //variable para guardar vector de getBy
            $id = $_POST["prov_consultar"];
            if ($id == "") {
                $valor = $proveedor->getAll();
            }else {
                //Conseguimos el metodo getby el cual me envia un vector y debo guardar en una variable
                $valor = $proveedor->getBy($selectfiltro, $id);
            }
            //Cargamos la vista index y le pasamos valores
            $this->view("proveedor/MostrarTodoproveedor", array(
                "proveedorfiltro" => $valor,
                "allusers" => $allusers,
                "prov_consultar" => $id
            ));
        } else if (isset($_GET["prov_consultar"])) {
            $allusers = $proveedor->getAll();
            //variable para guardar vector de getBy
            $id = $_GET["prov_consultar"];
            //Conseguimos el metodo getby el cual me envia un vector y debo guardar en una variable
            $valor = $proveedor->getBy('pro_nit', $id);
            //Cargamos la vista index y le pasamos valores
            $this->view("proveedor/MostrarTodoproveedor", array(
                "proveedorfiltro" => $valor,
                "allusers" => $allusers,
                "mensajes" => "El proveedor ha sido modificado con exito",
                "prov_consultar" => $id
            ));
        } else {
            $valor = $proveedor->getAll();
            $this->view("proveedor/MostrarTodoproveedor", array(
                "proveedorfiltro" => $valor,
                "prov_consultar" => null
            ));
        }
    }
public function mostrarproveedor() {
       $buscarproveedor = new Proveedor($this->adapter);
        $buscarprov = $buscarproveedor->buscartodoproveedor();
        echo json_encode($buscarprov);
   }

   public function borrar() {
        if (isset($_GET["id"])) {
            $id = (int) $_GET["id"];

            $proveedor = new Proveedor($this->adapter);
            $resp =$proveedor->deleteById("pro_nit", $id);
        }
            if ($resp == 1) {
                $vec_res = array("Mensaje" => "Exito1 al borrar");
            } else if ($resp == 1451) {
                $vec_res = array("Mensaje" => "El Proveedor1 no se puede eliminar ya que tiene otras tablas asociadas");
            } else {
                $vec_res = array("Mensaje" => "Hubo1 un error al borrar");
            }
            echo json_encode($vec_res);
        }
        
    //metodo para buscar cliente, para combo de contacto
    public function buscarproveedor() {
        $contacto = new proveedor($this->adapter);
        $allcontac = $contacto->getAll();
        echo json_encode($allcontac);
    }
   
}

