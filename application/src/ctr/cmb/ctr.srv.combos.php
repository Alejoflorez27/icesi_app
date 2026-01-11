<?php

class CtrSrvCombos
{

    public static function crear($nom_combo, $valor_bogota, $sla_bogota, $valor_externo, $sla_externo, $env_correo)
    {

        if (!isset($nom_combo) || $nom_combo == "")
            return BaseResponse::error(__FUNCTION__, "Nombre Combo es requerido");

        if (!isset($valor_bogota) || $valor_bogota == "")
            return BaseResponse::error(__FUNCTION__, "Valor es requerido");

        if (!isset($sla_bogota) || $sla_bogota == "")
            return BaseResponse::error(__FUNCTION__, "SLA es requerido");

        if (!isset($valor_externo) || $valor_externo == "")
            return BaseResponse::error(__FUNCTION__, "Valor es requerido");

        if (!isset($sla_externo) || $sla_externo == "")
            return BaseResponse::error(__FUNCTION__, "SLA es requerido");

        if (!isset($env_correo) || $env_correo == "")
            return BaseResponse::error(__FUNCTION__, "Envía Correo es requerido");

        $obj_srvCombos = new SrvCombos();
        $obj_srvCombos->setProperty('nom_combo', $nom_combo);
        $obj_srvCombos->setProperty('valor_bogota', $valor_bogota);
        $obj_srvCombos->setProperty('sla_bogota', $sla_bogota);
        $obj_srvCombos->setProperty('valor_externo', $valor_externo);
        $obj_srvCombos->setProperty('sla_externo', $sla_externo);
        $obj_srvCombos->setProperty('env_correo', $env_correo);
        $obj_srvCombos->setProperty('estado', 1);

        $result = $obj_srvCombos->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findAll()
    {
        $result = QuerySQL::select(
            <<<SQL
                 select distinct sc.id_combo , sc.nom_combo , sc.valor_bogota , sc.sla_bogota , sc.valor_externo,
                            sc.sla_externo , sc.estado, sc.env_correo , sc.usr_create , sc.fch_create 
                from srv_combos sc;
            SQL,
            false,
            true,
            "N"
        );

        return Result::success($result, "buscar combo");
    }

    public static function findAllActive()
    {
        $result = QuerySQL::select(
            <<<SQL
                 select distinct sc.id_combo , sc.nom_combo
                from srv_combos sc
                where sc.estado = 1;
            SQL,
            array(),
            true,
            "S"
        );

        return Result::success($result, "buscar combo");
    }

    public static function findCombosActive()
    {
        $obj_ref = new SrvCombos();
        return $obj_ref->selectAll(
            array("estado" => 1),
            array(
                "id_combo",
                "nom_combo"
            )
        );
    }

    /*public static function conbosClientes()
    {
        $obj_ref = new TrcComboCli();
        return $obj_ref->selectAll(
            array("estado" => 1, "id_empresa" => 1, "visible" => "S"),
            array(
                "id_combo_cli",
                "id_combo"
            )
        );
    }*/
    
    public static function listaCombos()
    {
        $result = QuerySQL::select(
            <<<SQL
                 select distinct sc.id_combo , sc.nom_combo , sc.valor_bogota , sc.sla_bogota , sc.valor_externo,
                            sc.sla_externo , sc.estado, sc.env_correo , sc.usr_create , sc.fch_create 
                from srv_combos sc, fac_cuentas_cont fcc , srv_combo_servicios scs
                where fcc.combo = sc.id_combo 
                 and sc.estado = 1
                 and fcc.destino_cuenta = 'C'
                 and sc.id_combo = scs.id_combo;
            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "buscar combo");
    }

    public static function delete($id_combo)
    {
        if (!isset($id_combo) || $id_combo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SrvCombos($id_combo);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findById($id_combo)
    {
        if (!isset($id_combo) || $id_combo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select sc.id_combo , sc.nom_combo , sc.valor_bogota , sc.sla_bogota , sc.valor_externo,
                        sc.sla_externo , sc.estado, sc.env_correo , sc.usr_create , sc.fch_create 
                from srv_combos sc 
                where sc.id_combo = :id_combo;
            SQL,
            array("id_combo" => $id_combo),
            false,
            "N"
        );

        return Result::success($result, "buscar Combo");
    }


    public static function update(
        $id_combo,
        $nom_combo,
        $valor_bogota,
        $sla_bogota,
        $valor_externo,
        $sla_externo,
        $env_correo
    ) {
        if (!isset($id_combo) || $id_combo == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SrvCombos($id_combo);
        $dao->setProperty('nom_combo', $nom_combo);
        $dao->setProperty('valor_bogota', $valor_bogota);
        $dao->setProperty('sla_bogota', $sla_bogota);
        $dao->setProperty('valor_externo', $valor_externo);
        $dao->setProperty('sla_externo', $sla_externo);
        $dao->setProperty('env_correo', $env_correo);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    public static function findAllByCombo($id_combo)
    {
        if (!isset($id_combo) || $id_combo == "")
            return Result::error(__FUNCTION__, "Combo es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select * 
                from srv_combo_servicios scs 
                where scs.activo = 1
                and (scs.id_combo = :id_combo )
            SQL,
            array("id_combo" => $id_combo),
            true,
            "N"
        );
        return Result::success($result, "buscar servcio por combos");
    }

    public static function findAllByComboMantenimiento($id_combo)
    {
        if (!isset($id_combo) || $id_combo == "")
            return Result::error(__FUNCTION__, "Combo es requerido");

        $result = QuerySQL::select(
            <<<SQL
                SELECT 
                    CASE 
                        WHEN EXISTS (
                            SELECT 1
                            FROM srv_combo_servicios scs
                            WHERE scs.activo = 1
                            AND scs.id_combo = :id_combo
                            AND scs.id_servicio = 4
                        ) THEN 1
                        ELSE 0
                    END AS tiene_mantenimiento
            SQL,
            array("id_combo" => $id_combo),
            true,
            "N"
        );
        return Result::success($result, "buscar servcio por combos");
    }

    public static function findAllByComboRutina($id_combo)
    {
        if (!isset($id_combo) || $id_combo == "")
            return Result::error(__FUNCTION__, "Combo es requerido");

        $result = QuerySQL::select(
            <<<SQL
                SELECT 
                    CASE 
                        WHEN EXISTS (
                            SELECT 1
                            FROM srv_combo_servicios scs
                            WHERE scs.activo = 1
                            AND scs.id_combo = :id_combo
                            AND scs.id_servicio = 9
                        ) THEN 1
                        ELSE 0
                    END AS tiene_rutina
            SQL,
            array("id_combo" => $id_combo),
            true,
            "N"
        );
        return Result::success($result, "buscar servcio por combos");
    }

    public static function findAllByComboManual($id_combo)
    {
        if (!isset($id_combo) || $id_combo == "")
            return Result::error(__FUNCTION__, "Combo es requerido");

        $result = QuerySQL::select(
            <<<SQL
                SELECT 
                    CASE 
                        WHEN EXISTS (
                            SELECT 1
                            FROM srv_combo_servicios scs
                            INNER JOIN srv_servicios ss ON ss.id_servicio = scs.id_servicio
                            WHERE scs.activo = 1
                            AND scs.id_combo = :id_combo
                            AND ss.tipo_servicio = 'M'
                        ) THEN 1
                        ELSE 0
                    END AS tiene_manual;
            SQL,
            array("id_combo" => $id_combo),
            true,
            "N"
        );
        return Result::success($result, "buscar servcio por combos");
    }

    public static function findAllByNombreManual($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id_solicitud es requerido");

        $result = QuerySQL::select(
            <<<SQL
            SELECT ss.nom_servicio
            FROM sol_solicitud_servicio sss, srv_servicios ss
            WHERE 1 = 1
            AND sss.id_servicio = ss.id_servicio
            AND ss.tipo_servicio = 'M'
            AND sss.id_solicitud = :id_solicitud
            AND sss.estado = 2
            AND sss.estado_proceso = 3
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );
        return Result::success($result, "buscar servcio por id_solicitud");
    }

    public static function findAllByServSinFin($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id_solicitud es requerido");

        $result = QuerySQL::select(
            <<<SQL
            SELECT 
                CASE 
                    WHEN EXISTS (
                        SELECT 1
                        FROM sol_solicitud_servicio sss
                        JOIN srv_servicios ss ON sss.id_servicio = ss.id_servicio
                        WHERE id_solicitud = :id_solicitud
                        AND sss.estado = 2
                        AND sss.estado_proceso = 3
                    )
                    THEN 'Servicios sin finalizar'
                    ELSE 'Todos finalizados'
                END AS estado_servicios;
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );
        return Result::success($result, "buscar servcio por combos");
    }



    public static function findAllByComboOrden($id_combo)
    {
        if (!isset($id_combo) || $id_combo == "")
            return Result::error(__FUNCTION__, "Combo es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select ss.id_servicio, ss.nom_servicio, ss.orden
                from srv_combo_servicios scs, srv_servicios ss
                where scs.activo = 1
                and scs.id_servicio = ss.id_servicio 
                and (scs.id_combo = :id_combo )
                ORDER BY ss.orden
            SQL,
            array("id_combo" => $id_combo),
            true,
            "N"
        );
        return Result::success($result, "buscar servcio por combos");
    }

    public static function findAllByComboAcademicoLaboral($id_combo)
    {
        if (!isset($id_combo) || $id_combo == "")
            return Result::error(__FUNCTION__, "Combo es requerido");

        $result = QuerySQL::select(
            <<<SQL
                SELECT 
                    CASE 
                        WHEN MAX(CASE WHEN ss.orden IN (3,4) THEN ss.orden END) = 3 
                            THEN MAX(CASE WHEN ss.orden = 3 THEN ss.nom_servicio END)
                        WHEN MAX(CASE WHEN ss.orden IN (3,4) THEN ss.orden END) = 4 
                            THEN MAX(CASE WHEN ss.orden = 4 THEN ss.nom_servicio END)
                    END AS servicio_seleccionado
                FROM srv_combo_servicios scs
                JOIN srv_servicios ss ON scs.id_servicio = ss.id_servicio
                WHERE scs.activo = 1
                AND scs.id_combo = :id_combo
                AND ss.orden IN (3,4);
            SQL,
            array("id_combo" => $id_combo),
            true,
            "N"
        );
        return Result::success($result, "buscar servcio por combos");
    }


    public static function valAutoPdfCandidato($id_combo)
    {
        if (!isset($id_combo) || $id_combo == "")
            return Result::error(__FUNCTION__, "Combo es requerido");

        $result = QuerySQL::select(
            <<<SQL
                SELECT 
                    CASE 
                        WHEN COUNT(*) > 0 THEN 'muestra_auto'
                        ELSE 'no_aplica'
                    END AS resultado
                FROM srv_combo_servicios scs
                JOIN srv_servicios ss ON scs.id_servicio = ss.id_servicio
                WHERE scs.activo = 1
                AND scs.id_combo = :id_combo
                AND ss.id_servicio IN (3, 6, 7, 11);
            SQL,
            array("id_combo" => $id_combo),
            true,
            "N"
        );
        return Result::success($result, "buscar servcio por combos");
    }

    public static function findAllComboCliente($id_empresa)
    {
        if (!isset($id_empresa) || $id_empresa == "")
            return Result::error(__FUNCTION__, "Id empresa es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select sc.id_combo , sc.nom_combo 
                from trc_combo_cli tcc, srv_combos sc 
                where tcc.estado = 1
                and tcc.visible = 'S'
                and tcc.id_combo = sc.id_combo 
                and tcc.id_empresa = :id_empresa
            SQL,
            array("id_empresa" => $id_empresa),
            true,
            "N"
        );
        return Result::success($result, "buscar servcio por combos");
    }

    public static function cambiarEstado($id_combo, $estado)
    {
        if (!isset($id_combo) || $id_combo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $resultCount = QuerySQL::select(
            <<<SQL
                    select count(1) cant
                    from srv_combos sc, srv_combo_servicios scs 
                    where sc.id_combo = scs.id_combo 
                    and scs.activo = 1
                    and sc.id_combo = :id_combo;
                SQL,
            array("id_combo" => $id_combo),
            true,
            "N"
        );

        $arrayResult = json_decode(json_encode($resultCount), true);
        $cantidad = $arrayResult[0]['cant'];

        if ($cantidad > 0) {
            return Result::error(__FUNCTION__, "No se puede inactivar el Combo, tiene Servicios asociados");
        } else {

            $result = QuerySQL::update(
                <<<SQL
                update srv_combos 
                 set estado = :estado 
                where  id_combo = :id_combo
            SQL,
                array(
                    "id_combo" => $id_combo,
                    "estado" => $estado
                ),
                false,
                "N"
            );

            return Result::success($result, "Cambiar estado producto");
        }
    }
}
