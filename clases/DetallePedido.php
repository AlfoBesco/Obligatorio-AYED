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

    public function getPedido()
    {
        return $this->pedido;
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

    public function setPedido($pedido)
    {
        $this->pedido = $pedido;
    }

    public function setProducto($producto)
    {
        $this->producto = $producto;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function setPrecioUnitario($precioUnitario)
    {
        $this->precioUnitario = $precioUnitario;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'pedido' => $this->pedido,
            'producto' => $this->producto,
            'cantidad' => $this->cantidad,
            'precioUnitario' => $this->precioUnitario
        ];
    }

    public function getSubtotal()
    {
        return $this->cantidad * $this->precioUnitario;
    }
}
