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
        /*case '':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivCaracteristicas::findById($router->param('id_caracteristica')));
            return;
            break;
        */
        /*case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivCaracteristicas::findAll($router->param('id_solicitud'),$router->param('id_servicio')));
            return;
            break;
        */
        /*case 'listasaspectosfisicos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivCaracteristicas::consultarTodos());
            return;
            break;
        */

        case 'listacomboservicio':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrPreguntaSaludPolPre::findAllByCombo($router->param('categoria'), $router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        case 'id_aspecto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrPreguntaSaludPolPre::findAByAspecto($router->param('categoria'),$router->param('codigo'), $router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        case 'obs_salud_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrObservaciones::observacionById($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('tipo_observacion')));
            return;
            break;

        case 'obs_salud_pol_pre_cursos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrObservaciones::observacionCursosById($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('tipo_observacion'), $router->param('tipo_observacion1'), $router->param('tipo_observacion2'), $router->param('tipo_observacion3')));
            return;
            break;
        case 'obs_salud_pol_pre_cursos_rutina':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrObservaciones::observacionCursosByIdRutina($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('tipo_observacion'), $router->param('tipo_observacion1'), $router->param('tipo_observacion2'), $router->param('tipo_observacion3')));
            return;
            break;

        case 'obs_licor_sustancias_pol_rutina':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrObservaciones::observacionSustanciaLicorById($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('tipo_observacion'), $router->param('tipo_observacion_sustancias')));
            return;
            break;

        /*case 'lista_combo_aspecto_fisico':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivCaracteristicas::findAllByComboAspectoFisico($router->param('id_caracteristica'), $router->param('p_aspecto')));
            return;
            break;
        */
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

        case 'crear_obs_salud_pol_pre':
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

        case 'crear_obs_admitio_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrObservaciones::crearAdmitio(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_observacion,
                    $v_observacion,
                    $v_item_poligrafia,
                    $v_admitio,
                    $v_resumen,
                    $v_item_poligrafia_sustancias, 
                    $v_admitio_sustancias,
                    $v_resumen_sustancias,

                )
            );
            return;
            break;

        case 'crear_obs_admitio_cursos_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrObservaciones::crearAdmitioCursos(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_observacion,
                    $v_observacion,
                    $v_item_poligrafia,
                    $v_admitio,
                    $v_resumen,
                    $v_item_poligrafia_sustancias, 
                    $v_admitio_sustancias,
                    $v_resumen_sustancias,
                    $v_tipo_observacion1,
                    $v_cursos,
                    $v_tipo_observacion2,
                    $v_edu_no_formal,
                )
            );
            return;
            break;

        case 'crear_obs_admitio_licor_sustancias_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrObservaciones::crearAdmitioLicorSustanciasRutina(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_observacion,
                    $v_observacion,
                    $v_tipo_observacion_sustancias,
                    $v_observacion_sustancias,
                    $v_item_poligrafia,
                    $v_admitio,
                    $v_resumen,
                    $v_item_poligrafia_sustancias, 
                    $v_admitio_sustancias,
                    $v_resumen_sustancias,
                )
            );
            return;
            break;
        case 'aspectos-agregar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrPreguntaSaludPolPre::crear(
                    $v_id_solicitud,
                    $v_id_servicio,  
                    $v_id_caracteristica_tipo,
                    $v_categoria,
                    $v_descripcion, 
                    $v_opcion,
                    $v_id_pregunta
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
                CtrPreguntaSaludPolPre::delete(
                    $router->param('id_preg_salud_pol'),
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

        case 'update_obs_salud_pol_pre':
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

        case 'update_obs_admitio_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrObservaciones::updateAdmitio(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_id_observacion,
                    $v_observacion,
                    $v_item_poligrafia,
                    $v_admitio,
                    $v_resumen,

                )
            );
            return;
            break;
            case 'update_obs_admitio_cursos_pol_pre':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrObservaciones::updateAdmitioCursos(
                        $v_id_solicitud,
                        $v_id_servicio,
                        $v_id_observacion,
                        $v_observacion,
                        $v_item_poligrafia,
                        $v_admitio,
                        $v_resumen,
                        $v_id_observacion2,
                        $v_tipo_observacion1,
                        $v_cursos,
                        $v_id_observacion3,
                        $v_tipo_observacion2,
                        $v_edu_no_formal,
                    )
                );
                return;
                break;
            case 'update_obs_admitio_alcohol_sustancias_pol_rutina':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrObservaciones::updateAdmitioAlcoholSustancias(
                        $v_id_solicitud,
                        $v_id_servicio,
                        $v_id_observacion,
                        $v_observacion,
                        $v_id_observacion_sustancias,
                        $v_observacion_sustancias,
                        $v_item_poligrafia,
                        $v_admitio,
                        $v_resumen,
                        $v_item_poligrafia_sustancias,
                        $v_admitio_sustancias,
                        $v_resumen_sustancias
    
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
