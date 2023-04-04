<?php

class Ingresos {

    public $conexion;
    public $fechaEntrada;
    public $fechaSalida;
    public $importe;
    public $comentario;
    public $idCliente;
    public $idPlataforma;
    public $idIngreso;
    public $huespedes;

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function getIngresos($pagina, $ingresosXpagina) {
        $sqlIngresos = "SELECT
    i.id_ingreso,
    i.fechaEntrada AS entrada,
    i.fechaSalida AS salida,
    i.id_plataforma,
    i.huespedes,
    i.importe,
    i.comentario,
    i.id_cliente,
    c.nombre AS cliente,
    c.id_pais,
    p.nombre AS pais,
    pl.plataforma
FROM
    ingresos AS i,
    clientes AS c,
    paises AS p,
    plataformas AS pl
WHERE
    c.id_cliente = i.id_cliente AND p.id_pais = c.id_pais AND pl.id_plataforma = i.id_plataforma
    ORDER BY i.fechaEntrada ASC
    LIMIT :iniciar, :ningresos";
        $resultado = $this->conexion->prepare($sqlIngresos);
        $resultado->bindParam(':iniciar', $pagina, PDO::PARAM_INT);
        $resultado->bindParam(':ningresos', $ingresosXpagina, PDO::PARAM_INT);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getHistorico($pagina, $ingresosXpagina) {
        $sqlIngresos = "SELECT
    i.id_ingreso,
    i.fechaEntrada AS entrada,
    i.fechaSalida AS salida,
    i.id_plataforma,
    i.huespedes,
    i.importe,
    i.comentario,
    i.id_cliente,
    c.nombre AS cliente,
    c.id_pais,
    p.nombre AS pais,
    pl.plataforma
FROM
    historico AS i,
    clientes AS c,
    paises AS p,
    plataformas AS pl
WHERE
    c.id_cliente = i.id_cliente AND p.id_pais = c.id_pais AND pl.id_plataforma = i.id_plataforma
    ORDER BY i.fechaEntrada DESC
    LIMIT :iniciar, :ningresos";
        $resultado = $this->conexion->prepare($sqlIngresos);
        $resultado->bindParam(':iniciar', $pagina, PDO::PARAM_INT);
        $resultado->bindParam(':ningresos', $ingresosXpagina, PDO::PARAM_INT);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }

    public function numeroIngresos() {
        $sqlIngresos = "SELECT
    i.id_ingreso,
    i.fechaEntrada AS entrada,
    i.fechaSalida AS salida,
    i.id_plataforma,
    i.huespedes,
    i.importe,
    i.comentario,
    i.id_cliente,
    c.nombre AS cliente,
    c.id_pais,
    p.nombre AS pais
FROM
    ingresos AS i,
    clientes AS c,
    paises AS p,
    plataformas AS pl
WHERE
    c.id_cliente = i.id_cliente AND p.id_pais = c.id_pais AND pl.id_plataforma = i.id_plataforma";
        $resultado = $this->conexion->prepare($sqlIngresos);
        $resultado->execute();
        $total = $resultado->rowCount();
        return $total;
    }
    
public function numeroHistorico() {
        $sqlIngresos = "SELECT
    i.id_ingreso,
    i.fechaEntrada AS entrada,
    i.fechaSalida AS salida,
    i.id_plataforma,
    i.huespedes,
    i.importe,
    i.comentario,
    i.id_cliente,
    c.nombre AS cliente,
    c.id_pais,
    p.nombre AS pais
FROM
    historico AS i,
    clientes AS c,
    paises AS p,
    plataformas AS pl
WHERE
    c.id_cliente = i.id_cliente AND p.id_pais = c.id_pais AND pl.id_plataforma = i.id_plataforma";
        $resultado = $this->conexion->prepare($sqlIngresos);
        $resultado->execute();
        $total = $resultado->rowCount();
        return $total;
    }

    public function sumaTotalIngresos() {
        $sqlSumaImportes = 'SELECT sum(importe) as totalImportes FROM `ingresos`';
        $resultado = $this->conexion->prepare($sqlSumaImportes);
        $resultado->execute();
        $sumaTotalIngresos = $resultado->fetch(PDO::FETCH_ASSOC);
        return $sumaTotalIngresos;
    }

    public function sumaTotalIngresosHistorico() {
        $sqlSumaImportes = 'SELECT sum(importe) as totalImportes FROM `historico`';
        $resultado = $this->conexion->prepare($sqlSumaImportes);
        $resultado->execute();
        $sumaTotalIngresosHistorico = $resultado->fetch(PDO::FETCH_ASSOC);
        return $sumaTotalIngresosHistorico;
    }

    public function sumaPendienteCobro() {
        $sqlSumaPteCobro = 'SELECT *  FROM ingresos';
        $resultado = $this->conexion->prepare($sqlSumaPteCobro);
        $resultado->execute();
        $pteCobro = $resultado->fetchAll(PDO::FETCH_OBJ);
        return $pteCobro;
    }

    public function borrarIngreso($id_Ingreso) {
        try {
            $sqlBorrarIngreso = "DELETE FROM ingresos WHERE id_ingreso = ?";
            $resultado = $this->conexion->prepare($sqlBorrarIngreso);
            $resultado->execute(array($id_Ingreso));
        } catch (Exception $e) {
            die("Error: ") . $e->getMessage();
        }
    }

    public function verIngreso($id_Ingreso) {
        $sqlIngreso = "SELECT
    i.id_ingreso,
    i.fechaEntrada AS entrada,
    i.fechaSalida AS salida,
    i.id_plataforma,
    i.huespedes,
    i.importe,
    i.comentario,
    i.id_cliente,
    c.nombre AS cliente,
    c.id_pais,
    p.nombre AS pais,
    pl.plataforma
FROM
    ingresos AS i,
    clientes AS c,
    paises AS p,
    plataformas AS pl
    
WHERE
    pl.id_plataforma = i.id_plataforma AND c.id_cliente = i.id_cliente AND p.id_pais = c.id_pais AND i.id_ingreso = ?";
        $resultado = $this->conexion->prepare($sqlIngreso);
        $resultado->execute(array($id_Ingreso));
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }

    public function nuevoIngreso($datos) {
        try {
            $sqlNuevoIngreso = "insert into ingresos (fechaEntrada, fechaSalida, importe, comentario, id_cliente, id_plataforma, huespedes) values (?,?,?,?,?,?,?)";
            $resultado = $this->conexion->prepare($sqlNuevoIngreso);
            $resultado->execute([$datos->fechaEntrada, $datos->fechaSalida, $datos->importe, $datos->comentario, $datos->idCliente, $datos->idPlataforma, $datos->huespedes]);
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

    public function actualizarIngreso($datos) {
        try {
            $sqlActualizar = "UPDATE `ingresos` SET `id_plataforma`= ?,`huespedes`= ? ,`fechaEntrada`= ?,`fechaSalida`=?,`importe`=?,`comentario`=?,`id_cliente`=? WHERE id_ingreso = ?";
            $resultado = $this->conexion->prepare($sqlActualizar);
            $resultado->execute([$datos->idPlataforma, $datos->huespedes, $datos->fechaEntrada, $datos->fechaSalida, $datos->importe, $datos->comentario, $datos->idCliente, $datos->idIngreso]);
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

    public function ingresoToHistorico() {
        // Esta funcion borra de la tabla ingresos y un trigger en la bbdd los inserta en la tabla historico
        $fecha_actual = new DateTime();
        $hoy = $fecha_actual->format("y/m/d");
        try {
            $sqlBorrarIngreso = "DELETE FROM ingresos WHERE fechaSalida < ?";
            $resultado = $this->conexion->prepare($sqlBorrarIngreso);
            $resultado->execute(array($hoy));
        } catch (Exception $e) {
            die("Error: ") . $e->getMessage();
        }
    }

}
