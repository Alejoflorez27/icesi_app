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
            echo json_encode(CtrTrcEmpresa::findById($router->param('id_empresa')));
            return;
            break;

        case 'especificacion_sol':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcEmpresa::findByIdEspecificacion($router->param('id_solicitud')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcEmpresa::findAll($router->param('estado') ? $router->param('estado') : '-1'));
            return;
            break;

        case 'empresa-padre-lista-by':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcEmpresa::empresaPadreListaBy($router->param('estado') ? $router->param('estado') : '-1', $router->param('id_empresa')));
            return;
            break;

        case 'empresa-padre-lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcEmpresa::empresaPadreLista($router->param('estado') ? $router->param('estado') : '-1'));
            return;
            break;

        case 'empresa-padre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcEmpresa::findAllEmpresaPadre($router->param('estado') ? $router->param('estado') : '-1'));
            return;
            break;

        case 'subempresa':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcEmpresa::findSubEmpresas($router->param('subEempresa')));
            return;
            break;

        case 'empresausr':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcEmpresa::findSubEmpresasUsr($router->param('IdEmpresa')));
            return;
            break;

        case 'empresas-usuario':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcEmpresa::findEmpresasByUsuario($router->param('username')));
            return;
            break;
        
        case 'empresas-all':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(CtrTrcEmpresa::findSubEmpresasAll($router->param('IdEmpresa')));
                return;
                break;    

        case 'tercero':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcEmpresa::findTerceros($router->param('empresa')));
            return;
            break;

        case 'responsable':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcEmpresa::findResponsables($router->param('empresa')));
            return;
            break;

            case 'todas':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcEmpresa::findAllEmpresas());
            return;
            break;


        case 'subempresa-padre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcEmpresa::findByIdPadre($router->param('cliente')));
            return;
            break;

        case 'list_auto_bash':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrTrcEmpresa::findByAutoXempre($router->param('id_empresa')));
            return;
            break; 

        case 'all_auto_bash':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrTrcEmpresa::findAutoXempre());
            return;
            break;  

        case 'imprimir-pdf-bash':
            //header("Content-Type: application/json; charset=UTF-8");
            //http_response_code(200); //cambio para el llamado de cualquier reporte
            //print_r($router->param('id_auto'));
            $pru = "Ctr".$router->param('rI');  
            $pru::informe_bash($router->param('id_empresa'), $router->param('id_auto'));
            //'Ctr'.$pru::imprimir($router->param('id_solicitud'), $router->param('id_servicio'));
            return;
            break;


        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado".$recurso));
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch (strtolower($recurso)) {
            case '':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
            //print_r($_POST);
                 echo json_encode(
                    CtrTrcEmpresa::crear(
                    )
                );  
                return;
                break;
            case "editar":
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
              //  print_r($_POST);
              ///  print_r($_FILES);
                echo json_encode(
                    CtrTrcEmpresa::update( )
                );  
                return;
                break;


            case "sub-empresa":
                    header("Content-Type: application/json; charset=UTF-8");
                    http_response_code(200);
                  //  print_r($_POST);
                  ///  print_r($_FILES);
                    echo json_encode(
                        CtrTrcEmpresa::crearSubEmp()
                    );  
                    return;
                    break;    
            case 'usrxemp':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrTrcEmpresa::crearUsuario($router->param('id_empresa'),
                        $v_username,
                        $v_id_empresa,
                        $v_email,
                        $v_password,
                        $v_nombres,
                        $v_apellidos,
                        $v_tipo_identificacion,
                        $v_numero_identificacion,
                        $v_perfil,
                        $v_cargo,
                        $v_bandera_bash,
                        $v_empresas
                    ));
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
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {

    switch (strtolower($recurso)) {
        case 'activar':
        case 'inactivar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrTrcEmpresa::update_state(
                    $router->param('id'),
                    strtolower($recurso) == 'activar' ? 'A' : 'I'
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

        case "ACTIVAR":
        case "INACTIVAR":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $nuevo_estado = strtoupper(substr($router->get(3), 0, 1));
            $resp_empresa = CtrTrcEmpresa::cambiarEstado($v_id, $nuevo_estado);
            echo json_encode($resp_empresa);
            return;
            break;

        case "":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
        //  print_r($_POST);
          ///  print_r($_FILES);
        
           echo json_encode(
                CtrTrcEmpresa::update(
                    $v_id_empresa,
                    $v_razon_social,
                    $v_rep_legal,
                    $v_tipo_id,
                    $v_numero_doc,
                    $v_id_ciudad,
                    $v_email_emp,
                    $v_flag_subemp,
                    $v_flag_grup
                )
            ); 
            return;
            break;

        case 'cambio-estado':

            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

           /* if ($v_estado == 1) {
                $v_estado_nuevo = 0;
            } else {
                $v_estado_nuevo = 1;
            } */

            echo json_encode(CtrTrcEmpresa::cambiarEstado($router->param('id_empresa'), $v_estado));
            return;
            break;

            case 'cambio-estado-usuario':

                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
    
              /*  if ($v_estado_usr == 'ACT') {
                    $v_estado_nuevo = 'INA';
                } else {
                    $v_estado_nuevo = 'ACT';
                }*/
    
                echo json_encode(CtrTrcEmpresa::cambiarEstadoUsuario($router->param('username'), $v_estado_usr));
                return;
                break;

            case "especificacion":
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrTrcEmpresa::especificacion($router->param('id_empresa'),$v_especificacion)
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
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    switch (strtolower($recurso)) {

        case 'delete_adjunto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrTrcEmpresa::deleteFoto(
                    $router->param('id_empresa'),
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
