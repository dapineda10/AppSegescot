<?php

class Cotizacion extends EntidadBase {

    private $cot_codigoCotizacion;
    private $con_codigo; //llave foranea
    private $cot_validez;
    private $cot_tiempoEntrega;
    private $cot_lugarEntrega;
    private $cot_formaPago;
    private $cot_fechaCotizacion;
    private $cot_quien_crea;
    private $cot_fechacreacion;
    private $cot_tipocotizacion;
    private $cot_estadoventa;

    public function __construct($adapter) {
        $table = "cotizaciones";
        parent::__construct($table, $adapter);
    }

    function getCot_codigoCotizacion() {
        return $this->cot_codigoCotizacion;
    }

    function getCon_codigo() {
        return $this->con_codigo;
    }

    function getCot_validez() {
        return $this->cot_validez;
    }

    function getCot_tiempoEntrega() {
        return $this->cot_tiempoEntrega;
    }

    function getCot_lugarEntrega() {
        return $this->cot_lugarEntrega;
    }

    function getCot_formaPago() {
        return $this->cot_formaPago;
    }

    function getCot_fechaCotizacion() {
        return $this->cot_fechaCotizacion;
    }

    function getCot_fechacreacion() {
        return $this->cot_fechacreacion;
    }

    function getCot_quien_crea() {
        return $this->cot_quien_crea;
    }

    function getCot_tipocotizacion() {
        return $this->cot_tipocotizacion;
    }

    function getCot_estadoventa() {
        return $this->cot_estadoventa;
    }

    function setCot_codigoCotizacion($cot_codigoCotizacion) {
        $this->cot_codigoCotizacion = $cot_codigoCotizacion;
    }

    function setCon_codigo($con_codigo) {
        $this->con_codigo = $con_codigo;
    }

    function setCot_validez($cot_validez) {
        $this->cot_validez = $cot_validez;
    }

    function setCot_tiempoEntrega($cot_tiempoEntrega) {
        $this->cot_tiempoEntrega = $cot_tiempoEntrega;
    }

    function setCot_lugarEntrega($cot_lugarEntrega) {
        $this->cot_lugarEntrega = $cot_lugarEntrega;
    }

    function setCot_formaPago($cot_formaPago) {
        $this->cot_formaPago = $cot_formaPago;
    }

    function setCot_fechaCotizacion($cot_fechaCotizacion) {
        $this->cot_fechaCotizacion = $cot_fechaCotizacion;
    }

    function setCot_quien_crea($cot_quien_crea) {
        $this->cot_quien_crea = $cot_quien_crea;
    }

    function setCot_fechacreacion($cot_fechacreacion) {
        $this->cot_fechacreacion = $cot_fechacreacion;
    }

    function setCot_tipocotizacion($cot_tipocotizacion) {
        $this->cot_tipocotizacion = $cot_tipocotizacion;
    }

    function setCot_estadoventa($cot_estadoventa) {
        $this->cot_estadoventa = $cot_estadoventa;
    }

    public function save() {
        $query = "INSERT INTO cotizaciones (cot_codigoCotizacion,con_codigo,cot_validez,
                cot_tiempoEntrega,cot_lugarEntrega,cot_formaPago,cot_quien_crea,cot_fechacreacion,cot_tipocotizacion,cot_estadoventa,cot_fechaCotizacion)VALUES(
                       '" . $this->cot_codigoCotizacion . "',
                       '" . $this->con_codigo . "',
                       '" . $this->cot_validez . "',
                       '" . $this->cot_tiempoEntrega . "',
                       '" . $this->cot_lugarEntrega . "',
                       '" . $this->cot_formaPago . "',    
                       '" . $this->cot_quien_crea . "',    
                       '" . $this->cot_fechacreacion . "',    
                       '" . $this->cot_tipocotizacion . "',    
                       'Pendiente',    
                       '" . $this->cot_fechaCotizacion . "'); ";

