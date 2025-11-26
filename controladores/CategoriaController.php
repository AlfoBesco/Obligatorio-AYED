<?php

class CategoriaController {

    public static function crear($nombre, $descripcion, $categoriaPadre, $subCategorias, $nivel) {
        // Validaciones
        if (empty($nombre) || empty($descripcion) || empty($nivel)) {
            return [
                'exito' => false,
                'mensaje' => 'Los campos Nombre, Descripcion y nivel son obligatorios.',
                'tipo' => 'danger'
            ];
        }
        
        
        $_SESSION['ultimo_id']++;
        $nuevoId = $_SESSION['ultimo_id'];
        $nuevaCategoria = new Categoria($nuevoId, $nombre, $descripcion, $categoriaPadre, $subCategorias, $nivel);
        $_SESSION['categorias'][$nuevoId] = $nuevaCategoria;
        
        return [
            'exito' => true,
            'mensaje' => 'Categoria creada exitosamente: ' . $nuevaCategoria->getNombre(),
            'tipo' => 'success',
            'categoria' => $nuevaCategoria
        ];
    }

}