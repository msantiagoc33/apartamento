<?php

class Conceptos {
    public $conexion;
    public $nombre;
    public $idConcepto;
    
    public function __construct() {
        $this->conexion = Conexion::conectar();
    }
    
    public function getConceptos(){
        $sqlconceptos = "SELECT * FROM conceptos ORDER BY nombre";
        $resultado = $this->conexion->prepare($sqlconceptos);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function buscarConceptos($datos){
        $sqlbuscar = "SELECT * FROM conceptos WHERE nombre = ?";
        $resultado = $this->conexion->prepare($sqlbuscar);
        $resultado->execute([$datos->nombre]);
        return $resultado->rowCount();
//        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function nuevoConcepto($datos) {
        try {
            $sqlNuevoConcepto = "insert into conceptos (nombre) values (?)";
            $resultado = $this->conexion->prepare($sqlNuevoConcepto);
            $resultado->execute([$datos->nombre]);
            
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
    
    public function eliminarConcepto($datos) {
        try {
            $sqlgasto = "delete from gastos where id_concepto = ?";
            $resultado1 = $this->conexion->prepare($sqlgasto);
            $resultado1->execute([$datos->idConcepto]);

            $sqlconcepto = "delete from conceptos where id_concepto = ?";
            $resultado2 = $this->conexion->prepare($sqlconcepto);
            $resultado2->execute([$datos->idConcepto]);
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
}

