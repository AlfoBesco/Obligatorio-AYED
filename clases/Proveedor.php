<?php

class Proveedor {
    private $id;
    private $nombreEmpresa;
    private $contacto;
    private $telefono;
    private $email;
    private $direccion;

    public function __construct($id, $nombreEmpresa, $contacto, $telefono, $email, $direccion) {
        $this->id = $id;
        $this->nombreEmpresa = $nombreEmpresa;
        $this->contacto = $contacto;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->direccion = $direccion;
    }

    public function getId() { 
        return $this->id; 
    }

    public function getNombreEmpresa() { 
        return $this->nombreEmpresa; 
    }

    public function getContacto() { 
        return $this->contacto; 
    }

    public function getTelefono() { 
        return $this->telefono; 
    }

    public function getEmail() { 
        return $this->email; 
    }

    public function getDireccion() { 
        return $this->direccion; 
    }
    
    public function setId($id){
        $this->id = $id;
    }

    public function setNombreEmpresa($nombreEmpresa){
        $this->nombreEmpresa = $nombreEmpresa;
    }

    public function setContacto($contacto){
        $this->contacto = $contacto;
    }

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }



    public function getProductos() {
    if (!isset($_SESSION['productos'])) {
        return [];
    }

    $resultado = [];

        foreach ($_SESSION['productos'] as $producto) {
            if ($producto->getProveedor()->getId() === $this->id) {
                $resultado[] = $producto;
            }
        }
        return $resultado;
    }

    public function contarProductos() {
        return count($this->getProductos());
    }




    public function toArray() {
        return [
            'id' => $this->id,
            'nombreEmpresa' => $this->nombreEmpresa,
            'contacto' => $this->contacto,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion
        ];
    }
}
?>