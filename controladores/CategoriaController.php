<?php

class CategoriaController {

    public static function crearCat($nombre, $descripcion, $categoriaPadre = null, $subCategorias, $nivel) {
        // Validaciones
        if (empty($nombre) || empty($descripcion) || empty($nivel)) {
            return [
                'exito' => false,
                'mensaje' => 'Los campos Nombre, Descripcion y nivel son obligatorios.',
                'tipo' => 'danger'
            ];
        }
        
        
        $_SESSION['ultimo_idCat']++;
        $nuevoId = $_SESSION['ultimo_idCat'];

        $padre = null;

        if($categoriaPadre !== null) {
            if(!isset($_SESSION['categorias'][$categoriaPadre])) {
                return ['exito' => false,
                        'mensaje'=> 'Categoria padre invalida.',
                        'tipo' => 'danger'
                ];
            }
            $padre = $_SESSION['categorias'][$categoriaPadre];
        }


        $nuevaCategoria = new Categoria($nuevoId, $nombre, $descripcion, $categoriaPadre, $subCategorias, $nivel);
        $_SESSION['categorias'][$nuevoId] = $nuevaCategoria;
        
        return [
            'exito' => true,
            'mensaje' => 'Categoria creada exitosamente: ' . $nuevaCategoria->getNombre(),
            'tipo' => 'success',
            'categoria' => $nuevaCategoria
        ];
    }

    public static function actualizarCat($id, $nombre, $descripcion, $categoriaPadre, $subCategorias, $nivel) {
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
                    'mensaje '=> 'Padre inválido',
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
        $categoria->setSubCategorias($subCategorias);
        $categoria->setNivel($nivel);
        
        return [
            'exito' => true,
            'mensaje' => 'Categoria actualizada exitosamente: ' . $categoria->getNombre(),
            'tipo' => 'success',
            'categoria' => $categoria
        ];
    }

    public static function eliminarCat($id) {
        if (!isset($_SESSION['categorias'][$id])) {
            return [
                'exito' => false,
                'mensaje' => 'Categoria no encontrada.',
                'tipo' => 'danger'
            ];
        }
        
        $categoria = $_SESSION['categorias'][$id];

        // Validar que no tenga subcategorías
        if (!$categoria->esHoja()) {
            return [
                'exito' => false,
                'mensaje' => 'No se puede eliminar: la categoría tiene subcategorías.',
                'tipo' => 'warning'
            ];
        }

        // Verificar productos asociados a esta categoría
        if (isset($_SESSION['productos']) && is_array($_SESSION['productos'])) {
            foreach ($_SESSION['productos'] as $p) {
                $catObj = null;
                if (is_object($p) && method_exists($p,'getCategoria')) $catObj = $p->getCategoria();
                elseif (is_array($p) && isset($p['categoria'])) $catObj = $_SESSION['categorias'][$p['categoria']] ?? null;
                if ($catObj) {
                    if (is_object($catObj) && method_exists($catObj,'getId') && $catObj->getId() == $id) {
                        return ['exito'=>false,'mensaje'=>'No se puede eliminar: existen productos asociados.','tipo'=>'warning'];
                    } elseif ((is_int($catObj) || is_string($catObj)) && ((int)$catObj) == $id) {
                        return ['exito'=>false,'mensaje'=>'No se puede eliminar: existen productos asociados.','tipo'=>'warning'];
                    }
                }
            }
        }

        // quitar referencia del padre si existe
        $padre = $categoria->getCategoriaPadre();
        if ($padre && is_object($padre)) {
            $padre->eliminarSubcategoria($id);
        }

        $nombre = $_SESSION['categorias'][$id]->getNombre();
        unset($_SESSION['categorias'][$id]);
        
        return [
            'exito' => true,
            'mensaje' => 'Categoria eliminada: ' . $nombre,
            'tipo' => 'warning'
        ];
    }

    public static function listarTodasCat() {
        return $_SESSION['categorias'];
    }

     public static function buscarCatPorId($id) {
        return isset($_SESSION['categorias'][$id]) ? $_SESSION['categorias'][$id] : null;
    }

}