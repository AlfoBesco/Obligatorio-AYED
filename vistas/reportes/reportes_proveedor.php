<?php
require_once '../../includes/sesion.php';
require_once '../../includes/header.php';
require_once '../../controladores/ProveedorController.php';
require_once '../../controladores/ProductoController.php';


// Obtener lista de proveedores
$proveedores = ProveedorController::listarTodosProv();

// Inicializar variables
$productos = [];
$proveedorSeleccionado = null;

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['proveedor'])) {
    $idProveedor = intval($_POST['proveedor']);
    $proveedorSeleccionado = ProveedorController::buscarPorId($idProveedor);
    $productos = ProductoController::listarPorProveedor($idProveedor);
}
?>

<div class="form-section">
    <h2>Reporte de Productos por Proveedor</h2>

    <form method="POST" class="form-row">
        <div class="form-group">
            <label for="proveedor">Proveedor</label>
            <select name="proveedor" id="proveedor" required>
                <option value="">-- Seleccione proveedor --</option>
                <?php foreach ($proveedores as $prov): ?>
                    <option value="<?= $prov->getId(); ?>"
                        <?= ($proveedorSeleccionado && $proveedorSeleccionado->getId() == $prov->getId()) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($prov->getNombreEmpresa()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-top: 32px;">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </form>


    <?php if ($proveedorSeleccionado): ?>
        <h3>Proveedor: <?= htmlspecialchars($proveedorSeleccionado->getNombreEmpresa()); ?></h3>

        <?php if (empty($productos)): ?>
            <div class="alert alert-warning">
                Este proveedor no tiene productos registrados.
            </div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= $producto->getId(); ?></td>
                            <td><?= htmlspecialchars($producto->getNombre()); ?></td>
                            <td><?= number_format($producto->getPrecio(), 2, ',', '.'); ?></td>
                            <td><?= $producto->getStock(); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php require_once '../../includes/footer.php'; ?>
