<?php

class Login {

    public $nombre;
    public $password;
    public $conexion;

    public function __construct() {
        try {
            $this->conexion = conexion::conectar();
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

    public function compruebaLogin($datos) {
        $sql = "select * from usuarios WHERE nombre = ? AND password = ?";
        try {
            $resultado = $this->conexion->prepare($sql);
            $resultado->execute([$datos->nombre, $datos->password]);
            return $resultado->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}
