<?php
session_start();
?>
<!DOCTYPE html>
<!-- ##################################################################################
En esta pagina se recogen los datos para insertar un nuevo ingreso en la tabla ingresos
####################################################################################-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../js/jquery-351-min.js"></script>
        <link rel="stylesheet" href="../css/estilos.css"/>
        
        <script>
            $(document).ready(function () {
                $('#fs').focusout(function () {
                    var entrada = new Date($('.entrada').val());

                    var salida = new Date($('.salida').val());

                    var diasdif = salida.getTime() - entrada.getTime();

                    var contdias = Math.round(diasdif / (1000 * 60 * 60 * 24));

                    $('#numeroDias').html(contdias);

                });
            });
        </script>
    </head>
    <body>
        <!--
        #####################################################################
            FORMULARIO DE ENTRADA DE DATOS
        #####################################################################-->
        <form id="formularioRegistroAmpliado" action="" method="post">
            <div id="registroAmpliado">
                <fieldset>
                    <legend>Datos del cliente  <?php echo $cliente ?></legend>

                    <label for="fechaAmpliadaEntrada">Fecha Entrada</label>
                    <input type="date" name="fechaAmpliadaEntrada" autofocus="autofocus" class="entrada"/>

                    <label for="importeAmpliada">Importe</label>
                    <input type="number" step="any" name="importeAmpliada" style="width: 55px">

                    <!--######################## RELLENAR EL COMBOBOX DE CLIENTES Y PAISES ###################################-->
                    <?php
                    include_once '../Modelo/ComboboxClientes.php'; // devuelve la variable paisAmpliada
                    ?> 

                    <br><br>
                    <label for="fechaAmpliadaSalida">Fecha Salida: </label>
                    <input type="date" name="fechaAmpliadaSalida" autofocus="autofocus" id="fs" class="salida"/>
                    
                    <span>Días de alojamiento: </span>
                    <span id="numeroDias"></span>

                </fieldset>
                <br>
                <fieldset id="info">
                    <legend>Información de la estancia</legend>
                    <textarea name="comentarioAmpliada" rows="10" cols="109">Escribe aquí tus comentarios</textarea>
                    
                    <input class="verde centrar" name="enviar" type="submit" id="enviar" value="GRABAR" style="width:100px">
                </fieldset>
            </div>
        </form>
    </body>
</html>
