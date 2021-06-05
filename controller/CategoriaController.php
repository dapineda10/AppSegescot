<?php

class categoriaController extends ControladorBase {

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
        //Creamos el objeto producto
        $categoria = new Categoria($this->adapter);
        //Conseguimos todos los productos (se utiliza metodo de (entidadbase) )
        $allusers = $categoria->getAll();

        //Cargamos la vista index y le pasamos valores
        $this->view("categoria/categoria", array(
            "allusers" => $allusers
        ));
		
		
    }

    public function crearcategoria() {
        //Si algún dato de los que necesita es POST entonces:

        if (isset($_POST["cat_idCategoria"])) {
            //Creamos una categoria
            $categoria = new Categoria($this->adapter);
            $categoria->setCat_idCategoria($_POST["cat_idCategoria"]);
            $categoria->setCat_nombre($_POST["cat_nombre"]);
            $categoria->setCat_descripcion($_POST["cat_descripcion"]);
			$save = $categoria->save();
        }
		//Redirect al controlador y la función
        $this->redirect("Categoria", "index");
        
    }

}
