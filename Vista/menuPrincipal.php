<style>
    #navPrincipal{
        text-decoration: none;
        list-style: none;
        display: grid;
        grid-template-columns:  repeat(6, 1fr);
        gap: 5px;
        align-content: space-around ;
        justify-items: center;
    }
    #navPrincipal li{
        background-color: #00cccc;
        border-radius: 5px;
        color: magenta;
    }
    .navPrincipal{
        margin: 0 auto;
    }
    #cabecera{
        margin-top: 10px;
        margin: 0 auto;
    }
    #sangut{
        font-size: 1.5em;
        color: #577399;
        font-weight: bold;
        letter-spacing: 3px;
        font-family: "Lucida Console", "Courier New", monospace;
    }
    .nav-item{
        color: #577399;
        font-size: 1.3em;
    }

    #cerrarSesion{
        color: #dd0000;
    }
</style>
<body>

    <div class="container">
        <header>
            <div id="cabecera" class="text-center">
                <h3><span class="fst-italic text-warning">Apartamento SANGUT (Hacienda Beach)</span></h3>
                <span><?php echo "Conectado como " . $_SESSION['usuario'] . ' desde las ' . $_SESSION['hora']; ?></span>
            </div>
            <br>

            <!--<nav class="navbar navbar-expand-lg navbar-light bg-light">-->
            <nav>
                <div class="navPrincipal">
                    <!--<ul id="nav-mobile" class="navbar-nav nav justify-content-end">-->       
                    <ul id="navPrincipal">  
                        <li class="nav-item"><a class="nav-link" id='listarIngresos'        href="#">INGRESOS</a></li>
                        <li class="nav-item"><a class="nav-link" id='historico'             href="#">HISTORICO</a></li>
                        <li class="nav-item"><a class="nav-link ocultar" id="gastos"                href="#">GASTOS</a></li>
                        <li class="nav-item"><a class="nav-link ocultar" id="conceptos"             href="#">CONCEPTOS</a></li>
                        <!--<li class="nav-item"><a class="nav-link" id='clientes'              href="#">CLIENTES</a></li>-->
                        <li class="nav-item"><a class="nav-link ocultar"                            href="#">HOME</a></li>  
                        <li class="nav-item"><a class="nav-link" id='cerrarSesion'          href="#">DESCONECTAR</a></li>
                    </ul>
                </div>  
            </nav>
        </header>
        <div id="info"></div>
    </div>
    <?php
    require_once 'Vista/pieJavaScript.php';
    ?>

</body>
</html>
