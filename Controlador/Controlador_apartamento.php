
<script>
    function recargarClientes() {
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
    }
    function recargarIngresos() {
        $.ajax({
            url: '?c=paginacionIngresos',
            success: function (ingresos) {
                $("#info").html(ingresos);
            },
            error: function ()
            {
                $('#info').html("Error. Por favor intentelo de nuevo");
            }
        });
    }
    function recargarGastos() {
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
    }

</script>
<?php

if (!isset($_SESSION['usuario'])) {
    session_start();
}

include_once 'Modelo/Modelo_login.php';
include_once 'Modelo/Modelo_clientes.php';
include_once 'Modelo/Modelo_ingresos.php';
include_once 'Modelo/Modelo_paises.php';
include_once 'Modelo/Modelo_conceptos.php';
include_once 'Modelo/Modelo_gastos.php';
include_once 'Modelo/Modelo_plataformas.php';

class ApartamentoControlador {

    public $conexion;
    public $usuario;
    public $password;
    public $MODELO_LOGIN;
    public $MODELO_INGRESOS;
    public $MODELO_CLIENTES;
    public $MODELO_PAISES;
    public $MODELO_CONCEPTOS;
    public $MODELO_GASTOS;
    public $MODELO_PLATAFORMAS;
    public $totalIngresosHistorico;

    public function __construct() {
        $this->MODELO_CLIENTES = new Clientes();
        $this->MODELO_INGRESOS = new Ingresos();
        $this->MODELO_PAISES = new Paises();
        $this->MODELO_CONCEPTOS = new Conceptos();
        $this->MODELO_GASTOS = new Gastos();
        $this->MODELO_PLATAFORMAS = new Plataformas();
    }

    public function index() {
        if (isset($_SESSION['usuario'])) {
            include_once 'Vista/menuPrincipal.php';
        } else {
            include_once 'Vista/login.html';
        }
    }

    public function login() {
        if (!isset($_SESSION['usuario'])) {
            $this->MODELO_LOGIN = new Login();
            $datos = new Login();

            $this->usuario = ($_POST['nombre']);
            $this->password = ($_POST['password']);

            $datos->nombre = $this->usuario;
            $datos->password = $this->password;

            $resultado = $this->MODELO_LOGIN->compruebaLogin($datos);

            if ($resultado) {
                date_default_timezone_set('Europe/Paris');
                $_SESSION['usuario'] = $datos->nombre;
                $_SESSION['hora'] = date('h:i:s \d\e\l d-m-Y', time());
                if (isset($_COOKIE['visita'])) {
                    setcookie('visita', $_COOKIE['visita'] + 1);
                } else {
                    setcookie('visita', 1, time() + 3600 * 24 * 30 * 12 * 2);
                }
// ===========================================================                
// Elimino las reservas que han vencido y las paso a historico
// ===========================================================
                $this->MODELO_INGRESOS->ingresoToHistorico();
// ===========================================================

                $this->index();
            } else {
                $this->index();
            }
        }
    }

// ============================= INGRESOS ==================================

    /**
     * Funcion de listar los registros de ingresos de 5 en 5
     */
    public function paginacionIngresos() {
        if (isset($_POST['volver'])) {
            $_POST['volver'] = null;
            $this->index();
        } elseif (!isset($_GET['pagina'])) {
            $pagina = (int) 1;
        } else {
            $pagina = (int) $_GET['pagina'];
        }

        $ingresosXPagina = (int) 5;
        $pagina = (int) ($pagina - 1) * $ingresosXPagina;

        $paises = $this->MODELO_PAISES->getPaises();
        $porCobrar = $this->MODELO_INGRESOS->sumaPendienteCobro();
        $resultado = $this->MODELO_INGRESOS->getIngresos($pagina, $ingresosXPagina);    // Obtener 5 registros de la tabla ingresos
        $numeroIngresos = $this->MODELO_INGRESOS->numeroIngresos();                     // Numero de registro de la tabla ingresos
        $totalIngresos = $this->MODELO_INGRESOS->sumaTotalIngresos();                   // Total del campo importe de la tabla ingresos
// Esta variable de sesion la creo en listado ingresos para que el totalIngresosHistorico
// solo lo haga una vez y luego le asigna el totalIngresosHistorico a la variable de session
// y la utilizo en listagoIngresos   
        if (!isset($_SESSION['historicoApartamento'])) {
            $totalIngresosHistorico = $this->MODELO_INGRESOS->sumaTotalIngresosHistorico(); // Total del campo importe de la tabla historico
            $totalIngresosHistorico = implode($totalIngresosHistorico);                     // Implode convierte el array en string, si no, no funcionaria como numero
            $totalIngresosHistorico = (float) $totalIngresosHistorico;                      // Convierte el string en float
            $_SESSION['historicoApartamento'] = $totalIngresosHistorico;
        }
        require_once 'Vista/ListadoIngresos.php';
    }

