<?php

$recurso = $router->get(3);

$permitidos_sin_login = array("imprimir-pdf","mostrar_adjuntos"); //end-points permitidos sin login

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
            echo json_encode(CtrSrvServicio::findById($router->param('id_solicitud')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            $expected_filters = ['fecha_desde', 'fecha_hasta', 'cliente', 'estado', 'combo', 'subempresa'];
            $filter = array();
            foreach ($expected_filters as $f) {
                $filter[$f] = ($router->param($f) === false || $router->param($f) == '') ? '' : $router->param($f);
            }

            echo json_encode(CtrSolSolicitud::findWithFilter($filter));
            return;
            break;

        case 'listas':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::consultarTodos());
            return;
            break;

        case 'servicios-anteriores':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::serviciosAnteriores($router->param('candidato'), $router->param('cliente')));
            return;
            break;

        case 'solicitud-servicios':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::solicitudServicios($router->param('id_solicitud')));
            return;
            break;

        case 'solicitud-editar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::consultaSolicitudEditar($router->param('id_solicitud')));
            return;
            break;

        case 'imprimir-pdf':
            //header("Content-Type: application/json; charset=UTF-8");
            //http_response_code(200); //cambio para el llamado de cualquier reporte
            $pru = "Ctr".$router->param('rI');  
            $pru::informe($router->param('id_sl'), $router->param('id_sv'), $router->param('id_combo'));
            //'Ctr'.$pru::imprimir($router->param('id_solicitud'), $router->param('id_servicio'));
            return;
            break;

        case 'mostrar_adjuntos':
            $rutaArchivo = $router->param('imagen');
            CtrSolAdjuntos::mostrarArchivo($rutaArchivo);
            return;
            break;

        case 'consultar-subempresa':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcEmpresa::findById($router->param('id_empresa')));
            return;
            break;
            
        case 'consultar-val-adicional':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolSolicitudServicio::findByIdValorAdicional($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        case 'consulta-srv_evaluado':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolSolicitud::ExiteServicioEvaluado($router->param('doc_candidato')));
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
                CtrSolSolicitud::crear()
            );
            return;
            break;

            case 'agregar-servicios':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitudServicio::agregar()
            );
            return;
            break;

        case 'actualizar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitud::update(
                    $router->param('id_solicitud'),
                    $v_doc_candidato,
                    $v_observacion,
                    $v_pais_edit,
                    $v_departamento_edit,
                    $v_id_ciudad_act
                    //$v_localidad
                )
            );
            return;
            break;


        case 'actualizar-candidato':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolCandidato::update(
                    $router->param('id_candidato'),
                    $v_tipo_id,
                    $v_numero_doc,
                    $v_nombre,
                    $v_apellido,
                    $v_id_ciudad_act,
                    $v_localidad,
                    $v_email,
                    $v_telefono,
                    $v_direccion,
                    $v_cargo
                )
            );
            return;
            break;

            // case 'valor-adicional':
            //     header("Content-Type: application/json; charset=UTF-8");
            //     http_response_code(200);
            //     echo json_encode(
            //         CtrSolSolicitud::valorAdicional($router->param('id_solicitud'), $v_observacion, $v_valor)
            //     );
            //     return;
            //     break;

        case 'preliminar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitud::preliminar(
                    $router->param('id_solicitud')
                )
            );
            return;
            break;

        case 'cargue':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolSolicitud::importFile($router->param('cliente'), $router->param('subempresa'), $router->param('tercero'), $router->param('responsable')));
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

            if ($router->param('id_solicitud') != $v_id_solicitud) {
                echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
                return;
                break;
            }

            echo json_encode(CtrSolSolicitud::delete($router->param('id_solicitud')));
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
        case 'cambio-estado':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            if ($v_estado == 1) {
                $v_estado_nuevo = 0;
            } else {
                $v_estado_nuevo = 1;
            }

            echo json_encode(CtrSolSolicitud::cambiarEstado($router->param('id_solicitud'), $v_estado_nuevo, $v_motivo_inactivo));
            return;
            break;

        case 'cancelar-solicitud':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            echo json_encode(CtrSolSolicitud::cancelarSolicitud($router->param('id_solicitud'), $v_motivo_cancelacion));
            return;
            break;

        case 'reenviar-correo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            echo json_encode(CtrSolSolicitud::reenviarCorreo($router->param('id_solicitud')));
            return;
            break;
        case 'estado_proceso':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolSolicitudServicio::estado_proceso($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('estado'), $router->param('estado_proceso')));
            return;
            break;

        case 'estado_proceso_asesor':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolSolicitudServicio::estado_proceso_asesor($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('estado'), $router->param('estado_proceso')));
            return;
            break;

        case 'asignar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolSolicitudServicio::asignar($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('prestador')));
            return;
            break;

        case 'programar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitudServicio::programar($router->param('id_solicitud'), $router->param('id_servicio'), strtolower($router->param('fecha_programacion')))
            );
            return;
            break;

        case 'asistencia':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitudServicio::asistencia($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('asistio'), $router->param('observacion_asistio'))
            );
            return;
            break;

        case 'proceso':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitudServicio::proceso($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('cont_proceso'))
            );
            return;
            break;

        case 'observacion':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitudServicio::observacion($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('observacion'))
            );
            return;
            break;

        case 'mensaje':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitudServicio::mensaje($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('para'), $router->param('mensaje'), $router->param('perfil_campo'),$router->param('origen'))
            );
            return;
            break;

        case 'finalizar-servicio':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitudServicio::finalizar($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('estado'), $router->param('mensaje'))
            );
            return;
            break;

        case 'cancelar-servicio':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitudServicio::cancelar($router->param('solicitud'), $router->param('servicio'),  $router->param('motivo'))
            );
            return;
            break;
        case 'cancelar-asignacion':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitudServicio::cancelarAsignacion($router->param('solicitud'), $router->param('servicio'))
            );
            return;
            break;

        case 'valor-adicional':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitudServicio::valorAdicional($router->param('id'), $router->param('solicitud'), $router->param('servicio'),  $router->param('valor_adicional'), $router->param('observacion'))
            );
            return;
            break;

        case 'calificar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitudServicio::calificar($router->param('solicitud'), $router->param('servicio'), $v_1, $v_2, $v_3, $v_4)
            );
            return;
            break;
        case 'actualizar_obs_calidad':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitud::updateCalidad(
                    $router->param('id_solicitud'),
                    $v_obs_calidad,
                    $v_concepto_final
                )
            );
            return;
            break;

        case 'actualizar_centro_costo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitud::updateCentroCosto(
                    $router->param('id_solicitud'),
                    $v_centro_costo
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
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {

    switch (strtolower($recurso)) {
        case 'publicar':
        case 'gestionar':
        case 'finalizar':
        case 'cancelar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $estado = array(
                'publicar' => 'pendiente',
                'gestionar' => 'gestion',
                'finalizar' => 'finalizada',
                'cancelar' => 'cancelada'
            );
            echo json_encode(
                CtrSolSolicitud::update_state(
                    $router->param('solicitud'),
                    $router->param('cliente'),
                    $estado[strtolower($recurso)]
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
