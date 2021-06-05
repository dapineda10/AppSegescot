<?php

class Categoria extends EntidadBase {

    private $cat_idCategoria;
    private $cat_nombre;
    private $cat_descripcion;

    public function __construct($adapter) {
        $table = "categoria";
        parent::__construct($table, $adapter);
    }

    function setCat_idCategoria($cat_idCategoria) {
        $this->cat_idCategoria = $cat_idCategoria;
    }

    function setCat_nombre($cat_nombre) {
        $this->cat_nombre = $cat_nombre;
    }

    function setCat_descripcion($cat_descripcion) {
        $this->cat_descripcion = $cat_descripcion;
    }

    function getCat_idCategoria() {
        return $this->cat_idCategoria;
    }

    function getCat_nombre() {
        return $this->cat_nombre;
    }

    function getCat_descripcion() {
        return $this->cat_descripcion;
    }

    public function save() {
        $query = "INSERT INTO categoria (cat_idCategoria,cat_nombre,cat_descripcion)
                  VALUES(
                       '" . $this->cat_idCategoria . "',
                       '" . $this->cat_nombre . "',
                       '" . $this->cat_descripcion . "'); ";
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
