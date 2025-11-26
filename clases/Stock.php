<?php

class Stock {
    private $id;
    private $producto;
    private $cantidad;
    private $ubicacion;
    private $fechaUltimaActualizacion;
    private $stockMinimo;

    public function __construct($id, $producto, $cantidad, $ubicacion, $fechaUltimaActualizacion, $stockMinimo) {
        $this->id = $id;
        $this->producto = $producto;
        $this->cantidad = $cantidad;
        $this->ubicacion = $ubicacion;
        $this->fechaUltimaActualizacion = $fechaUltimaActualizacion;
        $this->stockMinimo = $stockMinimo;
    }

    public function getId() { 
        return $this->id; 
    }

    public function getProducto() { 
        return $this->producto; 
    }

    public function getCantidad() {
        return $this->cantidad; 
    }

    public function getUbicacion() { 
        return $this->ubicacion; 
    }

    public function getFechaUltimaActualizacion() { 
        return $this->fechaUltimaActualizacion; 
    }

    public function getStockMinimo() { 
        return $this->stockMinimo; 
    }

    public function setProducto($producto) { 
        $this->producto = $producto; 
    }

    public function setCantidad($cantidad) { 
        $this->cantidad = $cantidad; 
    }

    public function setUbicacion($ubicacion) { 
        $this->ubicacion = $ubicacion; 
    }

    public function setFechaUltimaActualizacion($fechaUltimaActualizacion) { 
        $this->fechaUltimaActualizacion = $fechaUltimaActualizacion; 
    }

    public function setStockMinimo($stockMinimo) { 
        $this->stockMinimo = $stockMinimo; 
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'producto' => $this->producto,
            'cantidad' => $this->cantidad,
            'ubicacion' => $this->ubicacion,
            'fechaUltimaActualizacion' => $this->fechaUltimaActualizacion,
            'stockMinimo' => $this->stockMinimo,
        ];
    }
}
?>
