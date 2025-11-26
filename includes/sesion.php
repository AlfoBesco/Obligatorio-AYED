<?php
require_once __DIR__ . '/../clases/Categoria.php';

session_start();

if (!isset($_SESSION['categoriaS'])) {
    $_SESSION['categoriaS'] = [];
    $_SESSION['ultimo_id'] = 0;
        
    // Cargo datos de ejemplo
    $categoria1 = new Categoria(1, "Celulares", "abcde", "Tecnología", "Samsung", "1");
    
    $_SESSION['categoriaS'][1] = $categoria1;
    $_SESSION['ultimo_id'] = 1;
}

function obtenerCategorias() {
    return $_SESSION['categorias'];
}

function obtenerCategoriaPorId($id) {
    return isset($_SESSION['categorias'][$id]) ? $_SESSION['categorias'][$id] : null;
}
?>