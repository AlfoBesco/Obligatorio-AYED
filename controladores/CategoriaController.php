<?php

class CategoriaController
{
    private static function inicializar()
    {
        if (!isset($_SESSION['categorias'])) {
            $_SESSION['categorias'] = [];
            $_SESSION['ultimo_id_cat'] = 0;
        }
    }

    public static function crearCat($nombre, $descripcion, $categoriaPadre = null)
    {
        self::inicializar();

        // Validaciones
        if (empty($nombre) || empty($descripcion)) {
            return [
                'exito' => false,
                'mensaje' => 'Los campos Nombre y Descripcion son obligatorios.',
                'tipo' => 'danger'
            ];
        }

        $_SESSION['ultimo_id_cat']++;
        $nuevoId = $_SESSION['ultimo_id_cat'];

        $padre = null;

        // Solo validar si se pasó un valor no vacío
        if (!empty($categoriaPadre)) {
            if (!isset($_SESSION['categorias'][$categoriaPadre])) {
                return [
                    'exito' => false,
                    'mensaje' => 'Categoría padre inválida.',
                    'tipo' => 'danger'
                ];
            }
            $padre = $_SESSION['categorias'][$categoriaPadre];
        }

        $nuevaCategoria = new Categoria($nuevoId, $nombre, $descripcion, $padre);

        $_SESSION['categorias'][$nuevoId] = $nuevaCategoria;

        // Si tiene padre, agregar la subcategoría
        if ($padre) {
            $padre->agregarSubcategoria($nuevaCategoria);
        }

        return [
            'exito' => true,
            'mensaje' => 'Categoría creada exitosamente: ' . $nuevaCategoria->getNombre(),
            'tipo' => 'success',
            'categoria' => $nuevaCategoria
        ];
    }

    public static function actualizarCat($id, $nombre, $descripcion, $categoriaPadre)
    {
        if (!isset($_SESSION['categorias'][$id])) {
            return [
                'exito' => false,
                'mensaje' => 'Categoria no encontrada.',
                'tipo' => 'danger'
            ];
        }

        if (empty($nombre) || empty($descripcion) || empty($nivel)) {
            return [
                'exito' => false,
                'mensaje' => 'Los campos Nombre, Descripcion y nivel son obligatorios.',
                'tipo' => 'danger'
            ];
        }

        $categoria = $_SESSION['categorias'][$id];

        // Validar nuevo padre (no permitir autoreferencia ni descendiente)
        $nuevoPadre = null;
        if ($categoriaPadre !== null) {
            if (!isset($_SESSION['categorias'][$categoriaPadre])) {
                return [
                    'exito' => false,
                    'mensaje ' => 'Padre inválido',
                    'tipo' => 'danger'
                ];
            }
            $nuevoPadre = $_SESSION['categorias'][$categoriaPadre];

            // impedir asignar como hijo a uno de sus descendientes
            $desc = $categoria->buscarPorId($categoriaPadre);
            if ($desc !== null) {
                return [
                    'exito' => false,
                    'mensaje' => 'No se puede asignar un descendiente como padre',
                    'tipo' => 'danger'
                ];
            }
        }

        // Si cambio de padre, quitar enlace del padre anterior
        $antPadre = $categoria->getCategoriaPadre();
        if ($antPadre && is_object($antPadre) && $antPadre !== $nuevoPadre) {
            $antPadre->eliminarSubcategoria($id);
        }


        $categoria->setNombre($nombre);
        $categoria->setDescripcion($descripcion);
        $categoria->setCategoriaPadre($nuevoPadre);
        if ($nuevoPadre) {
            $nuevoPadre->agregarSubcategoria($categoria);
        }

        return [
            'exito' => true,
            'mensaje' => 'Categoria actualizada exitosamente: ' . $categoria->getNombre(),
            'tipo' => 'success',
            'categoria' => $categoria
        ];
    }

    public static function eliminarCat($id)
    {
        foreach ($_SESSION['categoriaRaiz'] as $i => $categoriaRaiz) {
            if ($categoriaRaiz->getId() == $id) {

                if (!$categoriaRaiz->puedeEliminarse()) {
                    return [
                        'exito' => false,
                        'mensaje' => 'No se puede eliminar: la categoría tiene subcategorías.',
                        'tipo' => 'warning'
                    ];
                }
                unset($_SESSION['categoriaRaiz'][$i]);
                $_SESSION['categoriaRaiz'] = array_values($_SESSION['categoriaRaiz']);
                return true;
            }

            $categoria = $categoriaRaiz->buscarPorId($id);

            // Validar que no tenga subcategorías o productos
            if ($categoria !== null) {
                if (!$categoria->puedeSerEliminada()) {
                    return [
                        'exito' => false,
                        'mensaje' => 'No se puede eliminar, la categoría tiene subcategorías o productos.',
                        'tipo' => 'warning'
                    ];
                }

                $padre = $categoria->getCategoriaPadre();
                if ($padre !== null) {
                    $padre->eliminarSubcategoria($id);
                    return true;
                }
            }
        }
        return "categoria no encontrada";
    }

    public static function listarTodasCat()
    {
        return $_SESSION['categorias'];
    }

    public static function buscarCatPorId($id)
    {
        return isset($_SESSION['categorias'][$id]) ? $_SESSION['categorias'][$id] : null;
    }
}
