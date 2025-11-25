<?php

class Categoria {
    private $id;
    private $nombre;
    private $descripcion;
    private $categoriaPadre;
    private $subCategorias;
    private $nivel;
    
    public function __construct($id, $nombre, $descripcion, $categoriaPadre, $subCategorias, $nivel) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->categoriaPadre = $categoriaPadre;
        $this->subCategorias = $subCategorias;
        $this->nivel = $nivel;
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
    
    public function getCategoriaPadre() { 
        return $this->categoriaPadre; 
    }
    
    public function getSubCategorias() { 
        return $this->subCategorias; 
    }
    
    public function getNivel() { 
        return $this->nivel; 
    }
    
    
    
    public function setNombre($nombre) { 
        $this->nombre = $nombre; 
    }
    
    public function setDescripcion($descripcion) { 
        $this->descripcion = $descripcion; 
    }
    
    public function setCategoriaPadre($categoriaPadre) { 
        $this->categoriaPadre = $categoriaPadre; 
    }
    
    public function setSubCategorias($subCategorias) { 
        $this->subCategorias = $subCategorias; 
    }
    
    public function setNivel($nivel) { 
        $this->nivel = $nivel; 
    }
    
       
    
    public function toArray() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'categoriaPadre' => $this->categoriaPadre,
            'subCategorias' => $this->subCategorias,
            'nivel' => $this->nivel
        ];
    }
}
?>