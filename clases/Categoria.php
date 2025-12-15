<?php

class Categoria
{
    private $id;
    private $nombre;
    private $descripcion;
    private $categoriaPadre;
    private $subCategorias;
    private $nivel;

    private $productos = [];

    public function __construct($id, $nombre, $descripcion = "")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->categoriaPadre = null;
        $this->subCategorias = [];
        $this->nivel = 0;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getCategoriaPadre()
    {
        return $this->categoriaPadre;
    }
    public function getSubCategorias()
    {
        return $this->subCategorias;
    }
    public function getNivel()
    {
        return $this->nivel;
    }

    public function getProductos()
    {
        return $this->productos;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setCategoriaPadre($categoriaPadre)
    {
        $this->categoriaPadre = $categoriaPadre;
    }
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
        foreach ($this->subCategorias as $subCat) {
            $subCat->setNivel($nivel + 1);
        }
    }


    public function agregarSubcategoria($categoria)
    {
        $this->subCategorias[] = $categoria;
        $categoria->setCategoriaPadre($this);
        $categoria->setNivel($this->nivel + 1);
    }

    public function eliminarSubcategoria($id)
    {
        foreach ($this->subCategorias as $key => $sub) {
            if ($sub->getId() == $id) {
                unset($this->subcategorias[$key]);
                // Re-indexar el array
                $this->subCategorias = array_values($this->subCategorias);
                return true;
            }
        }
        return false;
    }


    public function buscarPorId($id)
    {
        if ($this->id == $id) return $this;
        foreach ($this->subCategorias as $sub) {
            $resultado = $sub->buscarPorId($id);
            if ($resultado != null) {
                return $resultado;
            }
        }
        return null;
    }


    public function mostrarArbol($indent = "")
    {
        echo $indent . "<strong>" . htmlspecialchars($this->nombre) . "</strong> ";
        echo "<span style='color: #999;'>(Nivel " . $this->nivel . ")</span><br>";

        foreach ($this->subCategorias as $sub) {
            $sub->mostrarArbolHTML($indent . "&nbsp;&nbsp;&nbsp;&nbsp;");
        }
    }

    //INTEGRACION PRODUCTOS
    public function agregarProducto($producto)
    {
        $this->productos[] = $producto;
    }

    public function eliminarProducto($idProducto)
    {
        foreach ($this->productos as $i => $prod) {
            if ($prod->getId() == $idProducto) {
                unset($this->productos[$i]);
                $this->productos = array_values($this->productos);
                return true;
            }
        }
        return false;
    }

    public function contarProductosTotales()
    {
        global $productos; // Array global de productos

        $count = 0;

        // Contar productos de esta categoría
        foreach ($productos as $prod) {
            if ($prod->getCategoria()->getId() == $this->id) {
                $count++;
            }
        }

        // Sumar recursivamente productos de subcategorías
        foreach ($this->subCategorias as $sub) {
            $count += $sub->contarProductosTotales();
        }
        return $count;
    }

    public function obtenerTodosLosProductos()
    {
        global $productos;
        $resultado = [];
        // Productos directos de esta categoría
        foreach ($productos as $prod) {
            if ($prod->getCategoria()->getId() == $this->id) {
                $resultado[] = $prod;
            }
        }
        // Productos de todas las subcategorías (recursivo)
        foreach ($this->subCategorias as $sub) {
            $resultado = array_merge($resultado, $sub->obtenerTodosLosProductos());
        }
        return $resultado;
    }


    public function esHoja()
    {
        return empty($this->subCategorias);
    }

    public function esRaiz()
    {
        return $this->categoriaPadre === null;
    }

    public function puedeSerEliminada()
    {
        global $productos;

        // Verificar que no tenga subcategorías
        if (!empty($this->subcategorias)) {
            return false;
        }

        // Verificar que no tenga productos asociados
        foreach ($productos as $prod) {
            if ($prod->getCategoria()->getId() == $this->id) {
                return false;
            }
        }

        return true;
    }

    public function getRutaCompleta($separador = " > ")
    {
        $ruta = [];
        $actual = $this;
        // Recorrer hacia arriba hasta la raíz
        while ($actual != null) {
            array_unshift($ruta, $actual->getNombre());
            $actual = $actual->getCategoriaPadre();
        }
        return implode($separador, $ruta);
    }


    public function toArray()
    {
        $array = [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'nivel' => $this->nivel,
            'subcategorias' => []
        ];

        foreach ($this->subCategorias as $sub) {
            $array['subcategorias'][] = $sub->toArray();
        }

        return $array;
    }

    public function generarSelectHTML($seleccionado = null, $nivel = 0)
    {
        $indent = str_repeat("&nbsp;&nbsp;", $nivel);
        $selected = ($seleccionado == $this->id) ? "selected" : "";

        $html = "<option value='{$this->id}' $selected>{$indent}{$this->nombre}</option>\n";

        foreach ($this->subCategorias as $sub) {
            $html .= $sub->generarSelectHTML($seleccionado, $nivel + 1);
        }

        return $html;
    }

    // Alias para compatibilidad con código antiguo
    public function getNombreCompleto()
    {
        return $this->getRutaCompleta();
    }
}
