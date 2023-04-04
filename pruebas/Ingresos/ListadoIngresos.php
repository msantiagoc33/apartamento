<!DOCTYPE html>
<!--#################################################################################################
Esta archivo se encarga de listar todos los registros de la tabla ingresos
##################################################################################################-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <br><br>
        <div id="registrosContabilidad">
            <?php
            if ($error == null) {
                    $sqlIngresos = "select * from ingresos";
                if ($resultado = $conexion->query($sqlIngresos)) {
                    echo "<div id='registros'>";
                    echo "<table>";
                    // ========================= cabecera =========================
                    echo "<thead>";
                    echo "<tr>";
                    echo "<td>ENTRADA</td><td>SALIDA</td><td>IMPORTE</td><td>CLIENTE</td><td>PAIS</td><td>COMENTARIO</td>";
                    echo "<td>BORRAR</td><td>MODIFICAR</td><td>VER</td>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<div id='rows'>";
                    while ($row = $resultado->fetch()) {
                        // ========================= registros ========================    
                        echo "<form action='' method='post'>";
                        echo "<tr>";
                        echo "<td>" . $row['fechaEntrada'] . "</td>";
                        echo "<td>" . $row['fechaSalida'] . "</td>";
                        echo "<td>" . $row['importe'] . "</td>";

                        // Obtener el nombre del cliente con su id de cliente con el id_cliente de la tabla ingresos
                        $sqlCliente = "select * from clientes where id_cliente = '" . $row['id_cliente'] . "'";
                        if ($rCliente = $conexion->query($sqlCliente)) {
                            $rowCliente = $rCliente->fetch();
                            echo "<td>" . $rowCliente['nombre'] . "</td>";
                        }

                        // Obtener el nombre del pais con su id_pais obtenido de la tabla clientes
                        $sqlPais = "select * from paises where id_pais = '" . $rowCliente['id_pais'] . "'";
                        if ($rPais = $conexion->query($sqlPais)) {
                            $rowPais = $rPais->fetch();
                            echo "<td>" . $rowPais['nombre'] . "</td>";
                        }

                        // Recorto el texto de este campo a los primeros 15 caracteres porque no cabe todo
                        echo "<td>" . substr($row['comentario'], 0, 15) . "..." . "</td>";

                        // Este input oculto se utiliza para enviar el id_ingreso (tabla ingresos) con el formulario
                        echo "<input type='hidden' name='idIngreso' value='" . $row['id_ingreso'] . "'/>";

                        echo "<input type='hidden' name='nombreCliente' value='" . $rowCliente['nombre'] . "'/>";

                        echo "<td><input class='rojo' type='submit' name='borrar' value='BORRAR'></td>";
                        echo "<td><input class='verde' type='submit' name='modificar' value='MODIFICAR'></td>";
                        echo "<td><input class='azul' type='submit' name='ver' value='VER'></td>";


                        echo "</tr>";
                        echo "</form>";
                    }
                    echo "</div>"; // fin id rows
                    echo "</table>";
                    echo "</div>"; // fin id registros
                }
            } else {
                $_SESSION['mensaje'] = 'Ha habido un error al conectar con la base de datos. Contacto con el administrador de la pagina';
            }
            ?>

        </div>
    </body>
</html>
