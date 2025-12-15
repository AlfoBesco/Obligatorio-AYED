
<?php
class Pedido
{
    private $id;
    private $fechaPedido;
    private $proveedor;
    private $estado;
    private $detalles = [];
    private $total = 0;

    public function __construct($id, $fechaPedido, $proveedor, $estado, $detalles = [], $total = 0)
    {
        $this->id = $id;
        $this->fechaPedido = $fechaPedido;
        $this->proveedor = $proveedor;
        $this->estado = $estado;
        $this->detalles = $detalles;
        $this->total = $total;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getFechaPedido()
    {
        return $this->fechaPedido;
    }
    public function getProveedor()
    {
        return $this->proveedor;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function getDetalles()
    {
        return $this->detalles;
    }
    public function getTotal()
    {
        return $this->total;
    }

    public function setFechaPedido($fechaPedido)
    {
        $this->fechaPedido = $fechaPedido;
    }
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function cambiarEstado($nuevoEstado)
    {
        $this->estado = $nuevoEstado;
    }

    public function agregarDetalle($detalle)
    {
        $this->detalles[] = $detalle;
        $this->calcularTotal();
    }

    public function eliminarDetalle($detalleId)
    {
        foreach ($this->detalles as $i => $d) {
            if ($d->getId() == $detalleId) {
                unset($this->detalles[$i]);
                $this->detalles = array_values($this->detalles);
                break;
            }
        }
        $this->calcularTotal();
    }

    private function calcularTotal()
    {
        $this->total = 0;
        foreach ($this->detalles as $detalle) {
            $this->total += $detalle->getCantidad() * $detalle->getPrecio();
        }
    }
}
