<!--#################################################################################################
Esta archivo se encarga de listar todos los conceptos de la tabla conceptos
##################################################################################################-->
<body>
    <br><br>
    <div id="registrosConceptos" style="width:800px;" class="mx-auto">
        <div id="cabecera">
            <span>Listado de conceptos</span>                
        </div>
        <div class="justify-content-md-end">
            
        </div>
        <div class="registrosConceptos">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th><th>CONCEPTO</th><th><button type="button" id="nuevoConcepto" class="btn btn-primary">AÑADIR NUEVO CONCEPTO</button></th>
                    </tr>
                </thead>
                <?php foreach ($resultado as $row) : ?>
                    <tr>
                        <td> <?php echo $row->id_concepto; ?> </td>
                        <td> <?php echo $row->nombre; ?> </td> 
                        <td class="borrar">
                            <a href="#&idConcepto=<?php echo $row->id_concepto; ?>&nombre=" class="btn btn-danger">BORRAR</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>


    </div>
    <script>
        $(document).ready(function () {

            $("#nuevoConcepto").click(function () {

                $.ajax({
                    url: '?c=datosNuevoConcepto',
                    success: function (concepto) {
                        $("#info").html(concepto);
                    },
                    error: function () {
                        $('#info').html("Por favor intentelo de nuevo");
                    }
                });
            });

            $(".borrar a").click(function (e) {
                var url = $(e.target).attr("href");
                var params = getUrlParams(url);

                var idConcepto = params["idConcepto"];

                $.ajax({
                    url: '?c=eliminarConcepto',
                    data: {idConcepto: idConcepto},
                    success: function (eliminarConcepto) {
                        $("#info").html(eliminarConcepto);
                    },
                    error: function () {
                        $('#info').html("Por favor intentelo de nuevo");
                    }
                });
            });

            $(".pagination .siguiente a").click(function (e) {
                var url = $(e.target).attr("href");
                var params = getUrlParams(url);
                var pagina = params["pagina"];

                $.ajax({
                    url: '?c=clientes',
                    data: {pagina: pagina},
                    success: function (clientes) {
                        $("#info").html(clientes);
                    },
                    error: function () {
                        $('#info').html("Por favor intentelo de nuevo");
                    }
                });
            });
            $(".pagination .anterior a").click(function (e) {
                var url = $(e.target).attr("href");
                var params = getUrlParams(url);
                var pagina = params["pagina"];

                $.ajax({
                    url: '?c=clientes',
                    data: {pagina: pagina},
                    success: function (clientes) {
                        $("#info").html(clientes);
                    },
                    error: function () {
                        $('#info').html("Por favor intentelo de nuevo");
                    }
                });
            });
            /**
             * Esta funcion entra a trabajar cuando se pulsa un enlace dentro de la clase actual y dentro de la clase pagination
             * Obtiene la url en bruto y luego llama a la funcion getUrlParms para obtener el valor de variable
             * Luego ese valor se pasa a la funcion clientes de controlador y obtiene la pagina de clientes requerida
             */
            $(".pagination .actual a").click(function (e) {
                var url = $(e.target).attr("href");
                var params = getUrlParams(url);
                var pagina = params["pagina"];

                $.ajax({
                    url: '?c=clientes',
                    data: {pagina: pagina},
                    success: function (clientes) {
                        $("#info").html(clientes);
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
    <!--<script type="text/javascript" src="js/MenuPrincipal.js"></script>-->
</body>
</html>

