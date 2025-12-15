<?php
// Este archivo muestra el formulario de crear/editar proveedores
$proveedorEditar = isset($proveedorEditar) ? $proveedorEditar : null;
?>

<div class="form-section">
    <h2><?php echo $proveedorEditar ? 'Editar Proveedor' : 'Agregar Nuevo Proveedor'; ?></h2>

    <form method="POST" action="proveedores.php">
        <input type="hidden" name="accion" value="<?php echo $proveedorEditar ? 'actualizar' : 'crear'; ?>">
        <?php if ($proveedorEditar): ?>
            <input type="hidden" name="id" value="<?php echo $proveedorEditar->getId(); ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="nombreEmpresa">Nombre fantasía *</label>
                <input type="text"
                    id="nombreEmpresa"
                    name="nombreEmpresa"
                    value="<?php echo $proveedorEditar ? htmlspecialchars($proveedorEditar->getNombreEmpresa()) : ''; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="contacto">Contacto *</label>
                <input type="text"
                    id="contacto"
                    name="contacto"
                    value="<?php echo $proveedorEditar ? htmlspecialchars($proveedorEditar->getContacto()) : ''; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono *</label>
                <input type="number"
                    id="telefono"
                    name="telefono"
                    value="<?php echo $proveedorEditar ? htmlspecialchars($proveedorEditar->getTelefono()) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="email">E-Mail *</label>
                <input type="text"
                    id="email"
                    name="email"
                    value="<?php echo $proveedorEditar ? htmlspecialchars($proveedorEditar->getEmail()) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="direccion">Dirección *</label>
                <input type="text"
                    id="direccion"
                    name="direccion"
                    value="<?php echo $proveedorEditar ? htmlspecialchars($proveedorEditar->getDireccion()) : ''; ?>">
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">
                    <?php echo $proveedorEditar ? 'Actualizar Proveedor' : 'Crear Proveedor'; ?>
                </button>

                <?php if ($proveedorEditar): ?>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                <?php endif; ?>
            </div>
    </form>
</div>