<?php if (isset($pedidoEditar)): ?>
    <div class="form-section" style="margin-top:20px;">
        <h2>Agregar Detalle al Pedido #<?= htmlspecialchars($pedidoEditar->getId()); ?></h2>

        <form method="POST" action="pedidos.php">
            <input type="hidden" name="accion" value="agregarDetalle">
            <input type="hidden" name="pedidoId" value="<?= $pedidoEditar->getId(); ?>">

            <div class="form-group">
                <label for="producto">Producto *</label>
                <select id="producto" name="productoId" required>
                    <option value="">Seleccione un Producto</option>
                    <?php foreach ($_SESSION['productos'] as $producto): ?>
                        <option value="<?= $producto->getId(); ?>"><?= htmlspecialchars($producto->getNombre()); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad *</label>
                <input type="number" id="cantidad" name="cantidad" min="1" required>
            </div>

            <button type="submit" class="btn btn-success">Agregar Detalle</button>
        </form>
    </div>
<?php endif; ?>