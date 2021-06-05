<?php
session_start();

class ControladorBase {

    protected $layout = "main_layout";

    public function __construct() {
		require_once 'conectar.php';
        require_once 'EntidadBase.php';

        //Incluir todos los modelos
        foreach (glob("model/*.php") as $file) {
            require_once $file;
        }

        /* Validar que el tiempo de inactividad del usuario no supere el tiempo definido en la variable global
          TIEMPO_INACTIVIDAD */
      if (isset($_SESSION['timeout'])) {
            //Calcular el tiempo de vida de la sesion
            $tiempoSesion = time() - $_SESSION["timeout"];
            if ($tiempoSesion > (TIEMPO_INACTIVIDAD * 60)) {
                session_destroy();
                $this->redirect("Login", "index");
            } else {
                //Establecer nuevamente el tiempo de inicio de sesión
                $_SESSION["timeout"] = time();
            }
        }
    }
    
    //Plugins y funcionalidades

    /*
     * Este método lo que hace es recibir los datos del controlador en forma de array
     * los recorre y crea una variable dinámica con el indice asociativo y le da el 
     * valor que contiene dicha posición del array, luego carga los helpers para las
     * vistas y carga la vista que le llega como parámetro. En resumen un método para
     * renderizar vistas.
     */
    
    public function view($vista, $datos = null) {
        if ($datos) {
            foreach ($datos as $id_assoc => $valor) {
                ${$id_assoc} = $valor;
            }
        }
		require_once 'view/layouts/' . $this->layout . '.php';
        //    require_once 'view/'. $vista. 'View.php';
    }

    public function redirect($controlador = CONTROLADOR_DEFECTO, $accion = ACCION_DEFECTO) {
	        header("Location:index.php?controller=" . $controlador . "&action=" . $accion);
    }


}


