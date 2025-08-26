<?php
include_once(__DIR__ . '/../librerias/bd.php');

class Producto
{
    private $conexion;

    public $id;
    public $name;
    public $cost;
    public $photo;
    public $userId;

    public function __construct()
    {
        $this->conexion = Database::obtenerConexion();
    }

    public function guardar()
    {
        $this->name   = filter_var($this->name, FILTER_SANITIZE_STRING);
        $this->cost   = filter_var($this->cost, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $this->photo  = filter_var($this->photo, FILTER_SANITIZE_STRING);
        $this->userId = filter_var($this->userId, FILTER_SANITIZE_NUMBER_INT);

        $consulta = "INSERT INTO products (Name, Cost, Photo, UserId) VALUES ('$this->name', '$this->cost', '$this->photo', '$this->userId')";
        return mysqli_query($this->conexion, $consulta);
    }

    public function leer()
    {
        $consulta = "SELECT * FROM products";
        return mysqli_query($this->conexion, $consulta);
    }

    public function buscar($id)
    {
        $consulta = "SELECT * FROM products WHERE Id = $id";
        $result = mysqli_query($this->conexion, $consulta);
        if (mysqli_num_rows($result) == 0) {
            return null;
        }
        return $result;
    }
}
?>