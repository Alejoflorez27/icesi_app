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
            echo json_encode(CtrSolFamiliar::findByIdFamilia($router->param('id_familia')));
            return;
            break;

        case 'teletrabajo_by_id':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolFamiliar::findByIdFamiliaTeletrabajo($router->param('id_familia')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolFamiliar::findAll());
            return;
            break;
        case 'descripcion':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolFamiliar::descripcionFamiliarCandidato($router->param('id_solicitud')));
            return;
            break;
        case 'descripcion_visitas':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolFamiliar::descripcionFamiliar($router->param('id_solicitud')));
            return;
            break;
        case 'descripcion_visita_teletrabajo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolFamiliar::descripcionFamiliarTeletrabajo($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;
        case 'obs_familia_visitas':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrObservaciones::observacionById($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('tipo_observacion')));
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
                CtrSolFamiliar::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_id_ciudad_act,
                    $v_parentesco,
                    $v_nombre,
                    $v_apellido,
                    $v_edad,
                    $v_estado_civil,
                    $v_nivel_escolar,
                    $v_ocupacion,
                    $v_empresa,
                    $v_viv_candidato,
                    $v_depende_candidato,
                    $v_telefono,
                    $v_residencia
                )
            );
            return;
            break;

        case 'crear_familia_vi':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolFamiliar::crearVisitaIngreso(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_id_ciudad_act,
                    $v_parentesco,
                    $v_nombre,
                    $v_apellido,
                    $v_edad,
                    $v_estado_civil,
                    $v_nivel_escolar,
                    $v_ocupacion,
                    $v_empresa,
                    $v_viv_candidato,
                    $v_depende_candidato,
                    $v_telefono,
                    $v_horario,
                    $v_identificacion
                )
            );
            return;
            break;

            case 'crear_obs_familia_vi':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrObservaciones::crear(
                        $v_id_solicitud,
                        $v_id_servicio,
                        $v_tipo_observacion,
                        $v_observacion

                    )
                );
                return;
                break;

            case 'crear_familia_vm':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrSolFamiliar::crearVisitaMantenimiento(
                        $v_id_solicitud,
                        $v_id_servicio,
                        $v_id_ciudad_act,
                        $v_parentesco,
                        $v_nombre,
                        $v_apellido,
                        $v_edad,
                        $v_estado_civil,
                        $v_nivel_escolar,
                        $v_ocupacion,
                        $v_viv_candidato,
                        $v_depende_candidato,
                        $v_telefono,
                        $v_identificacion
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
        case 'delete_familia':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolFamiliar::delete(
                    $router->param('id_familia'),
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
        case 'update_familia':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolFamiliar::update(
                    $router->param('id_familia'),
                    $v_id_ciudad_act,
                    $v_parentesco,
                    $v_nombre,
                    $v_apellido,
                    $v_edad,
                    $v_estado_civil,
                    $v_nivel_escolar,
                    $v_ocupacion,
                    $v_empresa,
                    $v_viv_candidato,
                    $v_depende_candidato,
                    $v_telefono,
                    $v_residencia,
                    $v_identificacion
                )
            );
            return;
            break;

        case 'update_familia_teletrabajo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolFamiliar::update_teletrabajo(
                    $router->param('id_familia'),
                    $v_parentesco,
                    $v_nombre,
                    $v_apellido,
                    $v_edad,
                    $v_nivel_escolar,
                    $v_ocupacion,
                    $v_depende_candidato,
                    $v_horario,
                    $v_identificacion

                )
            );
            return;
            break;

        case 'update_obs_familia_vi':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrObservaciones::update(
                    $v_id_observacion,
                    $v_observacion

                )
            );
            return;
            break;

        case 'update_familia_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolFamiliar::update_pol_pre(
                    $router->param('id_familia'),
                    $v_id_ciudad_act,
                    $v_parentesco,
                    $v_nombre,
                    $v_apellido,
                    $v_edad,
                    //$v_estado_civil,
                    //$v_nivel_escolar,
                    $v_ocupacion,
                    //$v_viv_candidato,
                    //$v_depende_candidato
                )
            );
            return;
            break;

            case 'update_familia_pol_rutina':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrSolFamiliar::update_pol_rutina(
                        $router->param('id_familia'),
                        $v_id_ciudad_act,
                        $v_parentesco,
                        $v_nombre,
                        $v_apellido,
                        $v_edad,
                        $v_estado_civil,
                        $v_nivel_escolar,
                        $v_ocupacion,
                        $v_viv_candidato,
                        $v_depende_candidato
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

