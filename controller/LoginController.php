<?php

class LoginController extends ControladorBase {

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
        $this->layout = "login_layout";
    }

    public function index() {
        //Creamos el objeto $cotizaciones
        $usuario = new Usuario($this->adapter);
        //Conseguimos todas las cotizaciones (se utiliza metodo de (entidadbase) )
        $allusers = $usuario->getAll();

        // Cargamos la vista index y le pasamos valores
        $this->view("login/Login", array(
            "allusers" => $allusers
        ));
    }

    //Redirección a terminos y condiciones desde el Login
    public function index2() {
        $this->view("login/mensajebienvenida");
    }

    //Validación de usuario, se valida primero que tenga marcado el check y cuándo entra al check se validan los datos de seguridad
    public function login() {
        $usuario = new Usuario($this->adapter);
        if (isset($_POST["usu_email"]) && $_POST["usu_password"]) {
            $usuarioname = isset($_POST["usu_email"]) ? trim($_POST["usu_email"]) : "";
            $contrasenna = isset($_POST["usu_password"]) ? trim($_POST["usu_password"]) : "";
            if ($usuarioname == '' || $contrasenna == '') {
                $this->view("login/Login", array(
                    "errores" => "Debe completar todos los campos")
                );
            } else {
                //Creamos un usuario   
                $usuario->setUsu_email($usuarioname);
                $usuario->setUsu_password($contrasenna);
                $usuario->setUsu_documento($usuarioname);
                $check = isset($_POST["check"]);
                $allusers = $usuario->getAll();
                if ($check == "on") {
                    if ($usuario->validarLogin()) {
                        //Validar si el usuario ingresa por primera vez al sistema, si es así, entonces mostrar modal de bienvenida
                        $nuevavariable = $usuario->UsuarioNuevo();
                        //Envía falso cuándo el usuario que se registra tiene el usu_bienvenida en 0
                        if ($nuevavariable == false) {
                            $this->redirect("Default", "index2");
                            $usuario->setUsu_documento($usuarioname);
                            $usuario->setUsu_bienvenida($_POST["usu_bienvenida"]);
                            $updatebienvenida = $usuario->updatebienvenida();
                        } else {
                            $this->redirect("Default", "index");
                        }
                    } else {
                        $this->view("login/Login", array(
                            "errores" => "El usuario o contraseña son incorrectos")
                        );
                        echo "<script>alert(\"Usuario o contraseña incorrectos\");</script>";
                    }
                } else {
                    // Cargamos la vista index y le pasamos valores
                    $this->view("login/Login", array(
                        "allusers" => $allusers
                    ));
                    //echo 'No entra al if';
                }
            }
        } else {
            $this->view("login/Login");
        }
    }

    public function logout() {
        session_destroy();
        $this->view("login/Login");
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
