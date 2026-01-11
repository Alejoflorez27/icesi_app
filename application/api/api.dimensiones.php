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
            echo json_encode(CtrDimRespuestas::findByIdDimRespuesta($router->param('id_respuesta')));
            return;
            break;
        case 'variables_dimensiones':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::findAllVariables($router->param('id_servicio'), $router->param('id_dimension')));
            return;
            break;

        case 'variables_dimensiones_rutina':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::findAllVariablesRutina($router->param('id_servicio'), $router->param('id_dimension')));
            return;
            break;
        case 'v_mantenimiento_familia':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::findAllVariableDescripcionVM($router->param('id_pregunta')));
            return;
            break;
        case 'variables_financiero_ec':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::findAllVariablesFinancieroEC($router->param('id_respuesta')));
            return;
            break;
        case 'variables_compromiso_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::findAllVariablesCompromisoPolPre($router->param('id_respuesta')));
            return;
            break;
        case 'descripcion':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::descripcionDimension($router->param('id_solicitud'), $router->param('id_dimension'), $router->param('id_servicio')));
            return;
            break;
        case 'descripcion_estudio_confiabilidad':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::descripcionDimensionEstudioConfiabilidad($router->param('id_solicitud'), $router->param('id_dimension'), $router->param('id_servicio')));
            return;
            break;
        case 'descripcion_by_antecedentes':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::descripcionDimensionByPreguntaAntecedentes($router->param('id_solicitud'), $router->param('id_dimension'), $router->param('id_servicio'), $router->param('id_pregunta')));
            return;
            break;
        case 'descripcion_compromiso':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::descripcionCompromisodimensionPolPre($router->param('id_solicitud'), $router->param('id_dimension'), $router->param('id_servicio')));
            return;
            break;
        case 'descripcion_texto_antecedente':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::descripcionTextoAntecedente($router->param('id_solicitud'), $router->param('id_pre_fuente'), $router->param('id_servicio')));
            return;
            break;
        case 'validar_variable':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::ExiteVariable($router->param('id_pregunta'), $router->param('id_solicitud')));
            return;
            break;
        case 'validar_variable_ec':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::ExiteVariableEC($router->param('id_pregunta'), $router->param('id_solicitud')));
            return;
            break;
        case 'validar_variable_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::ExiteVariablePolPre($router->param('id_pregunta'), $router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;
        case 'evaluacion_dimension':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimRespuestas::PorcentajeDimensionConcepto($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('id_dimension')));
            return;
            break;
        case 'trae_dim_concepto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimConceptoFinal::DimConceptoById($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('id_dimension')));
            return;
            break;

        case 'validacion_dim_concepto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrDimConceptoFinal::DimConceptoValidacion($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        case 'trae_pre_fuente_consultada':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrPreFuenteConsultada::VariablesFuenteConsulta($router->param('id_pregunta')));
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
                CtrDimRespuestas::crear(
                    $v_id_pregunta,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_nivel_riesgo,
                    $v_respuesta,
                )
            );
            return;
            break;
        case 'crear_dim_compromiso':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrDimRespuestas::crearDimCompromiso(
                    $v_id_pregunta,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_nivel_riesgo,
                    $v_respuesta,
                )
            );
            return;
            break;

        case 'crear_array_antecedentes':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrDimRespuestas::crearAntecedentesArray(
                    $v_id_pregunta,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_nivel_riesgo,
                    $v_respuesta,
                    $v_array_area,
                )
            );
            return;
            break;
        case 'dim_antecedentes':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrDimRespuestas::crearAntecedentes(
                    $v_id_pre_fuente,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_p_fecha,
                    $v_p_nombre,
                    $v_p_numcupo,
                    $v_p_fecha_eps,
                    $v_p_nom_eps,
                    $v_p_tipo_eps,
                    $v_p_seleccion,
                    $v_p_fecha_runt,
                    $v_p_nombre_cand_runt,
                    $v_p_numcupo_runt,
                    $v_p_categoria,
                    $v_p_estado,
                    $v_p_num_libreta,
                )
            );
            return;
            break;

        case 'dimconceptofinal':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrDimConceptoFinal::crear(
                    $v_id_solicitud, 
                    $v_id_servicio, 
                    $v_id_dimension,  
                    $v_observacion,
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
        case '':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrDimRespuestas::delete(
                    $router->param('id_respuesta'),
                )
            );
            return;
            break;
        case 'delete_compromiso':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrDimRespuestas::deleteCompromiso(
                    $router->param('id_respuesta'),
                    $v_id_pregunta,
                    $v_id_solicitud,
                    $v_id_servicio,
                )
            );
            return;
            break;
        case 'delete_doc':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrDimRespuestas::delete_doc(
                    $router->param('id_respuesta'),
                    $v_id_pregunta,
                    $v_id_solicitud,
                    $v_id_servicio,
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
        case 'update_dimensiones_familia':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrDimRespuestas::update_dimensiones_familia(
                    $router->param('id_respuesta'),
                    $v_id_pregunta,
                    $v_nivel_riesgo,
                    $v_respuesta,
                )
            );
            return;
            break;
        case 'update_dimensiones_compromiso':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrDimRespuestas::update_dim_compromiso(
                    $router->param('id_respuesta'),
                    $v_id_pregunta,
                    $v_nivel_riesgo,
                    $v_respuesta,
                    $v_id_solicitud,
                    $v_id_servicio
                )
            );
            return;
            break;
        case 'update_antecedentes_array':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrDimRespuestas::updateAntecedentesArray(
                    $router->param('id_respuesta'),
                    $v_id_pregunta,
                    $v_nivel_riesgo,
                    $v_respuesta,
                    $v_array_area,
                )
            );
            return;
            break;
        //case para guardar los textos completos
        case 'update_dimensiones_antecedentes':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrDimRespuestas::update_dimensiones_antecedentes($v_id_respuesta,
                                                                  $v_texto_completo
                )
            );
            return;
            break;

        case 'dim_antecedentes_update':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrDimRespuestas::updateAntecedentes(
                    $v_id_pre_fuente,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_p_fecha,
                    $v_p_nombre,
                    $v_p_numcupo,
                    $v_p_fecha_eps,
                    $v_p_nom_eps,
                    $v_p_tipo_eps,
                    $v_p_seleccion,
                    $v_p_fecha_runt,
                    $v_p_nombre_cand_runt,
                    $v_p_numcupo_runt,
                    $v_p_categoria,
                    $v_p_estado,
                    $v_p_num_libreta,
                )
            );
            return;
            break;

            case 'update_dimconceptofinal':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrDimConceptoFinal::update(
                        $router->param('id_dim_concepto'),
                        $v_observacion,
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
