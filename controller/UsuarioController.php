<?php

class UsuarioController extends ControladorBase{

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
           $this->layout = "main_layout";
    }

    public function index() {
        //Creamos el objeto $cotizaciones
      $usuario = new Usuario($this->adapter);
        //Conseguimos todas las cotizaciones (se utiliza metodo de (entidadbase) )
        $allusers = $usuario->getAll();

        // Cargamos la vista index y le pasamos valores
        $this->view("usuario/registrarUsuario", array(
            "allusers" => $allusers
        ));  
    }
    public function registrarUsuario() {
          $roles = new Roles($this->adapter);
//Conseguimos todos los roles (se utiliza metodo de (entidadbase) )
        $allRol = $roles->getAll();
//Cargamos la vista index y le pasamos valores
        $this->view("usuario/registrarUsuario", array(
            "allRol" => $allRol
        ));
        //Si algún dato de los que necesita es POST entonces:
        if (isset($_POST["usu_documento"])) {
            //Creamos un usuario
            $usuario = new Usuario($this->adapter);
            $usuario->setUsu_documento($_POST["usu_documento"]);
            $usuario->setUsu_nombre($_POST["usu_nombre"]);
            $usuario->setUsu_fechaNacimiento($_POST["usu_fechaNacimiento"]);
            $usuario->setUsu_password($_POST["usu_password"]);
            $usuario->setUsu_telefono($_POST["usu_telefono"]);
            $usuario->setUsu_nombreUsuario($_POST["usu_nombreUsuario"]);
            $usuario->setUsu_direccion($_POST["usu_direccion"]);
            $usuario->setUsu_email($_POST["usu_email"]);
            $usuario->setUsu_rol($_POST["rol_idRol"]);
            $registrarusuario = $usuario->registrar();
            $this->view("usuario/registrarUsuario");
        }else{
           $this->view("usuario/registrarUsuario");
        } 
    }
    //Buscar todos los datos de usuarios
        public function mostrarusuarios() {
        $buscarusuarios = new Usuario($this->adapter);
        $buscarusu = $buscarusuarios->buscartodousuario();
        echo json_encode($buscarusu);
    }
    
    //Este metodo se usa para hacer la modificacion de un usuario que se carga en el modal
    public function modificarbd() {
        $usuario = new Usuario($this->adapter);
        //setear todos los campos
        if (isset($_POST["usu_documento"])) {
            //creamos una cotizacion
            $usuario->setUsu_documento($_POST["usu_documento"]);
            $usuario->setUsu_direccion($_POST["usu_direccion"]);
            $usuario->setUsu_email($_POST["usu_email"]);
            $usuario->setUsu_password($_POST["usu_password"]);
            $usuario->setUsu_nombreUsuario($_POST["usu_nombreUsuario"]);
            $usuario->setUsu_fechaNacimiento($_POST["usu_fechaNacimiento"]);
            $usuario->setUsu_telefono($_POST["usu_telefono"]);
            $usuario->setUsu_nombre($_POST["usu_nombre"]);
            $updateusuario = $usuario->updateusuario();
        } 
        $this->redirect("Usuario","index");
    }
}
