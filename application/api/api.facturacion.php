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
            echo json_encode(CtrFtFacturacion::findById($router->param('factura')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrFtFacturacion::findAll($router->param('cliente')));
            return;
            break;

        case 'pendiente-cliente':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $usuario = CtrUsuario::getUsuarioApp();
            $respuesta_usr = CtrUsuario::consultar($usuario);
            $empresa = $respuesta_usr['id_empresa'];

            echo json_encode(CtrFtFacturacion::prefacturasXAprobar($empresa));
            return;
            break;

        case 'info':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            echo json_encode(CtrFtFacturacion::infoFactura($id));
            return;
            break;

        case 'factura-info':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            echo json_encode(CtrFtFacturacion::factura($router->param('id')));
            return;
            break;

        case 'facturas':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            $usuario = CtrUsuario::getUsuarioApp();
            $respuesta_usr = CtrUsuario::consultar($usuario);
            $empresa = $respuesta_usr['id_empresa'];

            $expected_filters = ['cliente'];
            $filter = array();
            foreach ($expected_filters as $f) {
                $filter[$f] = ($router->param($f) === false || $router->param($f) == '') ? '' : $router->param($f);
            }

            echo json_encode(CtrFtFacturacion::facturas($filter, $empresa));
            return;
            break;

        case 'factura-detalle':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            echo json_encode(CtrFtFacturacion::facturaDetalle($router->param('factura'),$router->param('destino')));
            return;
            break;

        case 'factura-detalle-info':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            echo json_encode(CtrFtFacturacion::facturaDetalleBySolicitud($router->param('factura'), $router->param('solicitud')));
            return;
            break;

        case 'enviar-cliente':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            echo json_encode(CtrFtFacturacion::enviarCliente($router->param('id_factura')));
            return;
            break;


        case 'por-facturar-proveedor':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrFtFacturacion::proveedorLista($router->param('cliente') ? $router->param('cliente') : '-1'));
            return;
            break;


        case 'export':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrFtFacturacion::export());
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
                CtrFtFacturacion::new(
                    $v_cliente,
                    $v_valor_neto,
                    $v_solicitudes
                )
            );
            return;
            break;


        case 'proveedor':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrFtFacturacion::newProveedor(
                    $v_proveedor,
                    $v_valor_neto,
                    $v_ids,
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
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    switch (strtolower($recurso)) {
        case 'aprobar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrFtFacturacion::aprobar($router->param('id_factura'), $v_solicitudes, $v_motivo)
            );
            return;
            break;

        case 'rechazar-factura':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrFtFacturacion::rechazar($router->param('id_factura'), $v_motivo_rechazo)
            );
            return;
            break;

        case 'facturar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrFtFacturacion::facturar($router->param('id_factura'), $v_valor_neto,  $v_solicitudes, $v_motivo)
            );
            return;
            break;

        case 'facturar-proveedor':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrFtFacturacion::facturarProveedor($router->param('factura'), $v_valor_neto,  $v_servicios)
            );
            return;
            break;

        case 'actualiza-factura':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrFtFacturacion::actualizarFactura($router->param('id'), $v_numero_factura_contable)
            );
            return;
            break;

        case 'actualizar-valor':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrFtFacturacion::actualizarValorFactura($router->param('factura'), $router->param('id_solicitud'), $v_valor, $v_observacion, $v_id_servicio)
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
