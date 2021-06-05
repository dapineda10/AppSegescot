<?php

class DespachoController extends ControladorBase {

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

    public function indexcrear() {
//Creamos el objeto Cliente
        $cliente = new Cliente($this->adapter);
//Conseguimos todos los clientes (se utiliza metodo de (entidadbase) )
        $allusers = $cliente->getAll();

        $usuario = new Usuario($this->adapter);
//Conseguimos todos los despacho (se utiliza metodo de (entidadbase) )
        $allusuario = $usuario->getAll();

//Cargamos la vista index y le pasamos valores
        $this->view("despacho/indexcrearDespacho", array(
            "allusers" => $allusers,
            "allusuario" => $allusuario
        ));
    }
    //producto para despachar
     public function buscador2() {
        $buscarproducto = new Producto($this->adapter);
        $buscarproducto = $buscarproducto->buscartodo();
        echo json_encode($buscarproducto);
    }
    //Consulta para despachos con json, para la vista de mostrar todo de despacho
     public function buscartodoslosdespachos() {
        $buscardespacho = new Despacho($this->adapter);
        $buscardespacho = $buscardespacho->buscardespachojson();
        echo json_encode($buscardespacho);
    }
    
        public function mostrardatosdespacho() {
        $despachomostrar = new Despacho($this->adapter);
        $id = (int) $_POST["id"];
        $vectorAll = array();
        $valor = $despachomostrar->getById($id, "des_CodigoDespacho");
        $vectorAll[] = $valor;
        
        //$vectorAll[] = $otroVector;
        
        echo json_encode($valor);
    }

    public function creardespacho() {
//Si algún dato de los que necesita es POST entonces:

        if (isset($_POST["des_ObservacionesEnvio"])) {
//Creamos un despacho
            $despacho = new Despacho($this->adapter);
            $despacho->setDes_CodigoDespacho($_POST["des_CodigoDespacho"]);
            $despacho->setDes_Transportadora($_POST["des_Transportadora"]);
            $despacho->setDes_ObservacionesEnvio($_POST["des_ObservacionesEnvio"]);
            $despacho->setDes_Contrato_Oc($_POST["des_Contrato_Oc"]);
            $despacho->setDes_NumeroGuia($_POST["des_NumeroGuia"]);
            $despacho->setDes_CantidadCajas($_POST["des_CantidadCajas"]);
            $despacho->setDes_FechaEnvio($_POST["des_FechaEnvio"]);
            $despacho->setDes_Numfactura($_POST["des_Numfactura"]);
            $despacho->setCli_documento($_POST["cli_documento"]);
            $despacho->setUsu_documento($_POST["usu_documento"]);
            $savedespacho = $despacho->savedespacho();
        }
        $this->redirect("Despacho", "indexcrear");
    }
    public function consultardespacho() {
        $despachoconsultar = new despacho($this->adapter);
        $selectfiltro = isset($_POST['filtro']) ? $_POST['filtro'] : "";
        if (isset($_POST["documento_consultar"])) {
            $allusers = $despachoconsultar->getAll();
//variable para guardar vector de getBy
            $id = $_POST["documento_consultar"];
            if ($id == "") {
                $valor = $despachoconsultar->getAll();
            } else {
//Conseguimos el metodo getby el cual me envia un vector y debo guardar en una variable
                $valor = $despachoconsultar->getBy($selectfiltro, $id);
            }
//Cargamos la vista index y le pasamos valores
            $this->view("despacho/modificardespacho", array(
                "despachofiltro" => $valor,
                "allusers" => $allusers,
                "documento_consultar" => $id
            ));
        } else if (isset($_GET["documento_consultar"])) {
            $allusers = $despachoconsultar->getAll();
//variable para guardar vector de getBy
            $id = $_GET["documento_consultar"];
//Conseguimos el metodo getby el cual me envia un vector y debo guardar en una variable
            $valor = $despachoconsultar->getBy('des_CodigoDespacho', $id);
//Cargamos la vista index y le pasamos valores
            $this->view("despacho/modificardespacho", array(
                "despachofiltro" => $valor,
                "allusers" => $allusers,
                "mensajes" => "El despacho ha sido modificado con exito",
                "documento_consultar" => $id
            ));
        } else {
            $valor = $despachoconsultar->getAll();
            $this->view("despacho/modificardespacho", array(
                "despacho" => null,
                "documento_consultar" => "",
                "despachofiltro" => $valor,
            ));
        }
    }

    public function indexmodificar() {
//Creamos el objeto despacho
        $despacho = new Despacho($this->adapter);
        $valor = NULL;
//Conseguimos todos los despacho (se utiliza metodo de (entidadbase) )
        if (isset($_POST["id"])) {
//variable para guardar vector de getById
            $id = (int) $_POST["id"];
//Conseguimos el metodo getbyid el cual me envia un vector y debo guardar en una variable
            $valor = $despacho->getById($id, "des_CodigoDespacho");
//Cargamos la vista index y le pasamos valores
        }
        $allusers = $despacho->getAll();

//Cargamos la vista index y le pasamos valores
        $this->view("despacho/modificardespacho", array(
            "allusers" => $allusers,
            "despacho" => $valor
        ));
    }

