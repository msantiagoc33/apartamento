<!DOCTYPE html>
<style>
    body{
        font-size: 1em;
    }
</style>

<!--#################################################################################################
Esta archivo se encarga de listar todos los registros de la tabla ingresos
##################################################################################################-->
<?php
$pendienteCobro = 0;
$total = 0;
?>
<style>
   

</style>

<body>

    <br><br>


    <div class="container">
        <form action="#" method="post" name="formNuevoCliente" id="formNuevoCliente">
            <table class="table" id="tablaIngresos">
                <thead>
                    <tr>
                        <th class="text-center" id="entrada">ENTRADA</th>
                        <th class="text-center" id="salida">SALIDA</th>
                        <th class="text-center" id="noches"><i class="fa-solid fa-house"></i></th>
                        <th class="text-center ocultar">PLATAFORMA</th>
                        <th class="text-center" id="huespedes"><i class="fa-solid fa-person"></i></th>
                        <th class="text-center" id="importe"><i class="fa-solid fa-money-bill-1-wave"></i></th>
                        <th class="text-center">HUESPED</th>
                        <th class="text-center ocultar">PAIS</th>
                    </tr>
                </thead>
                <?php
                $ingresosXpagina = 5;
                // $numeroIngresos ya viene dada de controlador y es el numero de registros de la tabla ingresos
                $paginas = ceil($numeroIngresos / $ingresosXpagina);
                ?>
                <?php
                // Aqui recorremos todas la tabla de ingresos comparando la fecha de entrada con la fecha actual
                // si la diferencia es positiva es que aun no ha llegado la fecha y en ese caso
                // los importes pendiestes de cobro se acumulan en la variable $pendienteCobro
                foreach ($porCobrar as $row):
                    $fechaBBDD = $row->fechaEntrada;
                    $fecha_actual = strtotime(date("d-m-Y H:i:00", time()));
                    $fecha_entrada = strtotime("$fechaBBDD 21:00:00");
                    $diferencia = $fecha_entrada - $fecha_actual;
                    if ($diferencia > 0) {
                        $pendienteCobro += $row->importe;
                    }
                endforeach;

                foreach ($resultado as $row):
                    ?>
                    <tr class="registro">

                        <td class="entrada text-center">
                            <?php
                            echo $row->entrada;
                            ?>
                        </td>

                        <td class="salida text-center">
                            <?php
                            echo $row->salida;
                            ?>
                        </td>

                        <td class="text-center">                           
                            <?php
                            // Numero de noches
                            date_default_timezone_set("europe/madrid");
                            $fecha1 = new DateTime($row->entrada);
                            $fecha2 = new DateTime($row->salida);
                            $noches = $fecha2->diff($fecha1);
                            echo $noches->days;
                            ?>
                        </td>

                        <td class="text-center ocultar"><?php echo $row->plataforma; ?></td>
                        <td class="text-center"><?php echo $row->huespedes; ?></td>
                        <td class="" style='width: 70px; text-align:right; color:blue;'><?php echo number_format($row->importe, $decimals = 2, $dec_point = ',', $thousands_sep = "."); ?></td>

                        <?php
                        ?>

                        <td><?php echo $row->cliente; ?></td>
                        <td class="ocultar"><?php echo $row->pais; ?></td>

                    <input type='hidden' name='id_Ingreso' value='<?php echo $row->id_ingreso; ?>'/>

                    <td class="borrar">
                        <a href="#&idIngreso=<?php echo $row->id_ingreso; ?>&borrar='borrar' &rc='rc' " class="btn btn-danger borrar">Borrar</a>
                    </td>
                    <td class="ver">
                        <a href="#&idIngreso=<?php echo $row->id_ingreso; ?>&ver='ver'" class="btn btn-primary ver" name='ver'>Ver</a>
                    </td>

                    </tr>

                    <?php
                endforeach;
                $resultado = false;
                ?>
            </table>
            <!--Conocida la cantidad pendiente de cobro ($pendienteCobro) ya sabemos lo cobrado y el total-->
            <div class="row">
                <div class="col-4">
                    <?php if (is_float($pendienteCobro)) { ?>
                        <p style='font-weight:bold; color:blue;'>Pendiente de cobro: <?php echo number_format($pendienteCobro, $decimals = 2, $dec_point = ',', $thousands_sep = "."); ?></p>
                    <?php } ?>
                </div>
                <?php if (is_float($_SESSION['historicoApartamento'])) { ?>
                    <div class="col-4">                    
                        <p style='font-weight:bold; color:blue;'>Cobrado: <?php echo number_format($_SESSION['historicoApartamento'], $decimals = 2, $dec_point = ',', $thousands_sep = "."); ?></p>
                    </div>
                    <div class="col-4">
                        <p style='font-weight:bold; color:blue;'>Total (incluyendo el historico): <?php echo number_format(($_SESSION['historicoApartamento'] + $pendienteCobro), $decimals = 2, $dec_point = ',', $thousands_sep = "."); ?></p>
                    <?php } ?>
                </div>
            </div>
            <!----------------------------------------------------------------->
            <!--------------------------- PAGINACION -------------------------->
            <!----------------------------------------------------------------->
            <nav>
                <?php
                if (!isset($_GET['pagina'])) {
                    $_GET['pagina'] = 0;
                }
                ?>
                <ul class="pagination pagingresos">
                    <li class="anterior page-item <?php echo $_GET['pagina'] == 1 ? 'disabled' : '' ?>"> 
                        <a class="page-link" href="#&pagina=<?php echo $_GET['pagina'] - 1 ?>">ANTERIOR</a>
                    </li>

                    <?php for ($i = 0; $i < $paginas; $i++): ?>
                        <li class="actual page-item <?php echo $_GET['pagina'] == $i + 1 ? 'active' : '' ?>">
                            <a class="page-link" href="#&pagina=<?php echo $i + 1 ?>"> <?php echo $i + 1 ?> </a>
                        </li>
                    <?php endfor; ?>

                    <li class="siguiente page-item <?php echo $_GET['pagina'] == $paginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="#&pagina=<?php echo $_GET['pagina'] + 1 ?>">SIGUIENTE</a>
                    </li>                   
                </ul>
            </nav>
            <!----------------------------------------------------------------->
            <!--------------------------- FIN PAGINACION ---------------------->
            <!----------------------------------------------------------------->

            <button type="button" id="nuevoIngreso" class="btn btn-primary">AÑADIR NUEVO INGRES0</button>

            <button type="button"  class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addCuota">AÑADIR HUESPED</button>
            <!--Creando el modal-->
            <div class="modal fade" id="addCuota" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!--Cabecera-->
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Añadir un nuevo huesped</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!--Cuerpo-->
                        <div class="modal-body mt-3">                       
                            <div class="row">
                                <div class="col">
                                    <input type="text" name="nombreCliente" id="nombre" class="form-control" placeholder="Nombre" aria-label="Nombre" required>
                                </div>
                                <div class="col">
                                    <select id="paisSeleccionado" name="idPais" class="form-control">
                                        <option value="0">Selecciona un pais</option>
                                        <?php
                                        foreach ($paises as $pais) {
                                            echo '<option value="' . $pais->id_pais . '">' . $pais->nombre . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!--Pie-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" id="nuevoCliente" class="btn btn-primary" data-bs-dismiss="modal">Grabar huesped</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="js/MenuPrincipal.js"></script>
    <script type="text/javascript" src="js/Ingresos.js"></script>
    <script type="text/javascript" src="js/Clientes.js"></script>
</body>