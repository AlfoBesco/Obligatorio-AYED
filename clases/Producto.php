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

    public function __construct($id, $nombre, $descripcion, $precio, Categoria $categoria, Proveedor $proveedor, $activo = true) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->categoria = $categoria;
        $this->proveedor = $proveedor;
        $this->fechaRegistro = date('Y-m-d');
        $this->activo = $activo;

        $categoria->agregarProducto($this);
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
    public function isActivo() { 
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
    public function setActivo($activo) { 
        $this->activo = $activo; 
    }



    public function cambiarCategoria(Categoria $nuevaCategoria) {
        $this->categoria->eliminarProducto($this->id);
            if ($nuevaCategoria == null) {
            throw new Exception("La nueva categoría no puede ser nula.");
            }
        $this->categoria = $nuevaCategoria;
        $nuevaCategoria->agregarProducto($this);
    }

    public function aplicarDescuento($porcentaje) {
        if ($porcentaje < 0 || $porcentaje > 100) {
            throw new Exception("El porcentaje de descuento debe estar entre 0 y 100.");
        }
        $descuento = ($this->precio * $porcentaje) / 100;
        return $this->precio - $descuento;
    }

    public function toString() {
        return "Producto: {$this->id} - {$this->nombre} | $".$this->precio .
           " | Categoría: {$this->categoria->getNombre()} | Proveedor: {$this->proveedor->getNombreEmpresa()}";
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
