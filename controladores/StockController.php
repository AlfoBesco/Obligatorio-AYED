<?php
require_once __DIR__ . '/../clases/Stock.php';
require_once __DIR__ . '/../clases/Producto.php';

class StockController
{

    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['stock'])) {
            $_SESSION['stock'] = [];
        }
    }

    // Listar todos los stock
    public static function listarTodosStock()
    {
        return isset($_SESSION['stock']) ? $_SESSION['stock'] : [];
    }

    // Buscar stock por ID
    public static function buscarPorId($id)
    {
        $stock = self::listarTodosStock();
        foreach ($stock as $stock) {
            if ($stock->getId() == $id) {
                return $stock;
            }
        }
        return null;
    }

    // Crear nuevo stock
    public static function crearStock($productoId, $cantidad, $ubicacion, $stockMinimo)
    {
        $productos = isset($_SESSION['productos']) ? $_SESSION['productos'] : [];
        $producto = null;

        foreach ($productos as $prod) {
            if ($prod->getId() == $productoId) {
                $producto = $prod;
                break;
            }
        }

        if (!$producto) {
            return ['mensaje' => 'Producto no encontrado', 'tipo' => 'danger'];
        }

        $id = count($_SESSION['stock']) + 1;
        $fechaActualizacion = date('Y-m-d H:i:s');

        $stock = new Stock($id, $producto, $cantidad, $ubicacion, $fechaActualizacion, $stockMinimo);
        $_SESSION['stock'][] = $stock;

        return ['mensaje' => 'Stock creado exitosamente', 'tipo' => 'success'];
    }

    // Actualizar solo la cantidad y la fecha
    public static function actualizarStock($id, $cantidad)
    {
        $stock = self::buscarPorId($id);
        if (!$stock) {
            return ['mensaje' => 'Stock no encontrado', 'tipo' => 'danger'];
        }

        // Actualizamos la cantidad
        $stock->setCantidad($cantidad);

        // Actualizamos la fecha a la actual
        $stock->setFechaUltimaActualizacion(date('Y-m-d H:i:s'));

        return ['mensaje' => 'Cantidad actualizada exitosamente', 'tipo' => 'success'];
    }

    public static function descontarStock($productoId, $cantidadSolicitada)
    {
        $stockItems = self::listarTodosStock();

        foreach ($stockItems as $stock) {
            if ($stock->getProducto()->getId() == $productoId) {
                $cantidadActual = $stock->getCantidad();

                // Validar si hay suficiente stock
                if ($cantidadSolicitada > $cantidadActual) {
                    return [
                        'mensaje' => 'Cantidad solicitada supera el stock disponible',
                        'tipo' => 'danger'
                    ];
                }

                // Restar la cantidad solicitada
                $stock->setCantidad($cantidadActual - $cantidadSolicitada);
                $stock->setFechaUltimaActualizacion(date('Y-m-d H:i:s'));

                // Comprobar si el stock queda por debajo del mínimo
                if ($stock->getCantidad() < $stock->getStockMinimo()) {
                    return [
                        'mensaje' => 'Stock actualizado, pero está por debajo del mínimo',
                        'tipo' => 'warning'
                    ];
                }

                return [
                    'mensaje' => 'Stock actualizado tras el pedido',
                    'tipo' => 'success'
                ];
            }
        }

        // Si no se encuentra el producto en el stock
        return [
            'mensaje' => 'Producto no encontrado en stock',
            'tipo' => 'danger'
        ];
    }
}
