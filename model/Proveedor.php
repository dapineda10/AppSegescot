<?php

class Proveedor extends EntidadBase {

    private $pro_nit;
    private $pro_paginaWeb;
    private $pro_Nombre;
    private $pro_emailEmpresa;
    private $pro_direccion;
    private $pro_telefono;
    private $pro_pais;
    private $pro_ciudad;

    public function __construct($adapter) {
        $table = "proveedor";
        parent::__construct($table, $adapter);
    }

    function getPro_nit() {
        return $this->pro_nit;
    }

    function getPro_paginaWeb() {
        return $this->pro_paginaWeb;
    }

    function getPro_Nombre() {
        return $this->pro_Nombre;
    }

    function getPro_emailEmpresa() {
        return $this->pro_emailEmpresa;
    }

    function getPro_direccion() {
        return $this->pro_direccion;
    }

    function getPro_telefono() {
        return $this->pro_telefono;
    }

    function getPro_pais() {
        return $this->pro_pais;
    }

    function getPro_ciudad() {
        return $this->pro_ciudad;
    }

    function setPro_nit($pro_nit) {
        $this->pro_nit = $pro_nit;
    }

    function setPro_paginaWeb($pro_paginaWeb) {
        $this->pro_paginaWeb = $pro_paginaWeb;
    }

    function setPro_Nombre($pro_Nombre) {
        $this->pro_Nombre = $pro_Nombre;
    }

    function setPro_emailEmpresa($pro_emailEmpresa) {
        $this->pro_emailEmpresa = $pro_emailEmpresa;
    }

    function setPro_direccion($pro_direccion) {
        $this->pro_direccion = $pro_direccion;
    }

    function setPro_telefono($pro_telefono) {
        $this->pro_telefono = $pro_telefono;
    }

    function setPro_pais($pro_pais) {
        $this->pro_pais = $pro_pais;
    }

    function setPro_ciudad($pro_ciudad) {
        $this->pro_ciudad = $pro_ciudad;
    }

    public function saveproveedor() {
        $query = "INSERT INTO proveedor (pro_nit,pro_paginaWeb,pro_Nombre,pro_emailEmpresa, pro_direccion,pro_telefono,pro_pais,
    pro_ciudad)VALUES(
                       '" . $this->pro_nit . "',
                       '" . $this->pro_paginaWeb . "',
                       '" . $this->pro_Nombre . "',
                       '" . $this->pro_emailEmpresa . "',
                       '" . $this->pro_direccion . "',
                       '" . $this->pro_telefono . "',    
                       '" . $this->pro_pais . "',
                       '" . $this->pro_ciudad . "'); ";
        //mostrar la consulta completa en pantalla con     
        //echo "QUERY> ".$query;        
        $saveproveedor = $this->db()->query($query);
        
        
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

        // echo "SQL> ".$query;
        //$this->db()->error;
        return $saveproveedor;
    }

    public function updateproveedor() {
         $query = "UPDATE proveedor SET "
                ."pro_paginaWeb ='".$this->pro_paginaWeb."',"
                ."pro_Nombre='".$this->pro_Nombre."',"
                ."pro_emailEmpresa='".$this->pro_emailEmpresa."',"
                ."pro_direccion='".$this->pro_direccion."',"
                ."pro_telefono='".$this->pro_telefono."',"   
                ."pro_pais='".$this->pro_pais."',"
                ."pro_ciudad='".$this->pro_ciudad."'
                where pro_nit = '".$this->pro_nit."'";
        //echo "SQL> ".$query;
        //echo "QUERY> " . $query;
         
        $updateproveedor = $this->db()->query($query);
        
        
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
        
    }
    //mostrar datos de la tabla de datos dinamica de mostrar de proveedor
    public function  buscartodoproveedor() {
        $query = $this->db()->query("SELECT * FROM proveedor");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet["data"][] = $row;
        }
        //echo $query;
        //var_dump($resultSet);
        return $resultSet;
    }

}

