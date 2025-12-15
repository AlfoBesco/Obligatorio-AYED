<?php
// Este archivo muestra la tabla de proveedores
$proveedores = ProveedorController::listarTodosProv();
?>

<div class="table-section">
    <div class="section-header">
        <h2>Lista de Proveedores</h2>
        <span class="badge badge-primary"><?php echo count($proveedores); ?> registros</span>
    </div>
    
    <?php if (empty($proveedores)): ?>
        <div class="empty-state">
            <div style="font-size: 4em;">📭</div>
            <h3>No hay proveedores registrados</h3>
            <p>Comienza agregando tu primer proveedor usando el formulario de arriba.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre fantasía</th>
                        <th>Contacto</th>
                        <th>Teléfono</th>
                        <th>E-Mail</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proveedores as $proveedor): ?>
                        <tr>
                            <td><span class="badge badge-info">#<?php echo $proveedor->getId(); ?></span></td>
                            <td><?php echo htmlspecialchars($proveedor->getNombreEmpresa()); ?></td>
                            <td><?php echo htmlspecialchars($proveedor->getContacto()); ?></td>
                            <td><?php echo htmlspecialchars($proveedor->getTelefono()); ?></td>
                            <td><?php echo htmlspecialchars($proveedor->getEmail()); ?></td>
                            <td><?php echo htmlspecialchars($proveedor->getDireccion()); ?></td>
                            <td>
                                <div class="actions">
                                    <a href="proveedores.php?editar=<?php echo $proveedor->getId(); ?>" class="btn btn-warning btn-sm">
                                        Editar
                                    </a>
                                    
                                    <form method="POST" style="display: inline;" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar a <?php echo htmlspecialchars($proveedor->getId()); ?>?');">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id" value="<?php echo $proveedor->getId(); ?>">
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