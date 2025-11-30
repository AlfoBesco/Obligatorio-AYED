<?php

class ProductoController {
    
    public static function crearProd($id, $nombre, $descripcion, $precio, $categoria, $proveedor, $fechaRegistro, $activo) {
        // Validaciones
        if (empty($nombre) || empty($descripcion) || empty($precio) || empty($categoria) || empty($proveedor) || empty($fechaRegistro) || empty($activo)) {
            return [
                'exito' => false,
                'mensaje' => 'Todos los campos son obligatorios.',
                'tipo' => 'danger'
            ];
        }

        $producto = $_SESSION['productos'][$id];
        
        if (!is_numeric($precio) || $precio <= 0) {
            return [
                'exito' => false,
                'mensaje' => 'El precio debe ser un número mayor a cero.',
                'tipo' => 'danger'
            ];
        }

        // Buscar categoría y proveedor
        $categoria = CategoriaController::buscarCatPorId($producto->getCategoria()->getId());
        $proveedor = ProveedorController::buscarProvPorId($producto->getProveedor()->getId());

        if (!$categoria) {
            return [
                'exito' => false,
                'mensaje' => 'La categoría seleccionada no existe.',
                'tipo' => 'danger'
            ];
        }

        if (!$proveedor) {
            return [
                'exito' => false,
                'mensaje' => 'El proveedor seleccionado no existe.',
                'tipo' => 'danger'
            ];
        }


        $_SESSION['ultimo_idProd']++;
        $nuevoIdProd = $_SESSION['ultimo_idProd'];
        $nuevoProducto = new Producto($nuevoIdProd, $nombre, $descripcion, $precio, $categoria, $proveedor, $fechaRegistro, $activo);
        $_SESSION['productos'][$nuevoIdProd] = $nuevoProducto;
        
        return [
            'exito' => true,
            'mensaje' => 'Producto creado exitosamente: ' . $nuevoProducto->getNombre(),
            'tipo' => 'success',
            'producto' => $nuevoProducto
        ];
    }
    
    public static function actualizarProd($id, $nombre, $descripcion, $precio, $categoria, $proveedor, $fechaRegistro, $activo) {
        if (!isset($_SESSION['productos'][$id])) {
            return [
                'exito' => false,
                'mensaje' => 'Producto no encontrado.',
                'tipo' => 'danger'
            ];
        }

        $producto = $_SESSION['productos'][$id];
        
        if (empty($nombre) || empty($descripcion) || empty($precio) || empty($categoria) || empty($proveedor) || empty($fechaRegistro) || empty($activo)) {
            return [
                'exito' => false,
                'mensaje' => 'Todos los campos son obligatorios.',
                'tipo' => 'danger'
            ];
        }

        if (!is_numeric($precio) || $precio <= 0) {
            return [
                'exito' => false,
                'mensaje' => 'El precio debe ser un número válido.',
                'tipo' => 'danger'
            ];
        }

        $categoria = CategoriaController::buscarCatPorId($producto->getCategoria()->getId());
        $proveedor = ProveedorController::buscarProvPorId($producto->getProveedor()->getId());

        if (!$categoria) {
            return [
                'exito' => false,
                'mensaje' => 'La categoría seleccionada no existe.',
                'tipo' => 'danger'
            ];
        }

        if (!$proveedor) {
            return [
                'exito' => false,
                'mensaje' => 'El proveedor seleccionado no existe.',
                'tipo' => 'danger'
            ];
        }

        
        $producto->setNombre($nombre);
        $producto->setDescripcion($descripcion);
        $producto->setPrecio($precio);
        $producto->setCategoria($categoria);
        $producto->setProveedor($proveedor);
        $producto->setFechaRegistro($fechaRegistro);
        $producto->setActivo($activo);
        
        return [
            'exito' => true,
            'mensaje' => 'Producto actualizado exitosamente: ' . $producto->getNombre(),
            'tipo' => 'success',
            'producto' => $producto
        ];
    }
    
    public static function eliminarProd($id) {
        if (!isset($_SESSION['productos'][$id])) {
            return [
                'exito' => false,
                'mensaje' => 'Producto no encontrado.',
                'tipo' => 'danger'
            ];
        }
        
        $nombre = $_SESSION['productos'][$id]->getNombre();
        unset($_SESSION['productos'][$id]);
        
        return [
            'exito' => true,
            'mensaje' => 'Producto eliminado: ' . $nombre,
            'tipo' => 'warning'
        ];
    }
    
    public static function listarTodosProd() {
        return $_SESSION['productos'];
    }
    
    public static function buscarProdPorId($id) {
        return isset($_SESSION['productos'][$id]) ? $_SESSION['productos'][$id] : null;
    }
    
    public static function buscarProdPorNombre($termino) {
        $resultados = [];
        $termino = strtolower($termino);
        
        foreach ($_SESSION['productos'] as $producto) {
            $nombre = strtolower($producto->getNombre());
            if (strpos($nombre, $termino) !== false) {
                $resultados[] = $producto;
            }
        }
        return $resultados;
    }
    public static function buscarProdPorCategoria($termino) {
        $resultados = [];
        $termino = strtolower($termino);
        
        foreach ($_SESSION['productos'] as $producto) {
            $categoria = strtolower($producto->getCategoria());
            if (strpos($categoria, $termino) !== false) {
                $resultados[] = $producto;
            }
        }
        return $resultados;
    }
    public static function buscarProdPorProveedor($termino) {
        $resultados = [];
        $termino = strtolower($termino);

        foreach ($_SESSION['productos'] as $producto) {
            $proveedor = strtolower($producto->getProveedor());
            if (strpos($proveedor, $termino) !== false) {
                $resultados[] = $producto;
            }
        }
        return $resultados;
    }

    
    public static function contarTotalProd() {
        return count($_SESSION['productos']);
    }

    public static function aplicarDescuento($id, $porcentaje) {

        $producto = self::buscarProdPorId($id);

        if (!$producto) {
            return [
                'exito' => false,
                'mensaje' => 'Producto no encontrado.',
                'tipo' => 'danger'
            ];
        }

        if (!is_numeric($porcentaje) || $porcentaje <= 0 || $porcentaje > 90) {
            return [
                'exito' => false,
                'mensaje' => 'El porcentaje debe ser entre 1 y 90.',
                'tipo' => 'danger'
            ];
        }

        $nuevoPrecio = $producto->aplicarDescuento($porcentaje);

        return [
            'exito' => true,
            'mensaje' => "Descuento aplicado. Nuevo precio: $nuevoPrecio",
            'tipo' => 'success',
            'producto' => $producto
        ];
    }

    public static function cambiarCategoria($id, $nuevaCategoriaId) {

        // existe el producto?
        if (!isset($_SESSION['productos'][$id])) {
            return [
                'exito' => false,
                'mensaje' => 'Producto no encontrado.',
                'tipo' => 'danger'
            ];
        }

        $producto = $_SESSION['productos'][$id];

        // existe la nueva categoría?
        $nuevaCategoria = CategoriaController::buscarCatPorId($nuevaCategoriaId);
        if (!$nuevaCategoria) {
            return [
                'exito' => false,
                'mensaje' => 'La categoría seleccionada no existe.',
                'tipo' => 'danger'
            ];
        }

        $producto->cambiarCategoria($nuevaCategoria);

        return [
            'exito' => true,
            'mensaje' => 'Categoría actualizada correctamente. Nueva categoría: ' . $nuevaCategoria->getNombre(),
            'tipo' => 'success',
            'producto' => $producto
        ];
    }


}
?>