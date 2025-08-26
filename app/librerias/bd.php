<?php
include_once(__DIR__ . '/../conexion.php');

class Database
{
    private static $conexion = null;

    public static function obtenerConexion()
    {
        if (self::$conexion === null) {
            self::$conexion = mysqli_connect(SERVIDOR, USUARIO, CONTRASENA, BD);
            if (!self::$conexion) {
                throw new Exception('Error de conexión: ' . mysqli_connect_error());
            }
        }
        return self::$conexion;
    }
}
?>
