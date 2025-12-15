<?php
// Este archivo muestra el formulario de crear/editar stock
$stockEditar = isset($stockEditar) ? $stockEditar : null;
?>

<div class="form-section">
    <h2><?php echo $stockEditar ? 'Editar Stock' : 'Agregar Nuevo Stock'; ?></h2>

    <form method="POST" action="stock.php">
        <input type="hidden" name="accion" value="<?php echo $stockEditar ? 'actualizar' : 'crear'; ?>">
        <?php if ($stockEditar): ?>
            <input type="hidden" name="id" value="<?php echo $stockEditar->getId(); ?>">
        <?php endif; ?>

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
                <input type="number"
                    id="cantidad"
                    name="cantidad"
                    value="<?php echo $stockEditar ? htmlspecialchars($stockEditar->getCantidad()) : ''; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="ubicacion">Ubicación *</label>
                <input type="text"
                    id="ubicacion"
                    name="ubicacion"
                    value="<?php echo $stockEditar ? htmlspecialchars($stockEditar->getUbicacion()) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="fechaUltimaActualizacion">Fecha última actualización *</label>
                <input type="date"
                    id="fechaUltimaActualizacion"
                    name="fechaUltimaActualizacion"
                    value="<?php echo $stockEditar ? htmlspecialchars($stockEditar->getFechaUltimaActualizacion()) : ''; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="stockMinimo">Stock mínimo *</label>
                <input type="number"
                    id="stockMinimo"
                    name="stockMinimo"
                    value="<?php echo $stockEditar ? htmlspecialchars($stockEditar->getStockMinimo()) : ''; ?>">
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">
                    <?php echo $stockEditar ? 'Actualizar Stock' : 'Crear Stock'; ?>
                </button>

                <?php if ($stockEditar): ?>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                <?php endif; ?>
            </div>
    </form>
</div>