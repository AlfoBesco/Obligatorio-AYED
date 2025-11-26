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
            trim($_POST['descripcion']),
            trim($_POST['categoriaPadre']),
            trim($_POST['subCategorias']),
            trim($_POST['nivel'])
        );
    
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
    
    // ACTUALIZAR CATEGORÍA
    if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
        $resultado = CategoriaController::actualizar(
            intval($_POST['id']),
            trim($_POST['nombre']),
            trim($_POST['descripcion']),
            trim($_POST['categoriaPadre']),
            trim($_POST['subCategorias']),
            trim($_POST['nivel'])
        );
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
    
    // ELIMINAR CATEGORÍA
    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        $resultado = CategoriaController::eliminar(intval($_POST['id']));
        
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = $resultado['tipo'];
    }
}

// ========== OBTENER CATEGORÍA PARA EDITAR ==========
$categoriaEditar = null;
if (isset($_GET['editar'])) {
    $categoriaEditar = CategoriaController::buscarPorId(intval($_GET['editar']));
}

// ========== INCLUIR VISTAS ==========
$titulo = "Gestión de Categorías";
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