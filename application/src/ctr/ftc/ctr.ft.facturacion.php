<?php

class CtrFtFacturacion
{

    public static function findById($factura)
    {

        if (!isset($factura) || $factura == "")
            $factura = -1;

        $result = QuerySQL::select(
            <<<SQL
                select  distinct ffd.factura, ff.*, case when ffd.destino_factura = 'C' then 
                    (select te.razon_social  from trc_empresa te
                        where te.id_empresa = ff.id_empresa)
                else 
                    (select CONCAT(uu.nombres, ' ', uu.apellidos)  from usr_usuario uu where uu.username = ff.id_empresa)
                end razon_social 
                from ft_facturacion ff , ft_facturacion_detalle ffd 
                where ff.id = ffd.factura  
                 and ff.id = :factura
            SQL,
            array("factura" => $factura),
            false,
            "S"
        );

        return Result::success($result, "Buscar Factura por Id");
    }

    public static function findAll($cliente)
    {

        if (!isset($cliente) || $cliente == "")
            $cliente = -1;

        $result = QuerySQL::select(
            <<<SQL
                select a.id_empresa, a.tipo_id, a.descripcion, a.numero_doc, a.razon_social, a.id_solicitud, a.ciudad_vacante, a.cantidad_pendiente, sum(a.valor) valor
                from ( select ss.id_empresa , te.tipo_id , c.descripcion , te.numero_doc , te.razon_social, ss.id_solicitud , ss.ciudad_vacante ,
                                case when ss.id_solicitud is not null then 
                                (select count(DISTINCT(ss1.id_solicitud)) 
                                    from sol_solicitud ss1 
                                    where ss1.id_empresa = ss.id_empresa
                                    and ss1.id_estado_solicitud = 'finalizada'
                                    and ss1.facturado = 0
                                    and ss1.estado = 1
                                    and not exists (select 'x' 
                                                from ft_facturacion_detalle ffdq
                                                        where ss1.id_solicitud = ffdq.id_solicitud
                                                        and ffdq.destino_factura = 'C'))
                                else 
                                0 end cantidad_pendiente,
                                fnc_valor_combo_cli(ss.id_empresa, ss.id_combo, ss.ciudad_vacante) + nvl(ssa.valor,0) valor
                                from sol_solicitud ss LEFT  JOIN sol_servicios_adicionales ssa  ON ss.id_solicitud = ssa.id_solicitud, trc_empresa te, configurations c                           
                                where ss.id_estado_solicitud = 'finalizada'
                                and ss.facturado = 0
                                and ss.estado = 1
                                and ss.id_empresa  = te.id_empresa 
                                and c.categoria = 'tipo_identificacion'
                                and c.codigo =  te.tipo_id 
                                and  (:cliente = nvl(te.id_empresa_padre, te.id_empresa) or :cliente = -1)
                                and not exists (select 'x' 
                                                from ft_facturacion_detalle ffd
                                                        where ss.id_solicitud = ffd.id_solicitud
                                                        and ffd.destino_factura = 'C')) a
                        GROUP by a.id_empresa, a.tipo_id, a.descripcion, a.numero_doc, a.razon_social;
            SQL,
            array("cliente" => $cliente),
            true,
            "S"
        );

        return Result::success($result, "Buscar Servicios Por Facturar");
    }

    public static function findAllPendingByClient($cliente = null, $factura = null)
    {

        if (!isset($cliente) || $cliente == "")
            $cliente = -1;

        if (!isset($factura) || $factura == "") {
            $result = QuerySQL::select(
                <<<SQL
                select ss.id_empresa , ss.id_solicitud , ss.fch_solicitud, CONCAT(sc.nombre, ' ', sc.apellido)nombre_candidato, sc.numero_doc , sc.cargo_desempeno , ss.id_combo,
                (fnc_valor_combo_cli(ss.id_empresa, ss.id_combo, ss.ciudad_vacante)+ nvl(ssa.valor,0) ) valor_combo,  (fnc_valor_combo_cli(ss.id_empresa, ss.id_combo, ss.ciudad_vacante)+ nvl(ssa.valor,0)) valor,
                'Por prefacturar' desc_estado,
                    case when nvl(ssa.valor,0) != 0 then
                        (select sum(valor) from sol_servicios_adicionales ssa2
                        where ssa2.id_solicitud = ss.id_solicitud)
                    else 
                    0 end valor_adicional,
                    fnc_valor_combo_cli(ss.id_empresa, ss.id_combo, ss.ciudad_vacante) valor_solicitud
                from sol_solicitud ss LEFT  JOIN sol_servicios_adicionales ssa  ON ss.id_solicitud = ssa.id_solicitud, sol_candidato sc 
                where ss.estado = 1
                and ss.id_solicitud  = sc.id_solicitud 
                and ss.facturado = 0
                and ss.id_estado_solicitud = 'finalizada'
                and ss.id_empresa = :cliente
                and not exists (select 'x' 
                                from ft_facturacion_detalle ffd
                                        where ss.id_solicitud = ffd.id_solicitud
                                        and ffd.destino_factura = 'C');
            SQL,
                array("cliente" => $cliente),
                true,
                "S"
            );
            return Result::success($result, "Buscar Servicios Por Facturar");
        } else {
            $result = QuerySQL::select(
                <<<SQL
                    select ff.id_empresa, ffd.id_solicitud, ss.fch_solicitud, CONCAT(sc.nombre, ' ', sc.apellido)nombre_candidato, sc.numero_doc , sc.cargo_desempeno,
                   case when nvl(ffd.estado, 1) = 2 then
                        0
                    else
                        ffd.valor
                    end valor,
                    case when nvl(ffd.estado, 1) = 2 then
                        0
                    else
                         ffd.valor 
                    end valor_combo, ffd.estado, ffd.valor valor_check, ffd.valor valor_combo_ckeck,
                    fnc_valor_combo_cli(ss.id_empresa, ss.id_combo, ss.ciudad_vacante) valor_solicitud,
                    case when nvl(ssa.valor,0) != 0 then
                        (select sum(valor) from sol_servicios_adicionales ssa2
                        where ssa2.id_solicitud = ss.id_solicitud)
                    else 
                    0 end valor_adicional
                    from ft_facturacion ff, ft_facturacion_detalle ffd LEFT JOIN sol_solicitud ss ON ffd.id_solicitud = ss.id_solicitud LEFT  JOIN sol_servicios_adicionales ssa  ON ss.id_solicitud = ssa.id_solicitud, sol_candidato sc
                    where ff.id = ffd.factura
                        and ffd.id_solicitud  = sc.id_solicitud 
                        and ff.id = :factura
                SQL,
                array("factura" => $factura),
                true,
                "S"
            );
            return Result::success($result, "Buscar Servicios Por Facturar");
        }
    }