    public function paginacionHistorico() {
        if (isset($_POST['volver'])) {
            $_POST['volver'] = null;
            $this->index();
        } elseif (!isset($_GET['pagina'])) {
            $pagina = (int) 1;
        } else {
            $pagina = (int) $_GET['pagina'];
        }

        $ingresosXPagina = (int) 10;
        $pagina = (int) ($pagina - 1) * $ingresosXPagina;

        $resultado = $this->MODELO_INGRESOS->getHistorico($pagina, $ingresosXPagina);    // Obtener 10 registros de la tabla ingresos
        $numeroIngresos = $this->MODELO_INGRESOS->numeroHistorico();                     // Numero de registro de la tabla ingresos
        if (!isset($_SESSION['historicoApartamento'])) {
            $totalIngresosHistorico = $this->MODELO_INGRESOS->sumaTotalIngresosHistorico(); // Total del campo importe de la tabla historico
            $totalIngresosHistorico = implode($totalIngresosHistorico);                     // Implode convierte el array en string, si no, no funcionaria como numero
            $totalIngresosHistorico = (float) $totalIngresosHistorico;                      // Convierte el string en float
            $_SESSION['historicoApartamento'] = $totalIngresosHistorico;
        }
        require_once 'Vista/ListadoHistorico.php';
    }

    public function borrar_ver_Ingreso() {
        if (isset($_GET['borrar']))
            $borrar = ($_GET['borrar']);
        elseif (isset($_GET['ver']))
            $ver = ($_GET['ver']);

        $id_Ingreso = ($_GET['idIngreso']);

        if (isset($borrar)) {
            $this->MODELO_INGRESOS->borrarIngreso($id_Ingreso);
            $this->paginacionIngresos();
        } elseif (isset($ver)) {
// En ver podemos ver y actualizar, por tanto debemos cargar la tabla de plataformas y paises por 
// si tenemos que modificar estos campos.
            $clientes = $this->MODELO_CLIENTES->todosLosClientes();
            $plataformas = $this->MODELO_PLATAFORMAS->todasLasPlataformas();
            $resultado = $this->MODELO_INGRESOS->verIngreso($id_Ingreso);
            include_once 'Vista/VerIngreso.php';
        } else {
            require_once 'Vista/LitadoIngresos.php';
        }
    }

    public function modificarIngreso() {

        $idIngreso = ($_REQUEST['idIngreso']);
        $idPlataforma = ($_REQUEST['id_plataforma']);
        $idCliente = ($_REQUEST['id_cliente']);
        $huespedes = ($_REQUEST['huespedes']);
        $fechaEntrada = ($_REQUEST['fechaEntrada']);
        $fechaSalida = ($_REQUEST['fechaSalida']);
        $importe = ($_REQUEST['importe']);
        $comentario = ltrim($_REQUEST['comentario']);

        $datosAsiento = new Ingresos();

        $datosAsiento->idIngreso = $idIngreso;
        $datosAsiento->idPlataforma = $idPlataforma;
        $datosAsiento->idCliente = $idCliente;
        $datosAsiento->huespedes = $huespedes;
        $datosAsiento->fechaEntrada = $fechaEntrada;
        $datosAsiento->fechaSalida = $fechaSalida;
        if ($idPlataforma == 1) {
            $comisionAPP = $importe * 15 / 100;
            $comisionBBV = $importe * 1.1 / 100;
            $importe = $importe - $comisionAPP - $comisionBBV;
        }
        $datosAsiento->importe = $importe;
        $datosAsiento->comentario = $comentario;

        $this->MODELO_INGRESOS->actualizarIngreso($datosAsiento);

        $this->index();
    }

