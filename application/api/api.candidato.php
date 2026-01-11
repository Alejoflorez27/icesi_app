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
            echo json_encode(CtrSrvServicio::findById($router->param('id_solicitud')));
            return;
            break;

        case 'candidato':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolCandidato::findById_candidato($router->param('id_solicitud')));
            return;
            break;
        case 'candidato_visitas':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolCandidato::findById_candidato_vistas($router->param('id_candidato')));
            return;
            break;

        case 'candidato_ec_con_cifin':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolCandidato::findById_candidato_ec_con_cifin($router->param('id_candidato')));
            return;
            break;

        case 'candidato_poligrafia':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolCandidato::findById_candidato_poligrafia($router->param('id_candidato')));
            return;
            break;

        case 'candidato_visita_asociado':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolCandidato::findById_candidato_visita_asociado($router->param('id_solicitud')));
            return;
            break;

    /*    case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolSolicitud::findAll(
                $router->param('estado') ? $router->param('estado') : '-1'
            ));
            return;
            break;  */

        case 'listas':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::consultarTodos());
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

        case 'update_candidato_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolCandidato::update_candidato_pol_pre($router->param('id_candidato'))
                
            );
            return;
            break;

        case 'update_candidato_visita_asociado':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolCandidato::update_candidato_visita_asociado($router->param('id_candidato'))
                
            );
            return;
            break;
            
        case 'update_candidato_pol_rutina':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolCandidato::update_candidato_pol_rutina($router->param('id_candidato'))
                
            );
            return;
            break;

        case 'update_candidato_pol_especifico':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolCandidato::update_candidato_pol_especifico($router->param('id_candidato'))
                
            );
            return;
            break;
      /*  case '':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolSolicitud::crear(
                    $v_estado,
                    $v_id_combo,
                    $v_id_empresa,
                    $v_observacion,
                    $v_usuario,
                    $v_id_tercero
                )
            );
            return;
            break; */

        /*case 'solicitud-candidato':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolCandidato::crear(
                    $v_id_solicitud,
                    $v_id_ciudad_act,
                    $v_tipo_id,
                    $v_numero_doc,
                    $v_nombre,
                    $v_apellido,
                    $v_telefono,
                    $v_direccion,
                    $v_email
                )
            );
            return;
            break;*/

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

        case 'delete_adjunto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolCandidato::deleteFoto(
                    $router->param('id_candidato'),
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
   /*     case '':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSrvServicio::update(
                    $router->param('id_servicio'),
                    $v_id_producto,
                    $v_nom_servicio,
                    $v_estado
                )
            );
            return;
            break; */
            
        case 'update_candidato':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolCandidato::update_candidato(
                    $router->param('id_candidato'),
                    $v_id_ciudad_nac,
                    $v_id_ciudad_act,
                    $v_tipo_id,
                    $v_numero_doc,
                    $v_nombre,
                    $v_apellido,
                    $v_fch_nacimiento,
                    $v_edad,
                    $v_libreta,
                    $v_estado_civil,
                    $v_telefono,
                    $v_direccion,
                    $v_barrio,
                    $v_estracto,
                    $v_id_solicitud,
                    $v_id_ciudad_expe,
                    $v_fch_expedicion
                )
                
            );
            return;
            break;

            case 'update_candidato_visita_ingreso':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrSolCandidato::update_candidato_visita_ingreso(
                        $router->param('id_candidato'),
                        $v_id_ciudad_nac,
                        $v_id_ciudad_act,
                        $v_tipo_id,
                        $v_numero_doc,
                        $v_nombre,
                        $v_apellido,
                        $v_fch_nacimiento,
                        $v_edad,
                        $v_libreta,
                        $v_estado_civil,
                        $v_telefono,
                        $v_email,
                        $v_salario_dev,
                        $v_direccion,
                        $v_barrio,
                        $v_estracto,
                        $v_nivel_escolar,
                        $v_cargo_desempeno,
                        $v_persona_visita,
                        $v_parantesco_visita,
                        $v_id_solicitud

                    )
                    
                );
                return;
                break;

                case 'update_candidato_visita_mantenimiento':
                    header("Content-Type: application/json; charset=UTF-8");
                    http_response_code(200);
                    echo json_encode(
                        CtrSolCandidato::update_candidato_visita_mantenimiento(
                            $router->param('id_candidato'),
                            $v_id_ciudad_nac,
                            $v_id_ciudad_act,
                            $v_tipo_id,
                            $v_numero_doc,
                            $v_nombre,
                            $v_apellido,
                            $v_fch_nacimiento,
                            $v_edad,
                            $v_libreta,
                            $v_estado_civil,
                            $v_telefono,
                            $v_email,
                            $v_salario_actual,
                            $v_direccion,
                            $v_barrio,
                            $v_estracto,
                            $v_nivel_escolar,
                            $v_cargo_desempeno,
                            $v_persona_visita,
                            $v_parantesco_visita,
                            $v_id_solicitud
                        )
                        
                    );
                    return;
                    break;

                    case 'update_candidato_visita_teletrabajo':
                        header("Content-Type: application/json; charset=UTF-8");
                        http_response_code(200);
                        echo json_encode(
                            CtrSolCandidato::update_candidato_visita_teletrabajo(
                                $router->param('id_candidato'),
                                $v_id_ciudad_nac,
                                $v_id_ciudad_act,
                                $v_tipo_id,
                                $v_numero_doc,
                                $v_nombre,
                                $v_apellido,
                                $v_fch_nacimiento,
                                $v_edad,
                                $v_libreta,
                                $v_estado_civil,
                                $v_telefono,
                                $v_email,
                                $v_salario_actual,
                                $v_direccion,
                                $v_barrio,
                                $v_estracto,
                                $v_nivel_escolar,
                                $v_cargo_desempeno,
                                $v_persona_visita,
                                $v_parantesco_visita,
                                $v_id_solicitud
        
                            )
                            
                        );
                        return;
                        break;
                    case 'update_salario_antereior':
                        header("Content-Type: application/json; charset=UTF-8");
                        http_response_code(200);
                        echo json_encode(
                            CtrSolCandidato::update_salarioVM(
                                $router->param('id_candidato'),
                                $v_salario_anterior,

                            )
                            
                        );
                        return;
                        break;

                    case 'update_candidato_ec_con_cifin':
                        header("Content-Type: application/json; charset=UTF-8");
                        http_response_code(200);
                        echo json_encode(
                            CtrSolCandidato::update_candidato_ec_con_cifin(
                                $router->param('id_candidato'),
                                $v_id_ciudad_nac,
                                $v_id_ciudad_act,
                                $v_tipo_id,
                                $v_numero_doc,
                                $v_nombre,
                                $v_apellido,
                                $v_fch_nacimiento,
                                $v_edad,
                                $v_libreta,
                                $v_estado_civil,
                                $v_telefono,
                                $v_email,
                                $v_salario_dev,
                                //$v_salario_actual,
                                $v_direccion,
                                $v_barrio,
                                $v_estracto,
                                $v_nivel_escolar,
                                $v_cargo_desempeno,
                                $v_referencia_personal,
                                $v_id_solicitud
                            )
                            
                        );
                        return;
                        break;


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
