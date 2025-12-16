<?php

// Incluir archivos necesarios
require_once 'includes/sesion.php';
require_once 'controladores/CategoriaController.php';

// Manejar cierre de sesión
if (isset($_POST['cerrarSesion'])) {
    session_destroy();
    header("Location: index.php"); // o la página de inicio
    exit;
}

// Variables para mensajes
$mensaje = "";
$tipoMensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CREAR CATEGORIA
    if (isset($_POST['accion']) && $_POST['accion'] === 'crear') {
        $resultado = CategoriaController::crearCat(
            trim($_POST['nombre']),
            trim($_POST['descripcion']),
            !empty($_POST['categoriaPadre']) ? intval($_POST['categoriaPadre']) : null
        );

        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }

    // ACTUALIZAR CATEGORIA
    if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
        $resultado = CategoriaController::actualizarCat(
            intval($_POST['id']),
            trim($_POST['nombre']),
            trim($_POST['descripcion']),
            trim($_POST['categoriaPadre'])
        );

        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }

    // ELIMINAR CATEGORIA
    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        $resultado = CategoriaController::eliminarCat(intval($_POST['id']));

        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
}

$categoriaEditar = null;
if (isset($_GET['editar'])) {
    $categoriaEditar = CategoriaController::buscarCatPorId(intval($_GET['editar']));
}

$titulo = "Gestión de Categorias";
$paginaActual = "categorias";
include 'includes/header.php';

// Mostrar mensajes
if (!empty($mensaje)): ?>
    <div class="alert alert-<?php echo $tipoMensaje; ?>">
        <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif;

// Mostrar formulario
include 'vistas/formulario_categorias.php';

// Mostrar lista
include 'vistas/listar_categorias.php';

// Footer
include 'includes/footer.php';
?>