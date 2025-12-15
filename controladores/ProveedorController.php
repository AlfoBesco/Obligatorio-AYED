<?php

require_once __DIR__ . '/../clases/Proveedor.php';

class ProveedorController
{
    private static function inicializar()
    {
        if (!isset($_SESSION['proveedores'])) {
            $_SESSION['proveedores'] = [];
            $_SESSION['ultimo_id_prov'] = 0;
        }
    }

    public static function crearProv($nombreEmpresa, $contacto, $telefono, $email, $direccion)
    {
        self::inicializar();

        if (empty($nombreEmpresa) || empty($contacto) || empty($telefono) || empty($email) || empty($direccion)) {
            return [
                'exito' => false,
                'mensaje' => 'Todos los campos son obligatorios.',
                'tipo' => 'danger'
            ];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'exito' => false,
                'mensaje' => 'El email no es válido.',
                'tipo' => 'danger'
            ];
        }

        $_SESSION['ultimo_id_prov']++;
        $id = $_SESSION['ultimo_id_prov'];

        $proveedor = new Proveedor(
            $id,
            $nombreEmpresa,
            $contacto,
            $telefono,
            $email,
            $direccion
        );

        $_SESSION['proveedores'][$id] = $proveedor;

        return [
            'exito' => true,
            'mensaje' => 'Proveedor creado correctamente.',
            'tipo' => 'success'
        ];
    }

    public static function actualizarProv($id, $nombreEmpresa, $contacto, $telefono, $email, $direccion)
    {
        if (!isset($_SESSION['proveedores'][$id])) {
            return [
                'exito' => false,
                'mensaje' => 'Proveedor no encontrado.',
                'tipo' => 'danger'
            ];
        }

        if (empty($nombreEmpresa) || empty($contacto) || empty($telefono) || empty($email) || empty($direccion)) {
            return [
                'exito' => false,
                'mensaje' => 'Todos los campos son obligatorios.',
                'tipo' => 'danger'
            ];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'exito' => false,
                'mensaje' => 'El email no es válido.',
                'tipo' => 'danger'
            ];
        }

        $proveedor = $_SESSION['proveedores'][$id];

        $proveedor->setNombreEmpresa($nombreEmpresa);
        $proveedor->setContacto($contacto);
        $proveedor->setTelefono($telefono);
        $proveedor->setEmail($email);
        $proveedor->setDireccion($direccion);

        return [
            'exito' => true,
            'mensaje' => 'Proveedor actualizado correctamente.',
            'tipo' => 'success',
            'proveedor' => $proveedor
        ];
    }

    public static function eliminarProv($id)
    {

        if (!isset($_SESSION['proveedores'][$id])) {
            return [
                'exito' => false,
                'mensaje' => 'Proveedor no encontrado.',
                'tipo' => 'danger'
            ];
        }

        // No permitir eliminar proveedor si tiene productos asociados
        foreach ($_SESSION['productos'] as $producto) {
            if ($producto->getProveedor()->getId() === $id) {
                return [
                    'exito' => false,
                    'mensaje' => 'No se puede eliminar el proveedor porque tiene productos asociados.',
                    'tipo' => 'warning'
                ];
            }
        }

        unset($_SESSION['proveedores'][$id]);
        return [
            'exito' => true,
            'mensaje' => 'Proveedor eliminado correctamente.',
            'tipo' => 'success'
        ];
    }

    public static function listarTodosProv()
    {
        return $_SESSION['proveedores'];
    }

    public static function buscarProvPorId($id)
    {
        return $_SESSION['proveedores'][$id] ?? null;
    }

    public static function buscarProvPorNombre($termino)
    {
        $resultados = [];
        $termino = strtolower($termino);

        foreach ($_SESSION['proveedores'] as $proveedor) {
            if (strpos(strtolower($proveedor->getNombreEmpresa()), $termino) !== false) {
                $resultados[] = $proveedor;
            }
        }

        return $resultados;
    }

    public static function contarTotalProv()
    {
        return count($_SESSION['proveedores']);
    }

    public static function buscarPorId($id)
    {
        return isset($_SESSION['proveedores'][$id]) ? $_SESSION['proveedores'][$id] : null;
    }
}
