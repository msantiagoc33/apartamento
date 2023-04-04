<?php

// CONEXION CON LA BASE DE DATOS con  PDO
class Conexion {		
    
//     public static function conectar() {
//        try {
//            $conexion = new PDO(
//                "mysql:host=ns1092.ifastnet.com; 
//                dbname=sangutsi_apartamento; 
//                charset=utf8", 
//                "sangutsi_cabeza", 
//                "M33624f@"
//            );
//            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            return $conexion;
//        } catch (PDOException $e) {
//            die($e->getMessage());
//        }
//    }
//    
//    ********************** CONEXION LOCAL PARA PRUEBAS *************************************
        public static function conectar() {
        try {
            $conexion = new PDO("mysql:host=localhost; dbname=apartamento; charset=utf8", "cabeza", "mazemane");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
//    *********************************************************-*

}

