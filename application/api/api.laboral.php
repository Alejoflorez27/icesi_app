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
            echo json_encode(CtrSolLaboral::findByIdLaboral($router->param('id_laboral')));
            return;
            break;
        case 'find_by_id_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolLaboral::findByIdLaboralPolPre($router->param('id_laboral')));
            return;
            break;
        case 'trae_id_periodo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrLaboralPeriodos::findByIdLaboralPeriodo($router->param('id_laboral_periodos')));
            return;
            break;
        case 'laboral_brechas':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrLaboralBrechas::findByIdBrechas($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;
        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolLaboral::findAll());
            return;
            break;
        case 'descripcion':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolLaboral::descripcionLaboral($router->param('id_solicitud')));
            return;
            break;

        case 'descripcion_visitas':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolLaboral::descripcionLaboral_visitas($router->param('id_solicitud'),$router->param('id_servicio')));
            return; 
            break;

        case 'descripcion_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolLaboral::descripcionLaboral_pol_pre($router->param('id_solicitud')));
            return; 
            break;

        case 'descripcion_laboral_periodo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrLaboralPeriodos::descripcionLaboral_periodo($router->param('id_solicitud'), $router->param('id_servicio')));
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
                CtrSolLaboral::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_nombre_empresa,
                    $v_telefono_empresa,
                    $v_fch_ingreso,
                    $v_fch_retiro,
                    $v_cargo_ingreso,
                    $v_cargo_finalizo,
                    $v_tipo_contrato,
                    $v_jefe_inmediato,
                    $v_cargo_jefe,
                    $v_numero_jefe,
                    $v_funciones_desarrolladas,
                    $v_tipo_retiro,
                    $v_motivo_retiro,
                    $v_estado_empresa,
                    $v_tmp_total_laborado,
                    $v_horario_trabajo,
                    $v_observaciones,
                    $v_nom_funcionario_valida,
                    $v_cargo_funcionario_valida,
                    $v_concepto,
                    $v_id_ciudad_act
                )
            );
            return;
            break;

            case 'laboral_periodos':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrLaboralPeriodos::crear(
                        $v_id_solicitud,
                        $v_id_servicio,
                        $v_periodo,
                        $v_tmp_periodo,
                        $v_descripcion
                    )
                );
            return;
            break;
            case 'brechas':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrLaboralBrechas::crear(
                        $v_id_solicitud,
                        $v_id_servicio,
                        $v_pregunta_uno,
                        $v_pregunta_dos
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
        case 'delete_laboral':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolLaboral::delete(
                    $router->param('id_laboral'),
                )
            );
            return;
            break;
        case 'delete_periodo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrLaboralPeriodos::delete(
                    $router->param('id_laboral_periodos'),
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
        case 'update_laboral':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolLaboral::update(
                    $router->param('id_laboral'),
                    $v_nombre_empresa,
                    $v_telefono_empresa,
                    $v_fch_ingreso,
                    $v_fch_retiro,
                    $v_cargo_ingreso,
                    $v_cargo_finalizo,
                    $v_tipo_contrato,
                    $v_jefe_inmediato,
                    $v_cargo_jefe,
                    $v_numero_jefe,
                    $v_funciones_desarrolladas,
                    $v_tipo_retiro,
                )
            );
            return;
            break;

        case 'update_laboral_visita_ingreso':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolLaboral::update_visita_ingreso(
                    $router->param('id_laboral'),
                    $v_nombre_empresa,
                    $v_telefono_empresa,
                    $v_fch_ingreso,
                    $v_fch_retiro,
                    $v_cargo_finalizo,
                    $v_tipo_contrato,
                    $v_jefe_inmediato,
                    $v_cargo_jefe,
                    $v_numero_jefe,
                    $v_tipo_retiro,
                    $v_motivo_retiro,
                )
            );
            return;
            break;

        case 'update_laboral_ver_laboral':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolLaboral::update_ver_laboral(
                    $router->param('id_laboral'),
                    $v_nombre_empresa,
                    $v_telefono_empresa,
                    $v_fch_ingreso,
                    $v_fch_retiro,
                    $v_cargo_ingreso,
                    $v_cargo_finalizo,
                    $v_tipo_contrato,
                    $v_jefe_inmediato,
                    $v_cargo_jefe,
                    $v_numero_jefe,
                    $v_funciones_desarrolladas,
                    $v_tipo_retiro,
                    $v_estado_empresa,
                    $v_tmp_total_laborado,
                    $v_horario_trabajo,
                    $v_observaciones,
                    $v_nom_funcionario_valida,
                    $v_cargo_funcionario_valida,
                    $v_concepto
                )
            );
            return;
            break;

            case 'update_laboral_pol_pre':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrSolLaboral::update_pol_pre(
                        $router->param('id_laboral'),
                        $v_nombre_empresa,
                        $v_fch_ingreso,
                        $v_fch_retiro,
                        $v_cargo_ingreso,
                        $v_cargo_finalizo,
                        $v_funciones_desarrolladas,
                        $v_tipo_retiro,
                        $v_motivo_retiro,
                        $v_tmp_total_laborado,
                        $v_observaciones,
                        $v_id_ciudad_act
                    )
                );
                return;
                break;
            case 'update_laboral_pol_rutina':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrSolLaboral::update_pol_rutina(
                        $router->param('id_laboral'),
                        $v_nombre_empresa,
                        $v_fch_ingreso,
                        $v_cargo_ingreso,
                        $v_cargo_finalizo,
                        $v_funciones_desarrolladas,
                        $v_tmp_total_laborado,
                        $v_observaciones,
                        $v_id_ciudad_act
                    )
                );
                return;
                break;
            case 'update_laboral_periodos':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrLaboralPeriodos::update(
                        $router->param('id_laboral_periodos'),
                        $v_periodo,
                        $v_tmp_periodo,
                        $v_descripcion
                    )
                );
            return;
            break;
            case 'update_laboral_brechas':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrLaboralBrechas::update(
                        $router->param('id_laboral_brechas'),
                        $v_pregunta_uno,
                        $v_pregunta_dos
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
