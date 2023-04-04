
$(document).ready(function () {
// =============================================================================
// Grabar Modificar cliente
// ============================================================================= 
    var paisSeleccionado = $('select[name=paisSeleccionado]').val();
    var nombreCliente = $(":input").val();

    $("select[name=paisSeleccionado]").change(function () {
        paisSeleccionado = $('select[name=paisSeleccionado]').val();
    });

    $(":input").change(function () {
        nombreCliente = $('input[name=nombreCliente]').val();
    });

    $(".grabarModificarCliente a").click(function (e) {
        var url = $(e.target).attr("href");
        var params = getUrlParams(url);

        var idCliente = params["idCliente"];
        var idPaisAntiguo = params["idPaisAntiguo"];

        $.ajax({
            url: '?c=grabarModificarCliente',
            data: {idCliente: idCliente, nombreCliente: nombreCliente, idPaisAntiguo: idPaisAntiguo, paisSeleccionado: paisSeleccionado},
            success: function (modificarCliente) {
                $("#info").html(modificarCliente);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });

// =============================================================================
// Graba nuevo cliente
// =============================================================================    
    $('#formNuevoCliente').on('submit', function (e) {
        e.preventDefault();  //prevent form from submitting
        var data = $("#formNuevoCliente :input").serializeArray();
        $.ajax({
            url: '?c=nuevoCliente',
            type: "post",
            data: data,
            success: function (altaCliente) {
                $("#info").html(altaCliente);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
//            ,
//            complete: function () {
//                $.ajax({
//                    url: '?c=clientes',
//                    success: function (tareas) {
//                        $('#info').html(tareas);
//                    },
//                    error: function () {
//                        $('#info').html('Error. No se ha podido listar las tareas. Hable con el administrador.');
//                    }
//                });
//            }
        });
    });
// =============================================================================
// Datos Nuevo cliente
// =============================================================================
//    $("#nuevoCliente").one("click", function (e) {
//        e.preventDefault();  //prevent form from submitting
//        nombreCliente = $("#nombre").val();
//        idPais = $("#paisSeleccionado").val();
//        alert(nombreCliente);
//        $.ajax({
//            url: '?c=nuevoCliente',
//            type: "post",
//            data: {nombreCliente:nombreCliente, idPais:idPais},
//            success: function (NuevoCliente) {
//                $("#info").html(NuevoCliente);
//            },
//            error: function () {
//                $('#info').html("Por favor intentelo de nuevo");
//            }
//        });
//    });

// =============================================================================
// Borrar un cliente
// =============================================================================
    $(".borrar a").click(function (e) {
        $(".borrar a").off();
        var url = $(e.target).attr("href");
        var params = getUrlParams(url);

        var idCliente = params["idCliente"];

        $.ajax({
            url: '?c=eliminarCliente',
            data: {idCliente: idCliente},
            success: function (modificarCliente) {
                $("#info").html(modificarCliente);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            },
            complete: function () {
                $.ajax({
                    url: '?c=clientes',
                    success: function (tareas) {
                        $('#info').html(tareas);
                    },
                    error: function () {
                        $('#info').html('Error. No se ha podido listar las tareas. Hable con el administrador.');
                    }
                });
            }
        });


    });
// =============================================================================
// Modificar un cliente
// =============================================================================
    $(".modificar a").click(function (e) {
        $(".modificar a").off();
        var url = $(e.target).attr("href");
        var params = getUrlParams(url);

        var idCliente = params["idCliente"];
        var nombreCliente = params["nombreCliente"];
        var paisCliente = params["paisCliente"];
        var idPais = params["idPais"];

        $.ajax({
            url: '?c=modificarCliente',
            data: {idCliente: idCliente, nombreCliente: nombreCliente, paisCliente: paisCliente, idPais: idPais},
            success: function (modificarCliente) {
                $("#info").html(modificarCliente);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });
// =============================================================================
// Pagina siguiente
// =============================================================================
//    $(".pagination .siguiente a").click(function (e) {
//        var url = $(e.target).attr("href");
//        var params = getUrlParams(url);
//        var pagina = params["pagina"];
//
//        $.ajax({
//            url: '?c=clientes',
//            data: {pagina: pagina},
//            success: function (clientes) {
//                $("#info").html(clientes);
//            },
//            error: function () {
//                $('#info').html("Por favor intentelo de nuevo");
//            }
//        });
//    });
// =============================================================================
// Pagina anterior
// =============================================================================    
//    $(".pagination .anterior a").click(function (e) {
//        var url = $(e.target).attr("href");
//        var params = getUrlParams(url);
//        var pagina = params["pagina"];
//
//        $.ajax({
//            url: '?c=clientes',
//            data: {pagina: pagina},
//            success: function (clientes) {
//                $("#info").html(clientes);
//            },
//            error: function () {
//                $('#info').html("Por favor intentelo de nuevo");
//            }
//        });
//    });
// =============================================================================
// Pagina actual
// =============================================================================
    /**
     * Esta funcion entra a trabajar cuando se pulsa un enlace dentro de la clase actual y dentro de la clase pagination
     * Obtiene la url en bruto y luego llama a la funcion getUrlParms para obtener el valor de variable
     * Luego ese valor se pasa a la funcion clientes de controlador y obtiene la pagina de clientes requerida
     */
//    $(".pagination .actual a").click(function (e) {
//        var url = $(e.target).attr("href");
//        var params = getUrlParams(url);
//        var pagina = params["pagina"];
//
//        $.ajax({
//            url: '?c=clientes',
//            data: {pagina: pagina},
//            success: function (clientes) {
//                $("#info").html(clientes);
//            },
//            error: function () {
//                $('#info').html("Por favor intentelo de nuevo");
//            }
//        });
//    });
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



