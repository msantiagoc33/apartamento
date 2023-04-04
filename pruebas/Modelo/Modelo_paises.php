<?php

class Paises {
    public $conexion;
    
    public function __construct() {
        $this->conexion = Conexion::conectar();
    }
    
    public function getPaises(){
        $sqlIngresos = "SELECT * FROM paises ORDER BY nombre";
        $resultado = $this->conexion->prepare($sqlIngresos);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }
}

