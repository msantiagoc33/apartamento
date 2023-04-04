
<?php
if (!isset($_SESSION['usuario'])) {
    include_once 'Vista/cabecera.html';
    include_once 'Controlador/Controlador_apartamento.php';
    include_once 'Conexion/ConexionPDO.php';
}

$Controller = new ApartamentoControlador();
if (!isset($_REQUEST['c'])) {
    $Controller->index();   
} else {
    $action = $_REQUEST['c'];
    call_user_func(array($Controller, $action));
}

