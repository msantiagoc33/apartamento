
<?php
session_start();
?>
<!DOCTYPE html>
<!--#################################################################################################
Esta archivo se encarga de grabar un nuevo registro en la tabla ingresos
##################################################################################################-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        //################################################################################
        //CODIGO PARA INSERTAR REGISTRO EN INGRESOS
        //################################################################################
        include_once '../Modelo/ConexionPDO.php';

        $fechaEntrada = filter_input(INPUT_POST, 'fechaAmpliadaEntrada', FILTER_SANITIZE_SPECIAL_CHARS);
        $importe = (floatval(filter_input(INPUT_POST, 'importeAmpliada', FILTER_SANITIZE_SPECIAL_CHARS)));
        $idCliente = (int) filter_input(INPUT_POST, 'clienteAmpliada', FILTER_SANITIZE_SPECIAL_CHARS);
        $fechaSalida = filter_input(INPUT_POST, 'fechaAmpliadaSalida', FILTER_SANITIZE_SPECIAL_CHARS);
        $comentario = filter_input(INPUT_POST, 'comentarioAmpliada', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!empty($fechaEntrada) && !empty($fechaSalida) && !empty($importe) && !empty($idCliente) && !empty($comentario)) {

            $sqlInsertarIngreso = "insert into ingresos (fechaEntrada, fechaSalida, importe, comentario, id_cliente) values ('$fechaEntrada', '$fechaSalida', $importe, '$comentario', $idCliente);";

            $conexion->beginTransaction();

            $resultado = $conexion->exec($sqlInsertarIngreso);

            if ($resultado) {
                $conexion->commit();
                $_SESSION['mensaje'] = "Registro grabado correctamente.";
            } else {
                // revierte los cambios si algo ha ido mal
                $conexion->rollback();
            }
        } else {
            $_SESSION['mensaje'] = "Tienes que rellenar todos los campos !!!";
        }
        ?>
    </body>
</html>
