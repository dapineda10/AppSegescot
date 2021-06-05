<?php

class Roles extends EntidadBase {

    private $rol_idRol;
    private $rol_tipoRol;
    
    function __construct($adapter) {
         $table = "roles";
        parent::__construct($table, $adapter);
    }

    function getRol_idRol() {
        return $this->rol_idRol;
    }

    function getRol_tipoRol() {
        return $this->rol_tipoRol;
    }

    function setRol_idRol($rol_idRol) {
        $this->rol_idRol = $rol_idRol;
    }

    function setRol_tipoRol($rol_tipoRol) {
        $this->rol_tipoRol = $rol_tipoRol;
    }

       


}
