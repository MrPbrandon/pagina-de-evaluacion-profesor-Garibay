<?php
include_once(__DIR__ . '/../librerias/bd.php');

class Promocion
{
    private $conexion;

    public $id;
    public $fecha;
    public $usu_id;
    public $pro_id;

    public function __construct()
    {
        $this->conexion = Database::obtenerConexion();
    }

    public function guardar()
    {
        $this->usu_id = filter_var($this->usu_id, FILTER_SANITIZE_NUMBER_INT);
        $this->pro_id = filter_var($this->pro_id, FILTER_SANITIZE_NUMBER_INT);

        $consulta = "INSERT INTO tbl_promo (prom_fecha, prom_usu_id, prom_pro_id) VALUES (NOW(), '$this->usu_id', '$this->pro_id')";
        return mysqli_query($this->conexion, $consulta);
    }

    public function leer()
    {
        $consulta = "SELECT * FROM tbl_promo";
        return mysqli_query($this->conexion, $consulta);
    }
}
?>