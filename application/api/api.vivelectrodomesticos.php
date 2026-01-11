<?php

$recurso = $router->get(3);

$permitidos_sin_login = array(); //end-points permitidos sin login
$permitido = in_array($router->get(3), $permitidos_sin_login);

if (!$permitido) {
    if (!ValidateToken::autentication()) {
        http_response_code(403);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(Result::error(__FUNCTION__, "Acceso denegado"));
        return;
    }
}

$put_vars = json_decode(file_get_contents("php://input"), true);
if (isset($put_vars))
    extract($put_vars, EXTR_PREFIX_ALL, "v");


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    switch (strtolower($recurso)) {
        case '':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivElectrodomesticos::findByIdFormacion($router->param('id_electrodomestico')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivElectrodomesticos::findAll($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        case 'lista_electrodomesticos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivElectrodomesticos::findAllElectro($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch (strtolower($recurso)) {
        case '':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivElectrodomesticos::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_elemento,
                    $v_cantidad,
                    $v_estado_electrodomestico,
                    $v_tenencia_electrodomestico
                )
            );
            return;
            break;

        case 'crear':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            // Obtiene los datos del cuerpo del POST (JSON)
            $v_datos = json_decode(file_get_contents("php://input"), true);
            echo json_encode(
                CtrVivElectrodomesticos::crearElectrodomestico($router->param('id_solicitud'), $router->param('id_servicio'),$v_datos)
            );
            return;
            break;

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */

            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    switch (strtolower($recurso)) {
        case 'delete_electrodomestico':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivElectrodomesticos::delete(
                    $router->param('id_electrodomestico'),
                )
            );
            return;
            break;

        default:
            /*
                * Si no se llama algun metodo autorizado: 400 Bad Request
                */

            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    switch (strtolower($recurso)) {
        case 'update_electrodomestico':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivElectrodomesticos::update(
                    $router->param('id_electrodomestico'),
                    $v_tipo_elemento,
                    $v_cantidad,
                    $v_estado_electrodomestico,
                    $v_tenencia_electrodomestico
                )
            );
            return;
            break;

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
            break;
    }
}
