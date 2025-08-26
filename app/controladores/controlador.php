<?php
header("Content-Type: application/json; charset=UTF-8");
include_once(__DIR__ . '/../modelo/usuario.php');

$usuario = new Usuario();
$request = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$uri = explode("/", $uri);

if ($uri[1] == "producto") {
    include_once(__DIR__ . '/controlador_producto.php');
    die();
}

if ($uri[1] == "promocion") {
    include_once(__DIR__ . '/controlador_promocion.php');
    die();
}

switch ($request) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->name) && !empty($data->mail) && !empty($data->password)) {
            $usuario->name = $data->name;
            $usuario->mail = $data->mail;
            $usuario->password = $data->password;

            if ($usuario->guardar()) {
                http_response_code(201);
                echo json_encode(array("mensaje" => "Usuario guardado."));
            } else {
                http_response_code(503);
                echo json_encode(array("mensaje" => "No se pudo guardar el usuario."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("mensaje" => "Datos incompletos."));
        }
        break;
    case 'GET':
        if (isset($uri[2]) && is_numeric($uri[2])) {
            $idUsuario = (int)$uri[2];
            $datos = $usuario->buscar($idUsuario);
            if ($datos !== null) {
                $resultado = mysqli_fetch_assoc($datos);
                $respuesta["datos"] = array(
                    "id" => $resultado["Id"],
                    "name" => $resultado["Name"],
                    "mail" => $resultado["Mail"]
                );
                http_response_code(200);
                echo json_encode($respuesta);
            } else {
                http_response_code(404);
                echo json_encode(array("mensaje" => "No hay usuario con ese ID."));
            }
            break;
        }
        $datos = $usuario->leer();
        if ($datos !== null) {
            $respuesta = array("datos" => array());
            while ($resultado = mysqli_fetch_assoc($datos)) {
                $respuesta["datos"][] = array(
                    "id" => $resultado["Id"],
                    "name" => $resultado["Name"],
                    "mail" => $resultado["Mail"]
                );
            }
            http_response_code(200);
            echo json_encode($respuesta);
        } else {
            http_response_code(404);
            echo json_encode(array("mensaje" => "No hay datos."));
        }
        break;
}
?>