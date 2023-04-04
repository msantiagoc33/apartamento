<?php

class Gastos {

    public $conexion;
    public $fechaGasto;
    public $id_gasto;
    public $importe;
    public $comentario;
    public $id_concepto;

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function todosLosConceptos(){
        try{
        $sqlConceptos = 'SELECT * FROM conceptos ORDER BY nombre';
        $resultado = $this->conexion->prepare($sqlConceptos);
        $resultado->execute();
        $conceptos = $resultado->fetchAll(PDO::FETCH_OBJ);
        return $conceptos;
        } catch (Exception $e){
            die('Error: '.$e->getMessage());
        }
    }

    public function getGastos($pagina, $gastosXpagina) {
        $sqlGastos = "SELECT
    g.id_gasto,
    g.fecha,
    g.importe,
    g.comentario,
    g.id_concepto,
    c.nombre
FROM
    gastos AS g,
    conceptos AS c
    WHERE
    g.id_concepto = c.id_concepto 
    ORDER BY g.fecha DESC
    LIMIT :iniciar, :ngastos";
        $resultado = $this->conexion->prepare($sqlGastos);
        $resultado->bindParam(':iniciar', $pagina, PDO::PARAM_INT);
        $resultado->bindParam(':ngastos', $gastosXpagina, PDO::PARAM_INT);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getGastosFiltrado($pagina, $gastosXpagina,$idGastoFiltrado) {
        $sqlGastos = "SELECT
    g.id_gasto,
    g.fecha,
    g.importe,
    g.comentario,
    g.id_concepto,
    c.nombre
FROM
    gastos AS g,
    conceptos AS c
    WHERE
    g.id_concepto = c.id_concepto AND c.id_concepto = :idConcepto 
    ORDER BY g.fecha DESC
    LIMIT :iniciar, :ngastos";
        $resultado = $this->conexion->prepare($sqlGastos);
        $resultado->bindParam(':iniciar', $pagina, PDO::PARAM_INT);
        $resultado->bindParam(':ngastos', $gastosXpagina, PDO::PARAM_INT);
        $resultado->bindParam(':idConcepto', $idGastoFiltrado, PDO::PARAM_INT);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }

    public function numeroGastos() {
        $sqlGastos = "SELECT
    g.id_gasto,
    g.fecha,
    g.importe,
    g.comentario,
    c.nombre
FROM
    gastos AS g,
    conceptos AS c
    WHERE
    g.id_concepto = c.id_concepto";
        $resultado = $this->conexion->prepare($sqlGastos);
        $resultado->execute();
        $total = $resultado->rowCount();
        return $total;
    }
    
    public function numeroGastosFiltrado($idGastoFiltrado) {
        $sqlGastos = "SELECT
    g.id_gasto,
    g.fecha,
    g.importe,
    g.comentario,
    c.nombre
FROM
    gastos AS g,
    conceptos AS c
    WHERE
    g.id_concepto = c.id_concepto AND c.id_concepto = :idConcepto ";
        $resultado = $this->conexion->prepare($sqlGastos);
        $resultado->bindParam(':idConcepto', $idGastoFiltrado, PDO::PARAM_INT);
        $resultado->execute();
        $total = $resultado->rowCount();
        return $total;
    }

    public function sumaTotalGastos() {
        $sqlSumaImportes = 'SELECT sum(importe) as totalImportes FROM `gastos`';
        $resultado = $this->conexion->prepare($sqlSumaImportes);
        $resultado->execute();
        $sumaTotalGastos = $resultado->fetch(PDO::FETCH_ASSOC);
        return $sumaTotalGastos;
    }
    
     public function sumaTotalGastosFiltrado($idGastoFiltrado) {
        $sqlSumaImportes = 'SELECT sum(importe) as totalImportes FROM `gastos` WHERE id_concepto = :idConcepto';
        $resultado = $this->conexion->prepare($sqlSumaImportes);
        $resultado->bindParam(':idConcepto', $idGastoFiltrado, PDO::PARAM_INT);
        $resultado->execute();
        $sumaTotalGastos = $resultado->fetch(PDO::FETCH_ASSOC);
        return $sumaTotalGastos;
    }

    public function borrarGasto($id_Gasto) {
        $sqlBorrarGasto = "DELETE FROM gastos WHERE id_gasto = ?";
        $resultado = $this->conexion->prepare($sqlBorrarGasto);
        $resultado->execute(array($id_Gasto));
    }

    public function verGasto($id_Gasto) {
        $sqlGasto = "SELECT
    g.id_gasto,
    g.fecha,
    g.importe,
    g.comentario,
    c.nombre
FROM
    gastos AS g,
    conceptos AS c
    WHERE
    g.id_concepto = c.id_concepto AND g.id_gasto = ?";
        $resultado = $this->conexion->prepare($sqlGasto);
        $resultado->execute(array($id_Gasto));
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }

    public function nuevoGasto($datos) {
        try {
            $sqlNuevoGasto = "insert into gastos (fecha, importe, id_concepto, comentario) values (?,?,?,?)";
            $resultado = $this->conexion->prepare($sqlNuevoGasto);
            $resultado->execute([$datos->fechaGasto, $datos->importe, $datos->id_concepto, $datos->comentario]);
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

}
