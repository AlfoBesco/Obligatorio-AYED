<?php
// Este archivo muestra la tabla de categorias
$categorias = CategoriaController::listarTodasCat();
?>

<div class="table-section">
    <div class="section-header">
        <h2>Lista de Categorías</h2>
        <span class="badge badge-primary"><?php echo count($categorias); ?> registros</span>
    </div>

    <?php if (empty($categorias)): ?>
        <div class="empty-state">
            <div style="font-size: 4em;">📭</div>
            <h3>No hay categorías registradas</h3>
            <p>Comienza agregando tu primer categoría usando el formulario de arriba.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría principal</th>
                        <th>Sub-Categorías</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td><span class="badge badge-info">#<?php echo $categoria->getId(); ?></span></td>
                            <td><strong><?php echo htmlspecialchars($categoria->getNombreCompleto()); ?></strong></td>
                            <td><?php echo htmlspecialchars($categoria->getEmail()); ?></td>
                            <td><?php echo htmlspecialchars($categoria->getTelefono()); ?></td>
                            <td><?php echo htmlspecialchars($categoria->getDireccion()); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($categoria->getFechaRegistro())); ?></td>
                            <td>
                                <div class="actions">
                                    <a href="categorias.php?editar=<?php echo $categoria->getId(); ?>" class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <form method="POST" style="display: inline;"
                                        onsubmit="return confirm('¿Estás seguro de eliminar a <?php echo htmlspecialchars($categoria->getNombreCompleto()); ?>?');">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id" value="<?php echo $categoria->getId(); ?>">
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