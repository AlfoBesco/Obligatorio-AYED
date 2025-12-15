<?php

require_once __DIR__ . '/../clases/Proveedor.php';
require_once __DIR__ . '/../clases/Categoria.php';
require_once __DIR__ . '/../clases/Producto.php';
require_once __DIR__ . '/../clases/Pedido.php';
require_once __DIR__ . '/../clases/DetallePedido.php';
require_once __DIR__ . '/../clases/Stock.php';

session_start();

/* =========================
   PROVEEDORES (3)
========================= */
if (!isset($_SESSION['proveedores'])) {
    $_SESSION['proveedores'] = [];
    $_SESSION['ultimo_id_prov'] = 0;

    $p1 = new Proveedor(++$_SESSION['ultimo_id_prov'], "Tech Supplies S.A.", "Juan Pérez", "099123456", "contacto@techsupplies.com", "Montevideo");
    $p2 = new Proveedor(++$_SESSION['ultimo_id_prov'], "Hogar & Deco", "María González", "098765432", "info@hogardeco.com", "Canelones");
    $p3 = new Proveedor(++$_SESSION['ultimo_id_prov'], "Gadgets Uruguay", "Carlos Rodríguez", "091234567", "ventas@gadgetsuy.com", "Maldonado");

    $_SESSION['proveedores'] = [
        $p1->getId() => $p1,
        $p2->getId() => $p2,
        $p3->getId() => $p3
    ];
}

/* =========================
   CATEGORÍAS (ÁRBOL)
========================= */
if (!isset($_SESSION['categorias'])) {
    $_SESSION['categorias'] = [];
    $_SESSION['ultimo_id_cat'] = 0;

    $electronica = new Categoria(++$_SESSION['ultimo_id_cat'], "Electrónica", "Dispositivos electrónicos");
    $celulares   = new Categoria(++$_SESSION['ultimo_id_cat'], "Celulares", "Teléfonos móviles");
    $computadoras = new Categoria(++$_SESSION['ultimo_id_cat'], "Computadoras", "PC y notebooks");
    $laptops     = new Categoria(++$_SESSION['ultimo_id_cat'], "Laptops", "Portátiles");
    $desktop     = new Categoria(++$_SESSION['ultimo_id_cat'], "Desktop", "Computadoras de escritorio");
    $audio       = new Categoria(++$_SESSION['ultimo_id_cat'], "Audio", "Equipos de sonido");

    $ropa        = new Categoria(++$_SESSION['ultimo_id_cat'], "Ropa", "Indumentaria");
    $hombre      = new Categoria(++$_SESSION['ultimo_id_cat'], "Hombre", "Ropa masculina");
    $mujer       = new Categoria(++$_SESSION['ultimo_id_cat'], "Mujer", "Ropa femenina");

    $hogar       = new Categoria(++$_SESSION['ultimo_id_cat'], "Hogar", "Artículos del hogar");
    $cocina      = new Categoria(++$_SESSION['ultimo_id_cat'], "Cocina", "Utensilios de cocina");
    $decoracion  = new Categoria(++$_SESSION['ultimo_id_cat'], "Decoración", "Decoración del hogar");

    // Relaciones del árbol
    $electronica->agregarSubcategoria($celulares);
    $electronica->agregarSubcategoria($computadoras);
    $electronica->agregarSubcategoria($audio);
    $computadoras->agregarSubcategoria($laptops);
    $computadoras->agregarSubcategoria($desktop);

    $ropa->agregarSubcategoria($hombre);
    $ropa->agregarSubcategoria($mujer);

    $hogar->agregarSubcategoria($cocina);
    $hogar->agregarSubcategoria($decoracion);

    $_SESSION['categorias'] = [
        $electronica->getId() => $electronica,
        $celulares->getId() => $celulares,
        $computadoras->getId() => $computadoras,
        $laptops->getId() => $laptops,
        $desktop->getId() => $desktop,
        $audio->getId() => $audio,
        $ropa->getId() => $ropa,
        $hombre->getId() => $hombre,
        $mujer->getId() => $mujer,
        $hogar->getId() => $hogar,
        $cocina->getId() => $cocina,
        $decoracion->getId() => $decoracion
    ];
}

/* =========================
   PRODUCTOS (10)
========================= */
if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = [];
    $_SESSION['ultimo_id_prod'] = 0;

    $productos = [
        new Producto(++$_SESSION['ultimo_id_prod'], "Laptop Gamer", "RTX 3060", 1500, $laptops, $p1, date('Y-m-d'), true),
        new Producto(++$_SESSION['ultimo_id_prod'], "PC Oficina", "Uso administrativo", 800, $desktop, $p1, date('Y-m-d'), true),
        new Producto(++$_SESSION['ultimo_id_prod'], "iPhone 13", "Smartphone Apple", 1200, $celulares, $p3, date('Y-m-d'), true),
        new Producto(++$_SESSION['ultimo_id_prod'], "Auriculares Bluetooth", "Audio inalámbrico", 150, $audio, $p3, date('Y-m-d'), true),
        new Producto(++$_SESSION['ultimo_id_prod'], "Remera Hombre", "Algodón", 25, $hombre, $p2, date('Y-m-d'), true),
        new Producto(++$_SESSION['ultimo_id_prod'], "Vestido Mujer", "Vestido verano", 60, $mujer, $p2, date('Y-m-d'), true),
        new Producto(++$_SESSION['ultimo_id_prod'], "Sartén", "Antiadherente", 40, $cocina, $p2, date('Y-m-d'), true),
        new Producto(++$_SESSION['ultimo_id_prod'], "Mesa comedor", "Madera", 300, $decoracion, $p2, date('Y-m-d'), true),
        new Producto(++$_SESSION['ultimo_id_prod'], "Parlante", "Parlante portátil", 200, $audio, $p3, date('Y-m-d'), true),
        new Producto(++$_SESSION['ultimo_id_prod'], "Notebook Básica", "Estudiante", 600, $laptops, $p1, date('Y-m-d'), true),
    ];

    foreach ($productos as $prod) {
        $_SESSION['productos'][$prod->getId()] = $prod;
    }
}

/* =========================
   STOCK
========================= */
if (!isset($_SESSION['stock'])) {
    $_SESSION['stock'] = [];
    $_SESSION['ultimo_id_stock'] = 0;

    foreach ($_SESSION['productos'] as $producto) {
        $stock = new Stock(
            ++$_SESSION['ultimo_id_stock'],
            $producto,
            rand(5, 100),
            "Depósito Central",
            date('Y-m-d'),
            rand(5, 15)
        );
        $_SESSION['stock'][$stock->getId()] = $stock;
    }
}

/* =========================
   PEDIDOS (2)
========================= */
if (!isset($_SESSION['pedidos'])) {
    $_SESSION['pedidos'] = [];
    $_SESSION['ultimo_id_pedido'] = 0;

    $pedido1 = new Pedido(++$_SESSION['ultimo_id_ped'], date('Y-m-d'), $p1, "pendiente");
    $pedido2 = new Pedido(++$_SESSION['ultimo_id_ped'], date('Y-m-d'), $p2, "recibido");

    $pedido1->agregarDetalle(new DetallePedido(1, $pedido1, $_SESSION['productos'][1], 2, 1500));
    $pedido1->agregarDetalle(new DetallePedido(2, $pedido1, $_SESSION['productos'][4], 3, 150));

    $pedido2->agregarDetalle(new DetallePedido(3, $pedido2, $_SESSION['productos'][5], 5, 25));

    $_SESSION['pedidos'] = [
        $pedido1->getId() => $pedido1,
        $pedido2->getId() => $pedido2
    ];
}
