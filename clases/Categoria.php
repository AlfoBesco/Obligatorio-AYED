<?php

class Categoria {
    private $id;
    private $nombre;
    private $descripcion;
    private $categoriaPadre;
    private $subCategorias;
    private $nivel;
    
    public function __construct($id, $nombre, $descripcion, $categoriaPadre = null, $subCategorias = [], $nivel) {
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
      

    public function agregarSubcategoria($categoria) {
        if ($this->subCategorias === null) $this->subCategorias = [];
        $this->subCategorias[] = $categoria;
        // asegurar referencia padre/nivel si es objeto
        if (is_object($categoria) && method_exists($categoria, 'setCategoriaPadre')) {
            $categoria->setCategoriaPadre($this);
            if (method_exists($categoria,'setNivel')) $categoria->setNivel($this->nivel + 1);
        }
    }

    public function eliminarSubcategoria($id) {
        if (empty($this->subCategorias)) return false;
        foreach ($this->subCategorias as $idx => $sub) {
            if (is_object($sub) && method_exists($sub,'getId') && $sub->getId() == $id) {
                array_splice($this->subCategorias, $idx, 1);
                return true;
            } elseif (is_array($sub) && isset($sub['id']) && $sub['id'] == $id) {
                array_splice($this->subCategorias, $idx, 1);
                return true;
            }
        }
        foreach ($this->subCategorias as $sub) {
            if (is_object($sub) && method_exists($sub,'eliminarSubcategoria')) {
                if ($sub->eliminarSubcategoria($id)) return true;
            }
        }
        return false;
    }

    public function mostrarArbol($indent = 0) {
        $prefix = str_repeat('  ', $indent);
        // intentar contar productos si existe método o session
        $count = '';
        if (method_exists($this, 'contarProductosTotales')) {
            $c = $this->contarProductosTotales();
            $count = ' ('.$c.' productos)';
        }
        echo $prefix . $this->nombre . $count . PHP_EOL;
        if (!empty($this->subCategorias)) {
            foreach ($this->subCategorias as $sub) {
                if (is_object($sub) && method_exists($sub,'mostrarArbol')) {
                    $sub->mostrarArbol($indent+1);
                } else {
                    $name = is_array($sub) && isset($sub['nombre']) ? $sub['nombre'] : '(sin nombre)';
                    echo str_repeat('  ', $indent+1) . $name . PHP_EOL;
                }
            }
        }
    }

    public function buscarPorId($id) {
        if ($this->id == $id) return $this;
        if (!empty($this->subCategorias)) {
            foreach ($this->subCategorias as $sub) {
                if (is_object($sub) && method_exists($sub,'buscarPorId')) {
                    $found = $sub->buscarPorId($id);
                    if ($found !== null) return $found;
                } elseif (is_array($sub) && isset($sub['id']) && $sub['id'] == $id) {
                    return $sub;
                }
            }
        }
        return null;
    }

    public function getRutaCompleta() {
        $nombres = [];
        $current = $this;
        while ($current !== null) {
            $nombres[] = $current->getNombre();
            $padre = $current->getCategoriaPadre();
            if (is_object($padre)) {
                $current = $padre;
            } else {
                $current = null;
            }
        }
        $nombres = array_reverse($nombres);
        return implode(' > ', $nombres);
    }

    public function contarProductosTotales() {
        $total = 0;
        if (isset($_SESSION['productos']) && is_array($_SESSION['productos'])) {
            foreach ($_SESSION['productos'] as $p) {
                $cat = null;
                if (is_object($p) && method_exists($p,'getCategoria')) {
                    $cat = $p->getCategoria();
                } elseif (is_array($p) && isset($p['categoria'])) {
                    $catId = $p['categoria'];
                    $cat = $_SESSION['categorias'][$catId] ?? null;
                }
                if ($cat) {
                    if (is_object($cat) && method_exists($cat,'getId')) {
                        if ($cat->getId() == $this->id) $total++;
                        else {
                            // si la categoria del producto está debajo de esta por ruta
                            if (method_exists($cat,'getRutaCompleta') && strpos($cat->getRutaCompleta(), $this->getNombre()) !== false) $total++;
                        }
                    } elseif (is_int($cat) || is_string($cat)) {
                        if ((int)$cat == $this->id) $total++;
                    }
                }
            }
        }
        // sumar recursivamente hijos
        if (!empty($this->subCategorias)) {
            foreach ($this->subCategorias as $sub) {
                if (is_object($sub) && method_exists($sub,'contarProductosTotales')) {
                    $total += $sub->contarProductosTotales();
                }
            }
        }
        return $total;
    }

    public function esHoja() {
        return empty($this->subCategorias);
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