<?php
// Este archivo muestra la tabla de stock
$stock = StockController::listarTodosStock();
?>

<div class="table-section">
    <div class="section-header">
        <h2>Lista de Stock</h2>
        <span class="badge badge-primary"><?php echo count($stock); ?> registros</span>
    </div>

    <?php if (empty($stock)): ?>
        <div class="empty-state">
            <div style="font-size: 4em;">📭</div>
            <h3>No hay stock registrados</h3>
            <p>Agrega tu primer stock con el formulario de arriba.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Ubicación</th>
                        <th>Fecha última actualización</th>
                        <th>Stock mínimo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($stock as $item): ?>
                        <tr>
                            <td><span class="badge badge-info">#<?= htmlspecialchars($item->getId()); ?></span></td>
                            <td><?= htmlspecialchars($item->getProducto()->getNombre()); ?></td>
                            <td><?= htmlspecialchars($item->getCantidad()); ?></td>
                            <td><?= htmlspecialchars($item->getUbicacion()); ?></td>
                            <td><?= date('d/m/Y', strtotime($item->getFechaUltimaActualizacion())); ?></td>
                            <td><?= htmlspecialchars($item->getStockMinimo()); ?></td>
                            <td>
                                <div class="actions">
                                    <a href="stock.php?editar=<?= htmlspecialchars($item->getId()); ?>" class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <form method="POST" style="display: inline;"
                                        onsubmit="return confirm('¿Estás seguro de eliminar el stock #<?= htmlspecialchars($item->getId()); ?>?');">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($item->getId()); ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>