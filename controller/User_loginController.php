<?php

class user_loginController extends ControladorBase {

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
        $this->layout = "user_layout";
    }

    public function index() {
        $this->layout = "login_layout";
        //Creamos el objeto $cotizaciones
        $cliente = new Cliente($this->adapter);
        //Conseguimos todas las cotizaciones (se utiliza metodo de (entidadbase) )
        $allusers = $cliente->getAll();

        // Cargamos la vista index y le pasamos valores
        $this->view("login/userlogin", array(
            "allusers" => $allusers
        ));
          
        }
        
         public function inicio() {
        //Creamos el objeto $cotizaciones
        $cliente = new Cliente($this->adapter);
        //Conseguimos todas las cotizaciones (se utiliza metodo de (entidadbase) )
        $allusers = $cliente->getAll();

        // Cargamos la vista index y le pasamos valores
        $this->view("userCliente/inicio", array(
            "allusers" => $allusers
        ));
            
        }
        public function login() {
        if (isset($_POST["cli_email"]) && $_POST["cli_password"]) {
            $usuarioname = isset($_POST["cli_email"]) ? trim($_POST["cli_email"]) : "";
            $contrasenna = isset($_POST["cli_password"]) ? trim($_POST["cli_password"]) : "";

            if ($usuarioname == '' || $contrasenna == '') {
                $this->view("login/userlogin", array(
                    "errores" => "Debe completar todos los campos")
                );
            }
            else {
                //Creamos un usuario   
                $cliente = new cliente($this->adapter);
                $cliente->setCli_email($usuarioname);
                $cliente->setCli_password($contrasenna);
                $cliente->setCli_documento($usuarioname);
                if ($cliente->validarLogin1()) {
                    $this->redirect("User_login", "inicio");
                } else {
                    $this->layout = "login_layout";
                    $this->view("login/userlogin", array(
                        "errores" => "El usuario o contraseña son incorrectos")
                        
                    );
                    echo '<div class="alert alert-danger col-lg-4 col-lg-offset-4 id = "passincorrecta">Usuario o contraseña incorrectos</div>';
                    
                }
            }
        } else {
            $this->layout = "login_layout";
            $this->view("login/userlogin");
            
        }
  }

    public function logoutsesion() {
        $this->layout = "user_layout";
        session_destroy();
        $this->view("login/userlogin");
    }

    public function error($code = 0) {
        $codeMessage = (isset($_GET['msg']) ? $GET['msg'] : $code);
        $message = "";
        switch ($codeMessage) {
            case 1:
                $message = "No está autorizado para realizar esta accion";
                break;
            case 2:
                $message = "La acción que intenta cargar no existe";
                break;
            default:
                $message = "Error desconocido.";
                break;
        }
        $this->view("Login/Error", array(
            "message" => $message
        ));
    }

}
