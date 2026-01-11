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
            echo json_encode(CtrVivDistribuciones::findByIdFormacion($router->param('id_distribucion')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivDistribuciones::findAll($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

            case 'lista_teletrabajo':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(CtrVivDistribuciones::findAllTeletrabajo($router->param('id_solicitud'), $router->param('id_servicio')));
                return;
                break;

            case 'tipo_espacio':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(CtrVivDistribuciones::findByEspacio($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('tipo_espacio')));
                return;
                break;

            case 'lista_distribucion':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(CtrVivDistribuciones::findAllDidtribucionMobiliaria($router->param('id_solicitud'), $router->param('id_servicio')));
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
                CtrVivDistribuciones::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_espacio,
                    $v_numero_espacio,
                    $v_estado_espacio,
                    $v_dotacion_mobiliaria,
                    $v_descripcion,
                    $v_ocupante,
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
                CtrVivDistribuciones::crearDistribucion($router->param('id_solicitud'), $router->param('id_servicio'),$v_datos)
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
        case 'delete_distribucion':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivDistribuciones::delete(
                    $router->param('id_distribucion'),
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
        case 'update_distribucion':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivDistribuciones::update(
                    $router->param('id_distribucion'),
                    $v_tipo_espacio,
                    $v_numero_espacio,
                    $v_estado_espacio,
                    $v_dotacion_mobiliaria,
                )
            );
            return;
            break;

        case 'update_distribucion_teletrabajo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivDistribuciones::update_teletrabajo(
                    $router->param('id_distribucion'),
                    $v_tipo_espacio,
                    $v_numero_espacio,
                    $v_descripcion,
                    $v_ocupante
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
