<?php
// Este archivo muestra la tabla de stock
$stockList = StockController::listarTodosStock();
if (!is_array($stockList)) {
    $stockList = [];
}
?>

<div class="table-section">
    <div class="section-header">
        <h2>Lista de Stock</h2>
        <span class="badge badge-primary"><?= count($stockList); ?> registros</span>
    </div>

    <?php if (empty($stockList)): ?>
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
                        <th>Bajo stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stockList as $item): ?>
                        <tr>
                            <td><span class="badge badge-info">#<?= htmlspecialchars($item->getId()); ?></span></td>
                            <td><?= htmlspecialchars($item->getProducto()->getNombre()); ?></td>
                            <td><?= htmlspecialchars($item->getCantidad()); ?></td>
                            <td><?= htmlspecialchars($item->getUbicacion()); ?></td>
                            <td><?= date('d/m/Y', strtotime($item->getFechaUltimaActualizacion())); ?></td>
                            <td><?= htmlspecialchars($item->getStockMinimo()); ?></td>
                            <td>
                                <?= $item->verificarStockBajo() ? '<span class="badge badge-danger">¡Stock bajo!</span>' : '<span class="badge badge-success">OK</span>'; ?>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="stock.php?editar=<?= htmlspecialchars($item->getId()); ?>" class="btn btn-warning btn-sm">
                                        Editar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php
        $total = 0;
        foreach ($stockList as $item) {
            $total += $item->calcularValorTotal();
        }
        ?>
        <div class="alert alert-info" style="margin-top: 15px;">
            Valor total del inventario: $<?= number_format($total, 2); ?>
        </div>
    <?php endif; ?>