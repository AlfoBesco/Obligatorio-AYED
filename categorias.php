<?php

// Incluir archivos necesarios
require_once 'includes/sesion.php';
require_once 'controladores/CategoriaController.php';

// Variables para mensajes
$mensaje = "";
$tipoMensaje = "";

// ========== PROCESAR ACCIONES ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // CREAR CATEGORÍA
    if (isset($_POST['accion']) && $_POST['accion'] === 'crear') {
        $resultado = CategoriaController::crear(
            trim($_POST['nombre']),
            trim($_POST['apellido']),
            trim($_POST['email']),
            trim($_POST['telefono']),
            trim($_POST['direccion'])
        );
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
    
    // ACTUALIZAR CLIENTE
    if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
        $resultado = ClienteController::actualizar(
            intval($_POST['id']),
            trim($_POST['nombre']),
            trim($_POST['apellido']),
            trim($_POST['email']),
            trim($_POST['telefono']),
            trim($_POST['direccion'])
        );
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
    
    // ELIMINAR CLIENTE
    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        $resultado = ClienteController::eliminar(intval($_POST['id']));
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
}

// ========== OBTENER CLIENTE PARA EDITAR ==========
$clienteEditar = null;
if (isset($_GET['editar'])) {
    $clienteEditar = ClienteController::buscarPorId(intval($_GET['editar']));
}

// ========== INCLUIR VISTAS ==========
$titulo = "Gestión de Clientes";
$paginaActual = "clientes";
include 'includes/header.php';

// Mostrar mensajes
if (!empty($mensaje)): ?>
    <div class="alert alert-<?php echo $tipoMensaje; ?>">
        <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif;

// Mostrar formulario
include 'vistas/clientes_formulario.php';

// Mostrar lista
include 'vistas/clientes_listar.php';

// Footer
include 'includes/footer.php';
?>