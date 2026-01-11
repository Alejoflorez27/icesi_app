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
            echo json_encode(CtrVivSector::findById($router->param('id_sector')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivSector::findAll($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        case 'listasaspectosfisicos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivSector::consultarTodos());
            return;
            break;


        case 'listacomboservicio':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivSector::findAllByCombo($router->param('id_sector'), $router->param('categoria'), $router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;
        case 'validacion_viv':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivSector::findAllByComboviv($router->param('id_sector'), $router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;
        case 'id_aspecto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivSector::findAByAspecto($router->param('id_sector'), $router->param('categoria'),$router->param('codigo'), $router->param('id_solicitud'), $router->param('id_servicio')));
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
                CtrVivSector::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_sector, 
                    $v_estracto, 
                    $v_estado_sector, 
                    $v_ubicacion_sector, 
                    $v_tmp_ida_trabajo, 
                    $v_tmp_en_vivienda, 
                    $v_zonas_verdes, 
                    $v_vias_principales, 
                    $v_concepto_vecino
                )
            );
            return;
            break;
            
        case 'aspectos-agregar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivSectoresVariables::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_id_sector,
                    $v_categoria,
                    $v_id_caracteristica_tipo
                )
            );
            return;
            break;

        case 'aspectos-eliminar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivSectoresVariables::delete(
                    $v_id_sector,
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
        case 'deleteaspecto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivSectoresVariables::delete(
                    $router->param('id_sector_variable'),
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
                CtrVivSector::update(
                    $router->param('id_sector'),
                    $v_id_solicitud,
                    $v_sector, 
                    $v_estracto, 
                    $v_estado_sector, 
                    $v_ubicacion_sector, 
                    $v_tmp_ida_trabajo, 
                    $v_tmp_en_vivienda, 
                    $v_zonas_verdes, 
                    $v_vias_principales, 
                    $v_concepto_vecino,
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
