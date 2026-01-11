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

        case 'marihuana_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrPreguntaMarihuanaPolPre::alcoholPolPreById($router->param('id_solicitud'), $router->param('id_servicio')));
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

        case 'crear_marihuana_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrPreguntaMarihuanaPolPre::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_pregunta_uno,
                    $v_pregunta_dos,
                    $v_pregunta_tres,
                    $v_pregunta_cuatro,
                    $v_pregunta_cinco,
                    $v_pregunta_seis

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

        case 'update_marihuana_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrPreguntaMarihuanaPolPre::update(
                    $v_id_preg_marihuana_pol,
                    $v_pregunta_uno,
                    $v_pregunta_dos,
                    $v_pregunta_tres,
                    $v_pregunta_cuatro,
                    $v_pregunta_cinco,
                    $v_pregunta_seis


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