        $_SESSION['cot_codigoCotizacion'] = $this->cot_codigoCotizacion;
        //mostrar la consulta completa en pantalla con     
        //echo "QUERY> ".$query;        
        $savecotizacion = $this->db()->query($query);
        //echo $_SESSION['cot_codigoCotizacion'];
        //echo "SQL> ".$query;
        //$this->db()->error;
        return $savecotizacion;
    }

    public function consultacotizacion($sesion) {
        $query = $this->db()->query("SELECT * FROM producto
        LEFT JOIN productocotizacion ON productocotizacion.prd_codigoProducto=producto.prd_CodigoProducto
        LEFT JOIN cotizaciones ON cotizaciones.cot_codigoCotizacion=productocotizacion.cot_codigoCotizacion
        LEFT JOIN contacto ON contacto.con_codigo=cotizaciones.con_codigo
        LEFT JOIN proveedor ON proveedor.pro_nit=producto.pro_nit
        LEFT JOIN cliente ON cliente.cli_documento=contacto.cli_documento 
        WHERE productocotizacion.cot_codigoCotizacion=$sesion ORDER BY productocotizacion.prd_Codigo ASC");
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

    //Realizar la consultar en la base de datos 

    public function consultar() {
        $query = "SELECT * FROM cotizaciones WHERE cot_codigoCotizacion=" . $this->cot_codigoCotizacion . "(
                '" . $this->cot_codigoCotizacion . "',
                       '" . $this->con_codigo . "',
                       '" . $this->cot_validez . "',
                       '" . $this->cot_tiempoEntrega . "',
                       '" . $this->cot_lugarEntrega . "',
                       '" . $this->cot_formaPago . "',    
                       '" . $this->cot_fechaCotizacion . "');";

        return $query;
    }

    //Realiza la consulta para modificar en la base de datos
    public function updatecotizacion() {

        $query = "UPDATE cotizaciones SET "
                //  . "ser_ticket=" . $this->ser_ticket .","
                . "cot_codigoCotizacion='" . $this->cot_codigoCotizacion . "',"
                . "con_codigo='" . $this->con_codigo . "',"
                . "cot_validez='" . $this->cot_validez . "',"
                . "cot_tiempoEntrega='" . $this->cot_tiempoEntrega . "',"
                . "cot_lugarEntrega='" . $this->cot_lugarEntrega . "',"
                . "cot_formaPago='" . $this->cot_formaPago . "',"
                . "cot_estadoventa='" . $this->cot_estadoventa . "',"
                . "cot_fechaCotizacion='" . $this->cot_fechaCotizacion . "'               
                 where cot_codigoCotizacion='" . $this->cot_codigoCotizacion . "'";
        $update = $this->db()->query($query);
        //echo "SQL> ".$query;
        //print_r($query);
        //$this->db()->error;
        return $update;
    }

    //Muestra todas las cotizaciones cerradas o vendidas
    public function buscartodocotizacion() {
        $query = $this->db()->query("SELECT * FROM cotizaciones inner join contacto on cotizaciones.con_codigo=contacto.con_codigo and (cot_estadoventa='Vendida' or cot_estadoventa='Cerrada')");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet["data"][] = $row;
        }
        //echo $query;
        //var_dump($resultSet);
        return $resultSet;
    }

    //Muestra todas las cotizaciones vendidas
    public function buscartodocotizacionpendiente() {
        $query = $this->db()->query("SELECT * FROM cotizaciones inner join contacto on  cotizaciones.con_codigo=contacto.con_codigo and cot_estadoventa='Pendiente'");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet["data"][] = $row;
        }
        //echo $query;
        //var_dump($resultSet);
        return $resultSet;
    }

    public function ConsultarUltimoCodigo() {
        $query = $this->db()->query("select cot_codigoCotizacion + 1 as valor from cotizaciones ORDER BY 1 DESC LIMIT 1");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        return $resultSet;
    }

}
