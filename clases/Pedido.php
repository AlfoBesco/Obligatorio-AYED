<?php

class Pedido {
    private $id;
    private $fechaPedido;
    private $proveedor;
    private $estado;
    private $detalles;
    private $total;

    public function __construct($id, $fechaPedido, $proveedor, $estado, $detalles, $total) {
        $this->id = $id;
        $this->fechaPedido = $fechaPedido;
        $this->proveedor = $proveedor;
        $this->estado = $estado;
        $this->detalles = $detalles;
        $this->total = $total;
    }

    public function getId() { 
        return $this->id; 
    }

    public function getFechaPedido() { 
        return $this->fechaPedido; 
    }

    public function getProveedor() { 
        return $this->proveedor; 
    }

    public function getEstado() { 
        return $this->estado; 
    }

    public function getDetalles() { 
        return $this->detalles; 
    }

    public function getTotal() { 
        return $this->total; 
    }
    
    public function setId($id){
        $this->id = $id;
    }

    public function setFechaPedido($fechaPedido){
        $this->fechaPedido = $fechaPedido;
    }

    public function setProveedor($proveedor){
        $this->proveedor = $proveedor;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function setDetalles($detalles){
        $this->detalles = $detalles;
    }

    public function setTotal($total){
        $this->total = $total;
    }


    public function cambiarEstado($estado) {
        $this->estado = $estado;
    }


    public function toArray() {
        return [
            'id' => $this->id,
            'fechaPedido' => $this->fechaPedido,
            'proveedor' => $this->proveedor,
            'estado' => $this->estado,
            'detalles' => $this->detalles,
            'total' => $this->total
        ];
    }
}
?>