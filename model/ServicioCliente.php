<?php

class Serviciocliente extends EntidadBase {

    private $ser_fechaInicial;
    private $ser_ticket;
    private $ser_fechaFin;
    private $ser_estado;
    private $ser_tipoSoporte;
    private $ser_descripcion;
    private $cli_documento;

    public function __construct($adapter) {
        $table = "Serviciocliente";
        parent::__construct($table, $adapter);
    }

    function getCli_documento() {
        return $this->cli_documento;
    }

    function setCli_documento($cli_documento) {
        $this->cli_documento = $cli_documento;
    }

    function setSer_fechaInicial($ser_fechaInicial) {
        $this->ser_fechaInicial = $ser_fechaInicial;
    }

    function setSer_ticket($ser_ticket) {
        $this->ser_ticket = $ser_ticket;
    }

    function setSer_fechaFin($ser_fechaFin) {
        $this->ser_fechaFin = $ser_fechaFin;
    }

    function setSer_estado($ser_estado) {
        $this->ser_estado = $ser_estado;
    }

    function setSer_tipoSoporte($ser_tipoSoporte) {
        $this->ser_tipoSoporte = $ser_tipoSoporte;
    }

    function setSer_descripcion($ser_descripcion) {
        $this->ser_descripcion = $ser_descripcion;
    }

    function getSer_fechaInicial() {
        return $this->ser_fechaInicial;
    }

    function getSer_ticket() {
        return $this->ser_ticket;
    }

    function getSer_fechaFin() {
        return $this->ser_fechaFin;
    }

    function getSer_estado() {
        return $this->ser_estado;
    }

    function getSer_tipoSoporte() {
        return $this->ser_tipoSoporte;
    }

    function getSer_descripcion() {
        return $this->ser_descripcion;
    }

    public function saveservicio() {
        $query = "INSERT INTO serviciocliente (ser_fechaInicial,ser_estado,ser_fechaFin,ser_descripcion,cli_documento,ser_tipoSoporte)
            VALUES(
                       '" . $this->ser_fechaInicial . "',
                       '" . $this->ser_estado . "',
                       '" . $this->ser_fechaFin . "',
                       '" . $this->ser_descripcion . "',
                       '" . $this->cli_documento . "',
                       '" . $this->ser_tipoSoporte . "'); ";
        //mostrar la consulta completa en pantalla con     
        //echo "QUERY> ".$query;        
        $saveservicio = $this->db()->query($query);

        echo "SQL> " . $query;
        
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
        
        //$this->db()->error;
        return $saveservicio;
    }

    public function consultarcliente() {
        $query = $this->db()->query("SELECT cli_nombre,cli_documento FROM cliente,serviciocliente WHERE cliente.cli_documento=serviciocliente.cli_documento ");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        //var_dump($resultSet);
        return $resultSet;
    }

    public function updateservicio() {

        $query = "UPDATE serviciocliente SET "
                //  . "ser_ticket=" . $this->ser_ticket .","
                . "ser_fechaInicial='" . $this->ser_fechaInicial . "',"
                . "cli_documento='" . $this->cli_documento . "',"
                . "ser_estado='" . $this->ser_estado . "',"
                . "ser_tipoSoporte='" . $this->ser_tipoSoporte . "',"
                . "ser_descripcion='" . $this->ser_descripcion . "',"
                . "ser_fechaFin='" . $this->ser_fechaFin . "'               
                 where ser_ticket='" . $this->ser_ticket . "'";
        $update = $this->db()->query($query);
        //echo "SQL> ".$query;
        //print_r($query);
        //$this->db()->error;
        
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
        
        return $update;
    }

    public function consultarestado($tipoestado) {
        $SQL = "SELECT * FROM serviciocliente where ser_estado='".$tipoestado."'";
        $query = $this->db()->query($SQL);
        
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        //var_dump($resultSet);
        return $resultSet;
        
    }

}