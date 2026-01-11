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
            echo json_encode(CtrDispositivosTeletrabajo::findByIdEgresos($router->param('id_dispositivo')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDispositivosTeletrabajo::findAll($router->param('id_solicitud'), $router->param('id_servicio')));
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
                CtrDispositivosTeletrabajo::crear(
                    $v_id_solicitud, 
                    $v_id_servicio, 
                    $v_computador, 
                    $v_personal, 
                    $v_compartido, 
                    $v_num_persona, 
                    $v_camara, 
                    $v_marca, 
                    $v_internet,
                    $v_fijo,
                    $v_movil,
                    $v_limitado,
                    $v_ilimitado,
                    $v_paquete,
                    $v_individual,
                    $v_modem,
                    $v_banda_ancha,
                    $v_megas,
                    $v_linea_tele_local,
                    $v_linea_tele_p1,
                    $v_linea_tele_p2,
                    $v_linea_tele_p3,
                    $v_windows,
                    $v_ram,
                    $v_procesador,
                    $v_sistema,
                    $v_seguridad,
                    $v_numero,
                    $v_empresa_herramientas
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
        case 'delete_dispositivo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrRiesgosTeletrabajo::delete(
                    $router->param('id_dispositivo'),
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
        case 'update_dispositivo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrDispositivosTeletrabajo::update(
                    $router->param('id_dispositivo'),
                    $v_computador, 
                    $v_personal, 
                    $v_compartido,
                    $v_num_persona, 
                    $v_camara, 
                    $v_marca, 
                    $v_internet,
                    $v_fijo,
                    $v_movil,
                    $v_limitado,
                    $v_ilimitado,
                    $v_paquete,
                    $v_individual,
                    $v_modem,
                    $v_banda_ancha,
                    $v_megas,
                    $v_linea_tele_local,
                    $v_linea_tele_p1,
                    $v_linea_tele_p2,
                    $v_linea_tele_p3,
                    $v_windows,
                    $v_ram,
                    $v_procesador,
                    $v_sistema,
                    $v_seguridad,
                    $v_numero,
                    $v_empresa_herramientas
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
