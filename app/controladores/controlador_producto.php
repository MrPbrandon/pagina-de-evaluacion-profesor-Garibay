<?php
include_once(__DIR__ . '/../modelo/producto.php');

$producto = new Producto();

switch ($request) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->name) && !empty($data->cost) && !empty($data->photo) && !empty($data->userId)) {
            $producto->name = $data->name;
            $producto->cost = $data->cost;
            $producto->photo = $data->photo;
            $producto->userId = $data->userId;

            if ($producto->guardar()) {
                http_response_code(201);
                echo json_encode(array("mensaje" => "Producto guardado."));
            } else {
                http_response_code(503);
                echo json_encode(array("mensaje" => "No se pudo guardar el producto."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("mensaje" => "Datos incompletos."));
        }
        break;
    case 'GET':
        if (isset($uri[2]) && is_numeric($uri[2])) {
            $idProducto = (int)$uri[2];
            $datos = $producto->buscar($idProducto);
            if ($datos !== null) {
                $resultado = mysqli_fetch_assoc($datos);
                $respuesta["datos"] = array(
                    "id" => $resultado["Id"],
                    "name" => $resultado["Name"],
                    "cost" => $resultado["Cost"],
                    "photo" => $resultado["Photo"],
                    "userId" => $resultado["UserId"]
                );
                http_response_code(200);
                echo json_encode($respuesta);
            } else {
                http_response_code(404);
                echo json_encode(array("mensaje" => "No hay producto con ese ID."));
            }
            break;
        }
        $datos = $producto->leer();
        if ($datos !== null) {
            $respuesta = array("datos" => array());
            while ($resultado = mysqli_fetch_assoc($datos)) {
                $respuesta["datos"][] = array(
                    "id" => $resultado["Id"],
                    "name" => $resultado["Name"],
                    "cost" => $resultado["Cost"],
                    "photo" => $resultado["Photo"],
                    "userId" => $resultado["UserId"]
                );
            }
            http_response_code(200);
            echo json_encode($respuesta);
        } else {
            http_response_code(404);
            echo json_encode(array("mensaje" => "No hay productos."));
        }
        break;
}
?>