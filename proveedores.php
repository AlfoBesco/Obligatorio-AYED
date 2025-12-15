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
        $resultado = ProveedorController::crearProv(
            trim($_POST['nombreEmpresa']),
            trim($_POST['contacto']),
            trim($_POST['telefono']),
            trim($_POST['email']),
            trim($_POST['direccion'])
        );
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
    
    // ACTUALIZAR PROVEEDOR
    if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
        $resultado = ProveedorController::actualizarProv(
            intval($_POST['id']),
            trim($_POST['nombreEmpresa']),
            trim($_POST['contacto']),
            trim($_POST['telefono']),
            trim($_POST['email']),
            trim($_POST['direccion'])
        );
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
    
    // ELIMINAR PROVEEDOR
    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        $resultado = ProveedorController::eliminarProv(intval($_POST['id']));
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
}

// ========== OBTENER PROVEEDOR PARA EDITAR ==========
$proveedorEditar = null;
if (isset($_GET['editar'])) {
    $proveedorEditar = ProveedorController::buscarProvPorId(intval($_GET['editar']));
}

// ========== INCLUIR VISTAS ==========
$titulo = "Gestión de Proveedores";
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