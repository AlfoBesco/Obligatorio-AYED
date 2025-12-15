<?php
// Este archivo muestra la tabla de productos
$productos = $controller->listarPedidos();

?>

<div class="table-section">
    <div class="section-header">
        <h2>Lista de Productos</h2>
        <span class="badge badge-primary"><?php echo count($productos); ?> registros</span>
    </div>

    <?php if (empty($productos)): ?>
        <div class="empty-state">
            <div style="font-size: 4em;">📭</div>
            <h3>No hay productos registrados</h3>
            <p>Comienza agregando tu primer producto usando el formulario de arriba.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Proveedor</th>
                        <th>Fecha de registro</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><span class="badge badge-info">#<?php echo $producto->getId(); ?></span></td>
                            <td><?php echo htmlspecialchars($producto->getNombre()); ?></td>
                            <td><?php echo htmlspecialchars($producto->getDescripcion()); ?></td>
                            <td><?php echo htmlspecialchars($producto->getPrecio()); ?></td>
                            <td><?php echo htmlspecialchars($producto->getCategoria()); ?></td>
                            <td><?php echo htmlspecialchars($producto->getProveedor()); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($producto->getFechaRegistro())); ?></td>
                            <td><?php echo htmlspecialchars($producto->getActivo()); ?></td>
                            <td>
                                <div class="actions">
                                    <a href="productos.php?editar=<?php echo $producto->getId(); ?>" class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <form method="POST" style="display: inline;"
                                        onsubmit="return confirm('¿Estás seguro de eliminar a <?php echo htmlspecialchars($producto->getId()); ?>?');">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id" value="<?php echo $producto->getId(); ?>">
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