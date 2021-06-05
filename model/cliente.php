<?php

class Cliente extends EntidadBase {

    private $cli_documento;
    private $cli_paginaWeb;
    private $cli_direccion;
    private $cli_email;
    private $cli_zonaCliente;
    private $cli_ciudad;
    private $cli_nombre;
    private $cli_pais;
    private $cli_telefono;
    private $cli_password;
    //Si está en 1 quiere decir que es cliente potencial, si está en 0 quiere decir que es cliente de la empresa
    private $cli_tipocliente;
    //Dice la fecha en la que el cliente de la empresa es agregado
    private $cli_fecha_ingreso;
    //Dice la fecha en la que el cliente potencial ingresa a la empresa
    private $cli_fecha_ingreso_potencial;
    //Dice la fecha en la que el cliente potencial pasa a ser cliente de la empresa
    private $cli_fecha_salida_potencial;
    //Dice si el cliente antes de ser cliente de la empresa fue potencial en el sistema
    private $cli_antes_cliente_potencial;

    public function __construct($adapter) {
        $table = "cliente";
        parent::__construct($table, $adapter);
    }

    function getCli_tipocliente() {
        return $this->cli_tipocliente;
    }

    function getCli_documento() {
        return $this->cli_documento;
    }

    function getCli_paginaWeb() {
        return $this->cli_paginaWeb;
    }

    function getCli_direccion() {
        return $this->cli_direccion;
    }

    function getCli_email() {
        return $this->cli_email;
    }

    function getCli_zonaCliente() {
        return $this->cli_zonaCliente;
    }

    function getCli_ciudad() {
        return $this->cli_ciudad;
    }

    function getCli_nombre() {
        return $this->cli_nombre;
    }

    function getCli_pais() {
        return $this->cli_pais;
    }

    function getCli_telefono() {
        return $this->cli_telefono;
    }

    function getCli_password() {
        return $this->cli_password;
    }

    function getCli_fecha_salida_potencial() {
        return $this->cli_fecha_salida_potencial;
    }

    function getCli_fecha_ingreso() {
        return $this->cli_fecha_ingreso;
    }

    function getCli_fecha_ingreso_potencial() {
        return $this->cli_fecha_ingreso_potencial;
    }

    function getCli_antes_cliente_potencial() {
        return $this->cli_antes_cliente_potencial;
    }

    function setCli_documento($cli_documento) {
        $this->cli_documento = $cli_documento;
    }

    function setCli_paginaWeb($cli_paginaWeb) {
        $this->cli_paginaWeb = $cli_paginaWeb;
    }

    function setCli_direccion($cli_direccion) {
        $this->cli_direccion = $cli_direccion;
    }

    function setCli_email($cli_email) {
        $this->cli_email = $cli_email;
    }

    function setCli_zonaCliente($cli_zonaCliente) {
        $this->cli_zonaCliente = $cli_zonaCliente;
    }

    function setCli_ciudad($cli_ciudad) {
        $this->cli_ciudad = $cli_ciudad;
    }

    function setCli_nombre($cli_nombre) {
        $this->cli_nombre = $cli_nombre;
    }

    function setCli_pais($cli_pais) {
        $this->cli_pais = $cli_pais;
    }

    function setCli_telefono($cli_telefono) {
        $this->cli_telefono = $cli_telefono;
    }

    function setCli_password($cli_password) {
        $this->cli_password = $cli_password;
    }

    function setCli_tipocliente($cli_tipocliente) {
        $this->cli_tipocliente = $cli_tipocliente;
    }

    function setCli_fecha_ingreso($cli_fecha_ingreso) {
        $this->cli_fecha_ingreso = $cli_fecha_ingreso;
    }

    function setCli_fecha_ingreso_potencial($cli_fecha_ingreso_potencial) {
        $this->cli_fecha_ingreso_potencial = $cli_fecha_ingreso_potencial;
    }

    function setCli_fecha_salida_potencial($cli_fecha_salida_potencial) {
        $this->cli_fecha_salida_potencial = $cli_fecha_salida_potencial;
    }

    function setCli_antes_cliente_potencial($cli_antes_cliente_potencial) {
        $this->cli_antes_cliente_potencial = $cli_antes_cliente_potencial;
    }

