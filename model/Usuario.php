<?php

class Usuario extends EntidadBase {

    private $usu_documento;
    private $usu_nombre;
    private $usu_fechaNacimiento;
    private $usu_password;
    private $usu_telefono;
    private $usu_nombreUsuario;
    private $usu_direccion;
    private $usu_email;
    private $rol_idRol;
    private $usu_rol;
    private $usu_bienvenida;

    public function __construct($adapter) {
        $table = "usuario";
        parent::__construct($table, $adapter);
    }

    function setUsu_documento($usu_documento) {
        $this->usu_documento = $usu_documento;
    }

    function setUsu_nombre($usu_nombre) {
        $this->usu_nombre = $usu_nombre;
    }

    function setUsu_fechaNacimiento($usu_fechaNacimiento) {
        $this->usu_fechaNacimiento = $usu_fechaNacimiento;
    }

    function setUsu_password($usu_password) {
        $this->usu_password = $usu_password;
    }

    function setUsu_telefono($usu_telefono) {
        $this->usu_telefono = $usu_telefono;
    }

    function setUsu_nombreUsuario($usu_nombreUsuario) {
        $this->usu_nombreUsuario = $usu_nombreUsuario;
    }

    function setUsu_direccion($usu_direccion) {
        $this->usu_direccion = $usu_direccion;
    }

    function setUsu_email($usu_email) {
        $this->usu_email = $usu_email;
    }

    function setUsu_rol($usu_rol) {
        $this->usu_rol = $usu_rol;
    }

    function setUsu_bienvenida($usu_bienvenida) {
        $this->usu_bienvenida = $usu_bienvenida;
    }

    function getUsu_documento() {
        return $this->usu_documento;
    }

    function getUsu_nombre() {
        return $this->usu_nombre;
    }

    function getUsu_fechaNacimiento() {
        return $this->usu_fechaNacimiento;
    }

    function getUsu_password() {
        return $this->usu_password;
    }

    function getUsu_telefono() {
        return $this->usu_telefono;
    }

    function getUsu_nombreUsuario() {
        return $this->usu_nombreUsuario;
    }

    function getUsu_direccion() {
        return $this->usu_direccion;
    }

    function getUsu_email() {
        return $this->usu_email;
    }

    function getUsu_rol() {
        return $this->usu_rol;
    }

    function getUsu_bienvenida() {
        return $this->usu_bienvenida;
    }

    public function validarLogin() {
        $resultSet = null;
        $query = $this->db()->query("SELECT * FROM `usuario` INNER JOIN usuarioroles on usuario.usu_documento = usuarioroles.usu_documento
                  INNER JOIN roles ON roles.rol_idRol = usuarioroles.rol_idRol WHERE (usuario.usu_documento ='$this->usu_documento' || usu_email ='$this->usu_email')"
                . " && usu_password='$this->usu_password'");
// el print_r es para mostrar un array, es similar al echo

        if ($query->num_rows > 0) {
            //$row va a tomar la consulta como una fila y lo va a guardar en el row, de esa forma cada que hace el ciclo en $row se tiene un nuevo objeto
            while ($row = $query->fetch_object()) {
                //Resultset es un vector que guarda un array con dos variables (1)id (2)tipo
                $resultSet[] = array('id' => $row->rol_idRol, 'tipo' => $row->rol_tipoRol);
                $_SESSION['nombre'] = $row->usu_nombre;
                $_SESSION['documento'] = $row->usu_documento;
                $_SESSION['tipo'] = $row->usu_rol;
            }
            $_SESSION['datosvector'] = $resultSet;
            //$_SESSION['nombre'] = "Julian";   
            $_SESSION['timeout'] = time();
            session_regenerate_id();


            //Obtener error
            //Inser con el error de la consulta
            $query_log_error = "INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido ,log_error) VALUES( NOW(),'" . $_SESSION['documento'] . "', 'LOGIN', '',1,'LOGIN EXITOSO');";
            $save2 = $this->db()->query($query_log_error);

            return true;
        } else {
            $query_log_error = "INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido ,log_error) VALUES( NOW(),'', 'LOGIN', 'Usuario:" . $this->usu_documento . " - Contraseña:" . $this->usu_password . "',0,'NO PUDO LOGUEARSE');";
            $save2 = $this->db()->query($query_log_error);

            return false;
        }
    }

    //Validar usuario nuevo mensaje de bienvenida
    public function UsuarioNuevo() {
        $query = $this->db()->query("SELECT count(*) as conteo FROM `usuario` WHERE (usu_documento ='$this->usu_documento' || usu_email ='$this->usu_email') and usu_bienvenida='0'");

        $resultSet = null;
        while ($row = $query->fetch_row()) {
            $resultSet["data"] = $row;
        }

        //  var_dump($resultSet["data"][0]);

        if ($resultSet["data"][0] == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function registrar() {
        $query = "INSERT INTO usuario (usu_documento,usu_nombre,usu_fechaNacimiento,usu_password,usu_telefono,usu_nombreUsuario,
                     usu_direccion,usu_email, usu_bienvenida,usu_rol)VALUES(
                       '" . $this->usu_documento . "',
                       '" . $this->usu_nombre . "',
                       '" . $this->usu_fechaNacimiento . "',
                       '" . $this->usu_password . "',
                       '" . $this->usu_telefono . "',
                       '" . $this->usu_nombreUsuario . "',    
                       '" . $this->usu_direccion . "',
                       '" . $this->usu_email . "',
                       '0',
                        '" . $this->usu_rol . "'); ";
        //mostrar la consulta completa en pantalla con     
        //echo "QUERY> ".$query;        
        $registrarusuario = $this->db()->query($query);
        //echo "SQL> ".$query;
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

        return $registrarusuario;
    }

    public function buscartodousuario() {
        $query = $this->db()->query("SELECT * FROM usuario");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet["data"][] = $row;
        }
        //echo $query;
        //var_dump($resultSet);
        return $resultSet;
    }

    public function updateusuario() {

        $query = "UPDATE usuario SET "
                //  . "ser_ticket=" . $this->ser_ticket .","
                . "usu_documento='" . $this->usu_documento . "',"
                . "usu_direccion='" . $this->usu_direccion . "',"
                . "usu_email='" . $this->usu_email . "',"
                . "usu_password='" . $this->usu_password . "',"
                . "usu_nombreUsuario='" . $this->usu_nombreUsuario . "',"
                . "usu_fechaNacimiento='" . $this->usu_fechaNacimiento . "',"
                . "usu_nombre='" . $this->usu_nombre . "',"
                . "usu_telefono='" . $this->usu_telefono . "'             
                 where usu_documento='" . $this->usu_documento . "'";
        $update = $this->db()->query($query);
        //echo "SQL> ".$query;
        //print_r($query);
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

    public function updatebienvenida() {
        $query = "UPDATE usuario SET "
                . "usu_bienvenida='" . $this->usu_bienvenida . "'             
                 where usu_documento='" . $this->usu_email . "'";
        $update = $this->db()->query($query);
        $error = mysqli_error($this->db());
        echo $query;
        return $updatebienvenida;
    }

}
