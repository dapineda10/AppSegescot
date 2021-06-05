<?php
ini_set('max_execution_time', 300);
class Producto extends EntidadBase {

    private $prd_codigoProducto;
    private $prd_tipoDivisa;
    private $prd_costo;
    private $prd_tipoPresentacion;
    private $prd_nombre;
    private $prd_descripcion;
    private $prd_foto;
    private $prd_iva;
    private $cat_idCategoria;
    private $pro_nit;

    public function __construct($adapter) {
        $table = "producto";
        parent::__construct($table, $adapter);
    }

    function getPrd_codigoProducto() {
        return $this->prd_codigoProducto;
    }

    function getPrd_tipoDivisa() {
        return $this->prd_tipoDivisa;
    }

    function getPrd_costo() {
        return $this->prd_costo;
    }

    function getPrd_tipoPresentacion() {
        return $this->prd_tipoPresentacion;
    }

    function getPrd_nombre() {
        return $this->prd_nombre;
    }

    function getPrd_descripcion() {
        return $this->prd_descripcion;
    }

    function getPrd_foto() {
        return $this->prd_foto;
    }

    function getPrd_iva() {
        return $this->prd_iva;
    }

    function getCat_idCategoria() {
        return $this->cat_idCategoria;
    }

    function getPro_nit() {
        return $this->pro_nit;
    }

    function setPrd_codigoProducto($prd_codigoProducto) {
        $this->prd_codigoProducto = $prd_codigoProducto;
    }

    function setPrd_tipoDivisa($prd_tipoDivisa) {
        $this->prd_tipoDivisa = $prd_tipoDivisa;
    }

    function setPrd_costo($prd_costo) {
        $this->prd_costo = $prd_costo;
    }

    function setPrd_tipoPresentacion($prd_tipoPresentacion) {
        $this->prd_tipoPresentacion = $prd_tipoPresentacion;
    }

    function setPrd_nombre($prd_nombre) {
        $this->prd_nombre = $prd_nombre;
    }

    function setPrd_descripcion($prd_descripcion) {
        $this->prd_descripcion = $prd_descripcion;
    }

    function setPrd_foto($prd_foto) {
        $this->prd_foto = $prd_foto;
    }

    function setPrd_iva($prd_iva) {
        $this->prd_iva = $prd_iva;
    }

    function setCat_idCategoria($cat_idCategoria) {
        $this->cat_idCategoria = $cat_idCategoria;
    }

    function setPro_nit($pro_nit) {
        $this->pro_nit = $pro_nit;
    }

    public function save() {
        //$respuesta = '';
        $query = "INSERT INTO producto (prd_codigoProducto,prd_tipoDivisa,prd_costo,prd_tipoPresentacion,prd_nombre,prd_descripcion,prd_foto,
                  pro_nit, cat_idCategoria,prd_iva)
                VALUES(
                       '" . $this->prd_codigoProducto . "',
                       '" . $this->prd_tipoDivisa . "',
                       '" . $this->prd_costo . "',
                       '" . $this->prd_tipoPresentacion . "',
                       '" . $this->prd_nombre . "',
                       '" . $this->prd_descripcion . "',
                       '" . $this->prd_foto . "',
                       '" . $this->pro_nit . "',
                       '" . $this->cat_idCategoria . "',
                       '" . $this->prd_iva . "'); ";
        
        $save = $this->db()->query($query);
        
        //echo $query;
        
        //Aqui empieza para insertar en log
        //Obtener error
        $error = mysqli_error($this->db());
        
        //Reemplazar la coma por el @ y la comilla por |
        $query2 = str_replace(',', '@', $query);
        $query3 = str_replace("'", "|", $query2);

        $this->InsertarLog($error, $query2, $query3, "Adicionar");
        
        
        
        if($save){
            return 'ok';
        }else{
            
            return $error;
        }
        
        //return $save;
    }

    public function updateproducto() {
        $query = "UPDATE producto SET "
                . "prd_codigoProducto='" . $this->prd_codigoProducto . "',"
                . "prd_tipoDivisa='" . $this->prd_tipoDivisa . "',"
                . "prd_costo='" . $this->prd_costo . "',"
                . "prd_tipoPresentacion='" . $this->prd_tipoPresentacion . "',"
                . "prd_nombre='" . $this->prd_nombre . "',"
                . "prd_descripcion='" . $this->prd_descripcion . "',"
                . "prd_foto='" . $this->prd_foto . "',"
                . "pro_nit='" . $this->pro_nit . "',"
                . "cat_idCategoria='" . $this->cat_idCategoria . "',"
                . "prd_iva='" . $this->prd_iva . "'
                where prd_codigoProducto = '" . $this->prd_codigoProducto . "'";
        // echo "SQL> ".$query;
        $updateproducto = $this->db()->query($query);


        //Aqui empieza para insertar en log
        //Obtener error
        $error = mysqli_error($this->db());

        //Reemplazar la coma por el @ y la comilla por |
        $query2 = str_replace(',', '@', $query);
        $query3 = str_replace("'", "|", $query2);

        $this->InsertarLog($error, $query2, $query3, "Editar");
        
        if($updateproducto){
            return 'ok';
        }else{
            
            return $error;
        }
        
    }

    public function buscartodo() {
        $consulta = "SELECT prd_codigoProducto,prd_nombre,proveedor.pro_Nombre,prd_costo,cat_nombre,categoria.cat_idCategoria,prd_tipoPresentacion,prd_iva,proveedor.pro_nit,prd_tipoDivisa,prd_descripcion,prd_foto FROM producto,proveedor,categoria where producto.pro_nit=proveedor.pro_nit AND categoria.cat_idCategoria=producto.cat_idCategoria";
        $query = $this->db()->query($consulta);
        //echo $consulta;        
        $resultSet = null;        
        while ($row = $query->fetch_object()) {
            $resultSet["data"][] = $row;
        }

        //var_dump($resultSet);
        return $resultSet;
    }

    public function buscartodo1() {
        $query = $this->db()->query("SELECT cot_codigoCotizacion as id, cot_codigoCotizacion as label, cot_codigoCotizacion as value FROM cotizaciones "
                . "WHERE id = '$terminoConsulta' or label = '$terminoConsulta' or value = '$terminoConsulta' ");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        //print_r($query)
        return $resultSet;
    }
    
    private function InsertarLog ($error, $query2, $query3, $accion){
        //Query del log, reemplazar ADICION por el metodo que se va ejecutar
        $query_log = "INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido,log_error) VALUES( NOW(),'" . $_SESSION['documento'] . "', $accion, '" . $query3 . "',1 ,'EXITO');";

        //Validamos si tiene error
        if ($error != "") {

            //Reemplazamos las comillas la comilla por el pading
            $error2 = str_replace("'", "|", $error);

            //Inser con el error de la consulta
            $query_log_error = "INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido ,log_error) VALUES( NOW(),'" . $_SESSION['documento'] . "', $accion, '" . $query3 . "',0,'" . $error2 . "');";
            $save2 = $this->db()->query($query_log_error);
        } else {
            //Si no viene con error inserta la consultra que no tiene error
            $save2 = $this->db()->query($query_log);
        }
    }
    
    
}
