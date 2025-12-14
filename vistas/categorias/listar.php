<h2>Árbol de Categorías</h2>

<div style="margin-left:20px;">
    <?php
    foreach ($_SESSION['categoriasRaiz'] as $categoriaRaiz) {
        echo $categoriaRaiz->mostrarArbol();
    }
    ?>
</div>
