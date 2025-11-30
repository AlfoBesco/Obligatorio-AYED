<?php
require_once __DIR__ . '/../clases/Categoria.php';

session_start();

if (!isset($_SESSION['categorias'])) {
    $_SESSION['categorias'] = [];
    $_SESSION['ultimo_idCat'] = 0;
        
    // Cargo datos de ejemplo
    $categoria1 = new Categoria(1, "Celulares", "abcde", "Tecnología", "Samsung", "1");
    
    $_SESSION['categorias'][1] = $categoria1;
    $_SESSION['ultimo_idCat'] = 1;
}

function obtenerCategorias() {
    return $_SESSION['categorias'];
}

function obtenerCategoriaPorId($id) {
    return isset($_SESSION['categorias'][$id]) ? $_SESSION['categorias'][$id] : null;
}
?>