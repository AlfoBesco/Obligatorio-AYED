<?php
// Este archivo muestra el formulario de crear/editar categorias
$categoriaEditar = isset($categoriaEditar) ? $categoriaEditar : null;
?>

<div class="form-section">
    <h2><?php echo $categoriaEditar ? 'Editar Categoria' : 'Agregar Nueva Categoria'; ?></h2>

    <form method="POST" action="categorias.php">
        <input type="hidden" name="accion" value="<?php echo $categoriaEditar ? 'actualizar' : 'crear'; ?>">
        <?php if ($categoriaEditar): ?>
            <input type="hidden" name="id" value="<?php echo $categoriaEditar->getId(); ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text"
                    id="nombre"
                    name="nombre"
                    value="<?php echo $categoriaEditar ? htmlspecialchars($categoriaEditar->getNombre()) : ''; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripcion *</label>
                <input type="text"
                    id="descripcion"
                    name="descripcion"
                    value="<?php echo $categoriaEditar ? htmlspecialchars($categoriaEditar->getDescripcion()) : ''; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="categoriaPadre">Categoría Padre</label>
                <select id="categoriaPadre" name="categoriaPadre">
                    <option value="">-- Ninguna (categoría raíz) --</option>
                    <?php foreach ($_SESSION['categorias'] as $cat): ?>
                        <?php if ($cat->getCategoriaPadre() === null): // solo categorías raíz 
                        ?>
                            <option value="<?= $cat->getId(); ?>"
                                <?= ($categoriaEditar && $categoriaEditar->getCategoriaPadre() && $categoriaEditar->getCategoriaPadre()->getId() == $cat->getId()) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat->getNombre()); ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="margin-top: 32px;">
                <button type="submit" class="btn btn-primary">
                    <?php echo $categoriaEditar ? 'Actualizar Categoria' : 'Crear Categoria'; ?>
                </button>

                <?php if ($categoriaEditar): ?>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                <?php endif; ?>
            </div>
    </form>
</div>