    public function nuevoIngreso() {

        if (!isset($_POST['importe'])) {
            $clientes = $this->MODELO_CLIENTES->todosLosClientes();
            $plataformas = $this->MODELO_PLATAFORMAS->todasLasPlataformas();
            require_once 'Vista/NuevoIngreso.php';
        } else {
            $idCliente = ($_POST['id_cliente']);
            $plataforma = ($_POST['id_plataforma']);
            $huespedes = ($_POST['huespedes']);
            $fechaEntrada = ($_POST['fechaEntrada']);
            $fechaSalida = ($_POST['fechaSalida']);
            $importe = ($_POST['importe']);
            if ($plataforma == 1) {
                $comisionAPP = $importe * 15 / 100;
                $comisionBBV = $importe * 1.1 / 100;
                $importe = $importe - $comisionAPP - $comisionBBV;
            }
            $comentario = ($_POST['comentario']);

            $datos = new Ingresos();
            $datos->idCliente = $idCliente;
            $datos->idPlataforma = $plataforma;
            $datos->huespedes = $huespedes;
            $datos->fechaEntrada = $fechaEntrada;
            $datos->fechaSalida = $fechaSalida;
            $datos->importe = $importe;
            $datos->comentario = $comentario;

            $this->MODELO_INGRESOS->nuevoIngreso($datos);

//            $this->index();
            $this->paginacionIngresos();
        }
    }

// ============================= CLIENTES ==================================    

    public function clientes() {
        if (!isset($_GET['pagina'])) {
            $pagina = (int) 1;
        } else {
            $pagina = (int) $_GET['pagina'];
        }

        $clientesXPagina = (int) 5;
        $pagina = (int) ($pagina - 1) * $clientesXPagina;

        $resultado = $this->MODELO_CLIENTES->getClientes($pagina, $clientesXPagina);
        $totalClientes = $this->MODELO_CLIENTES->totalClientes();

        require_once 'Vista/ListadoClientes.php';
    }

    public function nuevoCliente() {

        $nombreCliente = ($_POST['nombreCliente']);
        $idPais = ($_POST['idPais']);
        echo $nombreCliente . " " . $idPais;
        $datos = new Clientes();
        $datos->nombreCliente = $nombreCliente;
        $datos->idPais = $idPais;
        $this->MODELO_CLIENTES->nuevoCliente($datos);
        $this->paginacionIngresos();
    }

    public function eliminarCliente() {
        $idCliente = ($_REQUEST['idCliente']);
        $this->MODELO_CLIENTES->eliminarCliente($idCliente);

        $this->clientes();
    }

    public function modificarCliente() {
        $idCliente = ($_REQUEST['idCliente']);
        $nombreCliente = ($_REQUEST['nombreCliente']);
        $paisCliente = ($_REQUEST['paisCliente']);
        $idPais = ($_REQUEST['idPais']);

        $datosCliente = new Clientes();

        $datosCliente->nombreCliente = $nombreCliente;
        $datosCliente->paisCliente = $paisCliente;
        $datosCliente->idCliente = $idCliente;
        $datosCliente->idPais = $idPais;

        $paises = $this->MODELO_PAISES->getPaises();

        include_once 'Vista/ModificarCliente.php';
    }

    public function grabarModificarCliente() {
        $idCliente = ($_GET['idCliente']);
        $nombreCliente = ($_GET['nombreCliente']);
        $idPais = ($_GET['paisSeleccionado']);
        $idPaisAntiguo = ($_GET['idPaisAntiguo']);

        if ($idPais == '0') {
            $idPais = $idPaisAntiguo;
        }

        $datosModificarCliente = new Clientes();

        $datosModificarCliente->nombreCliente = $nombreCliente;
        $datosModificarCliente->idCliente = (int) $idCliente;
        $datosModificarCliente->idPais = (int) $idPais;

        $this->MODELO_CLIENTES->modificarCliente($datosModificarCliente);

        $this->clientes();
    }

// ============================= CONCEPTOS =================================

    public function listaConceptos() {

        $resultado = $this->MODELO_CONCEPTOS->getConceptos();

        require_once 'Vista/ListadoConceptos.php';
    }

    public function datosNuevoConcepto() {

        require_once 'Vista/NuevoConcepto.php';
    }

