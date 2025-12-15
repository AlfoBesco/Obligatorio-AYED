
<?php
require_once 'clases/Pedido.php';
require_once 'clases/DetallePedido.php';

class PedidoController {
    public static function crearPed($fechaPedido, $proveedor, $estado) {
        if (empty($fechaPedido) || empty($proveedor) || empty($estado)) {
            return ['exito' => false, 'mensaje' => 'Todos los campos son obligatorios.', 'tipo' => 'danger'];
        }

        $_SESSION['ultimo_id_pedido']++;
        $nuevoId = $_SESSION['ultimo_id_pedido'];
        $nuevoPedido = new Pedido($nuevoId, $fechaPedido, $proveedor, $estado);
        $_SESSION['pedidos'][$nuevoId] = $nuevoPedido;

        return ['exito' => true, 'mensaje' => 'Pedido creado exitosamente.', 'tipo' => 'success', 'pedido' => $nuevoPedido];
    }

    public static function actualizarPed($id, $fechaPedido, $proveedor, $estado) {
        if (!isset($_SESSION['pedidos'][$id])) {
            return ['exito' => false, 'mensaje' => 'Pedido no encontrado.', 'tipo' => 'danger'];
        }

        $pedido = $_SESSION['pedidos'][$id];
        $pedido->setFechaPedido($fechaPedido);
        $pedido->setProveedor($proveedor);
        $pedido->setEstado($estado);

        return ['exito' => true, 'mensaje' => 'Pedido actualizado.', 'tipo' => 'success'];
    }

    public static function eliminarPed($id) {
        if (!isset($_SESSION['pedidos'][$id])) {
            return ['exito' => false, 'mensaje' => 'Pedido no encontrado.', 'tipo' => 'danger'];
        }
        unset($_SESSION['pedidos'][$id]);
        return ['exito' => true, 'mensaje' => 'Pedido eliminado.', 'tipo' => 'warning'];
    }

    public static function listarTodosPed() {
        return $_SESSION['pedidos'] ?? [];
    }

    public function agregarDetalle() {
        $pedido = $this->buscarPedidoPorId($_POST['pedidoId']);
        $producto = $this->buscarProductoPorId($_POST['productoId']);
        if (!$pedido || !$producto) return;

        $detalle = new DetallePedido(count($pedido->getDetalles()) + 1, $pedido, $producto, intval($_POST['cantidad']), $producto->getPrecio());
        $pedido->agregarDetalle($detalle);
        header("Location: pedidos.php?editar=" . $pedido->getId());
    }

    private function buscarProductoPorId($id) {
        foreach ($_SESSION['productos'] as $p) {
            if ($p->getId() == $id) return $p;
        }
        return null;
    }

    public static function buscarPedidoPorId($id) {
        return $_SESSION['pedidos'][$id] ?? null;
    }
}