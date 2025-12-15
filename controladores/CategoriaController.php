
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

        if (empty($nombre) || empty($descripcion)) {
            return [
                'exito' => false,
                'mensaje' => 'Los campos Nombre y Descripción son obligatorios.',
                'tipo' => 'danger'
            ];
        }

        $_SESSION['ultimo_id_cat']++;
        $nuevoId = $_SESSION['ultimo_id_cat'];

        $padre = null;
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

        $nuevaCategoria = new Categoria($nuevoId, $nombre, $descripcion);
        if ($padre) {
            $padre->agregarSubcategoria($nuevaCategoria);
        }

        $_SESSION['categorias'][$nuevoId] = $nuevaCategoria;

        return [
            'exito' => true,
            'mensaje' => 'Categoría creada exitosamente: ' . $nuevaCategoria->getNombre(),
            'tipo' => 'success'
        ];
    }

    public static function actualizarCat($id, $nombre, $descripcion, $categoriaPadre)
    {
        self::inicializar();

        if (!isset($_SESSION['categorias'][$id])) {
            return [
                'exito' => false,
                'mensaje' => 'Categoría no encontrada.',
                'tipo' => 'danger'
            ];
        }

        if (empty($nombre) || empty($descripcion)) {
            return [
                'exito' => false,
                'mensaje' => 'Los campos Nombre y Descripción son obligatorios.',
                'tipo' => 'danger'
            ];
        }

        $categoria = $_SESSION['categorias'][$id];
        $nuevoPadre = null;

        if (!empty($categoriaPadre)) {
            if (!isset($_SESSION['categorias'][$categoriaPadre])) {
                return [
                    'exito' => false,
                    'mensaje' => 'Padre inválido.',
                    'tipo' => 'danger'
                ];
            }
            $nuevoPadre = $_SESSION['categorias'][$categoriaPadre];

            // Evitar asignar un descendiente como padre
            if ($categoria->buscarPorId($categoriaPadre) !== null) {
                return [
                    'exito' => false,
                    'mensaje' => 'No se puede asignar un descendiente como padre.',
                    'tipo' => 'danger'
                ];
            }
        }

        // Si cambia de padre, eliminar del anterior
        $antPadre = $categoria->getCategoriaPadre();
        if ($antPadre && $antPadre !== $nuevoPadre) {
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
            'mensaje' => 'Categoría actualizada exitosamente: ' . $categoria->getNombre(),
            'tipo' => 'success'
        ];
    }

    public static function eliminarCat($id)
    {
        self::inicializar();

        if (!isset($_SESSION['categorias'][$id])) {
            return [
                'exito' => false,
                'mensaje' => 'Categoría no encontrada.',
                'tipo' => 'danger'
            ];
        }

        $categoria = $_SESSION['categorias'][$id];

        if (!$categoria->puedeSerEliminada()) {
            return [
                'exito' => false,
                'mensaje' => 'No se puede eliminar: la categoría tiene subcategorías o productos.',
                'tipo' => 'warning'
            ];
        }

        $padre = $categoria->getCategoriaPadre();
        if ($padre) {
            $padre->eliminarSubcategoria($id);
        }

        unset($_SESSION['categorias'][$id]);

        return [
            'exito' => true,
            'mensaje' => 'Categoría eliminada correctamente.',
            'tipo' => 'success'
        ];
    }

    public static function listarTodasCat()
    {
        self::inicializar();
        return $_SESSION['categorias'];
    }

    public static function buscarCatPorId($id)
    {
        return isset($_SESSION['categorias'][$id]) ? $_SESSION['categorias'][$id] : null;
    }
}