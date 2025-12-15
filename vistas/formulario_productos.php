<?php
// Este archivo muestra el formulario de crear/editar productos
$productoEditar = isset($productoEditar) ? $productoEditar : null;
?>

<div class="form-section">
    <h2><?php echo $productoEditar ? 'Editar Producto' : 'Agregar Nuevo Producto'; ?></h2>

    <form method="POST" action="productos.php">
        <input type="hidden" name="accion" value="<?php echo $productoEditar ? 'actualizar' : 'crear'; ?>">
        <?php if ($productoEditar): ?>
            <input type="hidden" name="id" value="<?php echo $productoEditar->getId(); ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text"
                    id="nombre"
                    name="nombre"
                    value="<?php echo $productoEditar ? htmlspecialchars($productoEditar->getNombre()) : ''; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción *</label>
                <input type="text"
                    id="descripcion"
                    name="descripcion"
                    value="<?php echo $productoEditar ? htmlspecialchars($productoEditar->getDescripcion()) : ''; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="precio">Precio *</label>
                <input type="number"
                    id="precio"
                    name="precio"
                    value="<?php echo $productoEditar ? htmlspecialchars($productoEditar->getPrecio()) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="categoria">Categoría *</label>
                <select id="categoria" name="categoria" required>
                    <option value="">-- Seleccione una categoría --</option>

                    <?php foreach ($_SESSION['categorias'] as $cat): ?>
                        <option value="<?= $cat->getId(); ?>"
                            <?= ($productoEditar && $productoEditar->getCategoria()->getId() == $cat->getId()) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat->getNombre()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="proveedor">Proveedor *</label>
                <select id="proveedor" name="proveedor" required>
                    <option value="">-- Seleccione un proveedor --</option>

                    <?php foreach ($_SESSION['proveedores'] as $prov): ?>
                        <option value="<?= $prov->getId(); ?>"
                            <?= ($productoEditar && $productoEditar->getProveedor()->getId() == $prov->getId()) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($prov->getNombre()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="fechaRegistro">Fecha de registro *</label>
                <input type="date"
                    id="fechaRegistro"
                    name="fechaRegistro"
                    value="<?php echo $productoEditar ? htmlspecialchars($productoEditar->getFechaRegistro()) : ''; ?>">
            </div> <!-- Cerrar correctamente -->

            <div class="form-group">
                <label for="activo">Activo *</label>
                <select id="activo" name="activo" required>
                    <option value="1" <?php echo ($productoEditar && $productoEditar->isActivo()) ? 'selected' : ''; ?>>Sí</option>
                    <option value="0" <?php echo ($productoEditar && !$productoEditar->isActivo()) ? 'selected' : ''; ?>>No</option>
                </select>
            </div> <!-- Cerrar correctamente -->

            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">
                    <?php echo $productoEditar ? 'Actualizar Producto' : 'Crear Producto'; ?>
                </button>

                <?php if ($productoEditar): ?>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>