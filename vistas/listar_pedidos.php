<?php
// Este archivo muestra la tabla de pedidos
$pedidos = PedidoController::listarTodos();
?>

<div class="table-section">
    <div class="section-header">
        <h2>Lista de Pedidos</h2>
        <span class="badge badge-primary"><?php echo count($pedidos); ?> registros</span>
    </div>
    
    <?php if (empty($pedidos)): ?>
        <div class="empty-state">
            <div style="font-size: 4em;">📭</div>
            <h3>No hay pedidos registrados</h3>
            <p>Comienza agregando tu primer pedido usando el formulario de arriba.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha de pedido</th>
                        <th>Proveedor</th>
                        <th>Estado principal</th>
                        <th>Detalles</th>
                        <th>Total</th>
                        <th>Acciones</th>
                        private $id;
    private $fechaPedido;
    private $proveedor;
    private $estado;
    private $detalles;
    private $total;
    
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><span class="badge badge-info">#<?php echo $pedido->getId(); ?></span></td>
                            <td><strong><?php echo htmlspecialchars($pedido->getFechaPedido()); ?></strong></td>
                            <td><?php echo htmlspecialchars($pedido->getProveedor()); ?></td>
                            <td><?php echo htmlspecialchars($pedido->getEstado()); ?></td>
                            <td><?php echo htmlspecialchars($pedido->getDetalles()); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($pedido->getTotal())); ?></td>
                            <td>
                                <div class="actions">
                                    <a href="pedidos.php?editar=<?php echo $pedido->getId(); ?>" class="btn btn-warning btn-sm">
                                        Editar
                                    </a>
                                    
                                    <form method="POST" style="display: inline;" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar a <?php echo htmlspecialchars($pedido->getId()); ?>?');">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id" value="<?php echo $pedido->getId(); ?>">
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