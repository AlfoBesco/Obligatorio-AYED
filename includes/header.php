<?php
require_once 'includes/sesion.php';
// Si no hay sesión iniciada, iniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determinar página actual
$paginaActual = isset($paginaActual) ? $paginaActual : 'inicio';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($titulo) ? $titulo : 'Gestión de Productos'; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <a href="index.php">
                    <span class="brand-text">Gestión de Productos</span>
                </a>
            </div>

            <ul class="nav-menu">
                <li class="nav-item <?php echo $paginaActual === 'inicio' ? 'active' : ''; ?>">
                    <a href="index.php">
                        <span class="nav-icon">👀</span>
                        Inicio
                    </a>
                </li>
                <li class="nav-item <?php echo $paginaActual === 'categorias' ? 'active' : ''; ?>">
                    <a href="categorias.php">
                        <span class="nav-icon">📌</span>
                        Categorías
                    </a>
                </li>
                <li class="nav-item <?php echo $paginaActual === 'proveedores' ? 'active' : ''; ?>">
                    <a href="proveedores.php">
                        <span class="nav-icon">👥</span>
                        Proveedores
                    </a>
                </li>
                <li class="nav-item <?php echo $paginaActual === 'productos' ? 'active' : ''; ?>">
                    <a href="productos.php">
                        <span class="nav-icon">🛒</span>
                        Productos
                    </a>
                </li>
                <li class="nav-item <?php echo $paginaActual === 'stock' ? 'active' : ''; ?>">
                    <a href="stock.php">
                        <span class="nav-icon">📊</span>
                        Stock
                    </a>
                </li>
                <li class="nav-item <?php echo $paginaActual === 'stock' ? 'active' : ''; ?>">
                    <a href="pedidos.php">
                        <span class="nav-icon">📋</span>
                        Pedidos
                    </a>
                </li>
                <li class="nav-item dropdown <?php echo $paginaActual === 'reportes' ? 'active' : ''; ?>">
                    <a href="#" class="dropdown-toggle">
                        <span class="nav-icon">🔍</span>
                        Reportes ▼
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="reportes.php">Proveedores</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="content">