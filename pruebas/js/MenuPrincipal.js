$(document).ready(function () {

//    ==========================================================================

    $("#listarIngresos").one("click",function () {
        console.log ("normal");
        limpiarClicks();
        $.ajax({
            url: '?c=paginacionIngresos',
            success: function (formulario) {
                $("#info").html(formulario);
            },
            error: function ()
            {
                $('#info').html("Error. Por favor intentelo de nuevo");
            }
        });
    });
    $("#listarIngresosM").one("click",function () {
        console.log ("media");
        limpiarClicks();
        $.ajax({
            url: '?c=paginacionIngresos',
            success: function (formulario) {
                $("#info").html(formulario);
            },
            error: function ()
            {
                $('#info').html("Error. Por favor intentelo de nuevo");
            }
        });
    });
//    ==========================================================================

    $("#historico").one("click",function () {
        limpiarClicks();
        $.ajax({
            url: '?c=paginacionHistorico',
            success: function (historico) {
                $("#info").html(historico);
            },
            error: function ()
            {
                $('#info').html("Error. Por favor intentelo de nuevo");
            }
        });
    });

    $("#historicoM").one("click",function () {
        limpiarClicks();
        $.ajax({
            url: '?c=paginacionHistorico',
            success: function (historico) {
                $("#info").html(historico);
            },
            error: function ()
            {
                $('#info').html("Error. Por favor intentelo de nuevo");
            }
        });
    });

//    ========================================================================== 
    $("#clientes").click(function () {
        $("#clientes").off();
        $.ajax({
            url: '?c=clientes',
            success: function (clientes) {
                $("#info").html(clientes);
            },
            error: function ()
            {
                $('#info').html("Error. Por favor intentelo de nuevo");
            }
        });
    });
//    ==========================================================================
    $("#conceptos").click(function () {
        $("#conceptos").off();
        $.ajax({
            url: '?c=listaConceptos',
            success: function (conceptos) {
                $("#info").html(conceptos);
            },
            error: function ()
            {
                $('#info').html("Error. Por favor intentelo de nuevo");
            }
        });
    });
//    ==========================================================================
    $("#nuevoCliente").click(function () {
        limpiarClicks();
        $.ajax({
            url: '?c=nuevoCliente',
            success: function (clientes) {
                $("#info").html('');  // limpiamos el div
                $("#info").html(clientes);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });
//    ==========================================================================
    $("#nuevoIngreso").click(function () {
        limpiarClicks();
        $.ajax({
            url: '?c=nuevoIngreso',
            success: function (ingresos) {
                $("#info").html(ingresos);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });
//    ==========================================================================
    $("#gastos").click(function () {
        limpiarClicks();
        $.ajax({
            url: '?c=listarGastos',
            success: function (gastos) {
                $("#info").html(gastos);
            },
            error: function ()
            {
                $('#info').html("Error. Por favor intentelo de nuevo");
            }
        });
    });
//    ==========================================================================
    $("#nuevoGasto").click(function () {
        limpiarClicks();
        $.ajax({
            url: '?c=nuevoGasto',
            success: function (gastos) {
                $("#info").html(gastos);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });
//    ==========================================================================
    $("#cerrarSesion").click(function () {
        limpiarClicks();
        $.ajax({
            url: '?c=desconectar',
            success: function (desconectar) {
                $(".container").html(desconectar);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });

    $("#cerrarSesionM").click(function () {
        limpiarClicks();
        $.ajax({
            url: '?c=desconectar',
            success: function (desconectar) {
                $(".container").html(desconectar);
            },
            error: function () {
                $('#info').html("Por favor intentelo de nuevo");
            }
        });
    });
//    ==========================================================================

    /**
     * 
     * Esta funcion se encarga de resetear todos los tipos de click que hay en el
     * menu principal para que no se repitan las funciones.
     */
    function limpiarClicks() {
        $("#cerrarSesion").off();
        $("#listarIngresos").off();
        $("#historico").off();
        $("#conceptos").off();
        $("#clientes").off();
        $("#listarIngresosM").off();
        $("#gastos").off();
        $("#nuevoIngreso").off();
        $("#nuevoCliente").off();
        $("#nuevoGasto").off();
    }
//    ==========================================================================

});

