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
                    value="<?php echo $pedidoEditar ? htmlspecialchars($pedidoEditar->getFechaPedido()) : ''; ?>"
                    required>
            </div>

            <!-- Proveedor Select -->
            <div class="form-group">
                <label for="proveedor">Proveedor *</label>
                <select id="proveedor" name="proveedor" required>
                    <option value="">Seleccione un Proveedor</option>
                    <?php
                    // Mostrar los proveedores cargados en la sesión
                    foreach ($_SESSION['proveedores'] as $proveedor) {
                        $selected = ($pedidoEditar && $pedidoEditar->getProveedor()->getId() == $proveedor->getId()) ? 'selected' : '';
                        echo "<option value='{$proveedor->getId()}' $selected>" . htmlspecialchars($proveedor->getNombre()) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="estado">Estado *</label>
                <input type="text"
                    id="estado"
                    name="estado"
                    value="<?php echo $pedidoEditar ? htmlspecialchars($pedidoEditar->getEstado()) : ''; ?>"
                    required>
            </div>
        </div>

        <h2><?php echo $pedidoEditar ? 'Editar Pedido' : 'Detalle del Pedido'; ?></h2>

        <div class="form-row">
            <div class="form-group">
                <label for="producto">Producto *</label>
                <select id="producto" name="producto" required>
                    <option value="">Seleccione un Producto</option>
                    <?php
                    // Mostrar los productos cargados en la sesión
                    foreach ($_SESSION['productos'] as $producto) {
                        $selected = ($pedidoEditar && $pedidoEditar->getProducto()->getId() == $producto->getId()) ? 'selected' : '';
                        echo "<option value='{$producto->getId()}' $selected>" . htmlspecialchars($producto->getNombre()) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number"
                    id="cantidad"
                    name="cantidad"
                    value="<?php echo $pedidoEditar ? htmlspecialchars($pedidoEditar->getCantidad()) : ''; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="precioUnitario">Precio unitario *</label>
                <input type="number"
                    id="precioUnitario"
                    name="precioUnitario"
                    value="<?php echo $pedidoEditar ? htmlspecialchars($pedidoEditar->getPrecioUnitario()) : ''; ?>"
                    required>
            </div>
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