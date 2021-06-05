<?php

class Reportes extends EntidadBase {

    private $rep_id;
    private $rep_nombre; //llave foranea
    private $rep_url;
    private $rep_descri;
   

    public function __construct($adapter) {
        $table = "t_reportes";
        parent::__construct($table, $adapter);
    }

    function getRep_id() {
        return $this->rep_id;
    }

    function getRep_nombre() {
        return $this->rep_nombre;
    }

    function getRep_url() {
        return $this->rep_url;
    }

    function getRep_descri() {
        return $this->rep_descri;
    }

    function setRep_id($rep_id) {
        $this->rep_id = $rep_id;
    }

    function setRep_nombre($rep_nombre) {
        $this->rep_nombre = $rep_nombre;
    }

    function setRep_url($rep_url) {
        $this->rep_url = $rep_url;
    }

    function setRep_descri($rep_descri) {
        $this->rep_descri = $rep_descri;
    }

     
//Consulta los reportes
    public function consultarreportes() {
        $query = $this->db()->query("select * from t_reportes");
        //mostrar la consulta completa en pantalla con     
        //echo "QUERY> ".$query;        
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet["data"][] = $row;
        }
        return $resultSet;

        
    }
    
      
    public function cantidaddecotizaciones() {
        $query = $this->db()->query("SELECT * FROM cotizaciones");
        //mostrar la consulta completa en pantalla con     
        //echo "QUERY> ".$query;        
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        return $resultSet;

        //echo $_SESSION['cot_codigoCotizacion'];
        //echo "SQL> " . $query;
        //$this->db()->error;
    }

      public function clientes() {
        $query = $this->db()->query("select cli_documento, cli_nombre, cli_ciudad, cli_telefono,cli_email ,cli_fecha_ingreso "
                . "from cliente where cli_tipocliente='0'");
        //mostrar la consulta completa en pantalla con     
        //echo "QUERY> ".$query;        
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        return $resultSet;

        //echo $_SESSION['cot_codigoCotizacion'];
        //echo "SQL> " . $query;
        //$this->db()->error;
    }
    
     public function clientespotenciales() {
        $query = $this->db()->query("select cli_documento, cli_nombre, cli_ciudad, cli_telefono,cli_email ,cli_fecha_ingreso_potencial from cliente where cli_tipocliente='1'");
        //mostrar la consulta completa en pantalla con     
        //echo "QUERY> ".$query;        
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        return $resultSet;

        //echo $_SESSION['cot_codigoCotizacion'];
        //echo "SQL> " . $query;
        //$this->db()->error;
    }  
}
