<?php

class DetallePedido
{
    private $id;
    private $pedido;
    private $producto;
    private $cantidad;
    private $precioUnitario;

    public function __construct($id, $pedido, $producto, $cantidad, $precioUnitario)
    {
        $this->id = $id;
        $this->pedido = $pedido;
        $this->producto = $producto;
        $this->cantidad = $cantidad;
        $this->precioUnitario = $precioUnitario;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getPrecioUnitario()
    {
        return $this->precioUnitario;
    }

    public function getSubtotal()
    {
        return $this->cantidad * $this->precioUnitario;
    }
}
