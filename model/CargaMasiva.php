<?php
ini_set('max_execution_time', 300);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CargaMasiva
 *
 * @author Jhonatan
 */
class CargaMasiva extends EntidadBase {
    //put your code here
     public $adapter;
     
     public function __construct($adapter) {
         $this->adapter = $adapter;
        $table = "producto";
        parent::__construct($table, $adapter);
    }
    
    
    public function ProcesarArchivo($archivo, $accion){
        $respuesta = "";
        $csv_file = fopen($archivo['tmp_name'], 'r');

        $encabezados = fgets($csv_file);
        if(!$this->ValidarEncabezados($encabezados)){
            
            return 'los encabezados estan malos';
         }
        
        switch ($accion) {
            case "insertar":
                $respuesta = $this->CrearProducto($encabezados ,$csv_file);
                
                break;
            case "":
                $respuesta = $this->ActualizarProducto($encabezados, $csv_file);
                break;
            case 2:
                echo "i es igual a 2";
                break;
        }
        
        return $respuesta;
       
    }
    
    private function ValidarEncabezados($encabezadosArchivo){
        
        $encabezados = "codigo;codigo_producto;categoria;nit_proveedor;divisa;costo;presentacion;nombre_producto;descripcion;iva;precio_mayor;precio_intermedio;precio_menor"; 
        
        if($encabezados = $encabezadosArchivo){
            return true;
        }else{
            return false;
        }
        
    }
    
    
    
    
    private function CrearProducto($encabezados,$csv_file){
        $error = 0;
        $productos = $this->ConsultarProductos();
        //exit;
        $respuesta = "";
        
        if(feof($csv_file)){
            fclose($csv_file);
            return "El archivo no tiene datos";
        }
        
       while(!feof($csv_file)){

            $linea = fgets($csv_file);
            
            if($encabezados != $linea && !empty($linea)){
                $datos = explode(';', $linea);
               //echo 'numero datos-> '.count($datos);
                
                $codigo = $datos[0];
                $codigoProducto = $datos[1];
                $categoria = $datos[2];
                $nitProveedor = $datos[3];
                $divisa = $datos[4];
                $costo = $datos[5];
                $presentacion = $datos[6];
                $nombreProducto = $datos[7];
                $descripcion = $datos[8];
                $iva = $datos[9];
                $precioMayor = $datos[10];
                $precioIntermedio = $datos[11];
                $precioMenor = $datos[12];

                $precios = array($precioMayor,$precioIntermedio,$precioMenor);
                $datosPrecios = array("mayor"=> $precioMayor, "intermedio"=> $precioIntermedio, "menor"=> $precioMenor);

                $producto = new Producto($this->adapter);
                $producto->setPrd_codigoProducto($codigoProducto);
                $producto->setCat_idCategoria($categoria);
                $producto->setPro_nit($nitProveedor);
                $producto->setPrd_tipoDivisa($divisa);
                $producto->setPrd_costo($costo);
                $producto->setPrd_tipoPresentacion($presentacion);
                $producto->setPrd_nombre($nombreProducto);
                $producto->setPrd_descripcion($descripcion);
                $producto->setPrd_foto("");
                $producto->setPrd_iva($iva);

                //if(!$this->ExisteProducto($productos, $codigoProducto)){
                if(!in_array($codigoProducto, $productos)){  
                    $error = 0;
                    echo 'entro';
                    $respuestaAccion = $producto->save();
                    if ($respuestaAccion=="ok") {
                        if(count($precios) > 0) {
                            
                            $newProductoPrecio = new ProductoPrecio($this->adapter);
                            $codProd = isset($codigoProducto) ? $codigoProducto : -1;
                            $newProductoPrecio->setPrd_CodigoProducto($codProd);
                            $newProductoPrecio->setVectorPrecios($precios);
                            $newProductoPrecio->save();
                            if($error != 1){
                            $mensaje="Proceso exitoso";
                            }
                        }
                    }else{
                       
                        $this->InsertarPendiente($codigoProducto, $respuestaAccion);
                       
                    }

                }else{

                    $respuestaAccion = $producto->updateproducto();
                    
                    if($respuestaAccion=="ok"){
                        
                        $this->ActualizarProductoPrecio($codigoProducto, $datosPrecios);
                        if($error != 1){ 
                            $mensaje="Proceso exitoso";
                        }
                        
                    }else{
                       
                        $this->InsertarPendiente($codigoProducto, $respuestaAccion);
                    }
                    
                   
                }
            
           
            }
        }
        
        fclose($csv_file);
        return $mensaje;
        
    }
    
    
    private function InsertarPendiente($codigoProducto,$respuestaAccion){
        
        $insert = "INSERT INTO `t_producto_pendiente`(`prd_codigo`, `ppe_tipo`, `ppe_fecha`, `ppe_motivo`) "
                            . "values('".$codigoProducto."', 'pendiente', now(), '".str_replace("'", "", $respuestaAccion)."')";
        $query = $this->db()->query($insert);
        $mensaje = "Ocurrió un error con algún producto, por favor revise el reporte de productos pendientes por subir e intente de nuevo";
        $error = 1;
        
    }