    //Esta validación se hace para el ingreso del cliente a un sistema propio para solicitud de soporte
    public function validarLogin() {
        $resultSet = null;
        $query = $this->db()->query("SELECT * FROM `cliente` WHERE
            (cli_documento ='$this->cli_documento' || cli_email ='$this->cli_email')"
                . " && cli_password='$this->cli_password'");
        // print_r($query);
// el print_r es para mostrar un array, es similar al echo
        if ($query->num_rows > 0) {
            //$row va a tomar la consulta como una fila y lo va a guardar en el row, de esa forma cada que hace el ciclo en $row se tiene un nuevo objeto
            while ($row = $query->fetch_object()) {
                //Resultset es un vector que guarda un array con dos variables (1)documento (2)email
                $resultSet[] = array('documento' => $row->cli_documento, 'email' => $row->cli_email);
                //$_SESSION['user_sesion'] = "Julian";   
                $_SESSION['user_sesion'] = $row->cli_nombre;
            }
            $_SESSION['datosvector'] = $resultSet;
            $_SESSION['timeout1'] = time();
            session_regenerate_id();
            return true;
        } else {
            return false;
        }
    }

    public function savecliente() {
        $query = "INSERT INTO cliente (cli_documento,cli_paginaWeb,cli_direccion,cli_email,cli_zonaCliente,
        cli_ciudad,cli_nombre,cli_pais,cli_telefono,cli_tipocliente,cli_fecha_ingreso,cli_password,
        cli_fecha_ingreso_potencial,cli_antes_cliente_potencial)VALUES(
                       '" . $this->cli_documento . "',
                       '" . $this->cli_paginaWeb . "',
                       '" . $this->cli_direccion . "',
                       '" . $this->cli_email . "',
                       '" . $this->cli_zonaCliente . "',
                       '" . $this->cli_ciudad . "',    
                       '" . $this->cli_nombre . "',
                       '" . $this->cli_pais . "',   
                       '" . $this->cli_telefono . "',
                       '" . $this->cli_tipocliente . "',
                       '" . $this->cli_fecha_ingreso . "',
                       '" . $this->cli_password . "',
                       '" . $this->cli_fecha_ingreso_potencial . "',
                       '" . $this->cli_antes_cliente_potencial . "'); ";
//mostrar la consulta completa en pantalla con     
//echo "QUERY> ".$query;        
        $savecliente = $this->db()->query($query);

// echo "SQL> ".$query;
//$this->db()->error;
        //Aqui empieza para insertar en log
        //Obtener error
        $error = mysqli_error($this->db());

        //Reemplazar la coma por el @ y la comilla por |
        $query2 = str_replace(',', '@', $query);
        $query3 = str_replace("'", "|", $query2);

        //Query del log, reemplazar ADICION por el metodo que se va ejecutar
        $query_log = "INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido,log_error) VALUES( NOW(),'" . $_SESSION['documento'] . "', 'ADICION', '" . $query3 . "',1 ,'EXITO');";

        //Validamos si tiene error
        if ($error != "") {

            //Reemplazamos las comillas la comilla por el pading
            $error2 = str_replace("'", "|", $error);

            //Inser con el error de la consulta
            $query_log_error = "INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido ,log_error) VALUES( NOW(),'" . $_SESSION['documento'] . "', 'ADICION', '" . $query3 . "',0,'" . $error2 . "');";
            $save2 = $this->db()->query($query_log_error);
        } else {
            //Si no viene con error inserta la consultra que no tiene error
            $save2 = $this->db()->query($query_log);
        }

