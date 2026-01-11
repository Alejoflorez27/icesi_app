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
            echo json_encode(CtrRiesgosTeletrabajo::findByIdEgresos($router->param('id_riesgo')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrRiesgosTeletrabajo::findAll($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        case 'validar_variable':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrRiesgosTeletrabajo::ExiteVariable($router->param('descripcion'), $router->param('list_aspecto'), $router->param('id_solicitud')));
            return;
            break;

        case 'preguntas_faltantes':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrRiesgosTeletrabajo::preguntasFaltantes($router->param('id_solicitud')));
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
                CtrRiesgosTeletrabajo::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_factor,
                    $v_aspecto,
                    $v_descripcion,
                    $v_calificacion,
                    $v_observacion,
                    $v_list_aspecto
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
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    switch (strtolower($recurso)) {
        case 'delete_riesgo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrRiesgosTeletrabajo::delete(
                    $router->param('id_riesgo'),
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
        case 'update_riesgo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrRiesgosTeletrabajo::update(
                    $router->param('id_riesgo'),
                    $v_factor,
                    $v_aspecto,
                    $v_calificacion,
                    $v_observacion
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
