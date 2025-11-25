<?php

class Producto {
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $categoria;
    private $proveedor;
    private $fechaRegistro;
    private $activo;

    public function __construct($id, $nombre, $descripcion, $precio, $categoria, $proveedor, $fechaRegistro, $activo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->categoria = $categoria;
        $this->proveedor = $proveedor;
        $this->fechaRegistro = date('Y-m-d H:i:s');
        $this->activo = $activo;
    }

    public function getId() { 
        return $this->id; 
    }

    public function getNombre() { 
        return $this->nombre; 
    }

    public function getDescripcion() { 
        return $this->descripcion; 
    }

    public function getPrecio() { 
        return $this->precio; 
    }

    public function getCategoria() { 
        return $this->categoria; 
    }

    public function getProveedor() { 
        return $this->proveedor; 
    }

    public function getFechaRegistro() { 
        return $this->fechaRegistro; 
    }

    public function getActivo() { 
        return $this->activo; 
    }


    public function setNombre($nombre) { 
        $this->nombre = $nombre; 
    }

    public function setDescripcion($descripcion) { 
        $this->descripcion = $descripcion; 
    }

    public function setPrecio($precio) { 
        $this->precio = $precio; 
    }

    public function setCategoria($categoria) { 
        $this->categoria = $categoria; 
    }

    public function setProveedor($proveedor) { 
        $this->proveedor = $proveedor; 
    }

    public function getFechaRegistro() { 
        return $this->fechaRegistro; 
    }

    public function setActivo($activo) { 
        $this->activo = $activo; 
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'categoria' => $this->categoria,
            'proveedor' => $this->proveedor,
            'fechaRegistro' => $this->fechaRegistro,
            'activo' => $this->activo,
        ];
    }
}
?>
