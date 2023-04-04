<!--#################################################################################################
Esta archivo se encarga mostar un asiento para su consulta o modificacion
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
                <span class="p-3">Ver-Modificar asiento</span>
            </div>
            <form id="formActualizarIngreso" class="margenSuperior" method="post" action='#'>
                <?php
                foreach ($resultado as $row) :
                    ?>
                    <input value="<?php echo $row->id_ingreso; ?>" type="hidden" name="idIngreso" >
                    
                    <div class="input-group mb-6 margenSuperior">
                        <select id="plataformaSeleccionada" name="id_plataforma" class="fw-bold  col-5 me-5">
                            <option value="<?php echo $row->id_plataforma; ?>"><?php echo $row->plataforma; ?></option>
                            <?php
                            foreach ($plataformas as $plataforma) {
                                echo '<option class="fw-bold" value="' . $plataforma->id_plataforma . '">' . $plataforma->plataforma . '</option>';
                            }
                            ?>
                        </select>
                        
                        <select id="clienteSeleccionado" name="id_cliente" class="fw-bold  col-5 me-6">
                            <option value="<?php echo $row->id_cliente; ?>"><?php echo $row->cliente; ?></option>
                            <?php
                            foreach ($clientes as $cliente) {
                                echo '<option class="fw-bold" value="' . $cliente->id_cliente . '">' . $cliente->cliente . '</option>';
                            }
                            ?>
                        </select>
                    </div>


                    <div class="input-group mb-3 margenSuperior">
                        <span class="input-group-text" id="basic-addon1">Número de huespedes</span>
                        <input value="<?php echo $row->huespedes; ?>" type="number" min="1" max="4" name="huespedes" class="form-control" placeholder="Número de huespedes" aria-label="Username" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3 margenSuperior">
                        <span class="input-group-text" id="basic-addon1">Fecha de entrada</span>
                        <input value="<?php echo $row->entrada; ?>" type="date" name="fechaEntrada" class="form-control" placeholder="Fecha de entrada" aria-label="Username" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3 titulo">
                        <span class="input-group-text" id="basic-addon1">Fecha de salida</span>
                        <input value="<?php echo $row->salida; ?>" type="date" name="fechaSalida" class="form-control" placeholder="Fecha de salida" aria-label="Username" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Importe</span>
                        <input value="<?php echo $row->importe; ?>" type="number" step="any" name="importe" class="form-control">
                    </div>

                    <div class="input-group">
                        <span class="input-group-text">Comentario</span>
                        <textarea class="form-control text-left" name="comentario"><?php echo $row->comentario;?></textarea>
                    </div>

                    <div class="row mt-3">
                        <div class="col-3 mx-auto">
                            <input class="btn btn-primary mx-auto" type="text" value="SALIR" name="salir" id="salir">
                        </div>
                        <div class="col-3 mx-auto">
                            <input class="btn btn-warning mx-auto" type="submit" value="ACTUALIZAR" name="actualizar" id="actualizar">
                        </div>
                    </div>

                <?php endforeach; ?>
            </form>
        </div>
    </div>
    <?php include_once 'Vista/pieJavaScript.php'; ?>
    <script type="text/javascript" src="js/Ingresos.js"></script> 
</body>
</html>

