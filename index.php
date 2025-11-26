<?php

require_once 'includes/sesion.php';
require_once 'controladores/CategoriaController.php';

$mensaje = "";
$tipoMensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['accion']) && $_POST['accion'] === 'crear') {
        $resultado = ClienteController::crear(
            trim($_POST['nombre']),
            trim($_POST['apellido']),
            trim($_POST['email']),
            trim($_POST['telefono']),
            trim($_POST['direccion'])
        );
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
    
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
    
    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        $resultado = ClienteController::eliminar(intval($_POST['id']));
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
}

$clienteEditar = null;
if (isset($_GET['editar'])) {
    $clienteEditar = ClienteController::buscarPorId(intval($_GET['editar']));
}

$titulo = "CRUD Clientes";
include 'includes/header.php';

if (!empty($mensaje)): ?>
    <div class="alert alert-<?php echo $tipoMensaje; ?>">
        <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif;

include 'vistas/principal.php';

// include 'vistas/formulario.php';

// include 'vistas/listar.php';

include 'includes/footer.php';
?>