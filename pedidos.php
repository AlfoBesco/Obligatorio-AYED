<?php

// Incluir archivos necesarios
require_once 'includes/sesion.php';
require_once 'controladores/PedidoController.php';

// Variables para mensajes
$mensaje = "";
$tipoMensaje = "";

// ========== PROCESAR ACCIONES ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // CREAR PEDIDO
    if (isset($_POST['accion']) && $_POST['accion'] === 'crear') {
        $resultado = PedidoController::crearPedido(
            trim($_POST['fechaPedido']),
            trim($_POST['proveedor']),
            trim($_POST['estado']),
            trim($_POST['detalles']),
            trim($_POST['total'])
        );
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
    
    // ACTUALIZAR PEDIDO
    if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
        $resultado = PedidoController::actualizarPedido(
            intval($_POST['id']),
            trim($_POST['fechaPedido']),
            trim($_POST['proveedor']),
            trim($_POST['estado']),
            trim($_POST['detalles']),
            trim($_POST['total'])
        );
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
    
    // ELIMINAR PEDIDO
    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        $resultado = PedidoController::eliminarPedido(intval($_POST['id']));
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
}

// ========== OBTENER PEDIDO PARA EDITAR ==========
$pedidoEditar = null;
if (isset($_GET['editar'])) {
    $pedidoEditar = PedidoController::buscarPedidoPorId(intval($_GET['editar']));
}

// ========== INCLUIR VISTAS ==========
$titulo = "Gestión de Pedidos";
$paginaActual = "pedidos";
include 'includes/header.php';

// Mostrar mensajes
if (!empty($mensaje)): ?>
    <div class="alert alert-<?php echo $tipoMensaje; ?>">
        <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif;

// Mostrar formulario
include 'vistas/formulario_pedidos.php';

// Mostrar lista
include 'vistas/listar_pedidos.php';

// Footer
include 'includes/footer.php';
?>