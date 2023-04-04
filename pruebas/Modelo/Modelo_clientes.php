<?php

class Clientes {

    public $conexion;
    public $nombreCliente;
    public $paisCliente;
    public $idCliente;
    public $idPais;

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function todosLosClientes() {
        $sqlClientes = "SELECT
    c.id_cliente,
    c.nombre as cliente,
    p.nombre as pais
FROM
    clientes AS c,
    paises AS p    
WHERE
    c.id_pais = p.id_pais
ORDER BY c.id_cliente DESC";
        $resultado = $this->conexion->prepare($sqlClientes);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getClientes($pagina,$articulosXpagina) {
        $sqlClientes = "SELECT
    c.id_cliente,
    c.nombre as cliente,
    p.nombre as pais,
    c.id_pais as idPais
FROM
    clientes AS c,
    paises AS p
WHERE
    c.id_pais = p.id_pais
ORDER BY c.id_cliente DESC
LIMIT :iniciar, :narticulos";
        $resultado = $this->conexion->prepare($sqlClientes);
        $resultado->bindParam(':iniciar', $pagina, PDO::PARAM_INT);
        $resultado->bindParam(':narticulos', $articulosXpagina, PDO::PARAM_INT);
        $resultado->execute();
        $total = $resultado->rowCount();
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }
/**
 * 
 * @return type Cuenta el numero de clientes
 */
    public function totalClientes() {
        $sqlClientes = 'SELECT
    c.id_cliente,
    c.nombre as cliente,
    p.nombre as pais
FROM
    clientes AS c,
    paises AS p
WHERE
    c.id_pais = p.id_pais';
        $resultado = $this->conexion->prepare($sqlClientes);
        $resultado->execute();
        $total = $resultado->rowCount();
        $resultado->fetchAll(PDO::FETCH_OBJ);
        return $resultado->rowCount();
    }

    public function eliminarCliente($idCliente) {
        try {
            $sqlIngresos = "delete from ingresos where id_cliente = ?";
            $resultado1 = $this->conexion->prepare($sqlIngresos);
            $resultado1->execute(array($idCliente));

            $sqlCliente = "delete from clientes where id_cliente = ?";
            $resultado2 = $this->conexion->prepare($sqlCliente);
            $resultado2->execute(array($idCliente));
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

    public function modificarCliente($datosModificarCliente) {
        try {
            $sqlCliente = "update clientes set nombre = ?, id_pais = ? where id_cliente = ?";
            $actualizar = $this->conexion->prepare($sqlCliente);
            $actualizar->execute([$datosModificarCliente->nombreCliente, $datosModificarCliente->idPais, $datosModificarCliente->idCliente]);
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
    
    public function nuevoCliente($datos) {
        try {
            $sqlNuevoCliente = "insert into clientes (nombre, id_pais) values (?,?)";
            $resultado = $this->conexion->prepare($sqlNuevoCliente);
            $resultado->execute([$datos->nombreCliente, $datos->idPais]);

        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

}
