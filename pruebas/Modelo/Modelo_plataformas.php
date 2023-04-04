<?php

class Plataformas {

    public $conexion;
    public $plataforma;
    public $id_plataforma;


    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function todasLasPlataformas() {
        $sqlClientes = "SELECT * FROM plataformas";
        $resultado = $this->conexion->prepare($sqlClientes);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }

}
