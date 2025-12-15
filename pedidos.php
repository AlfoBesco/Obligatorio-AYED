<?php
require_once 'includes/sesion.php';
require_once 'controladores/PedidoController.php';
require_once 'controladores/ProveedorController.php';

// Inicializar sesión para pedidos
if (!isset($_SESSION['pedidos'])) $_SESSION['pedidos'] = [];
if (!isset($_SESSION['ultimo_id_pedido'])) $_SESSION['ultimo_id_pedido'] = 0;

$mensaje = "";
$tipoMensaje = "";
$pedidoEditar = null;

// ================== ACCIONES POST ==================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'crear') {
        $resultado = PedidoController::crearPed(
            trim($_POST['fechaPedido']),
            trim($_POST['proveedor']),
            trim($_POST['estado'])
        );
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }

    if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
        $resultado = PedidoController::actualizarPed(
            intval($_POST['id']),
            trim($_POST['fechaPedido']),
            trim($_POST['proveedor']),
            trim($_POST['estado'])
        );
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }

    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        $resultado = PedidoController::eliminarPed(intval($_POST['id']));
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }

    if (isset($_POST['accion']) && $_POST['accion'] === 'agregarDetalle') {
        $controller = new PedidoController();
        $controller->agregarDetalle();
        exit;
    }
}

// ================== EDITAR PEDIDO ==================
if (isset($_GET['editar'])) {
    $pedidoEditar = PedidoController::buscarPedidoPorId(intval($_GET['editar']));
}

// ================== VISTA ==================
$titulo = "Gestión de Pedidos";
$paginaActual = "pedidos";
include 'includes/header.php';

// Mostrar mensajes
if (!empty($mensaje)): ?>
    <div class="alert alert-<?= $tipoMensaje; ?>">
        <?= htmlspecialchars($mensaje); ?>
    </div>
<?php endif; ?>

<div class="container<div class=" container">
    <?php include 'vistas/formulario_pedidos.php'; ?>
    <?php include 'vistas/formulario_pedidos_detalle.php'; ?>
    <?php include 'vistas/listar_pedidos.php'; ?>
</div>