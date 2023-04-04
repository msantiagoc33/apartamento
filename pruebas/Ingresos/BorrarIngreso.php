<?php 
session_start();

?>
<!DOCTYPE html>
<!--#################################################################################################
Esta archivo se encarga de borrar un registro de ingresos despues de haberlo seleccionado del listado
##################################################################################################-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $idIngreso = (int) filter_input(INPUT_POST, 'idIngreso', FILTER_SANITIZE_SPECIAL_CHARS);
            include_once 'Modelo/ConexionPDO.php';
            $sql = "delete from ingresos where id_ingreso = $idIngreso";
            include_once '../Modelo/ConexionPDO.php';
            $conexion->beginTransaction();

            $resultado = $conexion->exec($sql);

            if ($resultado) {
                $conexion->commit();
                $_SESSION['mensaje'] = "Registro borrado correctamente.";
            } else {
            // revierte los cambios si algo ha ido mal
                $conexion->rollback();
            }
        ?>
    </body>
</html>
