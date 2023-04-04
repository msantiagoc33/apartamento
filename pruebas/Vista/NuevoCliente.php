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
        <div class='container' style='width:50%;'>
            <div id="cabecera" class="center-align">
                <span class="p-5">Añadir nuevo cliente</span>
            </div>
            <form id="formNuevoCliente" method="post" action="#">
                <!--<form id="formNuevoCliente" method="post" action='?c=nuevoCliente'>-->
                <table>
                    <thead>
                        <tr>
                            <td>NOMBRE</td><td>PAIS</td>
                        </tr>
                    </thead>
                    <tr>
                        <td><input type="text" name="nombreCliente"></td>
                        <td>
                            <select id="paisSeleccionado" name="idPais">
                                <option value="0">Selecciona un pais</option>
                                <?php
                                foreach ($paises as $pais) {
                                    echo '<option value="' . $pais->id_pais . '">' . $pais->nombre . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td><input type="submit" value="ENVIAR"></td>
                    </tr>
                </table>  

            </form>
        </div>
    </div>
    <?php include_once 'Vista/pieJavaScript.php'; ?>
    <script type="text/javascript" src="js/Clientes.js"></script> 
</body>
</html>

