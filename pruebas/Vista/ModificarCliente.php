<!--#################################################################################################
Esta archivo se encarga de listar todos los clientes de la tabla clientes
##################################################################################################-->

<style>
    input{
        color: blue;
    }
</style>
<body>
    <br><br>
    <div id="registrosClientes">
        <div class='container' style='width:70%;'>
            <div id="cabecera" class="center-align">
                <span>Modificar cliente</span>

            </div>
            <!--<form method="post" action='?c=grabarModificarCliente'>-->
            <table>
                <thead>
                    <tr>
                        <td>NOMBRE</td><td>PAIS</td>
                    </tr>
                </thead>
                <tr>
                    <td><input type="text" name="nombreCliente" value="<?php echo $datosCliente->nombreCliente; ?>"></td>
                    <td><input readonly id="pais" type="text" value="<?php echo $datosCliente->paisCliente; ?>"></td>

                    <td>
                        <select id="paisSeleccionado" name="paisSeleccionado">
                            <option selected value="0">Selecciona un pais</option>
                            <?php
                            foreach ($paises as $pais) {
                                echo "<option value='" . $pais->id_pais . "'>" . $pais->nombre . "</option>";
                            }
                            ?>
                        </select>
                    </td>

                    <td><input type="hidden" name="idCliente" value="<?php echo $datosCliente->idCliente; ?>"</td>
                    <td><input type="hidden" name="idPaisAntiguo" value="<?php echo $datosCliente->idPais; ?>"</td>
                    <!--<td><input type="submit" value="ENVIAR"></td>-->
                    <td class="grabarModificarCliente">
                        <a href="#&idCliente=<?php echo $datosCliente->idCliente; ?>&idPaisAntiguo=<?php echo $datosCliente->idPais; ?>" class="btn bg-warning">ENVIAR</a>
                    </td>
                </tr>
            </table>  

            <!--</form>-->
        </div>
    </div>
     <script type="text/javascript" src="js/Clientes.js"></script> 
</body>
</html>

