<?php

class ProductoController extends ControladorBase {

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
        $producto = new Producto($this->adapter);
//Conseguimos todos los productos (se utiliza metodo de (entidadbase) )
        $allusers = $producto->getAll();

        $categoria = new Categoria($this->adapter);
//Conseguimos todos los productos (se utiliza metodo de (entidadbase) )
        $allCat = $categoria->getAll();

        $proveedor = new Proveedor($this->adapter);
//Conseguimos todos los productos (se utiliza metodo de (entidadbase) )
        $allProv = $proveedor->getAll();

//Cargamos la vista index y le pasamos valores
        $this->view("producto/crearproducto", array(
            "allCat" => $allCat,
            "allProv" => $allProv,
            "allusers" => $allusers
        ));
    }

    public function CargaMasivaView() {

        $proveedor = new Proveedor($this->adapter);
//Conseguimos todos los productos (se utiliza metodo de (entidadbase) )
        $allProv = $proveedor->getAll();

//Cargamos la vista index y le pasamos valores
        $this->view("producto/CargaMasiva", array(
        ));
    }
	
    public function crearproducto() {
//Si algún dato de los que necesita es POST entonces:
        if (isset($_POST["prd_codigoProducto"])) {
            $ruta_foto = isset($_POST["foto"]) ? $_POST["foto"] : "";
            $nombre_archivo = $_FILES["foto"]["name"];
            $tipo_archivo = $_FILES["foto"]["type"];
            $tamano_archivo = $_FILES["foto"]["size"];
            //Adjuntar imagen
          /*  echo $ruta_foto;
            echo $tipo_archivo;
            echo $tamano_archivo;*/
			
		if($tipo_archivo != "" || $tamano_archivo !=""){
            if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "png") || strpos($tipo_archivo, "jpg")) && ($tamano_archivo < 3000000))) {
                echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .gif o .jpeg o .jpg o .png<br><li>se permiten archivos de 3M máximo.</td></tr></table>";
            } else {
                $ruta_foto = $nombre_archivo;
                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta_foto)) {
                   // echo "El archivo ha sido cargado correctamente.";
                } else {
                   // echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
                }
            }
		}
            // Precios fijos productos
            $vectPrecios = [];
            $preciosProductos = isset($_POST['prdPrecios']) ? $_POST['prdPrecios'] : "";
            if($preciosProductos != "" && $preciosProductos != ","){
                $vectPrecios = explode(",", $preciosProductos);
            }
            //Creamos un producto
            $producto = new Producto($this->adapter);
            $producto->setPrd_codigoProducto($_POST["prd_codigoProducto"]);
            $producto->setCat_idCategoria($_POST["cat_idCategoria"]);
            $producto->setPro_nit($_POST["pro_nit"]);
            $producto->setPrd_tipoDivisa($_POST["prd_tipoDivisa"]);
            $producto->setPrd_costo($_POST["prd_costo"]);
            $producto->setPrd_tipoPresentacion($_POST["prd_tipoPresentacion"]);
            $producto->setPrd_nombre($_POST["prd_nombre"]);
            $producto->setPrd_descripcion($_POST["prd_descripcion"]);
            $producto->setPrd_foto($ruta_foto);
            $producto->setPrd_iva($_POST["prd_iva"]);
            $save = $producto->save();

            if($save && count($vectPrecios) > 0 ){
                $newProductoPrecio = new ProductoPrecio($this->adapter);
                $codProd = isset($_POST["prd_codigoProducto"]) ? $_POST["prd_codigoProducto"] : -1;
                $newProductoPrecio->setPrd_CodigoProducto($codProd);
                $newProductoPrecio->setVectorPrecios($vectPrecios);
                $newProductoPrecio->save();
            }
        }
        $this->redirect("producto", "crearproductoView");
    }

    public function consultarproducto() {
        $producto = new producto($this->adapter);
        $selectfiltro = isset($_POST['filtro']) ? $_POST['filtro'] : "";
        if (isset($_POST["prd_consultar"])) {
            $allusers = $producto->getAll();
//variable para guardar vector de getBy
            $id = $_POST["prd_consultar"];
            if ($id == "") {
                $valor = $producto->getAll();
            } else {
//Conseguimos el metodo getby el cual me envia un vector y debo guardar en una variable
                $valor = $producto->getBy($selectfiltro, $id);
            }
//Cargamos la vista index y le pasamos valores
            $this->view("producto/MostrarTodoProducto", array(
                "productofiltro" => $valor,
                "allusers" => $allusers,
                "prd_consultar" => $id
            ));
        } else if (isset($_GET["prd_consultar"])) {
            $allusers = $producto->getAll();
//variable para guardar vector de getBy
            $id = $_GET["prd_consultar"];
//Conseguimos el metodo getby el cual me envia un vector y debo guardar en una variable
            $valor = $producto->getBy('prd_codigoProducto', $id);
//Cargamos la vista index y le pasamos valores
            $this->view("producto/MostrarTodoProducto", array(
                "productofiltro" => $valor,
                "allusers" => $allusers,
                "mensajes" => "El producto ha sido modificado con exito",
                "prd_consultar" => $id
            ));
        } else {
            $valor = $producto->getAll();
            $this->view("producto/MostrarTodoProducto", array(
                "productofiltro" => $valor,
                "prd_consultar" => null
            ));
        }
    }

    public function indexmodificar() {
//Creamos el objeto producto
        $producto = new producto($this->adapter);
        $valor = NULL;
//Conseguimos todos los producto (se utiliza metodo de (entidadbase) )
        if (isset($_POST["id"])) {
//variable para guardar vector de getById
            $id = (String) $_POST["id"];
//Conseguimos el metodo getbyid el cual me envia un vector y debo guardar en una variable
            $valor = $producto->getById($id, "prd_codigoProducto");
//Cargamos la vista index y le pasamos valores
        }
        $allusers = $producto->getAll();

//Cargamos la vista index y le pasamos valores
        $this->view("producto/ModificarProducto", array(
            "allusers" => $allusers,
            "producto" => $valor
        ));
    }

    public function modificarproducto() {
//Creamos el objeto productos 
        $modificarproducto = new producto($this->adapter);
        $categoria = new Categoria($this->adapter);
        $allcategoria = $categoria->getAll();
        if (isset($_GET["id"])) {
//variable para guardar vector de getById
            $id = (String) $_GET["id"];
        }
//Conseguimos el metodo getbyid el cual me envia un vector y debo guardar en una variable
        $valor = $modificarproducto->getById($id, "prd_codigoProducto");
//Cargamos la vista index y le pasamos valores
        $this->view("producto/ModificarProducto", array(
            "allcategoria" => $allcategoria,
            "modificarproducto" => $valor
        ));
    }

    public function modificarbd() {
        $producto = new producto($this->adapter);
        //setear todos los campos
        if (isset($_POST["prd_codigoProducto"])) {
            //Creamos un producto
            $producto = new Producto($this->adapter);
            $producto->setPrd_codigoProducto($_POST["prd_codigoProducto"]);
            $producto->setCat_idCategoria($_POST["cat_idCategoria"]);
            $producto->setPro_nit($_POST["pro_nit"]);
            $producto->setPrd_tipoDivisa($_POST["prd_tipoDivisa"]);
            $producto->setPrd_costo($_POST["prd_costo"]);
            $producto->setPrd_tipoPresentacion($_POST["prd_tipoPresentacion"]);
            $producto->setPrd_nombre($_POST["prd_nombre"]);
            $producto->setPrd_descripcion($_POST["prd_descripcion"]);
            $producto->setPrd_foto($_POST["prd_foto"]);
            $producto->setPrd_iva($_POST["prd_iva"]);

            // Precios fijos productos
            $vectPrecios = [];
            $preciosProductos = isset($_POST['prdPrecios']) ? $_POST['prdPrecios'] : "";
            if($preciosProductos != "" && $preciosProductos != ","){
                $vectPrecios = explode(",", $preciosProductos);
            }

            // Se borran los registros asociados de la tabla productoprecio
            $codiprod=$_POST["prd_codigoProducto"];
            $productoPrecio = new ProductoPrecio($this->adapter);
            $resp2 = $productoPrecio->eliminarProductoPrecio($codiprod);

            // Se ingresan de nuevo los registros para la tabla productoprecio
            $newProductoPrecio = new ProductoPrecio($this->adapter);
            $newProductoPrecio->setPrd_CodigoProducto($producto->getPrd_codigoProducto());
            $newProductoPrecio->setVectorPrecios($vectPrecios);
            $newProductoPrecio->save();    

            $updateproducto = $producto->updateproducto();
        }
        //$this->redirect("producto", "consultarproducto&prd_consultar=" . $producto->getprd_codigoProducto());
        $this->redirect("producto", "consultarproducto");

//$this->redirect("producto", "indexmodificar");
    }

    public function mostrarproducto() {
        $this->layout = "User_layout";
        $producto = new Producto($this->adapter);
//Conseguimos todos los productos (se utiliza metodo de (entidadbase) )
        $allusers = $producto->getAll();

        $this->view("userCliente/productos", array(
            "allusers" => $allusers
        ));
    }

    public function mostrardatosproducto() {
        $productomostrar = new Producto($this->adapter);
        $id = (String) $_POST["id"];
        $valor = $productomostrar->getById($id, "prd_codigoProducto");
        echo json_encode($valor);
    }

    public function borrar() {
        if (isset($_GET["id"])) {
            $id = (String) $_GET["id"];

            // Se borran los registros asociados de la tabla productoprecio
            $productoPrecio = new ProductoPrecio($this->adapter);
            $resp2 = $productoPrecio->deleteById("prd_CodigoProducto", $id);

            $producto = new Producto($this->adapter);
            $resp = $producto->deleteById("prd_codigoProducto", $id);
        }
        if ($resp == 1) {
            $vec_res = array("Mensaje" => "Exito al borrar el producto");
            
        } else if ($resp == 1451) {
            $vec_res = array("Mensaje" => "El producto no se puede eliminar ya que tiene otras tablas asociadas");
        } else {
            $vec_res = array("Mensaje" => "Error" . $resp);
        }
        echo json_encode($vec_res);
    }

    public function getProductoPrecio(){
        $vectResp = [];
        if (isset($_GET["id"])) {
            $id = (String) $_GET["id"];
            $productoPrecio = new ProductoPrecio($this->adapter);
            $vectResp = $productoPrecio->obtenerdatos($id, "prd_CodigoProducto");
        }
        echo json_encode($vectResp);
    }

public function BuscarCantidadProducto() {
        $CantidadRegistros = new Producto($this->adapter);
        $CantidadRegistros = $CantidadRegistros->cantidadderegistros();
        echo json_encode($CantidadRegistros);
    }

    //Jhonatan Cuartas
    //Subir productos por medio de carga masiva
    public function CargaMasiva() {
        $archivo = $_FILES['archivo'];
        $accion = $_POST['accion'];
        //echo 'Nombre'.$archivo;
        if (isset($archivo)) {
            $carga = new CargaMasiva($this->adapter);
            $respuesta = $carga->ProcesarArchivo($archivo, $accion);
            $mensaje = $this->Mensaje($respuesta);
        } else {
            $respuesta = 'Debe subir un archivo';
            $mensaje = $this->Mensaje($respuesta);
        }
    }

    public function Mensaje($respuesta) {
        $this->view("producto/ModalMensaje", array(
            "respuesta" => $respuesta
        ));
    }
}