    //Metodo para actualiar los productos existentes
    private function ActualizarProductoPrecio($codigoProduto, $precios){
        
        $preciosBD = $this-> ConsultarPrecios($codigoProduto);
        
        if(!empty($precios["mayor"])){
            $existePrecio = $this->ExistePrecio($preciosBD, "mayor");
            if($existePrecio != '' ){
                $update = "UPDATE `productoprecio` SET `prd_costo`= ".$precios['mayor']." "
                        . "WHERE `prd_codprodprecio` = '".$existePrecio ."' and `prd_tipo_precio`= 'mayor'";
                
                $updatePrecio = $this->db()->query($update);
            }else{
                 $query = "INSERT INTO productoprecio (prd_CodigoProducto,prd_costo, prd_tipo_precio)
                    VALUES('" . $codigoProduto . "', '" . $precios["mayor"] . "', 'mayor'); ";
                
                $save = $this->db()->query($query);
            }
        }
        
        if(!empty($precios['menor'])){
            $existePrecio = $this->ExistePrecio($preciosBD, "menor");
            if($existePrecio != '' ){
                $update = "UPDATE `productoprecio` SET `prd_costo`= ".$precios['menor']." "
                        . "WHERE `prd_codprodprecio` = '".$existePrecio ."' and `prd_tipo_precio`= 'menor'";
                
                $updatePrecio = $this->db()->query($update);
            }else{
                 $query = "INSERT INTO productoprecio (prd_CodigoProducto,prd_costo, prd_tipo_precio)
                    VALUES('" . $codigoProduto . "', '" . $precios["menor"] . "', 'menor'); ";
                
                $save = $this->db()->query($query);
            }
        }
        
        if(!empty($precios['intermedio'])){
            $existePrecio = $this->ExistePrecio($preciosBD, "intermedio");
            if($existePrecio != '' ){
                $update = "UPDATE `productoprecio` SET `prd_costo`= ".$precios['intermedio']." "
                        . "WHERE `prd_codprodprecio` = '".$existePrecio ."' and `prd_tipo_precio`= 'intermedio'";
                
                $updatePrecio = $this->db()->query($update);
            }else{
                 $query = "INSERT INTO productoprecio (prd_CodigoProducto,prd_costo, prd_tipo_precio)
                    VALUES('" . $codigoProduto . "', '" . $precios["intermedio"] . "', 'intermedio'); ";
                
                $save = $this->db()->query($query);
            }
        }        
    }
    
    
    private function  ConsultarProductos(){
        
        $query = $this->db()->query("SELECT `prd_codigoProducto`  FROM `producto` ;");
        //$query = $this->db()->query("SELECT `ppe_motivo` as prd_codigoProducto  FROM `t_producto_pendiente` limit 10 ;");
        
        $resultSet = null;
        $count = 0;
        while ($row = $query->fetch_object()) {
            //$row = json_decode($row, true);
            $resultSet[$count] = $row->prd_codigoProducto;//$row['prd_codigoProducto'];
            $count++;
        }
        //echo $query;
        //var_dump($resultSet);
        return $resultSet;
    
    }
    
     private function  ExisteProducto($productos, $codigoProducto){
         
         if(in_array($codigoProducto, $productos)){
             return true;
         }
         
         
         /*$cadenaJson = json_encode($productos);
         $result = json_decode($cadenaJson, true);
         
         if(count($result)>0){
            for($i = 0; $i < count($result); $i++){
                if($result[$i]["prd_codigoProducto"] == $codigoProducto){
                 return true;
                }
            } 
         }*/

         return false;
    }
    
    
    private function  ConsultarPrecios($codigoProdcuto){
        
        $query = $this->db()->query("SELECT `prd_codprodprecio`, `prd_CodigoProducto`, `prd_costo`, `prd_tipo_precio` FROM `productoprecio` WHERE prd_CodigoProducto = '".$codigoProdcuto."';");
        $resultSet = null;
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        //echo $query;
        //var_dump($resultSet);
        return $resultSet;
    
    }
    
    private function ExistePrecio($precios, $tipo){
        
        $cadenaJson = json_encode($precios);
         $result = json_decode($cadenaJson, true);
         
         if(count($result)>0){
            for($i = 0; $i < count($result); $i++){
                if($result[$i]["prd_tipo_precio"] == $tipo){
                 return $result[$i]["prd_codprodprecio"];
                }
            } 
         }

         return '';
    }
    
        
     public function ProductosPendientes() {
        $query = $this->db()->query("select * from t_producto_pendiente");
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
