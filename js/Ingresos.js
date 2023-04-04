$(document).ready(function () {

// Comprueba la plataforma al entrar en cliente
    $("#clienteSeleccionado").focusin(function () {
        let plataforma = $('#plataformaSeleccionada').val();
        if (plataforma == 0) {
            limpiarMensaje();
            $("#mensage").html("Tiene que seleccionar una plataforma");
            $('#plataformaSeleccionada').focus();
            $('#plataformaSeleccionada').select();
        }

    });

    // Comprueba el cliente al entrar en numero de huespedes
    $("#huespedes").focusin(function () {
        let cliente = $('#clienteSeleccionado').val();
        if (cliente == 0) {
            limpiarMensaje();
            $("#mensage").html("Tiene que seleccionar un cliente");
            $('#clienteSeleccionado').focus();
            $('#clienteSeleccionado').select();
        }

    });

// Comprueba el número de huespedes al entra en el campo fechaEntrada
    $("#fechaEntrada").focusin(function () {
        limpiarMensaje();
        let huespedes = $('#huespedes').val();
        let minimo = 1;
        let maximo = 4;
        if (huespedes < minimo || huespedes > maximo) {
            $("#mensage").html("El número de huespedes es incorrecto, tiene que estar entre 1 y 4");
            $('#huespedes').focus();
            $('#huespedes').select();
        }

    });


// Comprueba que la fecha de salida no se menor que la de entrada al entrar en el campo importe
    $("#importe").focusin(function () {
        let entrada = $('#fechaEntrada').val();
        let salida = $('#fechaSalida').val();
        if (salida < entrada) {
            limpiarMensaje();
            $("#mensage").html("La fecha de SALIDA no puede ser menor que la de ENTRADA");
            $('#fechaEntrada').focus();
            $('#fechaEntrada').select();
        } else
            limpiarMensaje();
    });


    // Comprueba en cada pulsacion que solo introduzco numero y punto
    // sustituye cualquier cosa que no sea un número por nada
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
    $('#salir').one("click", function (e) {
        limpiarClicks();
        e.preventDefault(); //prevent form from submitting
        $.ajax({
            url: '?c=paginacionIngresos',
            success: function (ingresos) {
                $("#info").html(ingresos);
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

    $(".borrar a").one('click', function (e) {
        var eliminar = confirm("¿ Deseas eliminar este registro ?");
        if (eliminar) {
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
        }
    });


    $(".ver a").one('click', function (e) {

        limpiarClicks();
        url = $(e.target).attr("href");
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

    // Limpio el div id mensaje del formulario.
    function limpiarMensaje() {
        $("#mensage").html("");
    }
});
