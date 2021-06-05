<?php
ini_set('max_execution_time', 300);
class ProductoPrecio extends EntidadBase {

    private $prd_codprodprecio;
    private $prd_CodigoProducto;
    private $prd_costo;
    private $vectorPrecios;

    public function __construct($adapter) {
        $table = "productoprecio";
        parent::__construct($table, $adapter);
    }

    function setPrd_codprodprecio($prd_codprodprecio) {
        $this->prd_codprodprecio = $prd_codprodprecio;
    }
    function setPrd_CodigoProducto($prd_CodigoProducto) {
        $this->prd_CodigoProducto = $prd_CodigoProducto;
    }
    function setPrd_costo($prd_costo) {
        $this->prd_costo = $prd_costo;
    }
    function setVectorPrecios($vectorPrecios) {
        $this->vectorPrecios = $vectorPrecios;
    }

    function getPrd_codprodprecio() {
        return $this->prd_codprodprecio;
    }
    function getPrd_CodigoProducto() {
        return $this->prd_CodigoProducto;
    }
    function getPrd_costo() {
        return $this->prd_costo;
    }
    function getVectorPrecios() {
        return $this->vectorPrecios;
    }

    public function save() {
        
        $valorMedio = $this->ObtenerValorMedio();
        $jsonDatos = '[{"tipo": "mayor", "valor":'.max($this->vectorPrecios).'},{"tipo": "intermedio", "valor":'.$valorMedio.'},{"tipo": "menor", "valor":'.min($this->vectorPrecios).'}]';
        $jsonDatos = json_decode($jsonDatos,true);
        
        for($i = 0; $i < count($jsonDatos); $i++){
            if($jsonDatos[$i]["valor"] > 0){
                $query = "INSERT INTO productoprecio (prd_CodigoProducto,prd_costo, prd_tipo_precio)
                    VALUES('" . $this->prd_CodigoProducto . "', '" . $jsonDatos[$i]["valor"] . "', '".$jsonDatos[$i]["tipo"]."'); ";
                $save = $this->db()->query($query);
            }
             
            
        }
        
        /*foreach ($this->vectorPrecios as $item) {
            $query = "INSERT INTO productoprecio (prd_CodigoProducto,prd_costo)VALUES(
                       '" . $this->prd_CodigoProducto . "',
                       '" . $item . "'); ";
            $save = $this->db()->query($query);
        }*/
        
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

    public function obtenerdatos($codProd) {
        $query = $this->db()->query("SELECT * FROM productoprecio WHERE prd_CodigoProducto = '$codProd'");
        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        return $resultSet;
    }

    public function eliminarProductoPrecio($codiprod) {
         $query= "DELETE FROM productoprecio WHERE prd_codigoProducto = '$codiprod'";
        
        $this->db()->query($query);
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
    
    private function ObtenerValorMedio(){
        
        $precios = $this->vectorPrecios;
        $valor = 0;
        for($i = 0; $i < count($precios); $i++){
            if($precios[$i] != max($precios) && $precios[$i] != min($precios)){
                $valor = $precios[$i];
                echo 'valor medio ->'.$valor;
                return $valor;
            }
        }
        
        return $valor;
    }

}
