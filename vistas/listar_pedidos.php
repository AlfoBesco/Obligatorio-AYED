<?php $pedidos = PedidoController::listarTodosPed(); ?>
<div class="table-section" style="margin-top:30px;">
    <h2>Lista de Pedidos</h2>
    <span class="badge badge-primary"><?= count($pedidos); ?> registros</span>
    <?php if (empty($pedidos)): ?>
        <p>No hay pedidos registrados.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td>#<?= $pedido->getId(); ?></td>
                        <td><?= htmlspecialchars($pedido->getFechaPedido()); ?></td>
                        <td><?= htmlspecialchars($pedido->getProveedor()); ?></td>
                        <td><?= htmlspecialchars($pedido->getEstado()); ?></td>
                        <td><?= number_format($pedido->getTotal(), 2, ',', '.'); ?></td>
                        <td>
                            <a href="pedidos.php?editar=<?= $pedido->getId(); ?>" class="btn btn-warning btn-sm">Agregar Detalle</a>
                            <a href="pedidos.php?editar=<?= $pedido->getId(); ?>" class="btn btn-warning btn-sm">Modificar</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id" value="<?= $pedido->getId(); ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>