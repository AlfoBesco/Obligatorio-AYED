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
}
