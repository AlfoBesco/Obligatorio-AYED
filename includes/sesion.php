<?php

require_once __DIR__ . '/../clases/Proveedor.php';
require_once __DIR__ . '/../clases/Categoria.php';
require_once __DIR__ . '/../clases/Producto.php';
require_once __DIR__ . '/../clases/Pedido.php';
require_once __DIR__ . '/../clases/Stock.php';

session_start();

// 1️⃣ Proveedores
if (!isset($_SESSION['proveedores'])) {
    $_SESSION['proveedores'] = [];
    $_SESSION['ultimo_id_prov'] = 0;

    $p1 = new Proveedor(1, "Tech Supplies S.A.", "Juan Pérez", "099123456", "contacto@techsupplies.com", "Av. Libertador 1234, Montevideo");
    $p2 = new Proveedor(2, "Hogar & Deco", "María González", "098765432", "info@hogardeco.com", "Bulevar Artigas 5678, Montevideo");
    $p3 = new Proveedor(3, "Gadgets Uruguay", "Carlos Rodríguez", "091234567", "ventas@gadgetsuy.com", "21 de Setiembre 9876, Montevideo");

    $_SESSION['proveedores'] = [$p1->getId() => $p1, $p2->getId() => $p2, $p3->getId() => $p3];
    $_SESSION['ultimo_id_prov'] = 3;
}

// 2️⃣ Categorías
if (!isset($_SESSION['categorias'])) {
    $_SESSION['categorias'] = [];
    $_SESSION['ultimo_id_cat'] = 0;

    $c1 = new Categoria(1, "Electrónica", "Dispositivos y gadgets");
    $c2 = new Categoria(2, "Computadoras", "PCs, laptops y accesorios");
    $c3 = new Categoria(3, "Smartphones", "Teléfonos móviles y accesorios");
    $c4 = new Categoria(4, "Hogar", "Productos para el hogar");
    $c5 = new Categoria(5, "Muebles", "Muebles y decoración");
    $c6 = new Categoria(6, "Cocina", "Utensilios y electrodomésticos de cocina");

    $c1->agregarSubcategoria($c2);
    $c1->agregarSubcategoria($c3);
    $c4->agregarSubcategoria($c5);
    $c4->agregarSubcategoria($c6);

    $_SESSION['categorias'] = [$c1->getId() => $c1, $c2->getId() => $c2, $c3->getId() => $c3, $c4->getId() => $c4, $c5->getId() => $c5, $c6->getId() => $c6];
    $_SESSION['ultimo_id_cat'] = 6;
}

// 3️⃣ Productos
if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = [];
    $_SESSION['ultimo_id_prod'] = 0;

    $prod1 = new Producto(++$_SESSION['ultimo_id_prod'], "Laptop Gamer", "Laptop potente para videojuegos", 1500, $_SESSION['categorias'][2], $_SESSION['proveedores'][1], date('Y-m-d'), true);
    $prod2 = new Producto(++$_SESSION['ultimo_id_prod'], "Smartphone X", "Teléfono con cámara de alta resolución", 800, $_SESSION['categorias'][3], $_SESSION['proveedores'][2], date('Y-m-d'), true);
    $prod3 = new Producto(++$_SESSION['ultimo_id_prod'], "Sofá 3 plazas", "Sofá cómodo para living", 500, $_SESSION['categorias'][5], $_SESSION['proveedores'][1], date('Y-m-d'), true);
    $prod4 = new Producto(++$_SESSION['ultimo_id_prod'], "Mouse inalámbrico", "Mouse para oficina y gaming", 40, $_SESSION['categorias'][2], $_SESSION['proveedores'][2], date('Y-m-d'), true);

    $_SESSION['productos'] = [
        $prod1->getId() => $prod1,
        $prod2->getId() => $prod2,
        $prod3->getId() => $prod3,
        $prod4->getId() => $prod4
    ];
}

// 4️⃣ Pedidos
if (!isset($_SESSION['pedidos'])) {
    $_SESSION['pedidos'] = [];
    $_SESSION['ultimo_id_ped'] = 0;
    $_SESSION['ultimo_id_detalle'] = 0;

    $pedido1 = new Pedido(++$_SESSION['ultimo_id_ped']);
    $pedido2 = new Pedido(++$_SESSION['ultimo_id_ped']);
    $pedido3 = new Pedido(++$_SESSION['ultimo_id_ped']);

    $d1 = new DetallePedido(++$_SESSION['ultimo_id_detalle'], $_SESSION['productos'][1], 2, $_SESSION['productos'][1]->getPrecio());
    $d2 = new DetallePedido(++$_SESSION['ultimo_id_detalle'], $_SESSION['productos'][2], 1, $_SESSION['productos'][2]->getPrecio());
    $d3 = new DetallePedido(++$_SESSION['ultimo_id_detalle'], $_SESSION['productos'][3], 5, $_SESSION['productos'][3]->getPrecio());

    $pedido1->agregarDetalle($d1);
    $pedido1->agregarDetalle($d2);
    $pedido2->agregarDetalle($d3);

    $pedido3->entregarPedido();

    $_SESSION['pedidos'] = [
        $pedido1->getId() => $pedido1,
        $pedido2->getId() => $pedido2,
        $pedido3->getId() => $pedido3
    ];
}

// 5️⃣ Stock
if (!isset($_SESSION['stock'])) {
    $_SESSION['stock'] = [];
    $_SESSION['ultimo_id_stock'] = 0;

    // Crear ejemplos de stock (asegúrate de tener productos creados antes)
    $s1 = new Stock(++$_SESSION['ultimo_id_stock'], $_SESSION['productos'][1], 50, "Depósito Central", date('Y-m-d'), 10);
    $s2 = new Stock(++$_SESSION['ultimo_id_stock'], $_SESSION['productos'][2], 30, "Sucursal Montevideo", date('Y-m-d'), 5);
    $s3 = new Stock(++$_SESSION['ultimo_id_stock'], $_SESSION['productos'][3], 15, "Sucursal Colonia", date('Y-m-d'), 3);
    $s4 = new Stock(++$_SESSION['ultimo_id_stock'], $_SESSION['productos'][4], 100, "Depósito Secundario", date('Y-m-d'), 20);

    $_SESSION['stock'] = [
        $s1->getId() => $s1,
        $s2->getId() => $s2,
        $s3->getId() => $s3,
        $s4->getId() => $s4
    ];
}
