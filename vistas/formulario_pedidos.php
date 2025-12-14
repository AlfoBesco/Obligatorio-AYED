<?php
// Este archivo muestra el formulario de crear/editar pedidos
$pedidoEditar = isset($pedidoEditar) ? $pedidoEditar : null;
?>

<div class="form-section">
    <h2><?php echo $pedidoEditar ? 'Editar Pedido' : 'Agregar Nuevo Pedido'; ?></h2>
    
    <form method="POST" action="index.php">
        <input type="hidden" name="accion" value="<?php echo $pedidoEditar ? 'actualizar' : 'crear'; ?>">
        <?php if ($pedidoEditar): ?>
            <input type="hidden" name="id" value="<?php echo $pedidoEditar->getId(); ?>">
        <?php endif; ?>
        
        <div class="form-row">
            <div class="form-group">
                <label for="fechaPedido">Fecha de pedido *</label>
                <input type="date" 
                       id="fechaPedido" 
                       name="fechaPedido" 
                       value="<?php echo $pedidoEditar ? htmlspecialchars($pedidoEditar->getNombre()) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="proveedor">Proveedor *</label>
                <input type="text" 
                       id="proveedor" 
                       name="proveedor" 
                       value="<?php echo $pedidoEditar ? htmlspecialchars($pedidoEditar->getDescripcion()) : ''; ?>" 
                       required>
            </div>
        
            <div class="form-group">
                <label for="pedidoPadre">Pedido Padre</label>
                <input type="text" 
                       id="pedidoPadre" 
                       name="pedidoPadre" 
                       value="<?php echo $pedidoEditar ? htmlspecialchars($pedidoEditar->getPedidoPadre()) : ''; ?>" 
                       >
            </div>
        
        <div class="form-group">
            <label for="subPedidos">Sub-Pedidos</label>
            <textarea id="subPedidos" 
                      name="subPedidos"><?php echo $pedidoEditar ? htmlspecialchars($pedidoEditar->getSubPedidos()) : ''; ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nivel">Nivel *</label>
                <input type="text" 
                       id="nivel" 
                       name="nivel" 
                       value="<?php echo $pedidoEditar ? htmlspecialchars($pedidoEditar->getNivel()) : ''; ?>" 
                       required>
            </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">
                <?php echo $pedidoEditar ? 'Actualizar Pedido' : 'Crear Pedido'; ?>
            </button>
            
            <?php if ($pedidoEditar): ?>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            <?php endif; ?>
        </div>
    </form>
</div>