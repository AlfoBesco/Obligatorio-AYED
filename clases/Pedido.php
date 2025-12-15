<?php

class Pedido
{
    private $id;
    private $fecha;
    private $estado;
    private $detalles = [];

    public function __construct($id)
    {
        $this->id = $id;
        $this->fecha = date("Y-m-d");
        $this->estado = "pendiente";
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getDetalles()
    {
        return $this->detalles;
    }

    public function agregarDetalle($detalle)
    {
        $this->detalles[] = $detalle;
    }

    public function eliminarDetalle($detalleId)
    {
        foreach ($this->detalles as $i => $d) {
            if ($d->getId() == $detalleId) {
                unset($this->detalles[$i]);
                $this->detalles = array_values($this->detalles);
                return;
            }
        }
    }

    public function cancelarPedido()
    {
        if ($this->estado === "pendiente") {
            $this->estado = "cancelado";
            return true;
        }
        return false;
    }

    public function entregarPedido()
    {
        if ($this->estado === "pendiente") {
            $this->estado = "entregado";
            return true;
        }
        return false;
    }
}
