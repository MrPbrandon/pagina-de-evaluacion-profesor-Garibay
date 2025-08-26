<?php
include_once(__DIR__ . '/../librerias/bd.php');

class Usuario
{
    private $conexion;

    public $id;
    public $name;
    public $mail;
    public $password;

    public function __construct()
    {
        $this->conexion = Database::obtenerConexion();
    }

    public function guardar()
    {
        $this->name     = filter_var($this->name, FILTER_SANITIZE_STRING);
        $this->mail     = filter_var($this->mail, FILTER_SANITIZE_EMAIL);
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        $consulta = "INSERT INTO users (Name, Mail, Password) VALUES ('$this->name', '$this->mail', '$this->password')";
        return mysqli_query($this->conexion, $consulta);
    }

    public function leer()
    {
        $consulta = "SELECT * FROM users";
        return mysqli_query($this->conexion, $consulta);
    }

    public function buscar($id)
    {
        $consulta = "SELECT * FROM users WHERE Id = $id";
        $result = mysqli_query($this->conexion, $consulta);
        if (mysqli_num_rows($result) == 0) {
            return null;
        }
        return $result;
    }
}
?>
