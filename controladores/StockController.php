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

    // Actualizar stock
    public static function actualizarStock($id, $productoId, $cantidad, $ubicacion, $stockMinimo)
    {
        $stock = self::buscarPorId($id);
        if (!$stock) {
            return ['mensaje' => 'Stock no encontrado', 'tipo' => 'danger'];
        }

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

        $stock->setProducto($producto);
        $stock->setCantidad($cantidad);
        $stock->setUbicacion($ubicacion);
        $stock->setStockMinimo($stockMinimo);

        return ['mensaje' => 'Stock actualizado exitosamente', 'tipo' => 'success'];
    }

    // Eliminar stock
    public static function eliminarStock($id)
    {
        $stock = &$_SESSION['stock'];
        foreach ($stock as $key => $stock) {
            if ($stock->getId() == $id) {
                unset($stock[$key]);
                $stock = array_values($stock); // Reindexar
                return ['mensaje' => 'Stock eliminado exitosamente', 'tipo' => 'success'];
            }
        }
        return ['mensaje' => 'Stock no encontrado', 'tipo' => 'danger'];
    }
}
