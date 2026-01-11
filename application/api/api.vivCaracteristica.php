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
            echo json_encode(CtrVivCaracteristicas::findById($router->param('id_caracteristica')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivCaracteristicas::findAll($router->param('id_solicitud'),$router->param('id_servicio')));
            return;
            break;

        case 'listasaspectosfisicos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivCaracteristicas::consultarTodos());
            return;
            break;


        case 'listacomboservicio':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivCaracteristicas::findAllByCombo($router->param('id_caracteristica'), $router->param('categoria'), $router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;
        case 'validacion_viv':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivCaracteristicas::findAllByComboviv($router->param('id_caracteristica'), $router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;
        case 'id_aspecto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivCaracteristicas::findAByAspecto($router->param('id_caracteristica'), $router->param('categoria'),$router->param('codigo'), $router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        case 'lista_combo_aspecto_fisico':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivCaracteristicas::findAllByComboAspectoFisico($router->param('id_caracteristica'), $router->param('p_aspecto')));
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
                CtrVivCaracteristicas::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_vivienda,
                    $v_tipo_tenencia,
                    $v_tipo_tamano_vivienda,
                    $v_tipo_vivienda_estado,
                    $v_aclaracion_viv,
                    $v_direccion,
                    $v_telefono,
                    $v_barrio,
                    $v_estrato,
                    $v_zona,
                    $v_ambiente,
                    $v_sector,
                    $v_lugar,
                    $v_limpieza
                )
            );
            return;
            break;

        case 'aspectos-agregar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivCaracteristicasVariables::crear(
                    $v_id_solicitud,
                    $v_id_servicio,  
                    $v_id_caracteristica_tipo,
                    $v_id_caracteristica,
                    $v_categoria
                )
            );
            return;
            break;

        case 'aspectos-eliminar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivCaracteristicasVariables::delete(
                    $v_id_caracteristica,
                    $v_id_caracteristica_tipo
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
        case 'deleteaspectofisico':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivCaracteristicasVariables::delete(
                    $router->param('id_caracteristica_variable'),
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
        case '':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivCaracteristicas::update(
                    $router->param('id_caracteristica'),
                    $v_id_solicitud,
                    $v_tipo_vivienda,
                    $v_tipo_tenencia,
                    $v_tipo_tamano_vivienda,
                    $v_tipo_vivienda_estado,
                    $v_aclaracion_viv,
                    $v_direccion,
                    $v_telefono,
                    $v_barrio,
                    $v_estrato,
                    $v_zona,
                    $v_ambiente,
                    $v_sector,
                    $v_lugar,
                    $v_limpieza
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
