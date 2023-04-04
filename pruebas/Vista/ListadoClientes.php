<!--#################################################################################################
Esta archivo se encarga de listar todos los clientes de la tabla clientes
##################################################################################################-->

<body>
    <br><br>
    <div id="registrosClientes" style="width:800px;" class="mx-auto">
        <div id="cabecera">
            <span class="p-5">Listado de clientes</span>                
        </div>
        <div class="registrosClientes">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NOMBRE</th><th>PAIS</th>
                    </tr>
                </thead>

                <?php
                $articulosXpagina = 5;
                // $totalClientes ya viene dada de controlador
                $paginas = ceil($totalClientes / $articulosXpagina);
                ?>

                <?php foreach ($resultado as $row) : ?>
                    <tr>
                        <td> <?php echo $row->cliente; ?> </td>
                        <td> <?php echo $row->pais; ?> </td> 
                        <td class="borrar">
                            <a href="#&idCliente=<?php echo $row->id_cliente; ?>" class="btn btn-danger">BORRAR</a>
                        </td>
                        <td class="modificar">
                            <a href="#&idCliente=<?php echo $row->id_cliente; ?>&nombreCliente=<?php echo $row->cliente; ?>&paisCliente=<?php echo $row->pais; ?>&idPais=<?php echo $row->idPais; ?>" class="btn bg-warning">MODIFICAR</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <nav>
            <?php
            if (!isset($_GET['pagina'])) {
                $_GET['pagina'] = 0;
            }
            ?>
            <ul class="pagination">
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
        <button type="button" id="nuevoCliente" class="btn btn-primary">AÑADIR NUEVO CLIENTE</button>
    </div>
     <script type="text/javascript" src="js/Clientes.js"></script>   
</body>
</html>

