<style>
    #cabecera {
    margin-top: 10px;
}

#sangut {
    font-size: 1.5em;
    color: #4ae40d;
    font-weight: bold;
    letter-spacing: 3px;
    font-family: "Lucida Console", "Courier New", monospace;
}

.nav-item {
    color: #577399;
    font-size: 1.3em;
}

#cerrarSesion, #cerrarSesionM{
    color: red;
}
.containerMedia{
    display: none;
}

@media screen and (max-width:1080px) {
    .container {
        display: none;
    }

    .containerMedia {       
        display: block;
        width: 80%, auto;
        margin: 0 40px;
    }
    .navegacion ul{

                display: flex;
                flex-wrap: nowrap;
                flex-direction: row;
                list-style: none;
                justify-content: space-around;

    }

    ul li a{
        font-size: 2rem;
        text-decoration: none;
    }
    .containerMedia h3 {
        font-size: 3rem;
    }
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

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid ">
                    <a href="#" id="sangut" class="navbar-brand">SANGUT</a>
                    <ul id="nav-mobile" class="navbar-nav nav justify-content-end">
                        <li class="nav-item"><a class="nav-link" id='listarIngresos' href="#">INGRESOS</a></li>
                        <li class="nav-item"><a class="nav-link" id='historico' href="#">HISTORICO</a></li>
                        <li class="nav-item"><a class="nav-link" id="gastos" href="#">GASTOS</a></li>
                        <li class="nav-item"><a class="nav-link" id="conceptos" href="#">CONCEPTOS</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">HOME</a></li>
                        <li class="nav-item"><a class="nav-link" id='cerrarSesion' href="#">DESCONECTAR</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <div id="info"></div>
    </div>

    <div class="containerMedia">
        <header>
            <div id="cabecera" class="text-center">
                <h3><span class="fst-italic text-warning">Apartamento SANGUT</span></h3>
            </div>
            <br>

            <nav>
                <div class="navegacion">
                    <ul>
                        <li class="nav-item"><a class="nav-link" id='listarIngresosM' href="#">INGRESOS</a></li>
                        <li class="nav-item"><a class="nav-link" id='historicoM' href="#">HISTORICO</a></li>
                        <li class="nav-item"><a class="nav-link" id='cerrarSesionM' href="#">DESCONECTAR</a></li>
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