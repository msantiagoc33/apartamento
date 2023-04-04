<!--#################################################################################################
Esta archivo se de obtener los datos para un nuevo concepto
##################################################################################################-->
<style>
    input{
        color: blue;
    }
    .repetido {
        color: red;
        background-color: cyan;
        margin-top: 15px;
        text-align: center;
        font-weight: bold;
    }
</style>
<body>
    <br><br>
    <div id="registrosConceptos">
        <div class='container' style='width:50%;'>
            <div id="cabecera" class="center-align">
                <span>Añadir nuevo concepto</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <td>NOMBRE</td>
                    </tr>
                </thead>
                <tr>
                    <td><input id="concepto" type="text" name="concepto"></td>
                    <td class="datosNuevoConcepto"><a href="#&nombreConcepto=concepto" class="btn btn-danger">ENVIAR</a></td>
                    <!--<td><input type="submit" value="ENVIAR" id="datosNuevoConcepto"></td>-->
                </tr>
            </table>  
            <div class="mx-auto repetido"><?php if (isset($_POST['repetido'])) echo $_POST['repetido']; ?></div>
        </div>
        
    </div>
    <script>
        $(document).ready(function () {
            $( "#concepto" ).focus();
            
            $(".datosNuevoConcepto a").click(function (e) {

                var concepto = $('#concepto').val();

                $.ajax({
                    url: '?c=grabarNuevoConcepto',
                    data: {concepto: concepto},
                    success: function (concepto) {
                        $("#info").html(concepto);
                    },
                    error: function () {
                        $('#info').html("Por favor intentelo de nuevo");
                    }
                });
            });

            /**
             * 
             * @param {type} url array para almacenar los parametros de la url
             * @return devuelve el parametro obtenido de la url pasada como parametro
             */
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

