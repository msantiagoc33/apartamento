<!--#################################################################################################
Esta archivo se encarga de recoger los datos para un nuevo gasto
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
    <div id="registrosGastos">
        <div class='container' style='width:50%;'>
            <div id="cabecera" class="center-align">
                <span>Añadir nuevo gasto</span>
            </div>
            <div class="margenSuperior">
                <select id="gastoSeleccionado" name="id_concepto">
                    <option value="0">Selecciona tipo de gasto</option>
                    <?php
                    var_dump($conceptos);
                    foreach ($conceptos as $concepto) {
                        echo '<option value="' . $concepto->id_concepto . '">' . $concepto->nombre . '</option>';
                    }
                    ?>
                </select>
                
                <div class="input-group mb-3 margenSuperior">
                    <span class="input-group-text" id="basic-addon1">Fecha</span>
                    <input type="date" id="fechaGasto" name="fechaGasto" class="form-control" placeholder="Fecha del gasto" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                
                <div class="input-group mb-3 titulo">
                    <span class="input-group-text" id="basic-addon1">Importe</span>
                    <input type="text" id="importe" name="importe" class="form-control" placeholder="Importe" aria-label="Username" aria-label="Amount (to the nearest dollar)">
                    <span class="input-group-text">.00</span>
                </div>
                
                <div class="input-group">
                    <span class="input-group-text">Comentario</span>
                    <textarea class="form-control" id="comentario" name="comentario" aria-label="With textarea"></textarea>
                </div>
                
                <button id="enviarNuevoGasto" value="enviarNuevoGasto" class="margenSuperior btn btn-primary">ENVIAR</button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            $("#enviarNuevoGasto").click(function (e) {
                var enviarNuevoGasto = $('#enviarNuevoGasto').val(); 
                var idConcepto = $('#gastoSeleccionado').val();    
                var fechaGasto = $('#fechaGasto').val();    
                var importe    = $('#importe').val();      
                var comentario = $('#comentario').val(); 
                
                var parametros = {"enviarNuevoGasto": enviarNuevoGasto, "idConcepto":idConcepto, "fechaGasto":fechaGasto, "importe":importe, "comentario":comentario};
                
                $.ajax({
                    url: '?c=nuevoGasto',
                    type: 'post',
                    data: parametros,
                    success: function (concepto) {
                        $("#info").html(concepto);
                    },
                    error: function () {
                        $('#info').html("Por favor intentelo de nuevo");
                    }
                });
            });
            
             function getUrlParams(url) {
                var params = {};
                url.substring(1).replace(/[?&]+([^=&]+)=([^&]*)/gi,
                        function (str, key, value) {
                            params[key] = value;
                        });
                return params;
            }
        });

    </script>
</body>
</html>

