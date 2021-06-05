<?php

class Contacto extends EntidadBase {

    private $con_codigo;
    private $con_estadoCivil;
    private $con_cargo;
    private $con_telefono;
    private $con_profesion;
    private $con_email;
    private $con_nombreCompleto;
    private $con_fechaNacimiento;
    private $pro_nit;
    private $cli_documento;

    public function __construct($adapter) {
        $table = "contacto";
        parent::__construct($table, $adapter);
    }

    function getCon_codigo() {
        return $this->con_codigo;
    }

    function getCon_estadoCivil() {
        return $this->con_estadoCivil;
    }

    function getCon_cargo() {
        return $this->con_cargo;
    }

    function getCon_telefono() {
        return $this->con_telefono;
    }

    function getCon_profesion() {
        return $this->con_profesion;
    }

    function getCon_email() {
        return $this->con_email;
    }

    function getCon_nombreCompleto() {
        return $this->con_nombreCompleto;
    }

    function getCon_fechaNacimiento() {
        return $this->con_fechaNacimiento;
    }

    function getPro_nit() {
        return $this->pro_nit;
    }

    function getCli_documento() {
        return $this->cli_documento;
    }

    function setCon_codigo($con_codigo) {
        $this->con_codigo = $con_codigo;
    }

    function setCon_estadoCivil($con_estadoCivil) {
        $this->con_estadoCivil = $con_estadoCivil;
    }

    function setCon_cargo($con_cargo) {
        $this->con_cargo = $con_cargo;
    }

    function setCon_telefono($con_telefono) {
        $this->con_telefono = $con_telefono;
    }

    function setCon_profesion($con_profesion) {
        $this->con_profesion = $con_profesion;
    }

    function setCon_email($con_email) {
        $this->con_email = $con_email;
    }

    function setCon_nombreCompleto($con_nombreCompleto) {
        $this->con_nombreCompleto = $con_nombreCompleto;
    }

    function setCon_fechaNacimiento($con_fechaNacimiento) {
        $this->con_fechaNacimiento = $con_fechaNacimiento;
    }
    
    function setPro_nit($pro_nit) {
        $this->pro_nit = $pro_nit;
    }

    function setCli_documento($cli_documento) {
        $this->cli_documento = $cli_documento;
    }

    public function save() {
        $query = "INSERT INTO contacto (con_codigo,con_estadoCivil,con_cargo,con_telefono,
                  con_profesion,con_email,con_nombreCompleto,con_fechaNacimiento,pro_nit,cli_documento)
                  VALUES(
                       '" . $this->con_codigo . "',
                       '" . $this->con_estadoCivil . "',
                       '" . $this->con_cargo . "',
                       '" . $this->con_telefono . "',
                       '" . $this->con_profesion . "',
                       '" . $this->con_email . "',
                       '" . $this->con_nombreCompleto . "',
                       '" . $this->con_fechaNacimiento . "',
                       " . $this->pro_nit . ",
                       " . $this->cli_documento     
                . "); ";
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

    public function update() {
        
        $query = "UPDATE contacto SET "
                . "con_estadoCivil='" . $this->con_estadoCivil . "', "
                . "con_cargo='" . $this->con_cargo . "', "
                . "con_telefono='" . $this->con_telefono . "', "
                . "con_profesion='" . $this->con_profesion . "', "
                . "con_email='" .  $this->con_email . "', "
                . "con_nombreCompleto='" . $this->con_nombreCompleto . "', "
                . "con_fechaNacimiento='" . $this->con_fechaNacimiento . "'
     where con_codigo = '" . $this->con_codigo . "'";
        //print_r($query);
        $update = $this->db()->query($query);
        //echo "SQL> ".$query;
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

    public function buscar() {
        $query = "SELECT * where con_codigo = " . $this->con_codigo . " a (
                       '" . $this->con_codigo . "',
                       '" . $this->con_estadoCivil . "',
                       '" . $this->con_cargo . "',
                       '" . $this->con_telefono . "',
                       '" . $this->con_profesion . "',
                       '" . $this->con_email . "',
                       '" . $this->con_nombreCompleto . "',
                       '" . $this->con_fechaNacimiento . "',
                       '" . $this->pro_nit . "',
                       '" . $this->cli_documento . "');";   
    }
    
    public function  buscartodocontacto() {
        $query = $this->db()->query("SELECT * FROM contacto LEFT join proveedor on proveedor.pro_nit=contacto.pro_nit LEFT join cliente on cliente.cli_documento=contacto.cli_documento");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet["data"][] = $row;
        }
        //echo $query;
        //var_dump($resultSet);
        return $resultSet;
    }
	
	//Se usa para el combo de contacto en la cotización, se llama desde el controllador de cotización
        public function  buscarcontactocotizacion() {
        $query = $this->db()->query("SELECT * FROM contacto LEFT join cliente on cliente.cli_documento=contacto.cli_documento where pro_nit is null");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        //var_dump($resultSet);
        return $resultSet;
    
    }
    
    }
