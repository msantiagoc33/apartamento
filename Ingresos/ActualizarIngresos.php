<?php
session_start();

?>
<!DOCTYPE html>
<!-- ######################################################################################
Esta pagina se encarga de actualizar un ingreso despues de haberlo seleccionado del listado
########################################################################################-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // ================================================================================================================
        // este codigo se ejecuta cuando hemos modificado los campos y pulsamos el boton de MODIFICAR del formulario grande
        // ================================================================================================================
        if (filter_input(INPUT_POST, 'modificarRegistro', FILTER_SANITIZE_SPECIAL_CHARS)) {
            $idIngreso = filter_input(INPUT_POST, 'idIngreso', FILTER_SANITIZE_SPECIAL_CHARS);
            $fechaEntrada = filter_input(INPUT_POST, 'fechaEntradaAmpliada', FILTER_SANITIZE_SPECIAL_CHARS);
            $fechaSalida = filter_input(INPUT_POST, 'fechaSalidaAmpliada', FILTER_SANITIZE_SPECIAL_CHARS);
            $importe = (floatval(filter_input(INPUT_POST, 'importeAmpliada', FILTER_SANITIZE_SPECIAL_CHARS)));
            $comentario = filter_input(INPUT_POST, 'comentarioAmpliada', FILTER_SANITIZE_SPECIAL_CHARS); 
        }
        
        include_once '../Modelo/ConexionPDO.php';
        
        $sqlActualizaIngreso = "UPDATE `ingresos` SET `fechaEntrada` = '$fechaEntrada', `fechaSalida` = '$fechaSalida',`importe` = $importe,`comentario` = '$comentario' WHERE id_ingreso = $idIngreso";
        $conexion->beginTransaction();
        $resultadoIngreso = $conexion->exec($sqlActualizaIngreso);
        if ($resultadoIngreso) {
            $conexion->commit();
            $_SESSION['mensaje'] = "Registro modificado correctamente.";
            header('location:Contabilidad.php');
        } else {
            // revierte los cambios si algo ha ido mal
            $_SESSION['mensaje'] = "Ha ocurrido un error, no se ha modificado el registro.";
            $conexion->rollback();
            header('location:Contabilidad.php');
        }
        ?>
    </body>
</html>
