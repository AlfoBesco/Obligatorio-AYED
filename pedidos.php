<?php
require_once 'includes/sesion.php';
require_once 'controladores/PedidoController.php';

$controller = new PedidoController();

$mensaje = "";
$tipoMensaje = "";

// ================== ACCIONES POST ==================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['accion'] === 'crear') {
        $resultado = $controller->crearPed(
            $_POST['productoId'],
            $_POST['cantidad']
        );
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }

    if ($_POST['accion'] === 'agregarDetalle') {
        $controller->agregarDetalle();
    }
}

// ================== ACCIONES GET ==================
if (isset($_GET['accion'])) {
    switch ($_GET['accion']) {
        case 'ver':
            $controller->verPedido();
            break;

        case 'cancelar':
            $controller->cancelarPedido();
            break;

        case 'entregar':
            $controller->entregarPedido();
            break;

        case 'eliminarDetalle':
            $controller->eliminarDetalle();
            break;
    }
}

// ================== VISTA ==================
$titulo = "Gestión de Pedidos";
$paginaActual = "pedidos";
include 'includes/header.php';

if ($mensaje) {
    echo "<div class='alert alert-$tipoMensaje'>$mensaje</div>";
}

include 'vistas/formulario_pedidos.php';
include 'vistas/listar_pedidos.php';
include 'includes/footer.php';
