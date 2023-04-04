$(document).ready(function () {

// Comprueba que la fecha de salida no se menor que la de entrada
    $("#fechaSalida").focusout(function (event) {
        let entrada = $('#fechaEntrada').val();
        let salida = $('#fechaSalida').val();
        if (salida < entrada) {
            $("#mensage").html("La fecha de SALIDA no puede ser menor que la de ENTRADA");
            $('#fechaEntrada').focus();
            $('#fechaEntrada').select();
        }
    });
    // Comprueba en cada pulsacion que solo introduzco numero y punto
    $('#importe').on('input', function () {
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
// =============================================================================
// Graba nuevo ingreso
// =============================================================================    
    $('#formNuevoIngreso').one('submit', function (e) {

        limpiarClicks();
        e.preventDefault(); //prevent form from submitting
        var data = $("#formNuevoIngreso :input").serializeArray();
        $.ajax({
            url: '?c=nuevoIngreso',
            type: "post",
            data: data,
            success: function (altaIngreso) {
                $("#info").html(altaIngreso);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            },
            complete: function () {
                $.ajax({
                    url: '?c=paginacionIngresos',
                    success: function (ingresos) {
                        $('#info').html(ingresos);
                    },
                    error: function () {
                        $('#info').html('Error. No se ha podido listar las tareas. Hable con el administrador.');
                    }
                });
            }
        });
    });
// =============================================================================
// Cancelar modificar ingreso
// =============================================================================    
    $('#salir').one("click", function () {
        limpiarClicks();
        e.preventDefault(); //prevent form from submitting

        $.ajax({
            url: '?c=paginacionIngresos',
            success: function (index) {
                $("#info").html(index);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });
// =============================================================================
// Modificar ingreso
// =============================================================================    
    $('#formActualizarIngreso').one('submit', function (e) {
        limpiarClicks();
        e.preventDefault(); //prevent form from submitting
        var data = $("#formActualizarIngreso :input").serializeArray();
        console.log(data);
        $.ajax({
            url: '?c=modificarIngreso',
            type: "post",
            data: data,
            success: function (modificarIngreso) {
                $("#info").html(modificarIngreso);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            },
            complete: function () {
                $.ajax({
                    url: '?c=paginacionIngresos',
                    success: function (ingresos) {
                        $('#info').html(ingresos);
                    },
                    error: function () {
                        $('#info').html('Error. No se ha podido listar las tareas. Hable con el administrador.');
                    }
                });
            }
        });
    });
// ================================================================================= 
//
// Esta seccion cambia el color de la fecha de entrada
//
// ================================================================================= 


    var fecha = new Date();
    var hoy = fecha.getFullYear() + "/" + (fecha.getMonth() + 1) + "/" + fecha.getDate();
    hoy = Date.parse(hoy);
    pintarRows(hoy);

    function pintarRows() {
        $("#tablaIngresos tr .entrada").each(function () {

            var entrada;
            entrada = $(this).text();
            entrada = new Date(entrada);
            entrada = entrada.getFullYear() + "/" + (entrada.getMonth() + 1) + "/" + entrada.getDate();
            entrada = Date.parse(entrada);
            if (entrada > hoy) {
                $(this).css({'background-color': '#ff0000', 'color': 'white'});
            } else {
                $(this).css({'background-color': '#0000ff', 'color': 'white'});
            }
        });

    }

// =================================================================================     
// ================================================================================= 
//
// Elimina un registro
//
// ================================================================================= 
    $(".borrar a").one('click', function (e) {
        var eliminar=confirm("¿ Deseas eliminar este registro ?");
        if(eliminar){
            limpiarClicks();
            var url = $(e.target).attr("href");
            var params = getUrlParams(url);
            var idIngreso = params["idIngreso"];
            var borrar = params['borrar'];
                $.ajax({
                    url: '?c=borrar_ver_Ingreso',
                    data: {idIngreso: idIngreso, borrar: borrar},
                    success: function (eliminarConcepto) {
                        $("#info").html(eliminarConcepto);
                    },
                    error: function () {
                        $('#info').html("Por favor intentelo de nuevo");
                    }
                });
        }    
    });

// ================================================================================= 
//
// ver/borrar un ingreso
//
// ================================================================================= 
    $(".ver a").one('click', function (e) {

        limpiarClicks();
        var url = $(e.target).attr("href");
        var params = getUrlParams(url);
        var idIngreso = params["idIngreso"];
        var ver = params["ver"];
        $.ajax({
            url: '?c=borrar_ver_Ingreso',
            data: {idIngreso: idIngreso, ver: ver},
            success: function (modificarCliente) {
                $("#info").html(modificarCliente);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });
// ================================================================================= 
//
// Paginacion de ingresos, siguiente
//
// ================================================================================= 
    $(".pagingresos .siguiente a").one('click', function (e) {
        limpiarClicks();
        var url = $(e.target).attr("href");
        var params = getUrlParams(url);
        var pagina = params["pagina"];
        $.ajax({
            url: '?c=paginacionIngresos',
            data: {pagina: pagina},
            success: function (clientes) {
                $("#info").html(clientes);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });
// ================================================================================= 
//
// Paginacion de igresos, anterior
//
// ================================================================================= 
    $(".pagingresos .anterior a").one('click', function (e) {

        limpiarClicks();
        var url = $(e.target).attr("href");
        var params = getUrlParams(url);
        var pagina = params["pagina"];
        $.ajax({
            url: '?c=paginacionIngresos',
            data: {pagina: pagina},
            success: function (clientes) {
                $("#info").html(clientes);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });
// ================================================================================= 
//
// paginacion de ingresos, actual
//
// ================================================================================= 
    $(".pagingresos .actual a").one('click', function (e) {

        limpiarClicks();
        var url = $(e.target).attr("href");
        var params = getUrlParams(url);
        var pagina = params["pagina"];
        $.ajax({
            url: '?c=paginacionIngresos',
            data: {pagina: pagina},
            success: function (clientes) {
                $("#info").html(clientes);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });
// ================================================================================= 
//
// Paginacion de historico, siguiente
//
// ================================================================================= 
    $(".pagination .siguienteHistorico a").one('click', function (e) {

        limpiarClicks();
        var url = $(e.target).attr("href");
        var params = getUrlParams(url);
        var pagina = params["pagina"];
        $.ajax({
            url: '?c=paginacionHistorico',
            data: {pagina: pagina},
            success: function (clientes) {
                $("#info").html(clientes);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });
// ================================================================================= 
//
// Paginacion de historico, anterior
//
// ================================================================================= 
    $(".pagination .anteriorHistorico a").one('click', function (e) {

        limpiarClicks();
        var url = $(e.target).attr("href");
        var params = getUrlParams(url);
        var pagina = params["pagina"];
        $.ajax({
            url: '?c=paginacionHistorico',
            data: {pagina: pagina},
            success: function (clientes) {
                $("#info").html(clientes);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });
// ================================================================================= 
//
// Paginacion de historico, actual
//
// ================================================================================= 
    $(".pagination .actualHistorico a").one('click', function (e) {

        limpiarClicks();
        var url = $(e.target).attr("href");
        var params = getUrlParams(url);
        var pagina = params["pagina"];
        $.ajax({
            url: '?c=paginacionHistorico',
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
//    ==========================================================================

    /**
     * 
     * Esta funcion se encarga de resetear todos los tipos de click que hay en el
     * menu principal para que no se repitan las funciones.
     */
    function limpiarClicks() {
        $("#formNuevoIngreso").off();
        $("#salir").off();
        $("#formActualizarIngreso").off();
        $("#borrar").off();
        $(".ver").off();
        $(".pagingresos .siguiente a").off();
        $(".pagingresos .anterior a").off();
        $(".pagingresos .actual a").off();
        $(".pagination .siguienteHistorico a").off();
        $(".pagination .anteriorHistorico a").off();
        $(".pagination .actualHistorico a").off();
    }
});