        return $savecliente;
    }

    public function mostrar() {
        $query = "SELECT * FROM cliente  where cli_documento = $this->cli_documento";
        echo "SQL> " . $query;
    }

    public function update() {
        $query = "UPDATE cliente SET "
                . "cli_paginaWeb = '" . $this->cli_paginaWeb . "', "
                . "cli_direccion = '" . $this->cli_direccion . "', "
                . "cli_email = '" . $this->cli_email . "', "
                . "cli_zonaCliente = " . $this->cli_zonaCliente . ", "
                . "cli_ciudad = '" . $this->cli_ciudad . "', "
                . "cli_nombre = '" . $this->cli_nombre . "', "
                . "cli_password = '" . $this->cli_nombre . "', "
                . "cli_pais = '" . $this->cli_pais . "', "
                . "cli_telefono = '" . $this->cli_telefono . "', "
                . "cli_password = '" . $this->cli_password . "'
where cli_documento = '" . $this->cli_documento . "'";
        //echo "SQL> ".$query;
        $update = $this->db()->query($query);
        //$this->db()->error;
        //Aqui empieza para insertar en log
        //Obtener error
        $error = mysqli_error($this->db());

        //Reemplazar la coma por el @ y la comilla por |
        $query2 = str_replace(',', '@', $query);
        $query3 = str_replace("'", "|", $query2);

        //Query del log, reemplazar ADICION por el metodo que se va ejecutar
        $query_log = "INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido,log_error) VALUES( NOW(),'" . $_SESSION['documento'] . "', 'EDICION', '" . $query3 . "',1 ,'EXITO');";

        //Validamos si tiene error
        if ($error != "") {

            //Reemplazamos las comillas la comilla por el pading
            $error2 = str_replace("'", "|", $error);

            //Inser con el error de la consulta
            $query_log_error = "INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido ,log_error) VALUES( NOW(),'" . $_SESSION['documento'] . "', 'EDICION', '" . $query3 . "',0,'" . $error2 . "');";
            $save2 = $this->db()->query($query_log_error);
        } else {
            //Si no viene con error inserta la consultra que no tiene error
            $save2 = $this->db()->query($query_log);
        }

        return $update;
    }

    public function updatpasarcliente() {
        $query = "UPDATE cliente SET "
                . "cli_tipocliente = '" . $this->cli_tipocliente . "', "
                . "cli_fecha_salida_potencial = NOW()
                   where cli_documento = '" . $this->cli_documento . "'";
        echo "SQL> " . $query;
        $update = $this->db()->query($query);
        //$this->db()->error;
        //Aqui empieza para insertar en log
        //Obtener error
        $error = mysqli_error($this->db());

        //Reemplazar la coma por el @ y la comilla por |
        $query2 = str_replace(',', '@', $query);
        $query3 = str_replace("'", "|", $query2);

        //Query del log, reemplazar ADICION por el metodo que se va ejecutar
        $query_log = "INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido,log_error) VALUES( NOW(),'" . $_SESSION['documento'] . "', 'EDICION', '" . $query3 . "',1 ,'EXITO');";

        //Validamos si tiene error
        if ($error != "") {

            //Reemplazamos las comillas la comilla por el pading
            $error2 = str_replace("'", "|", $error);

            //Inser con el error de la consulta
            $query_log_error = "INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido ,log_error) VALUES( NOW(),'" . $_SESSION['documento'] . "', 'EDICION', '" . $query3 . "',0,'" . $error2 . "');";
            $save2 = $this->db()->query($query_log_error);
        } else {
            //Si no viene con error inserta la consultra que no tiene error
            $save2 = $this->db()->query($query_log);
        }

        return $update;
    }

    public function validarLogin1() {
        $resultSet = null;
        $query = $this->db()->query("SELECT * FROM `cliente`WHERE (cli_documento ='$this->cli_documento' || cli_email ='$this->cli_email')"
                . " && cli_password='$this->cli_password'");
// el print_r es para mostrar un array, es similar al echo

        if ($query->num_rows > 0) {
            //$row va a tomar la consulta como una fila y lo va a guardar en el row, de esa forma cada que hace el ciclo en $row se tiene un nuevo objeto
            while ($row = $query->fetch_object()) {
                //Resultset es un vector que guarda un array con dos variables (1)id (2)tipo
                $resultSet[] = array('id' => $row->rol_idRol, 'tipo' => $row->rol_tipoRol);
                $_SESSION['nombre'] = $row->cli_nombre;
                $_SESSION['documento'] = $row->cli_documento;
                $_SESSION['email'] = $row->cli_email;
                $_SESSION['direccion'] = $row->cli_direccion;
                $_SESSION['telefono'] = $row->cli_telefono;
                $_SESSION['paginaWeb'] = $row->cli_paginaWeb;
                $_SESSION['ciudad'] = $row->cli_ciudad;
                $_SESSION['zonaCliente'] = $row->cli_zonaCliente;
                $_SESSION['pais'] = $row->cli_pais;
                $_SESSION['password'] = $row->cli_password;
            }
            $_SESSION['datosvector'] = $resultSet;
            //$_SESSION['nombre'] = "Julian";   
            $_SESSION['timeout'] = time();
            session_regenerate_id();
            return true;
        } else {
            return false;
        }
    }

    // Comentario Julian Salazar
    public function buscartodocliente() {
        $query = $this->db()->query("SELECT * FROM cliente where cli_tipocliente='0'");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet["data"][] = $row;
        }
        //echo $query;
        //var_dump($resultSet);
        return $resultSet;
    }

//Mostrar datos en lista de cliente potencial con filtro de tipocliente=1
    public function buscartodoclientepotencial() {
        $query = $this->db()->query("SELECT * FROM cliente where cli_tipocliente='1'");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet["data"][] = $row;
        }
        //echo $query;
        //var_dump($resultSet);
        return $resultSet;
    }

    //Consultas para combos de cliente y cliente potencial en contacto
    // Comentario Julian Salazar
    public function buscartodocliente1() {
        $query = $this->db()->query("SELECT * FROM cliente");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        //var_dump($resultSet);
        return $resultSet;
    }

}
