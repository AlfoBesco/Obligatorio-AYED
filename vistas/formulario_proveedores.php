<?php
// Este archivo muestra el formulario de crear/editar proveedors
$proveedorEditar = isset($proveedorEditar) ? $proveedorEditar : null;
?>

<div class="form-section">
    <h2><?php echo $proveedorEditar ? 'Editar Proveedor' : 'Agregar Nuevo Proveedor'; ?></h2>
    
    <form method="POST" action="index.php">
        <input type="hidden" name="accion" value="<?php echo $proveedorEditar ? 'actualizar' : 'crear'; ?>">
        <?php if ($proveedorEditar): ?>
            <input type="hidden" name="id" value="<?php echo $proveedorEditar->getId(); ?>">
        <?php endif; ?>
        
        <div class="form-row">
            <div class="form-group">
                <label for="fechaProveedor">Fecha de proveedor *</label>
                <input type="date" 
                       id="fechaProveedor" 
                       name="fechaProveedor" 
                       value="<?php echo $proveedorEditar ? htmlspecialchars($proveedorEditar->getNombre()) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="proveedor">Proveedor *</label>
                <input type="text" 
                       id="proveedor" 
                       name="proveedor" 
                       value="<?php echo $proveedorEditar ? htmlspecialchars($proveedorEditar->getDescripcion()) : ''; ?>" 
                       required>
            </div>
        
            <div class="form-group">
                <label for="proveedorPadre">Proveedor Padre</label>
                <input type="text" 
                       id="proveedorPadre" 
                       name="proveedorPadre" 
                       value="<?php echo $proveedorEditar ? htmlspecialchars($proveedorEditar->getProveedorPadre()) : ''; ?>" 
                       >
            </div>
        
        <div class="form-group">
            <label for="subProveedors">Sub-Proveedors</label>
            <textarea id="subProveedors" 
                      name="subProveedors"><?php echo $proveedorEditar ? htmlspecialchars($proveedorEditar->getSubProveedors()) : ''; ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nivel">Nivel *</label>
                <input type="text" 
                       id="nivel" 
                       name="nivel" 
                       value="<?php echo $proveedorEditar ? htmlspecialchars($proveedorEditar->getNivel()) : ''; ?>" 
                       required>
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