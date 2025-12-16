<div class="welcome-section">
    <div class="welcome-header">
        <h2>Gestion de categorías de productos</h2>
    </div>

    <div class="features-grid">
        <div class="feature-card">
            <img src="https://3313137.fs1.hubspotusercontent-na1.net/hub/3313137/hubfs/Changes-in-digital-commerce-policy-mooted2.jpg?width=676&name=Changes-in-digital-commerce-policy-mooted2.jpg">

            <div class="arbol-categorias">
                <h3>Árbol de Categorías</h3>

                <?php
                if (!empty($_SESSION['categorias'])) {
                    foreach ($_SESSION['categorias'] as $categoria) {
                        $categoria->mostrarArbol();
                    }
                } else {
                    echo "<p>No hay categorías cargadas.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="tech-info">
        <h3>Contacto</h3>
        <div class="tech-badges">
            <span class="tech-badge">Tel.: 458602380</span>
            <span class="tech-badge">Cel.: 095 773 262</span>
            <span class="tech-badge">Avenida Artigas 633</span>
            <span class="tech-badge">Juan Lacaze</span>
            <span class="tech-badge">Colonia</span>
            <span class="tech-badge">Uruguay</span>
        </div>
    </div>
</div>