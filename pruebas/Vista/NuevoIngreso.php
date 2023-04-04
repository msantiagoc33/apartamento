<!--#################################################################################################
Esta archivo se encarga de listar todos los ingresos de la tabla clientes
##################################################################################################-->
<style>
    input{
        color: blue;
    }
    .margenSuperior{
        margin-top: 15px;
    }
</style>
<body>
    <br><br>
    <div id="registrosClientes">
        <div class='container' style='width:50%;'>
            <div id="cabecera" class="center-align">
                <span>Añadir nuevo ingreso</span>
            </div>

            <!--<form class="margenSuperior" method="post" action='?c=nuevoIngreso'>-->
            <form id="formNuevoIngreso" class="margenSuperior" method="post" action='#'>

                <div class="input-group mb-6 margenSuperior">
                    <select id="plataformaSeleccionada" name="id_plataforma" class="fw-bold  col-5 me-5">
                        <option value="0">Selecciona una plataforma</option>
                        <?php
                        foreach ($plataformas as $plataforma) {
                            echo '<option  class="fw-bold text-primary" value="' . $plataforma->id_plataforma . '">' . $plataforma->plataforma . '</option>';
                        }
                        ?>
                    </select>

                    <select id="paisSeleccionado" name="id_cliente" class="fw-bold col-6">
                        <option value="0">Selecciona un cliente</option>
                        <?php
                        foreach ($clientes as $cliente) {
                            echo '<option class="fw-bold" value="' . $cliente->id_cliente . '">' . $cliente->cliente . '</option>';
                        }
                        ?>
                    </select>
                </div>


                <div class="input-group mb-3 margenSuperior">
                    <span class="input-group-text" id="basic-addon1">Número de huespedes</span>
                    <input type="number" min="1" max="4" name="huespedes" class="form-control" required placeholder="Número de huespedes" aria-label="Username" aria-describedby="basic-addon1">
                </div>

                <div class="input-group mb-3 margenSuperior">
                    <span class="input-group-text" id="basic-addon1">Fecha de entrada</span>
                    <input type="date" id="fechaEntrada" name="fechaEntrada" class="form-control" placeholder="Fecha de entrada" aria-label="Username" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3 titulo">
                    <span class="input-group-text" id="basic-addon1">Fecha de salida</span>
                    <input type="date" id="fechaSalida" name="fechaSalida" class="form-control" placeholder="Fecha de salida" aria-label="Username" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Importe</span>
                    <input type="text" id="importe" name="importe" class="form-control" aria-label="Amount (to the nearest dollar)" required>
                    <span class="input-group-text">.00</span>
                </div>

                <div class="input-group">
                    <span class="input-group-text">Comentario</span>
                    <textarea class="form-control" name="comentario" aria-label="With textarea"></textarea>
                </div>


                <input class="margenSuperior" id="enviar" type="submit" value="ENVIAR" name="enviarIngreso">

                <div id="mensage" class="text-danger fw-bold"></div>


            </form>
        </div>
    </div>
    <?php include_once 'Vista/pieJavaScript.php'; ?>
    <script type="text/javascript" src="js/Ingresos.js"></script> 
</body>
</html>

