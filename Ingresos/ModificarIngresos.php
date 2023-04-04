<?php
session_start();

?>
<!DOCTYPE html>
<!--#################################################################################################
Esta archivo se encarga de capturar los datos para modificar un registro de ingresos
##################################################################################################-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // ================================================================================================================
        // Este codigo se ejecuta cualdo pulsamos el boton modificar de la linea de registros para capturar los valores
        // Aqui capturamos los nuevos valores pero aqui no se actualizar el registro de ingresos
        // ================================================================================================================
        // Si he pulsado el boton modificar del listado de registros ...
        // Este idIngreso me servira para saber que registro tengo que capturar y actualizar posteriormente.
        $idIngreso = (int) filter_input(INPUT_POST, 'idIngreso', FILTER_SANITIZE_SPECIAL_CHARS);

        $nombreCliente = filter_input(INPUT_POST, 'nombreCliente', FILTER_SANITIZE_SPECIAL_CHARS);

        include_once '../Modelo/ConexionPDO.php';

        $sql = "select * from ingresos where id_ingreso = $idIngreso";

        $resultado = $conexion->query($sql);

        $rowModificar = $resultado->fetch();

        // Solo capturo el comentario y el importe, el resto lo escribo de nuevo
        if ($rowModificar != null) {
            $comentario = $rowModificar['comentario'];
            $importe = $rowModificar['importe'];
            $fechaEntrada = $rowModificar['fechaEntrada'];
            $fechaSalida = $rowModificar['fechaSalida'];
        } else {
            $_SESSION['mensaje'] = 'No hay ningun registro para modificar';
        }
        ?>

        <form id="formularioRegistroAmpliado" action="ActualizarIngresos.php" method="post">
            <div id="registroAmpliado">
                <fieldset>                                                       
                    <legend>Esta modificando los datos del cliente <?php echo '<b>' . $nombreCliente . '</b>' ?></legend>

                        <label for="fechaEntradaAmpliada">Entrada</label>
                        <input type="date" name="fechaEntradaAmpliada" autofocus="autofocus" value="<?php echo $fechaEntrada; ?>">
                        
                        <label for="fechaSalidaAmpliada">Salida</label>
                        
                        <input type="date" name="fechaSalidaAmpliada" value="<?php echo $fechaSalida; ?>"/>
                       
                    <label for="importeAmpliada">Importe</label>                           
                    <input type="text" style="width: 100px;" name="importeAmpliada" value="<?php echo $importe; ?>"/>

                    <!--######################## RELLENAR EL COMBOBOX DE CLIENTES y PAISES ###################################-->

                    <?php
//                    include_once '../Modelo/ComboboxClientes.php';
//                    include_once 'ComboboxPaises.php';
                    ?>

                    <input type="hidden"  name="idIngreso" value="<?php echo $idIngreso; ?>"/>
                </fieldset>
                <br>
                <fieldset>
                    <legend>Información detallada del registro</legend>
                    <textarea name="comentarioAmpliada" rows="10" cols="109"><?php echo $comentario; ?></textarea>
                    <div class="centrar">
                        <input class="verde" name="modificarRegistro" type="submit" id="enviar" value="MODIFICAR" style="width:100px">
                        <a href="Contabilidad.php">
                            <input class="amarillo" name="salir" value="ANULAR"/>
                        </a>
                    </div>
                </fieldset>

            </div>
        </form>

    </body>
</html>
