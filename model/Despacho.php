<?php

class Despacho extends EntidadBase {

    private $des_CodigoDespacho;
    private $des_Transportadora;
    private $des_ObservacionesEnvio;
    private $des_Contrato_Oc;
    private $des_NumeroGuia;
    private $des_CantidadCajas;
    private $des_FechaEnvio;
    private $des_Numfactura;
    private $cli_documento;
    private $usu_documento;

    public function __construct($adapter) {
        $table = "despacho";
        parent::__construct($table, $adapter);
    }

    function getDes_CodigoDespacho() {
        return $this->des_CodigoDespacho;
    }

    function getDes_Transportadora() {
        return $this->des_Transportadora;
    }

    function getDes_ObservacionesEnvio() {
        return $this->des_ObservacionesEnvio;
    }

    function getDes_Contrato_Oc() {
        return $this->des_Contrato_Oc;
    }

    function getDes_NumeroGuia() {
        return $this->des_NumeroGuia;
    }

    function getDes_CantidadCajas() {
        return $this->des_CantidadCajas;
    }

    function getDes_FechaEnvio() {
        return $this->des_FechaEnvio;
    }

    function getDes_Numfactura() {
        return $this->des_Numfactura;
    }

    function getCli_documento() {
        return $this->cli_documento;
    }

    function getUsu_documento() {
        return $this->usu_documento;
    }

    function setDes_CodigoDespacho($des_CodigoDespacho) {
        $this->des_CodigoDespacho = $des_CodigoDespacho;
    }

    function setDes_Transportadora($des_Transportadora) {
        $this->des_Transportadora = $des_Transportadora;
    }

    function setDes_ObservacionesEnvio($des_ObservacionesEnvio) {
        $this->des_ObservacionesEnvio = $des_ObservacionesEnvio;
    }

    function setDes_Contrato_Oc($des_Contrato_Oc) {
        $this->des_Contrato_Oc = $des_Contrato_Oc;
    }

    function setDes_NumeroGuia($des_NumeroGuia) {
        $this->des_NumeroGuia = $des_NumeroGuia;
    }

    function setDes_CantidadCajas($des_CantidadCajas) {
        $this->des_CantidadCajas = $des_CantidadCajas;
    }

    function setDes_FechaEnvio($des_FechaEnvio) {
        $this->des_FechaEnvio = $des_FechaEnvio;
    }

    function setDes_Numfactura($des_Numfactura) {
        $this->des_Numfactura = $des_Numfactura;
    }

    function setCli_documento($cli_documento) {
        $this->cli_documento = $cli_documento;
    }

    function setUsu_documento($usu_documento) {
        $this->usu_documento = $usu_documento;
    }

    public function savedespacho() {
        $query = "INSERT INTO despacho (des_CodigoDespacho,des_Transportadora,des_ObservacionesEnvio,des_Contrato_Oc,
                         des_NumeroGuia,des_CantidadCajas,des_FechaEnvio,des_Numfactura,cli_documento,usu_documento)VALUES(
                       '" . $this->des_CodigoDespacho . "',
                       '" . $this->des_Transportadora . "',
                       '" . $this->des_ObservacionesEnvio . "',
                       '" . $this->des_Contrato_Oc . "',
                       '" . $this->des_NumeroGuia . "',
                       '" . $this->des_CantidadCajas . "',   
                       '" . $this->des_FechaEnvio . "', 
                       '" . $this->des_Numfactura . "', 
                       '" . $this->cli_documento . "', 
                       '" . $this->usu_documento . "'); ";
        $_SESSION['des_CodigoDespacho'] = $this->des_CodigoDespacho;
        echo $_SESSION['des_CodigoDespacho'];
        //echo "QUERY> " . $query;
        //echo "SQL> " . $query;
        //$this->db()->error;
        $savedespacho = $this->db()->query($query);
        
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
        
        
        return $savedespacho;
    }

    public function updatedespacho() {

        $query = "UPDATE despacho SET "
                . "des_Transportadora='" . $this->des_Transportadora . "',"
                . "des_ObservacionesEnvio='" . $this->des_ObservacionesEnvio . "',"
                . "des_Contrato_Oc='" . $this->des_Contrato_Oc . "',"
                . "des_NumeroGuia='" . $this->des_NumeroGuia . "',"
                . "des_CantidadCajas='" . $this->des_CantidadCajas . "',"
                . "des_FechaEnvio='" . $this->des_FechaEnvio . "',"
                . "des_Numfactura='" . $this->des_Numfactura . "',"
                . "cli_documento='" . $this->cli_documento . "',"
                . "usu_documento='" . $this->usu_documento . "'
                where des_CodigoDespacho = '" . $this->des_CodigoDespacho . "'";
        //echo "SQL> " . $query;
        //echo "QUERY> " . $query;
        
        //Aqui empieza para insertar en log
        
        //Obtener error
        $error=mysqli_error($this->db());
         
        //Reemplazar la coma por el @ y la comilla por |
        $query2= str_replace(',','@', $query);
        $query3= str_replace("'","|", $query2);
        
        //Query del log, reemplazar ADICION por el metodo que se va ejecutar
        $query_log ="INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido,log_error) VALUES( NOW(),'".$_SESSION['documento']."', 'EDICION', '".$query3."',1 ,'EXITO');";
       
        //Validamos si tiene error
        if($error!=""){
            
            //Reemplazamos las comillas la comilla por el pading
            $error2= str_replace("'","|", $error);
            
            //Inser con el error de la consulta
             $query_log_error ="INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido ,log_error) VALUES( NOW(),'".$_SESSION['documento']."', 'EDICION', '".$query3."',0,'".$error2."');";
             $save2 = $this->db()->query($query_log_error);
        }else{
            //Si no viene con error inserta la consultra que no tiene error
               $save2 = $this->db()->query($query_log);
           }
        
        
        $updatedespaco = $this->db()->query($query);
    }

    public function buscar() {
        $query = "SELECT * from despacho where des_CodigoDespacho = " . $this->des_CodigoDespacho . " (
                       '" . $this->des_Transportadora . "',
                       '" . $this->des_ObservacionesEnvio . "',
                       '" . $this->des_Contrato_Oc . "',
                       '" . $this->des_NumeroGuia . "',
                       '" . $this->des_CantidadCajas . "',
                       '" . $this->des_FechaEnvio . "',
                       '" . $this->des_Numfactura . "',
                       '" . $this->cli_documento . "',
                       '" . $this->usu_documento . "'); ";
    }

    public function  buscardespachojson() {
        $query = $this->db()->query("SELECT * FROM despacho");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet["data"][] = $row;
        }
        //echo $query;
        //var_dump($resultSet);
        return $resultSet;
    }
}