    public static function new(
        $cliente,
        $valor_neto,
        $solicitudes = array()
    ) {
        if (!isset($cliente) || $cliente == "")
            return Result::error(__FUNCTION__, "cliente es requerido");

        if (!isset($valor_neto) || $valor_neto == "")
            return Result::error(__FUNCTION__, "valor_neto es requerido");

        if (!is_numeric($valor_neto))
            return Result::error(__FUNCTION__, "valor_neto debe ser numerico");

        if ((isset($solicitudes)) && !is_array($solicitudes))
            return Result::error(__FUNCTION__, "Solicitudes debe ser un array");



        $calc_expiration = new DateTime(date("Y-m-d"));
        $calc_expiration->add(new DateInterval('P30D'));
        $date_expiration = $calc_expiration->format('Y-m-d');
        $date_now = date("Y-m-d H:i:s");


        $dao = new FtFacturacion();
        $dao->setProperty("id_empresa", $cliente);
        $dao->setProperty("valor_neto", $valor_neto);
        $dao->setProperty("estado", -1);

        $dao->setProperty("fecha_facturacion", $date_now);
        $dao->setProperty("fecha_vencimiento", $date_expiration);

        $response =  $dao->insert();

        if ($response['success']) {

            if (!empty($solicitudes)) {
                $id = $response['id'];
                $total = 0;
                foreach ($solicitudes as $solicitud) {
                    $srv = Result::getData(CtrSolSolicitud::findById($solicitud, false));

                    $resultValor = QuerySQL::select(
                        <<<SQL
                               select fnc_valor_combo_cli(:cliente, :combo, :ciudad) valor;
                            SQL,
                        array(
                            "cliente" => $cliente,
                            "combo" => $srv['id_combo'],
                            "ciudad" => $srv['ciudad_vacante']
                        ),
                        true,
                        "N"
                    );

                    $arrayValor = json_decode(json_encode($resultValor), true);
                    $valor = $arrayValor[0]['valor'];

                    $resultValorAdd = QuerySQL::select(
                        <<<SQL
                               SELECT nvl(valor,0) valor 
                                FROM sol_servicios_adicionales ssa 
                                where ssa.id_solicitud = :id_solicitud;
                            SQL,
                        array(
                            "id_solicitud" => $srv['id_solicitud']
                        ),
                        true,
                        "N"
                    );

                    $arrayValorAdd = json_decode(json_encode($resultValorAdd), true);
                    $valorAdd = $arrayValorAdd[0]['valor'];

                    $valor_solicitud = $valor + $valorAdd;

                    $result = CtrFtFacturacionDetalle::new($id, $solicitud,  $srv['id_combo'], $valor_solicitud, 'C');
                    if (Result::isError($result)) {
                        self::delete($id);
                        return $result;
                    }
                    $total += $valor_solicitud;
                }

                if ($total != $valor_neto) {
                    self::delete($id);
                    return Result::error(__FUNCTION__, "valor_neto no coincide con el total de los servicios");
                }
            }
            if ($response['success']) {


                return Result::success($response);
            }
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $response);
        }
    }



    public static function enviarCliente($idFactura)
    {

        $dao = new FtFacturacion($idFactura);
        $dao->setProperty("estado", 0);
        $response =  $dao->update();

        if ($response['success']) {
            $correo = Result::getData(self::enviarCorreo($idFactura, 'prefactura'));
            return Result::success($correo, "Enviar Cliente");
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $response);
        }
    }



    public static function delete(
        $factura
    ) {
        if (!isset($factura) || $factura == "")
            return Result::error(__FUNCTION__, "factura es requerido");

        $servicios = Result::getData(CtrFtFacturacionDetalle::findAllByFactura($factura));

        foreach ($servicios as $servicio) {
            $result = CtrFtFacturacionDetalle::delete($factura, $servicio['id_solicitud']);
            if (Result::isError($result))
                return $result;
        }

        $dao = new FtFacturacion($factura);
        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }



    public static function prefacturasXAprobar($cliente)
    {
        if (!isset($cliente) || $cliente == "" || $cliente == 0)
            $cliente = -1;

        $result = QuerySQL::select(
            <<<SQL
                /*viejo*/
                /*select ff.id , ff.fecha_facturacion , ff.fecha_vencimiento , ff.valor_neto, ff.id_empresa, TIMESTAMPDIFF(DAY, ff.fch_create,  now()) AS dias_transcurridos, ff.estado,
                    decode(ff.estado,0,'Prefacturado', 1,'Aprobado', 2,'Rechazado',3,'Facturado', -1, 'Pendiente envío Cliente') estado_desc
                    from ft_facturacion ff , ft_facturacion_detalle ffd
                    where   case when :cliente = -1 then 
                            1 = 1
                           and  ff.estado  in (-1,0)
                        ELSE
                            ff.id_empresa  in (select te3.id_empresa
                                            from trc_empresa te3 
                                            where (:cliente = nvl(te3.id_empresa_padre, te3.id_empresa) or  :cliente = te3.id_empresa)
                                            and te3.estado = 1)
                            and  ff.estado  in (0)
                        end
                     and ff.id = ffd.factura
                     and ffd.destino_factura = 'C';*/
                    /*nuevo*/
                select DISTINCT
                ff.id, 
                ff.fecha_facturacion, 
                ff.fecha_vencimiento, 
                ff.valor_neto, 
                ff.id_empresa, 
                TIMESTAMPDIFF(DAY, ff.fch_create, now()) AS dias_transcurridos, 
                ff.estado,
                decode(ff.estado, 0, 'Prefacturado', 1, 'Aprobado', 2, 'Rechazado', 3, 'Facturado', -1, 'Pendiente envío Cliente') as estado_desc,
                te3.razon_social -- Columna que se agrega
                from 
                    ft_facturacion ff
                    join trc_empresa te3 on ff.id_empresa = te3.id_empresa -- Hacemos el join para obtener la razon_social
                    join ft_facturacion_detalle ffd on ff.id = ffd.factura
                where 
                    case 
                        when :cliente = -1 then 
                            1 = 1
                            and ff.estado in (-1, 0)
                        else
                            ff.id_empresa in (
                                select te3.id_empresa
                                from trc_empresa te3 
                                where (:cliente = nvl(te3.id_empresa_padre, te3.id_empresa) or :cliente = te3.id_empresa)
                                and te3.estado = 1
                            )
                            and ff.estado in (0)
                    end
                    and ffd.destino_factura = 'C';

        SQL,
            array("cliente" => $cliente),
            true,
            "S"
        );

        return Result::success($result, "Buscar Prefacturas por Aprobar");
    }

    public static function infoFactura($id)
    {

        $result = QuerySQL::select(
            <<<SQL
            select ff.id , ff.fecha_facturacion , ff.fecha_vencimiento , ff.valor_neto, ff.id_empresa, TIMESTAMPDIFF(DAY, ff.fch_create,  now()) AS dias_transcurridos, nvl(ff.estado,0) estado,
             decode(ff.estado,0,'Prefacturado', 1,'Aprobado', 2,'Rechazado',3,'Facturado') estado_desc
            from ft_facturacion ff 
            where (id = :id or :id = -1);
        SQL,
            array("id" => $id),
            true,
            "S"
        );

        return Result::success($result, "Buscar Prefacturas por Aprobar");
    }

    public static function facturar(
        $factura,
        $valor_neto,
        $solicitudes = array()
    ) {

        if (!isset($factura) || $factura == "")
            return Result::error(__FUNCTION__, "factura es requerido");

        foreach ($solicitudes as $solicitud) {
            $result = CtrFtFacturacionDetalle::facturar($factura, $solicitud);
            if (Result::isError($result))
                return $result;
        }


        $dao = new FtFacturacion($factura);
        $dao->setProperty("estado", 3);
        $dao->setProperty("motivo_rechazo", null);
        $dao->setProperty("valor_neto", $valor_neto);

        $result =  $dao->update();


        if ($result['success']) {
            $correo = Result::getData(self::enviarCorreo($factura, 'aprobar'));
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    public static function aprobar(
        $factura,
        $solicitudes = array(),
        $motivo = null
    ) {
        if (!isset($factura) || $factura == "")
            return Result::error(__FUNCTION__, "factura es requerido");

        // print_r($solicitudes);

        foreach ($solicitudes as $solicitud) {
            $result = CtrFtFacturacionDetalle::aprobar($factura, $solicitud);
            if (Result::isError($result))
                return $result;
        }


        $dao = new FtFacturacion($factura);
        $dao->setProperty("estado", 1);
        $dao->setProperty("motivo_rechazo", null);
        $dao->setProperty("motivo_aprobacion", $motivo);

        $result =  $dao->update();

        if ($result['success']) {
            $result = QuerySQL::update(
                <<<SQL
                update ft_facturacion_detalle 
                 set estado = 2
                where  factura = :factura
                 and estado in (0)
                 and destino_factura = 'C';
            SQL,
                array(
                    "factura" => $factura
                ),
                false,
                "N"
            );

            $correo = Result::getData(self::enviarCorreo($factura, 'aprobar'));
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    public static function rechazar($factura, $motivo_rechazo)
    {
        if (!isset($factura) || $factura == "")
            return Result::error(__FUNCTION__, "factura es requerido");

        $servicios = Result::getData(CtrFtFacturacionDetalle::findAllByFactura($factura));

        foreach ($servicios as $servicio) {
            $result = CtrFtFacturacionDetalle::rechazar($factura, $servicio['id_solicitud']);
            if (Result::isError($result))
                return $result;
        }

        $dao = new FtFacturacion($factura);
        $dao->setProperty("estado", 2);
        $dao->setProperty("motivo_rechazo", $motivo_rechazo);

        $result =  $dao->update();

        if ($result['success']) {
            $result = QuerySQL::update(
                <<<SQL
                update ft_facturacion
                  set valor_neto = (select sum(valor)
                                from ft_facturacion_detalle
                                where factura = :factura
                                and estado = 1)
                where id = :factura;
            SQL,
                array(
                    "factura" => $factura,
                ),
                false,
                "N"
            );

            $correo = Result::getData(self::enviarCorreo($factura, 'rechazo'));
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }



    public static function enviarCorreo($factura, $tipo)
    {

        $resultCorreos = QuerySQL::select(
            <<<SQL
                select te.razon_social , te.email_emp , ff.valor_neto , ff.fecha_vencimiento, ff.motivo_rechazo
                    from ft_facturacion ff,  trc_empresa te 
                    where ff.id_empresa = te.id_empresa
                    and ff.id = :factura;

        SQL,
            array(
                "factura" => $factura
            ),
            true,
            "N"
        );

        $arrayCorreos = json_decode(json_encode($resultCorreos), true);
        $cliente = $arrayCorreos[0]['razon_social'];
        $valor = $arrayCorreos[0]['valor_neto'];
        $fechaVencimiento = $arrayCorreos[0]['fecha_vencimiento'];
        $para = $arrayCorreos[0]['email_emp'];
        $motivo_rechazo = $arrayCorreos[0]['motivo_rechazo'];

        if ($tipo == 'prefactura') {
            $evento = 'la prefactura';
            $asunto = 'Prefactura para revisión';
            $motivo = '';
            $responsable = $cliente;
        } else if ($tipo == 'rechazo') {
            $evento = 'el rechazo de la factura';
            $asunto = 'Rechazo de prefactura';
            $motivo = 'Con motivo ' . $motivo_rechazo;
            $responsable = 'Facturador';
        } else {
            $evento = 'la aprobación de la factura';
            $asunto = 'Aprobación de prefactura';
            $motivo = '';
            $responsable = 'Facturador';
        }

        $mensaje = "Apreciado " . $responsable . " se acabó de realizar " . $evento . " número " . $factura . " por un valor de " . $valor . " con fecha de vencimiento " . $fechaVencimiento .
            " " . $motivo . " agradecemos su revisón";

        try {
            $mail = new MAIL($para, $asunto, $mensaje);
        } catch (Exception $e) {
            return array("success" => false, "action" => "Envío Prefactura", "code" => $e->getMessage());
        }

        try {
            $mail->send();
        } catch (Exception $e) {
            return array("success" => false, "action" => "Envío Prefactura", "code" => $mail->ErrorInfo);
        }
    }


    public static function facturas($filter = array(), $empresa)
    {
        if (!isset($filter['cliente']) || $filter['cliente'] == "")
            $filter['cliente'] = -1;

            if (!isset($empresa) || $empresa == "")
            $empresa = -1;

        $usuario = CtrUsuario::getUsuarioApp();
        $resultCount = CtrUsuario::consultar($usuario);
        $perfil = $resultCount['perfil'];

        $result = QuerySQL::select(
            <<<SQL
                select distinct ffd.factura, ff.id , ff.id_empresa  , 
                case when ffd.destino_factura = 'C' then 
                    (select te.razon_social  from trc_empresa te
                        where te.id_empresa = ff.id_empresa)
                else 
                    (select CONCAT(uu.nombres, ' ', uu.apellidos)  from usr_usuario uu where uu.username = ff.id_empresa)
                end razon_social   , ff.fecha_facturacion , ff.fecha_vencimiento , ff.valor_neto , ff.numero_factura_contable , ff.motivo_aprobacion , ff.estado,
                decode(ff.estado, -1, 'Pendiente envío Cliente', 0,'Prefacturado', 1,'Aprobado',2,'Rechazado', 3, 'Facturado') desc_estado , ffd.destino_factura, decode(ffd.destino_factura, 'P', 'Proveedor','Cliente') desc_destino_factura, $empresa As empresa_usr_connect
            from ft_facturacion ff, ft_facturacion_detalle ffd 
            where   ff.id = ffd.factura  
                and case when :empresa = -1 then 
                            case when :perfil in (1,12) then
                                 (ff.id_empresa = :cliente_proveedor or :cliente_proveedor = -1)
                            else
                                ff.id_empresa = :usuario 
                            end
                        ELSE
                            ff.id_empresa  in (select te3.id_empresa
                                            from trc_empresa te3 
                                            where (:empresa = nvl(te3.id_empresa_padre, te3.id_empresa) or  :empresa = te3.id_empresa)
                                            and te3.estado = 1)
                        end;
        SQL,
            array(
                "empresa" => $empresa,
                "usuario" => $usuario,
                "perfil" => $perfil,
                "cliente_proveedor" => $filter['cliente'],
            ),
            true,
            "S"
        );

        return Result::success($result, "Buscar Facturas Realizadas");
    }

    public static function facturaDetalle($factura, $destino)
    {

        if (!isset($factura) || $factura == "")
            $factura = -1;

        if ($destino == 'C') {

            $result = QuerySQL::select(
                <<<SQL
                select ffd.*,
                sc.nom_combo ,
                CONCAT(sc2.nombre, ' ', sc2.apellido) candidato,
                CONCAT(sc2.tipo_id , '-', sc2.numero_doc) nro_doc
                from ft_facturacion_detalle ffd , srv_combos sc, sol_candidato sc2
                where ffd.id_combo_cli = sc.id_combo 
                and ffd.id_solicitud = sc2.id_solicitud 
                    and ffd.factura = :factura
                    and ffd.destino_factura = 'C';
            SQL,
                array("factura" => $factura),
                true,
                "S"
            );
            return Result::success($result, "Buscar Factura Detalle por Id");
        } else {
            $result = QuerySQL::select(
                <<<SQL
                select ffd.id_solicitud , ss.nom_servicio , ffd.valor , ffd.observacion 
                    from ft_facturacion_detalle ffd , srv_servicios ss 
                    where factura = :factura
                    and ffd.id_servicio = ss.id_servicio 
                    and ffd.factura = :factura
                    and ffd.destino_factura = 'P';
            SQL,
                array("factura" => $factura),
                true,
                "S"
            );
            return Result::success($result, "Buscar Factura Detalle por Id");
        }
    }

    public static function facturaDetalleBySolicitud($factura, $solicitud)
    {

        if (!isset($factura) || $factura == "")
            $factura = -1;

        $result = QuerySQL::select(
            <<<SQL
                select ffd.*,
                sc.nom_combo ,
                CONCAT(sc2.nombre, ' ', sc2.apellido) candidato,
                CONCAT(sc2.tipo_id , '-', sc2.numero_doc) nro_doc,
                 case when ffd.id_servicio is not null then 
                    (select nom_servicio from srv_servicios where id_servicio = ffd.id_servicio)
                  else 
                    null   
                  end servicio
                from ft_facturacion_detalle ffd , srv_combos sc, sol_candidato sc2 
                where ffd.id_combo_cli = sc.id_combo 
                and ffd.id_solicitud = sc2.id_solicitud 
                    and ffd.factura = :factura
                    and ffd.id_solicitud = :solicitud
                    ;
            SQL,
            array(
                "factura" => $factura,
                "solicitud" => $solicitud,
            ),
            false,
            "S"
        );

        return Result::success($result, "Buscar Factura Detalle por Id");
    }

    public static function factura($id)
    {

        $result = QuerySQL::select(
            <<<SQL
            select ff.id , ff.id_empresa , case when ffd.destino_factura = 'C' then 
                    (select te.razon_social  from trc_empresa te
                        where te.id_empresa = ff.id_empresa)
                else 
                    (select CONCAT(uu.nombres, ' ', uu.apellidos)  from usr_usuario uu where uu.username = ff.id_empresa)
                end razon_social   , ff.fecha_facturacion , ff.fecha_vencimiento , ff.valor_neto , ff.numero_factura_contable , ff.motivo_aprobacion , ff.estado 
            from ft_facturacion ff, ft_facturacion_detalle ffd
            where ff.id = ffd.factura  
            and ff.id = :id ;
        SQL,
            array("id" => $id),
            false,
            "N"
        );

        return Result::success($result, "Buscar Info Factura");
    }

    public static function actualizarFactura($id, $numero_factura_contable)
    {

        $result = QuerySQL::update(
            <<<SQL
            update ft_facturacion
              set numero_factura_contable = :numero_factura_contable
            where id = :id ;
        SQL,
            array(
                "id" => $id,
                "numero_factura_contable" => $numero_factura_contable
            ),
            false,
            "N"
        );

        return Result::success($result, "Actualizar Factura");
    }

    public static function actualizarValorFactura($factura, $id_solicitud, $valor, $observacion = null, $id_servicio = null)
    {

        $result = QuerySQL::update(
            <<<SQL
            update ft_facturacion_detalle
              set valor = :valor,
                   estado = (case when destino_factura = 'C' then 
                                1
                             else 
                                estado
                             end) ,
                   observacion = :observacion 
            where factura = :factura
              and  id_solicitud = :id_solicitud
              and  case when :id_servicio is null then 
                        1 = 1
                    else 
                        id_servicio = :id_servicio
                    end ;
        SQL,
            array(
                "factura" => $factura,
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio,
                "valor" => $valor,
                "observacion" => $observacion,
            ),
            false,
            "N"
        );

        if ($result['success']) {
            $result = QuerySQL::update(
                <<<SQL
                update ft_facturacion
                  set valor_neto = (select sum(valor)
                                from ft_facturacion_detalle
                                where factura = :factura
                                and estado = (case when destino_factura = 'C' then 
                                                    1
                                              else 
                                                    estado
                                              end))
                where id = :factura;
            SQL,
                array(
                    "factura" => $factura,
                ),
                false,
                "N"
            );
        }

        return Result::success($result, "Actualizar Factura Detalle");
    }





    //////////// PROVEEDOR /////////////

    public static function proveedorLista($proveedor)
    {
        //print_r($proveedor);

        if (!isset($proveedor) || $proveedor == "")
            $proveedor = -1;

        $result = QuerySQL::select(
            <<<SQL
                 select sss.id_usuario_asig, uu.tipo_identificacion,  uu.numero_identificacion, CONCAT(uu.nombres, ' ', uu.apellidos) proveedor,
                    case when sss.id_servicio is not null then
                    sum((select count(DISTINCT(sss1.id_servicio)) 
                                                        from sol_solicitud_servicio sss1
                                                        where sss.estado = 8
                                                        and sss.estado_proceso in (6,7)
                                                        and sss.facturado = 'N'
                                                        and sss1.calificado = 'S'
                                                        and sss.id_usuario_asig = sss1.id_usuario_asig
                                                        and sss1.id = sss.id                                                        
                                                        and not exists (select 'x' 
                                                                    from ft_facturacion_detalle ffdq
                                                                            where sss1.id_solicitud = ffdq.id_solicitud
                                                                            and sss1.id_servicio = ffdq.id_servicio
                                                                            and ffdq.destino_factura = 'P'
                                                                            and ffdq.estado = 3)))
                                                    else 
                                                    0 end cantidad_pendiente,
                        sum(fnc_valor_combo_prov(sss.id_servicio , ss.ciudad_vacante) + nvl(ssa.valor,0)) valor   ,
                        nvl(ffd.factura, 0) factura , ffd.estado,
                        decode(ffd.estado, null, 'Pendiente prefacturar', 0,'Prefacturado', 1 , 'Aprobado', 2, 'Rechazado', 3,'Facturado' ) desc_estado                     
                    from sol_solicitud_servicio sss LEFT  JOIN sol_servicios_adicionales ssa  ON sss.id_solicitud = ssa.id_solicitud and sss.id_servicio = ssa.id_servicio 
                          LEFT JOIN ft_facturacion_detalle ffd  on sss.id_solicitud = ffd.id_solicitud and sss.id_servicio = ffd.id_servicio,
                         sol_solicitud ss, usr_usuario uu
                    where sss.estado = 8
                    and sss.estado_proceso in (6,7)
                    and sss.calificado = 'S'
                    and sss.facturado = 'N'
                    and (sss.id_usuario_asig = :proveedor or :proveedor = -1)
                    and sss.id_usuario_asig = uu.username
                    and ss.id_solicitud = sss.id_solicitud
                    group by 1, 8
                    order by sss.fch_create desc;
            SQL,
            array("proveedor" => $proveedor),
            true,
            "N"
        );

        return Result::success($result, "Buscar Servicios para Facturar Proveedores");
    }


    public static function findAllPendingByProveedor($proveedor = null, $factura = null)
    {

        if (!isset($proveedor) || $proveedor == "")
            $proveedor = -1;



        if (!isset($factura) || $factura == "") {
            $result = QuerySQL::select(
                <<<SQL
                select sss.id, sss.id_solicitud, sss.id_servicio, DATE_FORMAT(sss.fecha_termina_proveedor, '%Y-%m-%d') fecha_servicio,
                    fnc_valor_combo_prov(sss.id_servicio , ss.ciudad_vacante) + nvl(ssa.valor,0) valor_total,
                    nvl(ssa.valor,0) valor_serv_adicional,
                    fnc_valor_combo_prov(sss.id_servicio , ss.ciudad_vacante) valor_servicio,
                    srv.nom_servicio,
                    ss.doc_candidato,
                    null observacion
                from sol_solicitud_servicio sss 
                    LEFT  JOIN sol_servicios_adicionales ssa  ON sss.id_solicitud = ssa.id_solicitud and sss.id_servicio = ssa.id_servicio,
                sol_solicitud ss, srv_servicios srv
                where sss.estado = 8
                and sss.estado_proceso in (6,7)
                and sss.calificado = 'S'
                and sss.facturado = 'N'
                and sss.id_servicio = srv.id_servicio
                and ss.id_solicitud = sss.id_solicitud
                and sss.id_usuario_asig = :proveedor
                and not exists (select 'x' 
                                   from ft_facturacion_detalle ffd
                                                        where sss.id_solicitud = ffd.id_solicitud
                                                        and sss.id_servicio = ffd.id_servicio
                                                        and ffd.destino_factura = 'P'
                                                        and ffd.estado in (0,3));
            SQL,
                array("proveedor" => $proveedor),
                true,
                "S"
            );
            return Result::success($result, "Buscar Servicios Por Facturar");
        } else {

            $result = QuerySQL::select(
                <<<SQL
                    select sss.id, sss.id_solicitud, sss.id_servicio, DATE_FORMAT(sss.fecha_termina_proveedor, '%Y-%m-%d') fecha_servicio,
                        nvl(ssa.valor,0) valor_serv_adicional,
                        ffd.valor valor_servicio,
                        (ffd.valor + nvl(ssa.valor,0))  valor_total,
                        srv.nom_servicio,
                        ss.doc_candidato,
                        ffd.observacion
                    from sol_solicitud_servicio sss LEFT  JOIN sol_servicios_adicionales ssa  ON sss.id_solicitud = ssa.id_solicitud and sss.id_servicio = ssa.id_servicio , 
                    sol_solicitud ss, srv_servicios srv, ft_facturacion_detalle ffd
                    where sss.estado = 8
                    and sss.estado_proceso in (6,7)
                    and sss.calificado = 'S'
                    and sss.facturado = 'N'
                    and sss.id_servicio = srv.id_servicio
                    and ss.id_solicitud = sss.id_solicitud
                    and ffd.id_solicitud = sss.id_solicitud
                    and ffd.id_servicio = sss.id_servicio
                    and sss.id_usuario_asig = :proveedor
                    and exists (select 'x' 
                                    from ft_facturacion_detalle ffd
                                                            where sss.id_solicitud = ffd.id_solicitud
                                                            and sss.id_servicio = ffd.id_servicio
                                                            and ffd.destino_factura = 'P'
                                                            and ffd.estado = 0
                                                            and ffd.factura = :factura);
            SQL,
                array(
                    "factura" => $factura,
                    "proveedor" => $proveedor
                ),
                true,
                "S"
            );
            return Result::success($result, "Buscar Servicios Por Facturar");
        }
    }



    public static function newProveedor(
        $proveedor,
        $valor_neto,
        $ids = array()
    ) {
        if (!isset($proveedor) || $proveedor == "")
            return Result::error(__FUNCTION__, "cliente es requerido");

        if (!isset($valor_neto) || $valor_neto == "")
            return Result::error(__FUNCTION__, "valor_neto es requerido");

        if (!is_numeric($valor_neto))
            return Result::error(__FUNCTION__, "valor_neto debe ser numerico");

        $calc_expiration = new DateTime(date("Y-m-d"));
        $calc_expiration->add(new DateInterval('P30D'));
        $date_expiration = $calc_expiration->format('Y-m-d');
        $date_now = date("Y-m-d H:i:s");

        $dao = new FtFacturacion();
        $dao->setProperty("id_empresa", $proveedor);
        $dao->setProperty("valor_neto", $valor_neto);
        $dao->setProperty("estado", 0);
        $dao->setProperty("fecha_facturacion", $date_now);
        $dao->setProperty("fecha_vencimiento", $date_expiration);

        $response =  $dao->insert();

        if ($response['success']) {

            if (!empty($ids)) {
                $id = $response['id'];
                $total = 0;
                foreach ($ids as $servicio) {
                    $srv = Result::getData(CtrSrvServicio::infoServicioByFact($servicio, false));

                    $resultValor = QuerySQL::select(
                        <<<SQL
                               select fnc_valor_combo_prov(:servicio, :ciudad) valor;
                            SQL,
                        array(
                            "servicio" => $srv['id_servicio'],
                            "ciudad" => $srv['ciudad_vacante']
                        ),
                        true,
                        "N"
                    );

                    $arrayValor = json_decode(json_encode($resultValor), true);
                    $valor = $arrayValor[0]['valor'];

                    $resultValorAdd = QuerySQL::select(
                        <<<SQL
                               SELECT nvl(valor,0) valor 
                                FROM sol_servicios_adicionales ssa 
                                where ssa.id_solicitud = :id_solicitud
                                 and ssa.id_servicio = :id_servicio;
                            SQL,
                        array(
                            "id_solicitud" => $srv['id_solicitud'],
                            "id_servicio" => $srv['id_servicio'],
                        ),
                        true,
                        "N"
                    );

                    $arrayValorAdd = json_decode(json_encode($resultValorAdd), true);
                    $valorAdd = $arrayValorAdd[0]['valor'];

                    $valor_servicio = $valor + $valorAdd;
                    $result = CtrFtFacturacionDetalle::new($id, $srv['id_solicitud'], $srv['id_combo'], $valor_servicio, 'P', 0, $srv['id_servicio']);
                    if (Result::isError($result)) {
                        self::delete($id);
                        return $result;
                    }
                    $total += $valor_servicio;
                }

                if ($total != $valor_neto) {
                    self::delete($id);
                    return Result::error(__FUNCTION__, "valor_neto no coincide con el total de los servicios");
                }
            }
            if ($response['success']) {
                return Result::success($response);
            }
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $response);
        }
    }


    public static function facturarProveedor(
        $factura,
        $valor_neto,
        $servicios = array()
    ) {

        if (!isset($factura) || $factura == "")
            return Result::error(__FUNCTION__, "factura es requerido");

        foreach ($servicios as $servicio) {
            $srv = Result::getData(CtrSrvServicio::infoServicioByFact($servicio, false));

            $updFactDetalle = QuerySQL::update(
                <<<SQL
                       update ft_facturacion_detalle
                         set estado = 3
                        where factura = :factura
                         and id_solicitud = :id_solicitud
                         and id_servicio = :id_servicio;
                    SQL,
                array(
                    "factura" => $factura,
                    "id_solicitud" => $srv['id_solicitud'],
                    "id_servicio" => $srv['id_servicio'],
                ),
                true,
                "N"
            );

            $updSolsServ = QuerySQL::update(
                <<<SQL
                       update sol_solicitud_servicio
                         set facturado = 'S'
                        where id_solicitud = :id_solicitud
                         and id_servicio = :id_servicio;
                    SQL,
                array(
                    "id_solicitud" => $srv['id_solicitud'],
                    "id_servicio" => $srv['id_servicio'],
                ),
                true,
                "N"
            );
            if (Result::isError($updSolsServ))
                return $updSolsServ;
        }

        $dao = new FtFacturacion($factura);
        $dao->setProperty("estado", 3);
        $dao->setProperty("motivo_rechazo", null);
        $dao->setProperty("valor_neto", $valor_neto);

        $result =  $dao->update();

        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }



    //////////EXPORTACION ////////



    public static function export()
    {
        $result = QuerySQL::select(
            <<<SQL
                 select case when ffd.destino_factura = 'C' then 
                    (select te.razon_social  from trc_empresa te
                            where te.id_empresa = ff.id_empresa)
                    else 
                        (select CONCAT(uu.nombres, ' ', uu.apellidos)  from usr_usuario uu where uu.username = ff.id_empresa)
                    end empresa, 
                    case when ffd.destino_factura = 'C' then 
                    (select te.numero_doc  from trc_empresa te
                            where te.id_empresa = ff.id_empresa)
                    else 
                        (select  uu.numero_identificacion  from usr_usuario uu where uu.username = ff.id_empresa)
                    end id_empresa, 
                    sc.numero_doc , 
                    CONCAT(sc.nombre, ' ', sc.apellido) candidato,
                    sc.cargo_desempeno ,
                    case when ss.ciudad_vacante = (select descripcion from configurations c where categoria = 'configuracion' and codigo = 'id_ciud_bog') then 
                        case when ffd.destino_factura = 'C' then    
                                (select item
                                from fac_cuentas_cont fcc
                                where combo = ss.id_combo 
                                and ubicacion_cuenta = 'B'
                                and fcc.estado = 1
                                and fcc.destino_cuenta = 'C')
                            else 
                                (select item
                                from fac_cuentas_cont fcc
                                where combo = ss.id_combo 
                                and ubicacion_cuenta = 'B'
                                and fcc.estado = 1
                                and fcc.destino_cuenta = 'P')
                            end 
                    else 
                    case when ffd.destino_factura = 'C' then    
                    (select item
                        from fac_cuentas_cont fcc
                        where combo = ss.id_combo 
                        and ubicacion_cuenta = 'E'
                        and fcc.estado = 1
                        and fcc.destino_cuenta = 'C')
                    else 
                        (select item
                        from fac_cuentas_cont fcc
                        where combo = ss.id_combo 
                        and ubicacion_cuenta = 'E'
                        and fcc.estado = 1
                        and fcc.destino_cuenta = 'P')
                    end
                    end item,
                    sc2.nom_combo ,  
                    case when ss.ciudad_vacante is not null then 
                        (select nombre from conf_ciudad cc where id_ciudad =ss.ciudad_vacante )
                    else
                        null
                    end ciudad,
                    ffd.valor ,
                    ssa.valor valor_adicional 
                    from ft_facturacion ff , ft_facturacion_detalle ffd left join sol_servicios_adicionales ssa on ffd.id_solicitud = ssa.id_solicitud and ffd.id_servicio = ssa.id_servicio 
                    , sol_solicitud ss, sol_candidato sc, srv_combos sc2 
                    where ff.estado = 3
                    and ffd.estado = 3
                    and ff.id = ffd.factura 
                    and ss.id_solicitud = ffd.id_solicitud
                    and ss.id_solicitud = sc.id_solicitud
                    and ss.id_combo = sc2.id_combo;
            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "Buscar Servicios para Facturar Proveedores");
    }
}
