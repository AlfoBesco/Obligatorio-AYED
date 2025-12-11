<?php
// Este archivo muestra el formulario de crear/editar categorias
$categoriaEditar = isset($categoriaEditar) ? $categoriaEditar : null;
?>

<div class="form-section">
    <h2><?php echo $categoriaEditar ? 'Editar Categoria' : 'Agregar Nueva Categoria'; ?></h2>
    
    <form method="POST" action="index.php">
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
                       value="<?php echo $clienteEditar ? htmlspecialchars($clienteEditar->getNombre()) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="apellido">Apellido *</label>
                <input type="text" 
                       id="apellido" 
                       name="apellido" 
                       value="<?php echo $clienteEditar ? htmlspecialchars($clienteEditar->getApellido()) : ''; ?>" 
                       required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="<?php echo $clienteEditar ? htmlspecialchars($clienteEditar->getEmail()) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="tel" 
                       id="telefono" 
                       name="telefono" 
                       value="<?php echo $clienteEditar ? htmlspecialchars($clienteEditar->getTelefono()) : ''; ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <textarea id="direccion" 
                      name="direccion"><?php echo $clienteEditar ? htmlspecialchars($clienteEditar->getDireccion()) : ''; ?></textarea>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">
                <?php echo $clienteEditar ? 'Actualizar Cliente' : 'Crear Cliente'; ?>
            </button>
            
            <?php if ($clienteEditar): ?>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            <?php endif; ?>
        </div>
    </form>
</div>