<?php
include_once(__DIR__ . '/../modelo/promocion.php');

$promocion = new Promocion();

switch ($request) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->usu_id) && !empty($data->pro_id)) {
            $promocion->usu_id = $data->usu_id;
            $promocion->pro_id = $data->pro_id;
            if ($promocion->guardar()) {
                http_response_code(201);
                echo json_encode(array("mensaje" => "Promoción guardada."));
            } else {
                http_response_code(503);
                echo json_encode(array("mensaje" => "No se pudo guardar la promoción."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("mensaje" => "Datos incompletos."));
        }
        break;
    case 'GET':
        $datos = $promocion->leer();
        if ($datos !== null) {
            $respuesta = array("datos" => array());
            while ($resultado = mysqli_fetch_assoc($datos)) {
                $respuesta["datos"][] = array(
                    "prom_id" => $resultado["prom_id"],
                    "prom_fecha" => $resultado["prom_fecha"],
                    "prom_usu_id" => $resultado["prom_usu_id"],
                    "prom_pro_id" => $resultado["prom_pro_id"]
                );
            }
            http_response_code(200);
            echo json_encode($respuesta);
        } else {
            http_response_code(404);
            echo json_encode(array("mensaje" => "No hay promociones."));
        }
        break;
}
?>
