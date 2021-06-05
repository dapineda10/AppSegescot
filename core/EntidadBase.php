<?php
class EntidadBase
{
    private $db;
    private $conectar;

    public function __construct($table, $adapter)
    {
        $this->table = (string)$table;
        $this->conectar = null;
        $this->db = $adapter;
    }

    public function getConetar()
    {
        return $this->conectar;
    }
   
    public function db()
    {
        return $this->db;
    }
    
    public function getAll()
    {
        $SQL = "SELECT * FROM $this->table";
        //var_dump($SQL);
        //echo '<br> <br>';
        $query = $this->db->query("SELECT * FROM $this->table");
        //var_dump($query);
        //echo '<br> <br>';
        //print_r($query);
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        //var_dump($resultSet);
        return $resultSet;
    }

    public function getById($id, $primaryKey)
    {
        $query = $this->db->query("SELECT * FROM $this->table WHERE ". $primaryKey. "=". $id);
        $resultSet = null;
        if ($row = $query->fetch_object()) {
            $resultSet = $row;
        } else {
            echo '<script> alert("No se pudo mostrar lo que busca, por favor contacte al administrador")</script>';
            }
        return $resultSet;
    }

    public function getBy($column, $value)
    {
        $query = $this->db->query("SELECT * FROM $this->table WHERE $column='$value'");
       //echo "SELECT * FROM $this->table WHERE $column='$value'";
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
       // print_r($query);
        return $resultSet;
    }


      public function deleteById($primaryKey, $id)
    {
        $query = $this->db->query("DELETE FROM $this->table WHERE ". $primaryKey. "='". $id."'");
        
        $q = "DELETE FROM $this->table WHERE ". $primaryKey. "='". $id ."'";
        
        $codigoError = 0;
       // echo "DELETE FROM $this->table WHERE $primaryKey = $id";
        if ($this->db()->errno) {
            $codigoError = $this->db()->errno;
            return $codigoError;
        }
        
         //Aqui empieza el metodo para insertar en log
        
        //Obtener error
        $error=mysqli_error($this->db);
         
        //Reemplazar la coma por el @ y la comilla por |
        $query2= str_replace(',','@', $q);
        $query3= str_replace("'","|", $query2);
        
        //Query del log, reemplazar ADICION por el metodo que se va ejecutar
        $query_log ="INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido,log_error) VALUES( NOW(),'".$_SESSION['documento']."', 'ELIMINACION', '".$query3."',1 ,'EXITO');";
       
        //Validamos si tiene error
        if($error!=""){
            
            //Reemplazamos las comillas la comilla por el pading
            $error2= str_replace("'","|", $error);
            
            //Inser con el error de la consulta
             $query_log_error ="INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido ,log_error) VALUES( NOW(),'".$_SESSION['documento']."', 'ELIMINACION', '".$query3."',0,'".$error2."');";
             $save2 = $this->db->query($query_log_error);
        }else{
            //Si no viene con error inserta la consultra que no tiene error
               $save2 = $this->db->query($query_log);
           }
      
       
        
        return $query;
    }


    public function deleteBy($column, $value)
    {
        $query = "DELETE FROM $this->table WHERE $column='$value'";
        $this->db->query($query);
        
          //Aqui empieza para insertar en log
        
        //Obtener error
        $error=mysqli_error($this->db());
         
        //Reemplazar la coma por el @ y la comilla por |
        $query2= str_replace(',','@', $query);
        $query3= str_replace("'","|", $query2);
        
        //Query del log, reemplazar ADICION por el metodo que se va ejecutar
        $query_log ="INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido,log_error) VALUES( NOW(),'".$_SESSION['documento']."', 'ELIMINACION', '".$query3."',1 ,'EXITO');";
       
        //Validamos si tiene error
        if($error!=""){
            
            //Reemplazamos las comillas la comilla por el pading
            $error2= str_replace("'","|", $error);
            
            //Inser con el error de la consulta
             $query_log_error ="INSERT INTO t_log(log_fecha_insercion,log_usuario, log_accion, log_query,log_valido ,log_error) VALUES( NOW(),'".$_SESSION['documento']."', 'ELIMINACION', '".$query3."',0,'".$error2."');";
             $save2 = $this->db->query($query_log_error);
        }else{
            //Si no viene con error inserta la consultra que no tiene error
               $save2 = $this->db->query($query_log);
           }
        
        
        return $query;
    }

    /*
     * Aqui podemos montarnos un monton de métodos que nos ayuden
     * a hacer operaciones con la base de datos de la entidad
     */
}

?>
