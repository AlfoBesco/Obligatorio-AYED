<?php
// Este archivo muestra el formulario de crear/editar stock
$stockEditar = isset($stockEditar) ? $stockEditar : null;
?>

<div class="form-section">
    <h2><?= $stockEditar ? 'Editar Stock' : 'Agregar Nuevo Stock'; ?></h2>

    <form method="POST" action="stock.php">
        <input type="hidden" name="accion" value="<?= $stockEditar ? 'actualizar' : 'crear'; ?>">

        <?php if ($stockEditar): ?>
            <input type="hidden" name="id" value="<?= $stockEditar->getId(); ?>">
            <div class="form-group">
                <label for="cantidad">Cantidad *</label>
                <input type="number" id="cantidad" name="cantidad"
                    value="<?= htmlspecialchars($stockEditar->getCantidad()); ?>" required>
            </div>
        <?php else: ?>
            <div class="form-row">
                <div class="form-group">
                    <label for="producto">Producto *</label>
                    <select id="productoId" name="productoId" required>
                        <option value="">-- Seleccione un producto --</option>
                        <?php foreach ($_SESSION['productos'] as $cat): ?>
                            <option value="<?= $cat->getId(); ?>"
                                <?= ($stockEditar && $stockEditar->getProducto()->getId() == $cat->getId()) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat->getNombre()); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cantidad">Cantidad *</label>
                    <input type="number" id="cantidad" name="cantidad" required>
                </div>

                <div class="form-group">
                    <label for="ubicacion">Ubicación *</label>
                    <input type="text" id="ubicacion" name="ubicacion">
                </div>

                <div class="form-group">
                    <label for="stockMinimo">Stock mínimo *</label>
                    <input type="number" id="stockMinimo" name="stockMinimo">
                </div>
            </div>
        <?php endif; ?>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">
                <?= $stockEditar ? 'Actualizar Stock' : 'Crear Stock'; ?>
            </button>
            <?php if ($stockEditar): ?>
                <a href="stock.php" class="btn btn-secondary">Cancelar</a>
            <?php endif; ?>
        </div>
    </form>
</div>