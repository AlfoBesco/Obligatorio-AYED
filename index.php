<?php

require_once 'includes/sesion.php';

require_once 'controladores/CategoriaController.php';

$mensaje = "";
$tipoMensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['accion']) && $_POST['accion'] === 'crear') {

        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $categoriaPadreId = $_POST['categoriaPadre'] ?? null;

        $resultado = CategoriaController::crearCat(
            $nombre,
            $descripcion,
            $categoriaPadreId
        );

        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }

    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {

        $resultado = CategoriaController::eliminarCat(
            intval($_POST['id'])
        );

        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
}

$categoriaEditar = null;
if (isset($_GET['editar'])) {
    $categoriaEditar = CategoriaController::buscarCatPorId(
        intval($_GET['editar'])
    );
}

$titulo = "CRUD Categorías";
include 'includes/header.php';

if (!empty($mensaje)): ?>
    <div class="alert alert-<?php echo $tipoMensaje; ?>">
        <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif;

include 'vistas/principal.php';
include 'includes/footer.php';
