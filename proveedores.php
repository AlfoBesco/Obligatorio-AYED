<?php

// Incluir archivos necesarios
require_once 'includes/sesion.php';
require_once 'controladores/ProveedorController.php';

// Variables para mensajes
$mensaje = "";
$tipoMensaje = "";

// ========== PROCESAR ACCIONES ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // CREAR PROVEEDOR
    if (isset($_POST['accion']) && $_POST['accion'] === 'crear') {
        $resultado = ProveedorController::crearProveedor(
            trim($_POST['fechaProveedor']),
            trim($_POST['proveedor']),
            trim($_POST['estado']),
            trim($_POST['detalles']),
            trim($_POST['total'])
        );
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
    
    // ACTUALIZAR PROVEEDOR
    if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
        $resultado = ProveedorController::actualizarProveedor(
            intval($_POST['id']),
            trim($_POST['fechaProveedor']),
            trim($_POST['proveedor']),
            trim($_POST['estado']),
            trim($_POST['detalles']),
            trim($_POST['total'])
        );
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
    
    // ELIMINAR PROVEEDOR
    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        $resultado = ProveedorController::eliminarProveedor(intval($_POST['id']));
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
}

// ========== OBTENER PROVEEDOR PARA EDITAR ==========
$proveedorEditar = null;
if (isset($_GET['editar'])) {
    $proveedorEditar = ProveedorController::buscarProveedorPorId(intval($_GET['editar']));
}

// ========== INCLUIR VISTAS ==========
$titulo = "Gestión de Proveedors";
$paginaActual = "proveedors";
include 'includes/header.php';

// Mostrar mensajes
if (!empty($mensaje)): ?>
    <div class="alert alert-<?php echo $tipoMensaje; ?>">
        <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif;

// Mostrar formulario
include 'vistas/formulario_proveedores.php';

// Mostrar lista
include 'vistas/listar_proveedores.php';

// Footer
include 'includes/footer.php';
?>