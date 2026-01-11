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
            echo json_encode(CtrVivProtocoloSeguridad::findByIdActivos($router->param('id_seguridad')));
            return;
            break;
        case 'concepto_final':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivConceptoProfesional::findByIdConcepto($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;
        case 'concepto_final_confiabilidad':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivConceptoProfesional::findByIdConceptoConfiabilidad($router->param('id_solicitud')));
            return;
            break;
        case 'concepto_final_sin_srv':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivConceptoProfesional::findByAllConceptoSinSrv($router->param('id_solicitud')));
            return;
            break;
        case 'concepto_final_by_sin_srv':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivConceptoProfesional::findByIdConceptoSinSrv($router->param('id_concepto')));
            return;
            break;
        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivProtocoloSeguridad::findAll($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        case 'lista_noexists':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivProtocoloSeguridad::findAllNoExists($router->param('tipo_protocolo_seguridad_vi')));
            return;
            break;

        case 'concepto_completo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivProtocoloSeguridad::findconceptovi($router->param('concepto_seguridad')));
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
                CtrVivConceptoProfesional::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_expectativas,
                    $v_metas, 
                    $v_medio_hv, 
                    $v_condicion_laboral, 
                    $v_concepto_final, 
                    $v_observacion,
                    $v_requisito,
                    $v_calificacion,
                    $v_hallazgo,
                    $v_concepto_pertenece,
                    $v_pregunta_uno,
                    $v_pregunta_dos,
                    $v_pregunta_tres,
                    $v_otro_dos,
                    $v_otro_tres,
                    $v_asociado_confiable,
                    $v_referencia
                )
            );
            return;
            break;
            case 'crear-conceptos-confiabilidad':
                //print_r($registros);
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    //print_r($v_registros)
                    CtrVivConceptoProfesional::crear_confiabilidad(
                        $v_registros
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
        case 'delete_seguridad':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivProtocoloSeguridad::delete(
                    $router->param('id_seguridad'),
                )
            );
            return;
            break;

        case 'delete_concepto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivConceptoProfesional::delete(
                    $router->param('id_concepto'),
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
        case 'update_concepto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivConceptoProfesional::update(
                    $router->param('id_concepto'),
                    $v_expectativas,
                    $v_metas, 
                    $v_medio_hv, 
                    $v_condicion_laboral, 
                    $v_concepto_final, 
                    $v_observacion,
                    $v_referencia
                )
            );
            return;
            break;
            case 'update-conceptos-confiabilidad':
                //print_r($registros);
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    //print_r($v_registros)
                    CtrVivConceptoProfesional::update_confiabilidad(
                        $v_registros
                    )
                );
                return;
                break;

        case 'update_concepto_vsa':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivConceptoProfesional::update_vsa(
                    $router->param('id_concepto'),
                    $v_pregunta_uno,
                    $v_pregunta_dos, 
                    $v_pregunta_tres, 
                    $v_otro_dos, 
                    $v_otro_tres, 
                    $v_asociado_confiable,
                    $v_requisito,
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
