<?php
require_once "../clases/Pedido.php";
require_once "../clases/DetallePedido.php";
require_once "../clases/Producto.php";

class PedidoController {

    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['pedidos'])) {
            $_SESSION['pedidos'] = [];
        }

        if (!isset($_SESSION['productos'])) {
            $_SESSION['productos'] = [];
        }
    }

    /* ============================================================
                        MÉTODOS PRINCIPALES
       ============================================================ */

    // Registrar un nuevo pedido
    public function registrarPedido() {
        $productoId = $_POST['productoId'];
        $cantidad   = $_POST['cantidad'];

        $producto = $this->buscarProductoPorId($productoId);

        if (!$producto) {
            header("Location: ../vistas/pedidos.php?error=producto_no_encontrado");
            exit;
        }

        $id = $this->generarId();

        $pedido = new Pedido($id, $producto, $cantidad);
        $pedido->registrarPedido(); // estado "pendiente" + fecha

        $_SESSION['pedidos'][] = $pedido;

        header("Location: ../vistas/pedidos.php?ok=pedido_registrado");
    }


    // Listar todos los pedidos
    public function listarPedidos() {
        return $_SESSION['pedidos'];
    }


    // Ver un pedido por ID
    public function verPedido() {
        $id = $_GET['id'];

        $pedido = $this->buscarPedidoPorId($id);

        if (!$pedido) {
            header("Location: ../vistas/pedidos.php?error=pedido_no_encontrado");
            exit;
        }

        $_SESSION['pedidoActual'] = $pedido;

        header("Location: ../vistas/verPedido.php");
    }


    /* ============================================================
                        MANEJO DE DETALLES
       ============================================================ */

    public function agregarDetalle() {
        $pedidoId   = $_POST['pedidoId'];
        $productoId = $_POST['productoId'];
        $cantidad   = $_POST['cantidad'];

        $pedido = $this->buscarPedidoPorId($pedidoId);
        $producto = $this->buscarProductoPorId($productoId);

        if (!$pedido || !$producto) {
            header("Location: ../vistas/pedidos.php?error=datos_invalidos");
            exit;
        }

        $detalle = new DetallePedido($producto, $cantidad);

        $pedido->agregarDetalle($detalle);
        $this->guardarPedidos();

        header("Location: ../vistas/verPedido.php?id=$pedidoId&ok=detalle_agregado");
    }


    public function eliminarDetalle() {
        $pedidoId  = $_GET['pedidoId'];
        $detalleId = $_GET['detalleId'];

        $pedido = $this->buscarPedidoPorId($pedidoId);

        if (!$pedido) {
            header("Location: ../vistas/pedidos.php?error=pedido_no_encontrado");
            exit;
        }

        $pedido->eliminarDetalle($detalleId);
        $this->guardarPedidos();

        header("Location: ../vistas/verPedido.php?id=$pedidoId&ok=detalle_eliminado");
    }


    /* ============================================================
                        CAMBIO DE ESTADO
       ============================================================ */

    // Cancelar
    public function cancelarPedido() {
        $id = $_GET['id'];

        $pedido = $this->buscarPedidoPorId($id);

        if ($pedido && $pedido->cancelarPedido()) {
            $this->guardarPedidos();
            header("Location: ../vistas/pedidos.php?ok=pedido_cancelado");
        } else {
            header("Location: ../vistas/pedidos.php?error=no_se_puede_cancelar");
        }
    }

    // Entregar
    public function entregarPedido() {
        $id = $_GET['id'];

        $pedido = $this->buscarPedidoPorId($id);

        if ($pedido && $pedido->entregarPedido()) {
            $this->guardarPedidos();
            header("Location: ../vistas/pedidos.php?ok=pedido_entregado");
        } else {
            header("Location: ../vistas/pedidos.php?error=no_se_puede_entregar");
        }
    }


    /* ============================================================
                        MÉTODOS DE APOYO
       ============================================================ */

    private function buscarProductoPorId($id) {
        foreach ($_SESSION['productos'] as $p) {
            if ($p->getId() == $id) {
                return $p;
            }
        }
        return null;
    }

    private function buscarPedidoPorId($id) {
        foreach ($_SESSION['pedidos'] as $p) {
            if ($p->getId() == $id) {
                return $p;
            }
        }
        return null;
    }

    private function guardarPedidos() {
        $_SESSION['pedidos'] = $_SESSION['pedidos'];
    }

    private function generarId() {
        return count($_SESSION['pedidos']) + 1;
    }
}

$controller = new PedidoController();


/* ============================================================
          Ruteo — EXACTAMENTE IGUAL AL ESTILO DE TU ZIP
   ============================================================ */

    if (isset($_GET['accion'])) {
        switch ($_GET['accion']) {

            case 'registrar':
            $controller->registrarPedido();
            break;

            case 'ver':
            $controller->verPedido();
            break;

            case 'cancelar':
            $controller->cancelarPedido();
            break;

            case 'entregar':
            $controller->entregarPedido();
            break;

            case 'eliminarDetalle':
            $controller->eliminarDetalle();
            break;
        }
    }

    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {

        case 'agregarDetalle':
            $controller->agregarDetalle();
            break;
        }
    }
