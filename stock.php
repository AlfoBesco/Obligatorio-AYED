<?php

// Incluir archivos necesarios
require_once 'includes/sesion.php';
require_once 'controladores/StockController.php';

// Variables para mensajes
$mensaje = "";
$tipoMensaje = "";

// ========== PROCESAR ACCIONES ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CREAR STOCK
    if (isset($_POST['accion']) && $_POST['accion'] === 'crear') {
        $resultado = StockController::crearStock(
            trim($_POST['productoId']),
            intval($_POST['cantidad']),
            trim($_POST['ubicacion']),
            intval($_POST['stockMinimo'])
        );

        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }

    // ACTUALIZAR STOCK
    if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
        $resultado = StockController::actualizarStock(
            intval($_POST['id']),
            trim($_POST['productoId']),
            intval($_POST['cantidad']),
            trim($_POST['ubicacion']),
            intval($_POST['stockMinimo'])
        );

        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }

    // ELIMINAR STOCK
    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        $resultado = StockController::eliminarStock(intval($_POST['id']));

        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
}

// ========== OBTENER STOCK PARA EDITAR ==========
$stockEditar = null;
if (isset($_GET['editar'])) {
    $stockEditar = StockController::buscarPorId(intval($_GET['editar']));
}

// ========== INCLUIR VISTAS ==========
$titulo = "Gestión de Stock";
$paginaActual = "stock";
include 'includes/header.php';

// Mostrar mensajes
if (!empty($mensaje)): ?>
    <div class="alert alert-<?php echo $tipoMensaje; ?>">
        <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif;

// Mostrar formulario
include 'vistas/formulario_stock.php';

// Mostrar lista
include 'vistas/listar_stock.php';

// Footer
include 'includes/footer.php';
?>