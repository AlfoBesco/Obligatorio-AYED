<?php
require_once 'controladores/ProveedorController.php';
require_once 'controladores/ProductoController.php';

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

<div class="report-section" style="margin-top:30px;">
    <h2>Reporte de Productos por Proveedor</h2>

    <!-- Formulario para seleccionar proveedor -->
    <form method="POST" style="margin-bottom:20px;">
        <label for="proveedor">Selecciona un proveedor:</label>
        <select name="proveedor" id="proveedor" required>
            <option value="">-- Elige un proveedor --</option>
            <?php foreach ($proveedores as $prov): ?>
                <option value="<?= $prov->getId(); ?>" <?= ($proveedorSeleccionado && $proveedorSeleccionado->getId() == $prov->getId()) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($prov->getNombreEmpresa()); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <!-- Mostrar resultados -->
    <?php if ($proveedorSeleccionado): ?>
        <h3>Proveedor: <?= htmlspecialchars($proveedorSeleccionado->getNombreEmpresa()); ?></h3>
        <p><strong>Contacto:</strong> <?= htmlspecialchars($proveedorSeleccionado->getContacto()); ?> |
            <strong>Email:</strong> <?= htmlspecialchars($proveedorSeleccionado->getEmail()); ?>
        </p>

        <?php if (empty($productos)): ?>
            <div class="alert alert-warning">Este proveedor no tiene productos registrados.</div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Producto</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td>#<?= $producto->getId(); ?></td>
                            <td><?= htmlspecialchars($producto->getNombre()); ?></td>
                            <td><?= htmlspecialchars($producto->getDescripcion()); ?></td>
                            <td><?= number_format($producto->getPrecio(), 2, ',', '.'); ?> €</td>
                            <td><?= intval($producto->getStock()); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>