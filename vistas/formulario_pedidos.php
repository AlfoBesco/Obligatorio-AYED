<?php
// Este archivo muestra el formulario de crear/editar pedidos
$pedidoEditar = isset($pedidoEditar) ? $pedidoEditar : null;
?>


<div class="form-section">
    <h2><?= $pedidoEditar ? 'Editar Pedido' : 'Crear Pedido'; ?></h2>
    <form method="POST" action="pedidos.php">
        <input type="hidden" name="accion" value="<?= $pedidoEditar ? 'actualizar' : 'crear'; ?>">
        <?php if ($pedidoEditar): ?>
            <input type="hidden" name="id" value="<?= $pedidoEditar->getId(); ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="fechaPedido">Fecha *</label>
                <input type="date" id="fechaPedido" name="fechaPedido"
                       value="<?= $pedidoEditar ? htmlspecialchars($pedidoEditar->getFechaPedido()) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="proveedor">Proveedor *</label>
                <select id="proveedor" name="proveedor" required>
                    <option value="">Seleccione un proveedor</option>
                    <?php foreach ($_SESSION['proveedores'] as $prov): ?>
                        <option value="<?= $prov->getId(); ?>"
                            <?= ($pedidoEditar && $pedidoEditar->getProveedor() == $prov->getId()) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($prov->getNombreEmpresa()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="estado">Estado *</label>
                <input type="text" id="estado" name="estado"
                       value="<?= $pedidoEditar ? htmlspecialchars($pedidoEditar->getEstado()) : ''; ?>" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><?= $pedidoEditar ? 'Actualizar' : 'Crear'; ?></button>
    </form>
</
