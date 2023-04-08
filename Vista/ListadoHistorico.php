<!DOCTYPE html>
<style>
    body{
        font-size: 1em;
    }
</style>
<!--#################################################################################################
Esta archivo se encarga de listar todos los registros de la tabla historico
##################################################################################################-->
<?php
$pendienteCobro = 0;
$total = 0;
?>

<body>

    <br><br>

    <div class="container">
        <div class="text-center mx-auto">
            <span class="h2">LISTADO DE REGISTROS DEL HISTORICO</span>
        </div>
        <form action="#" method="post">
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
                $ingresosXpagina = 10;
                // $numeroIngresos ya viene dada de controlador y es el numero de registros de la tabla ingresos
                $paginas = ceil($numeroIngresos / $ingresosXpagina);
                ?>
                <?php
                foreach ($resultado as $row):
                    ?>
                    <tr class="registro">

                        <td class="entrada text-center">
                            <?php
                            echo $row->entrada;
                            ?>
                        </td>

                        <td class="text-center">
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
                        <td style='width: 70px; text-align:right; color:blue;'><?php echo number_format($row->importe, $decimals = 2, $dec_point = ',', $thousands_sep = "."); ?></td>

                        <?php
                        ?>

                        <td><?php echo $row->cliente; ?></td>
                        <td class="ocultar"><?php echo $row->pais; ?></td>


                        <?php
                    endforeach;
                    $resultado = false;
                    ?>
            </table>
            <div class="row">
                <div class="col-8">
                    <?php if ($_SESSION['historicoApartamento'] > 0) { ?>
                        <p>Total del HISTORICO: <?php echo number_format($_SESSION['historicoApartamento'], $decimals = 2, $dec_point = ',', $thousands_sep = "."); ?></p>
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
                <ul class="pagination">
                    <li class="anteriorHistorico page-item <?php echo $_GET['pagina'] == 1 ? 'disabled' : '' ?>"> 
                        <a class="page-link" href="#&pagina=<?php echo $_GET['pagina'] - 1 ?>">ANTERIOR</a>
                    </li>

                    <?php for ($i = 0; $i < $paginas; $i++): ?>
                        <li class="actualHistorico page-item <?php echo $_GET['pagina'] == $i + 1 ? 'active' : '' ?>">
                            <a class="page-link" href="#&pagina=<?php echo $i + 1 ?>"> <?php echo $i + 1 ?> </a>
                        </li>
                    <?php endfor; ?>

                    <li class="siguienteHistorico page-item <?php echo $_GET['pagina'] == $paginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="#&pagina=<?php echo $_GET['pagina'] + 1 ?>">SIGUIENTE</a>
                    </li>                   
                </ul>
            </nav>
            <!----------------------------------------------------------------->
            <!--------------------------- FIN PAGINACION ---------------------->
            <!----------------------------------------------------------------->
        </form>
    </div>
    <script type="text/javascript" src="js/MenuPrincipal.js"></script>
    <script type="text/javascript" src="js/Ingresos.js"></script>
</body>