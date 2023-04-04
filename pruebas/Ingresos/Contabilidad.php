<?php

//################################################################################
// NUEVO INGRESO
//################################################################################
if (filter_input(INPUT_POST, 'enviar', FILTER_SANITIZE_SPECIAL_CHARS)) {
    include_once 'GrabarNuevoIngreso.php';
}
//################################################################################
//CODIGO PARA ELIMINAR REGISTRO EN INGRESOS
//################################################################################
if (filter_input(INPUT_POST, 'borrar', FILTER_SANITIZE_SPECIAL_CHARS)) {
    include_once 'BorrarIngreso.php';
}
//################################################################################

include_once 'Vista/cabecera.html';
?>
<!DOCTYPE html>
<!--#################################################################################################
Esta archivo se encarga de añadir un nuevo registro en la tabla ingresos pero desde aqui tambien
se llama a borrar registro y al listado de todos los registros
##################################################################################################-->

    <body>
        <div id="contenedor">
            <div id="encabezado">
                <h1>Gestión apartamento SANGUT - Ingresos</h1>
            </div>

            <?php
            // ================================================================================================================
            // Este codigo se ejecuta cualdo pulsamos el boton modificar de la linea de registros para capturar los valores
            // ================================================================================================================
            // Si he pulsado el boton modificar del listado de registros ...
            if (filter_input(INPUT_POST, 'modificar', FILTER_SANITIZE_SPECIAL_CHARS)) {
                include_once 'ModificarIngresos.php';

                // Si no se ha pulsado el boton modificar, la pantalla esta preparada para un nuevo ingreso    
            } else {
                include_once 'FormularioNuevoIngreso.php';
            }

            // ####################################################################
            // LISTADO DE REGISTROS -->
            // ####################################################################

            include_once 'ListadoIngresos.php';
            ?>
        </div>

        <div id="pie">
            <br>
            <p><?php 
            echo $_SESSION['mensaje']; 
            $_SESSION['mensaje'] = '';
            ?></p>  
            
        </div>
    </body>
</html>
