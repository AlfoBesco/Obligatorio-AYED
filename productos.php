<?php

// Incluir archivos necesarios
require_once 'includes/sesion.php';
require_once 'controladores/ProductoController.php';

// Manejar cierre de sesión
if (isset($_POST['cerrarSesion'])) {
    session_destroy();
    header("Location: index.php"); // o la página de inicio
    exit;
}

// Variables para mensajes
$mensaje = "";
$tipoMensaje = "";

// ========== PROCESAR ACCIONES ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // CREAR PRODUCTO
    if (isset($_POST['accion']) && $_POST['accion'] === 'crear') {
        $resultado = ProductoController::crearProd(
            trim($_POST['nombre']),
            trim($_POST['descripcion']),
            trim($_POST['precio']),
            trim($_POST['categoria']),
            trim($_POST['proveedor']),
            trim($_POST['fechaRegistro']),
            trim($_POST['activo'])
        );
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
    
    // ACTUALIZAR PRODUCTO
    if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
        $resultado = ProductoController::actualizarProd(
            intval($_POST['id']),
            trim($_POST['nombre']),
            trim($_POST['descripcion']),
            trim($_POST['precio']),
            trim($_POST['categoria']),
            trim($_POST['proveedor']),
            trim($_POST['fechaRegistro']),
            trim($_POST['activo'])
        );
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
    
    // ELIMINAR PRODUCTO
    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        $resultado = ProductoController::eliminarProd(intval($_POST['id']));
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
}

// ========== OBTENER PRODUCTO PARA EDITAR ==========
$productoEditar = null;
if (isset($_GET['editar'])) {
    $productoEditar = ProductoController::buscarProdPorId(intval($_GET['editar']));
}

// ========== INCLUIR VISTAS ==========
$titulo = "Gestión de Productos";
$paginaActual = "productos";
include 'includes/header.php';

// Mostrar mensajes
if (!empty($mensaje)): ?>
    <div class="alert alert-<?php echo $tipoMensaje; ?>">
        <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif;

// Mostrar formulario
include 'vistas/formulario_productos.php';

// Mostrar lista
include 'vistas/listar_productos.php';

// Footer
include 'includes/footer.php';
?>