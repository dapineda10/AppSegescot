<?php

class ProductoCotizacion extends EntidadBase {

    private $cot_codigoCotizacion;
    private $prd_CodigoProducto;
    private $cot_cantdad;
    private $cot_precioVenta;
    private $prd_codigo;
    private $prc_usuario_crea;
    private $prc_fecha_creacion;
   

        public function __construct($adapter) {
        $table = "productocotizacion";
        parent::__construct($table, $adapter);
    }

    function setCot_codigoCotizacion($cot_codigoCotizacion) {
        $this->cot_codigoCotizacion = $cot_codigoCotizacion;
    }

    function setprd_CodigoProducto($prd_CodigoProducto) {
        $this->prd_CodigoProducto = $prd_CodigoProducto;
    }

    function setCot_cantdad($cot_cantdad) {
        $this->cot_cantdad = $cot_cantdad;
    }

    function setCot_precioVenta($cot_precioVenta) {
        $this->cot_precioVenta = $cot_precioVenta;
    }

    function getCot_codigoCotizacion() {
        return $this->cot_codigoCotizacion;
    }

    function getprd_CodigoProducto() {
        return $this->prd_CodigoProducto;
    }

    function getCot_cantdad() {
        return $this->cot_cantdad;
    }

    function getCot_precioVenta() {
        return $this->cot_precioVenta;
    }
     function getPrd_codigo() {
        return $this->prd_codigo;
    }

    function setPrd_codigo($prd_codigo) {
        $this->prd_codigo = $prd_codigo;
    }

    function getPrc_usuario_crea() {
        return $this->prc_usuario_crea;
    }

    function getPrc_fecha_creacion() {
        return $this->prc_fecha_creacion;
    }

    function setPrc_usuario_crea($prc_usuario_crea) {
        $this->prc_usuario_crea = $prc_usuario_crea;
    }

    function setPrc_fecha_creacion($prc_fecha_creacion) {
        $this->prc_fecha_creacion = $prc_fecha_creacion;
    }

        
    
    public function save() {
        $query = "INSERT INTO productocotizacion (prd_codigo,cot_codigoCotizacion,prd_CodigoProducto,cot_cantdad,
                cot_precioVenta,prc_usuario_crea,prc_fecha_creacion)VALUES(
                       '" . $this->prd_codigo . "',
                       '" . $this->cot_codigoCotizacion . "',
                       '" . $this->prd_CodigoProducto . "',
                       '" . $this->cot_cantdad . "',
                       '" . $this->cot_precioVenta . "',
                       '" . $this->prc_usuario_crea . "',
                        NOW()); ";
        //echo $query;
        
        //$_SESSION['cot_codigoCotizacion'] = $this->cot_codigoCotizacion;
        //mostrar la consulta completa en pantalla con     
        //echo "QUERY> " . $query;
        $save = $this->db()->query($query);
        //$save2 = $this->db()->query($query_log);
        //echo $_SESSION['cot_codigoCotizacion'];
        //echo "SQL> " . $query;
        //$this->db()->error;
         
        //Aqui empieza para insertar en log
        
        //Obtener error
        $error=mysqli_error($this->db());
         
        //Reemplazar la coma por el @ y la comilla por |
        $query2= str_replace(',','@', $query);
        $query3= str_replace("'","|", $query2);
        
        //Query del log, reemplazar ADICION por el metodo que se va ejecutar
        $query_log ="INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido,log_error) VALUES( NOW(),'".$_SESSION['documento']."', 'ADICION', '".$query3."',1 ,'EXITO');";
       
        //Validamos si tiene error
        if($error!=""){
            
            //Reemplazamos las comillas la comilla por el pading
            $error2= str_replace("'","|", $error);
            
            //Inser con el error de la consulta
             $query_log_error ="INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido ,log_error) VALUES( NOW(),'".$_SESSION['documento']."', 'ADICION', '".$query3."',0,'".$error2."');";
             $save2 = $this->db()->query($query_log_error);
        }else{
            //Si no viene con error inserta la consultra que no tiene error
               $save2 = $this->db()->query($query_log);
           }
           
        return $save;
    }

    public function obtenerdatos($codicoti) {
        $query = $this->db()->query("SELECT * FROM productocotizacion
         LEFT JOIN producto ON producto.prd_codigoProducto=productocotizacion.prd_CodigoProducto
         RIGHT JOIN cotizaciones ON cotizaciones.cot_codigoCotizacion=productocotizacion.cot_codigoCotizacion
            WHERE cotizaciones.cot_codigoCotizacion = '$codicoti' or productocotizacion.cot_codigoCotizacion= '$codicoti'");
       
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        return $resultSet;
        //print_r($query);
    }
    
        public function eliminarproducto($codiprod) {
        //$query ="DELETE FROM productocotizacion WHERE prd_CodigoProducto = '$codiprod' AND cot_codigoCotizacion='$codicoti'";
        $query = $this->db()->query("DELETE FROM productocotizacion WHERE prd_codigo = '$codiprod'");
//           $codigoError = 0;
//       // echo "DELETE FROM $this->table WHERE $primaryKey = $id";
//        if ($this->db()->errno) {
//            $codigoError = $this->db()->errno;
//            return $codigoError;
//        }
//        //print_r($query);
        
        
         //Aqui empieza para insertar en log
        
        //Obtener error
        $error=mysqli_error($this->db());
         
        //Reemplazar la coma por el @ y la comilla por |
        $query2= str_replace(',','@', $query);
        $query3= str_replace("'","|", $query2);
        
        //Query del log, reemplazar ADICION por el metodo que se va ejecutar
        $query_log ="INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido,log_error) VALUES( NOW(),'".$_SESSION['documento']."', 'ELIMINACION', '".$query3."',1 ,'EXITO');";
       
        //Validamos si tiene error
        if($error!=""){
            
            //Reemplazamos las comillas la comilla por el pading
            $error2= str_replace("'","|", $error);
            
            //Inser con el error de la consulta
             $query_log_error ="INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido ,log_error) VALUES( NOW(),'".$_SESSION['documento']."', 'ELIMINACION', '".$query3."',0,'".$error2."');";
             $save2 = $this->db()->query($query_log_error);
        }else{
            //Si no viene con error inserta la consultra que no tiene error
               $save2 = $this->db()->query($query_log);
           }
        
        return $query;
        
    }
    
    //Consultar todos los datos del produto unido a la cotizacion
    public function  buscartodoproductocotizacion($prd_codigo) {
        $query = $this->db()->query("SELECT * FROM productocotizacion where prd_codigo='$prd_codigo'");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet["data"][] = $row;
        }
        //echo $query;
        //var_dump($resultSet);
        return $resultSet;
    }
     
     

}