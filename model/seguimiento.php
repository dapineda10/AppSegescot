<?php

class seguimiento extends EntidadBase {

    private $seg_ticket;//Llave primaria
    private $usu_documento; //Llave foranea
    private $cot_codigoCotizacion;//Llave foranea
    private $seg_comentario;
    private $seg_fechaRegistro;
    private $seg_fechacompromiso;
    
    public function __construct($adapter) {
        $table = "seguimiento";
        parent::__construct($table, $adapter);
    }
    
    function getSeg_ticket() {
        return $this->seg_ticket;
    }

    function getUsu_documento() {
        return $this->usu_documento;
    }

    function getCot_codigoCotizacion() {
        return $this->cot_codigoCotizacion;
    }

    function getSeg_comentario() {
        return $this->seg_comentario;
    }

    function getSeg_fechaRegistro() {
        return $this->seg_fechaRegistro;
    }

    function getSeg_fechacompromiso() {
        return $this->seg_fechacompromiso;
    }
     function setSeg_ticket($seg_ticket) {
        $this->seg_ticket = $seg_ticket;
    }

    function setUsu_documento($usu_documento) {
        $this->usu_documento = $usu_documento;
    }

    function setCot_codigoCotizacion($cot_codigoCotizacion) {
        $this->cot_codigoCotizacion = $cot_codigoCotizacion;
    }

    function setSeg_comentario($seg_comentario) {
        $this->seg_comentario = $seg_comentario;
    }

    function setSeg_fechaRegistro($seg_fechaRegistro) {
        $this->seg_fechaRegistro = $seg_fechaRegistro;
    }

    function setSeg_fechacompromiso($seg_fechacompromiso) {
        $this->seg_fechacompromiso = $seg_fechacompromiso;
    }
    
    public function saveseguimiento() {
        $query = "INSERT INTO seguimiento(usu_documento,cot_codigoCotizacion,seg_comentario,seg_fechaRegistro,
        seg_fechacompromiso)VALUES(
                       '" . $this->usu_documento . "',
                       '" . $this->cot_codigoCotizacion . "',
                       '" . $this->seg_comentario . "',
                       '" . $this->seg_fechaRegistro . "',  
                       '" . $this->seg_fechacompromiso . "'); ";

        //mostrar la consulta completa en pantalla con     
        //echo "QUERY> ".$query;        
        $saveseguimientocot = $this->db()->query($query);
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
        
        return $saveseguimientocot;
    }
    
    //Realiza la consulta para modificar en la base de datos
        public function updateseguimiento() {
        $query = "UPDATE seguimiento SET "
                . "seg_comentario='" . $this->seg_comentario . "',"            
                . "seg_fechacompromiso='" . $this->seg_fechacompromiso . "'               
                 where seg_ticket='" . $this->seg_ticket . "'";
        $updateseguimientocot = $this->db()->query($query);
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
        
        return $updateseguimientocot;
    }
        public function consultarseguimiento() {
        $query="SELECT * FROM seguimiento WHERE cot_codigoCotizacion=".$this->cot_codigoCotizacion."(
                       '" . $this->seg_ticket . "',
                       '" . $this->usu_documento . "',
                       '" . $this->cot_codigoCotizacion . "',
                       '" . $this->seg_comentario . "',
                       '" . $this->seg_fechaRegistro . "',
                       '" . $this->seg_fechacompromiso . "');";
        
        return $query;
        
    }
   /* 
        public function consultarsegcot($id) {
        $query= $this->db()->query("SELECT usu_documento FROM cotizaciones,contacto "
                . "WHERE cotizaciones.con_codigo=contacto.con_codigo and cotizaciones.con_codigo=$id");
        //mostrar la consulta completa en pantalla con     
        //echo "QUERY> ".$query;        
          $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        return $resultSet;
        
        //echo $_SESSION['cot_codigoCotizacion'];
        //echo "SQL> ".$query;
        //$this->db()->error;
    }*/ 
    
        //mostrar datos de la tabla de datos dinamica de mostrar de seguimiento
    public function  buscartodoseguimiento() {
        $query = $this->db()->query(""
        . "SELECT * FROM seguimiento
        LEFT JOIN cotizaciones ON cotizaciones.cot_codigoCotizacion=seguimiento.cot_codigoCotizacion
        LEFT JOIN contacto ON contacto.con_codigo=cotizaciones.con_codigo");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet["data"][] = $row;
        }
        //echo $query;
        //var_dump($resultSet);
        return $resultSet;
    }
}


