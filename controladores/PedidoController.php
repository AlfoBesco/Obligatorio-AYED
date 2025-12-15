<?php

require_once __DIR__ . '/../clases/Pedido.php';
require_once __DIR__ . '/../clases/DetallePedido.php';
require_once __DIR__ . '/../clases/Producto.php';


class PedidoController
{

    public function __construct()
    {
        if (!isset($_SESSION)) session_start();
        $_SESSION['pedidos'] ??= [];
        $_SESSION['productos'] ??= [];
    }

    // ================== PEDIDOS ==================

    public function crearPed($productoId, $cantidad)
    {
        $producto = $this->buscarProductoPorId($productoId);

        if (!$producto) {
            return ['mensaje' => 'Producto no encontrado', 'tipo' => 'danger'];
        }

        $id = count($_SESSION['pedidos']) + 1;
        $pedido = new Pedido($id);
        $pedido->agregarDetalle(
            new DetallePedido(1, $pedido, $producto, $cantidad, $producto->getPrecio())
        );

        $_SESSION['pedidos'][] = $pedido;

        return ['mensaje' => 'Pedido creado correctamente', 'tipo' => 'success'];
    }

    public function listarPedidos()
    {
        return $_SESSION['pedidos'];
    }

    public function verPedido()
    {
        $pedido = $this->buscarPedidoPorId($_GET['id']);
        $_SESSION['pedidoActual'] = $pedido;
        header("Location: ../vistas/verPedido.php");
    }

    // ================== DETALLES ==================

    public function agregarDetalle()
    {
        $pedido = $this->buscarPedidoPorId($_POST['pedidoId']);
        $producto = $this->buscarProductoPorId($_POST['productoId']);

        if (!$pedido || !$producto) return;

        $detalle = new DetallePedido(
            count($pedido->getDetalles()) + 1,
            $pedido,
            $producto,
            $_POST['cantidad'],
            $producto->getPrecio()
        );

        $pedido->agregarDetalle($detalle);
        header("Location: ../vistas/verPedido.php?id=" . $pedido->getId());
    }

    public function eliminarDetalle()
    {
        $pedido = $this->buscarPedidoPorId($_GET['pedidoId']);
        $pedido->eliminarDetalle($_GET['detalleId']);
        header("Location: ../vistas/verPedido.php?id=" . $pedido->getId());
    }

    // ================== ESTADOS ==================

    public function cancelarPedido()
    {
        $pedido = $this->buscarPedidoPorId($_GET['id']);
        $pedido->cancelar();
        header("Location: ../pedidos.php");
    }

    public function entregarPedido()
    {
        $pedido = $this->buscarPedidoPorId($_GET['id']);
        $pedido->entregar();
        header("Location: ../pedidos.php");
    }

    // ================== AUXILIARES ==================

    private function buscarProductoPorId($id)
    {
        foreach ($_SESSION['productos'] as $p) {
            if ($p->getId() == $id) return $p;
        }
        return null;
    }

    private function buscarPedidoPorId($id)
    {
        foreach ($_SESSION['pedidos'] as $p) {
            if ($p->getId() == $id) return $p;
        }
        return null;
    }
}
