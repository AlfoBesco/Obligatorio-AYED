
<?php
require_once 'clases/Pedido.php';
require_once 'clases/DetallePedido.php';
require_once 'controladores/StockController.php';

class PedidoController
{
    public static function crearPed($fechaPedido, $proveedor, $estado)
    {
        if (empty($fechaPedido) || empty($proveedor) || empty($estado)) {
            return ['exito' => false, 'mensaje' => 'Todos los campos son obligatorios.', 'tipo' => 'danger'];
        }

        $_SESSION['ultimo_id_pedido']++;
        $nuevoId = $_SESSION['ultimo_id_pedido'];
        $nuevoPedido = new Pedido($nuevoId, $fechaPedido, $proveedor, $estado);
        $_SESSION['pedidos'][$nuevoId] = $nuevoPedido;

        return ['exito' => true, 'mensaje' => 'Pedido creado exitosamente.', 'tipo' => 'success', 'pedido' => $nuevoPedido];
    }

    public static function actualizarPed($id, $estado)
    {
        if (!isset($_SESSION['pedidos'][$id])) {
            return [
                'exito' => false,
                'mensaje' => 'Pedido no encontrado.',
                'tipo' => 'danger'
            ];
        }

        if (empty($estado)) {
            return [
                'exito' => false,
                'mensaje' => 'El campo estado es obligatorio.',
                'tipo' => 'danger'
            ];
        }

        $pedido = $_SESSION['pedidos'][$id];
        $pedido->setEstado($estado);
        return [
            'exito' => true,
            'mensaje' => 'Estado actualizado exitosamente: ' . $pedido->getEstado(),
            'tipo' => 'success',
            'pedido' => $pedido
        ];
    }

    public static function eliminarPed($id)
    {
        if (!isset($_SESSION['pedidos'][$id])) {
            return ['exito' => false, 'mensaje' => 'Pedido no encontrado.', 'tipo' => 'danger'];
        }
        unset($_SESSION['pedidos'][$id]);
        return ['exito' => true, 'mensaje' => 'Pedido eliminado.', 'tipo' => 'warning'];
    }

    public static function listarTodosPed()
    {
        return $_SESSION['pedidos'] ?? [];
    }


    public function agregarDetalle()
    {
        $pedido = $this->buscarPedidoPorId($_POST['pedidoId']);
        $producto = $this->buscarProductoPorId($_POST['productoId']);
        $cantidadSolicitada = intval($_POST['cantidad']);

        if (!$pedido || !$producto) return;

        // Crear el detalle del pedido
        $detalle = new DetallePedido(count($pedido->getDetalles()) + 1, $pedido, $producto, $cantidadSolicitada, $producto->getPrecio());
        $pedido->agregarDetalle($detalle);

        // Actualizar el stock del producto
        $resultadoStock = StockController::descontarStock($producto->getId(), $cantidadSolicitada);

        // Opcional: mostrar mensaje si el stock queda bajo el mínimo
        if ($resultadoStock['tipo'] === 'danger') {
            $_SESSION['mensaje_stock'] = $resultadoStock['mensaje'];
        }

        header("Location: pedidos.php?editar=" . $pedido->getId());
    }


    public function agregarDetalles()
    {
        $pedido = $this->buscarPedidoPorId($_POST['pedidoId']);
        if (!$pedido) return;

        $productos = $_POST['productoId'];
        $cantidades = $_POST['cantidad'];

        foreach ($productos as $index => $productoId) {
            $producto = $this->buscarProductoPorId($productoId);
            $cantidadSolicitada = intval($cantidades[$index]);

            if ($producto && $cantidadSolicitada > 0) {
                $detalle = new DetallePedido(count($pedido->getDetalles()) + 1, $pedido, $producto, $cantidadSolicitada, $producto->getPrecio());
                $pedido->agregarDetalle($detalle);

                // Actualizar stock
                StockController::descontarStock($producto->getId(), $cantidadSolicitada);
            }
        }

        header("Location: pedidos.php?editar=" . $pedido->getId());
    }


    private function buscarProductoPorId($id)
    {
        foreach ($_SESSION['productos'] as $p) {
            if ($p->getId() == $id) return $p;
        }
        return null;
    }

    public static function buscarPedidoPorId($id)
    {
        return $_SESSION['pedidos'][$id] ?? null;
    }
}
