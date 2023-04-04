<!DOCTYPE html>
<!--#################################################################################################
Esta archivo se encarga de listar todos los gastos de la tabla gastos
##################################################################################################-->
<?php
$subtotal = 0;
$total = 0;
?>
<body>
    <br><br>
    <div class="container">
        <?php
        if (!isset($idGastoFiltrado)) {
            $idGastoFiltrado = 0;
        }
        ?>
        <div class='row justify-content-center'>
            <div class="col-2">
                <select name="concepto" id="concepto">
                    <option name="filtrarGasto" id="filtrarGasto" value="0">Filtrar por ...</option>
                    <?php foreach ($conceptos as $concepto) : ?>
                        FILTRAR <option name="filtrarGasto" id="filtrarGasto" value="<?php echo $concepto->id_concepto; ?>"><?php echo $concepto->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <table class="table table-striped">            
            <thead>
                <tr>
                    <th>FECHA</th>
                    <th>CONCEPTO</th>
                    <th>IMPORTE</th>
                    <th>COMENTARIO</th>
                    <th><button type="button" id="nuevoGasto" class="btn btn-primary">AÑADIR NUEVO GASTO</button></th>
                </tr>
            </thead>
            <?php
            $gastosXpagina = 5;
            // $numeroGastos ya viene dada de controlador y es el numero de registros de la tabla ingresos
            $paginas = ceil($numeroGastos / $gastosXpagina);
            ?>
            <?php
            foreach ($resultado as $row):
                ?>
                <tr>
                    <td><?php echo $row->fecha; ?></td>
                    <td><?php echo $row->nombre; ?></td>
                    <td style='width: 70px; text-align:right; color:blue;'><?php echo number_format($row->importe, $decimals = 2, $dec_point = ',', $thousands_sep = "."); ?></td>

                    <?php $subtotal += $row->importe; ?>

                    <td><?php echo substr($row->comentario, 0, 15) . "..." ?></td>

                <input type='hidden' name='idGasto' value='<?php echo $row->id_gasto; ?>'/>
                <input type='hidden' name='idConcepto' value='<?php echo $row->id_concepto; ?>'/>

                <td class="borrar">
                    <a href="#&idGasto=<?php echo $row->id_gasto; ?>&borrar='borrar'" class="btn btn-danger">BORRAR</a>
                </td>
                <td class="ver">
                    <a href="#&idGasto=<?php echo $row->id_gasto; ?>&ver='ver'"      class="btn btn-primary">VER</a>
                </td>
                </tr>

            <?php endforeach; ?> 
            <tr>
                <td colspan='2'>Subtotal de esta página: </td>
                <td style='font-weight:bold; color:blue;'><?php echo number_format($subtotal, $decimals = 2, $dec_point = ',', $thousands_sep = "."); ?></td>
            </tr>
            <tr>
                <td colspan='2'>Total: </td>
                <td style='font-weight:bold; color:blue;'><?php echo number_format($totalGastos['totalImportes'], $decimals = 2, $dec_point = ',', $thousands_sep = "."); ?></td>
            </tr>
        </table>
        <!----------------------------------------------------------------->
        <!--------------------------- PAGINACION -------------------------->
        <!----------------------------------------------------------------->
        <nav>
            <?php
            if (!isset($_GET['pagina'])) {
                $_GET['pagina'] = 0;
            }
            ?>
            <ul class="pagination">
                <li class="anterior page-item <?php echo $_GET['pagina'] == 1 ? 'disabled' : '' ?>"> 
                    <a class="page-link" href="#&pagina=<?php echo $_GET['pagina'] - 1 ?>&filtrado=<?php echo $idGastoFiltrado; ?>">ANTERIOR</a>
                </li>

                <?php for ($i = 0; $i < $paginas; $i++): ?>
                    <li class="actual page-item <?php echo $_GET['pagina'] == $i + 1 ? 'active' : '' ?>">
                        <a class="page-link" href="#&pagina=<?php echo $i + 1 ?>&filtrado=<?php echo $idGastoFiltrado; ?>"> <?php echo $i + 1 ?> </a>
                    </li>
                <?php endfor; ?>

                <li class="siguiente page-item <?php echo $_GET['pagina'] == $paginas ? 'disabled' : '' ?>">
                    <a class="page-link" href="#&pagina=<?php echo $_GET['pagina'] + 1 ?>&filtrado=<?php echo $idGastoFiltrado; ?>"> SIGUIENTE </a>
                </li>                   
            </ul>
        </nav>
        <!----------------------------------------------------------------->
        <!--------------------------- FIN PAGINACION ---------------------->
        <!----------------------------------------------------------------->

    </div>
    <script>
        $(document).ready(function () {
//           ===================================================================== 
//            var parametros;
//            var filtrado;
//            var pagina;
                var url;
                var params;
                var pagina;
                var filtrado;

            $("#concepto").change(function () {
                var filtrado = $("#concepto").val();
                var parametros = {"filtrado": filtrado};
                $.ajax({
                    type: "GET",
                    url: '?c=listarGastoFiltrado',
                    data: parametros,
                    success: function (gastoFiltrado) {
                        $("#info").html(gastoFiltrado);
                    },
                    error: function () {
                        $('#info').html("Por favor intentelo de nuevo");
                    }
                });
            });

// ============================================================================= 
            $(".pagination .siguiente a").click(function (e) {
                url = $(e.target).attr("href");
                params = getUrlParams(url);
                pagina = params["pagina"];
                filtrado = params["filtrado"];

                if (filtrado != '0') {
                    $.ajax({
                        type: "GET",
                        url: '?c=listarGastoFiltrado',
                        data: {"filtrado": filtrado, "pagina": pagina},
                        success: function (gastos) {
                            $("#info").html(gastos);
                        },
                        error: function () {
                            $('#info').html("Error. Por favor intentelo de nuevo");
                        }
                    });
                } else {
                    $.ajax({
                        url: '?c=listarGastos',
                        data: {pagina: pagina},
                        success: function (gastos) {
                            $("#info").html(gastos);
                        },
                        error: function () {
                            $('#info').html("Por favor intentelo de nuevo");
                        }
                    });
                }
            });
// ============================================================================= 
            $(".pagination .anterior a").click(function (e) {
                var url = $(e.target).attr("href");
                var params = getUrlParams(url);
                var pagina = params["pagina"];
                var filtrado = params["filtrado"];

                if (filtrado != '0') {
                    parametros = {"filtrado": filtrado, "pagina": pagina};
                    $.ajax({
                        type: "GET",
                        url: '?c=listarGastoFiltrado',
                        data: parametros,
                        success: function (gastos) {
                            $("#info").html(gastos);
                        },
                        error: function () {
                            $('#info').html("Error. Por favor intentelo de nuevo");
                        }
                    });
                } else {
                    $.ajax({
                        url: '?c=listarGastos',
                        data: {pagina: pagina},
                        success: function (gastos) {
                            $("#info").html(gastos);
                        },
                        error: function () {
                            $('#info').html("Por favor intentelo de nuevo");
                        }
                    });
                }
            });
// =============================================================================
            /**
             * Esta funcion entra a trabajar cuando se pulsa un enlace dentro de la clase actual y dentro de la clase pagination
             * Obtiene la url en bruto y luego llama a la funcion getUrlParms para obtener el valor de variable
             * Luego ese valor se pasa a la funcion clientes de controlador y obtiene la pagina de clientes requerida
             */
            $(".pagination .actual a").click(function (e) {
                var url = $(e.target).attr("href");
                var params = getUrlParams(url);
                var pagina = params["pagina"];
                var filtrado = params["filtrado"];

                if (filtrado != '0') {
//                    parametros = {"filtrado": filtrado, "pagina": pagina};
                    $.ajax({
                        type: "GET",
                        url: '?c=listarGastoFiltrado',
                        data: {"filtrado": filtrado, "pagina": pagina},
                        success: function (gastos) {
                            $("#info").html(gastos);
                        },
                        error: function () {
                            $('#info').html("Error. Por favor intentelo de nuevo");
                        }
                    });
                } else {
                    $.ajax({
                        url: '?c=listarGastos',
                        data: {pagina: pagina},
                        success: function (gastos) {
                            $("#info").html(gastos);
                        },
                        error: function () {
                            $('#info').html("Por favor intentelo de nuevo");
                        }
                    });
                }
            });
// =============================================================================
            $(".ver a").click(function (e) {
                var url = $(e.target).attr("href");
                var params = getUrlParams(url);

                var idGasto = params["idGasto"];
                var ver = params["ver"];

                $.ajax({
                    url: '?c=borrar_ver_Gasto',
                    data: {idGasto: idGasto, ver: ver},
                    success: function (modificarCliente) {
                        $("#info").html(modificarCliente);
                    },
                    error: function () {
                        $('#info').html("Por favor intentelo de nuevo");
                    }
                });
            });
// =============================================================================            
            $(".borrar a").click(function (e) {
                var url = $(e.target).attr("href");
                var params = getUrlParams(url);

                var idGasto = params["idGasto"];
                var borrar = params['borrar'];

                $.ajax({
                    url: '?c=borrar_ver_Gasto',
                    data: {idGasto: idGasto, borrar: borrar},
                    success: function (eliminarGasto) {
                        $("#info").html(eliminarGasto);
                    },
                    error: function () {
                        $('#info').html("Por favor intentelo de nuevo");
                    }
                });
            });
// =============================================================================                        
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
    <script type="text/javascript" src="js/MenuPrincipal.js"></script>
</body>