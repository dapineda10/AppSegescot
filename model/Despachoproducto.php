<?php

class Despachoproducto extends EntidadBase {

    private $des_CodigoDespacho;
    private $prd_CodigoProducto;
    private $des_NumeroCaja;
    private $prd_TiempoGarantia;
    private $prd_cantidadVenta;

    public function __construct($adapter) {
        $table = "despachoproducto";
        parent::__construct($table, $adapter);
    }

    function getDes_CodigoDespacho() {
        return $this->des_CodigoDespacho;
    }

    function getPrd_CodigoProducto() {
        return $this->prd_CodigoProducto;
    }

    function getDes_NumeroCaja() {
        return $this->des_NumeroCaja;
    }

    function getPrd_TiempoGarantia() {
        return $this->prd_TiempoGarantia;
    }

    function getPrd_cantidadVenta() {
        return $this->prd_cantidadVenta;
    }

    function setDes_CodigoDespacho($des_CodigoDespacho) {
        $this->des_CodigoDespacho = $des_CodigoDespacho;
    }

    function setPrd_CodigoProducto($prd_CodigoProducto) {
        $this->prd_CodigoProducto = $prd_CodigoProducto;
    }

    function setDes_NumeroCaja($des_NumeroCaja) {
        $this->des_NumeroCaja = $des_NumeroCaja;
    }

    function setPrd_TiempoGarantia($prd_TiempoGarantia) {
        $this->prd_TiempoGarantia = $prd_TiempoGarantia;
    }

    function setPrd_cantidadVenta($prd_cantidadVenta) {
        $this->prd_cantidadVenta = $prd_cantidadVenta;
    }

    public function save() {

        $query = "INSERT INTO despachoproducto (des_CodigoDespacho,prd_CodigoProducto,des_NumeroCaja,prd_TiempoGarantia,prd_cantidadVenta )
                VALUES(
                       '" . $this->des_CodigoDespacho . "',
                       '" . $this->prd_CodigoProducto . "',
                       '" . $this->des_NumeroCaja . "',
                       '" . $this->prd_TiempoGarantia . "',
                       '" . $this->prd_cantidadVenta . "'); ";
        $save = $this->db()->query($query);
        //echo "SQL> ".$query;
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

}