    public function modificardespacho() {
//Creamos el objeto despachos 
        $modificardespacho = new Despacho($this->adapter);
        $cliente = new Cliente($this->adapter);
        $allclient = $cliente->getAll();
        $usuario = new Usuario($this->adapter);
        $allusuario = $usuario->getAll();
        if (isset($_GET["id"])) {
//variable para guardar vector de getById
            $id = (int) $_GET["id"];
        }
//Conseguimos el metodo getbyid el cual me envia un vector y debo guardar en una variable
        $valor = $modificardespacho->getById($id, "des_CodigoDespacho");

//Cargamos la vista index y le pasamos valores
        $this->view("despacho/despachomodificar", array(
            "allclient" => $allclient,
            "allusuario" => $allusuario,
            "modificardespacho" => $valor
        ));
    }

    public function modificarbd() {
        $despacho = new Despacho($this->adapter);
//setear todos los campos
        if (isset($_POST["codigodespacho"])) {
//Creamos un despacho
            $despacho = new Despacho($this->adapter);
            $despacho->setDes_CodigoDespacho($_POST["codigodespacho"]);
            $despacho->setDes_Transportadora($_POST["transportadora"]);
            $despacho->setDes_ObservacionesEnvio($_POST["ObservacionesEnvio"]);
            $despacho->setDes_Contrato_Oc($_POST["contrato"]);
            $despacho->setDes_NumeroGuia($_POST["NumeroGuia"]);
            $despacho->setDes_CantidadCajas($_POST["CantidadCajas"]);
            $despacho->setDes_FechaEnvio($_POST["fechaenvio"]);
            $despacho->setDes_Numfactura($_POST["Numfactura"]);
            $despacho->setCli_documento($_POST["cli_documento"]);
            $despacho->setUsu_documento($_POST["usu_documento"]);
            $updatedespaco = $despacho->updatedespacho();
        }
       $this->redirect("despacho", "consultardespacho&documento_consultar=" . $despacho->getDes_CodigoDespacho());
//$this->redirect("Despacho", "indexmodificar");
    }

//Borrar un despacho
 public function borrar() {
        if (isset($_GET["id"])) {
            $id = (int) $_GET["id"];
            $despacho = new Despacho($this->adapter);
            $resp = $despacho->deleteById("des_CodigoDespacho", $id);
            if ($resp == 1) {
                $vec_res = array("Mensaje" => "Exito al borrar");
            } else if ($resp == 1451) {
                $vec_res = array("Mensaje" => "El Despacho no se puede eliminar ya que tiene otras tablas asociadas");
            } else {
                $vec_res = array("Mensaje" => "Hubo un error al borrar  $resp");
            }
            echo json_encode($vec_res);
        }
        //$this->redirect("despacho", "consultardespacho&documento_consultar=" . $despacho->getDes_CodigoDespacho()); 
    }
    
    
    //se agregan los despachos a la tabla Depachoproducto
    public function agregardespacho() {
        $CodigoDespacho = $_SESSION['des_CodigoDespacho'];
        $CodigoProducto = $_POST["prd_codigoProducto"];
        $NumeroCaja = $_POST["des_NumeroCaja"];
        $TiempoGarantia = $_POST["prd_TiempoGarantia"];
        $cantidadVenta = $_POST["prd_cantidadVenta"];
        
        echo $_SESSION['des_CodigoDespacho'];
        //objeto de Despacho producto para gregar a la base de datos
        $despachoproducto = new Despachoproducto($this->adapter);
        $despachoproducto->setdes_CodigoDespacho($CodigoDespacho);
        $despachoproducto->setprd_nombre($CodigoProducto);
        $despachoproducto->setdes_NumeroCaja($NumeroCaja);
        $despachoproducto->setprd_TiempoGarantia($TiempoGarantia);
        $despachoproducto->setprd_cantidadVenta($cantidadVenta);
        $save = $despachoproducto->save();   
    }
    public function buscardespacho() {
        
         //asignar codigo de despacho a variable de sessión
        $coddesp = $_POST['des_CodigoDespacho'];
        $_SESSION['des_CodigoDespacho'] = $coddesp;
        //retornar consulta para condición al hacer una cotización        
        $obtenerdatos = new Despachoproducto($this->adapter);
        $obtener = $obtenerdatos->save();
    
    }
    //metodo para buscar en el combo despacho - cliente
    public function buscarcliente() {
        $cliente = new Cliente($this->adapter);
        $allclient = $cliente->getAll();
        echo json_encode($allclient);
    }
        public function buscarusuario() {
        $usuario = new Usuario($this->adapter);
        $allusuario = $usuario->getAll();
        echo json_encode($allusuario);
    }
}