    public function grabarNuevoConcepto() {
        $concepto = strtoupper(($_GET['concepto']));

        $datos = new Conceptos();

        $datos->nombre = $concepto;

        $resultado = $this->MODELO_CONCEPTOS->buscarConceptos($datos);

        if ($resultado == 0) {
            $this->MODELO_CONCEPTOS->nuevoConcepto($datos);
            $this->listaConceptos();
        } else {
            $_POST['repetido'] = "!!! ESE CONCEPTO YA ESTA GRABADO CON ANTERIORIDAD !!!";
            $this->datosNuevoConcepto();
        }
    }

    public function eliminarConcepto() {
        $idConcepto = ($_GET['idConcepto']);

        $datos = new Conceptos();

        $datos->idConcepto = $idConcepto;

        $this->MODELO_CONCEPTOS->eliminarConcepto($datos);

        $this->listaConceptos();
    }

// ============================= GASTOS ====================================

    public function listarGastos() {
        if (!isset($_GET['pagina'])) {
            $pagina = (int) 1;
        } else {
            $pagina = (int) $_GET['pagina'];
        }

        $gastosXPagina = (int) 5;
        $pagina = (int) ($pagina - 1) * $gastosXPagina;

        $resultado = $this->MODELO_GASTOS->getGastos($pagina, $gastosXPagina);
        $numeroGastos = $this->MODELO_GASTOS->numeroGastos();                     // Numero de registro de la tabla gastos
        $totalGastos = $this->MODELO_GASTOS->sumaTotalGastos();
        $conceptos = $this->MODELO_CONCEPTOS->getConceptos();

        require_once 'Vista/ListadoGastos.php';
    }

    public function listarGastoFiltrado() {
        $idGastoFiltrado = $_GET['filtrado'];
        if (!isset($_GET['pagina'])) {
            $pagina = (int) 1;
        } else {
            $pagina = (int) $_GET['pagina'];
        }

        $gastosXPagina = (int) 5;
        $pagina = (int) ($pagina - 1) * $gastosXPagina;

        $resultado = $this->MODELO_GASTOS->getGastosFiltrado($pagina, $gastosXPagina, $idGastoFiltrado);
        $numeroGastos = $this->MODELO_GASTOS->numeroGastosFiltrado($idGastoFiltrado);                     // Numero de registro filtrado de la tabla gastos     
        $totalGastos = $this->MODELO_GASTOS->sumaTotalGastosFiltrado($idGastoFiltrado);
        $conceptos = $this->MODELO_CONCEPTOS->getConceptos();

        require_once 'Vista/ListadoGastos.php';
    }

    public function borrar_ver_Gasto() {
        if (isset($_GET['borrar'])) {
            $borrar = ($_GET['borrar']);
        } elseif (isset($_GET['ver'])) {
            $ver = ($_GET['ver']);
        }

        $id_Gasto = ($_GET['idGasto']);

        if (isset($borrar)) {
            $resultado = $this->MODELO_GASTOS->borrarGasto($id_Gasto);
            echo '<script>', 'recargarGastos();', '</script>';
        } elseif (isset($ver)) {
            $resultado = $this->MODELO_GASTOS->verGasto($id_Gasto);
            include_once 'Vista/VerGasto.php';
        } else {
            require_once 'Vista/LitadoGastos.php';
        }
    }

    public function datosNuevoGasto() {
        require_once 'Vista/NuevoGasto.php';
    }

    public function nuevoGasto() {
        if (!isset($_POST['enviarNuevoGasto'])) {
            $conceptos = $this->MODELO_GASTOS->todosLosConceptos();
            require_once 'Vista/NuevoGasto.php';
        } else {
            $idConcepto = ($_POST['idConcepto']);
            $fecha = ($_POST['fechaGasto']);
            $importe = ($_POST['importe']);
            $comentario = ($_POST['comentario']);

            $datos = new Gastos();

            $datos->id_concepto = $idConcepto;
            $datos->fechaGasto = $fecha;
            $datos->importe = $importe;
            $datos->comentario = $comentario;

            $this->MODELO_GASTOS->nuevoGasto($datos);
            $this->listarGastos();
        }
    }

// ============================= DESCONECTAR ===================================
    public function desconectar() {
        session_unset();
        session_destroy();
        require_once 'Vista/login.html';
    }

}
