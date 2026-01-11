<?php

class CtrSrvServicio
{

    public static function crear($id_producto, $nom_servicio, $tipo_servicio = 'M', $estado, $reporte = null, $ruta_reporte = null, $valor_bogota = 0, $valor_fuera_bogota = 0, $valor_adicional = 'N')
    {
        if (!isset($id_producto) || $id_producto == "")
            return BaseResponse::error(__FUNCTION__, "Id producto es requerido");

        if (!isset($nom_servicio) || $nom_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Nombre servicio es requerido");

        $obj_srvServicio = new SrvServicio();
        $obj_srvServicio->setProperty('id_producto', $id_producto);
        $obj_srvServicio->setProperty('nom_servicio', $nom_servicio);
        $obj_srvServicio->setProperty('tipo_servicio', $tipo_servicio);
        $obj_srvServicio->setProperty('reporte', $reporte);
        $obj_srvServicio->setProperty('ruta_reporte', $ruta_reporte);
        $obj_srvServicio->setProperty('estado', $estado);
        $obj_srvServicio->setProperty('valor_bogota', $valor_bogota);
        $obj_srvServicio->setProperty('valor_fuera_bogota', $valor_fuera_bogota);
        $obj_srvServicio->setProperty('valor_adicional', $valor_adicional);

        $result = $obj_srvServicio->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findAll($estado = null)
    {
        if (!isset($estado) || $estado == "")
            $estado = -1;

        $result = QuerySQL::select(
            <<<SQL
                select ss.id_servicio , ss.id_producto, sp.nom_prod , ss.nom_servicio , 
                    ss.estado , ss.usr_create , ss.fch_create , ss.tipo_servicio, ss.reporte, ss.ruta_reporte , ss.valor_bogota, ss.valor_fuera_bogota, ss.valor_adicional
                    from srv_servicios ss , srv_producto sp 
                    where sp.id_producto = ss.id_producto 
                    and (ss.estado = :estado or :estado = -1)   
            SQL,
            array("estado" => $estado),
            true,
            "N"
        );

        return Result::success($result, "buscar servicio");
    }

    static public function consultarTodos()
    {
        $obj_srvServicio = new SrvServicio();
        return $obj_srvServicio->selectAll();
    }

    public static function delete($id_servicio)
    {
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SrvServicio($id_servicio);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findByIdServicio($id_servicio)
    {
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select ss.id_servicio , ss.id_producto, sp.nom_prod , ss.nom_servicio , ss.tipo_servicio, ss.reporte, ss.ruta_reporte,
                    ss.estado , ss.usr_create , ss.fch_create , ss.valor_bogota, ss.valor_fuera_bogota, ss.valor_adicional, ss.nomReporte
                    from srv_servicios ss , srv_producto sp 
                    where sp.id_producto = ss.id_producto 
                    and  ss.id_servicio = :id_servicio
            SQL,
            array("id_servicio" => $id_servicio),
            false,
            "N"
        );

        return Result::success($result, "buscar servicio");
    }


    public static function serviciosAnteriores($candidato, $empresa)
    {
        if (!isset($candidato) || $candidato == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
               select ss.id_solicitud , ss.id_combo , sc2.nom_combo , ss.id_estado_solicitud , ss.observacion , ss.fch_solicitud , sc2.valor_bogota, sc2.valor_externo
                from sol_solicitud ss, sol_candidato sc , srv_combos sc2 
                where ss.id_solicitud = sc.id_solicitud  
                and ss.id_combo = sc2.id_combo 
                and ss.id_empresa = :empresa
                and sc.numero_doc = :candidato;
            SQL,
            array(
                "candidato" => $candidato,
                "empresa" => $empresa
            ),
            true,
            "S"
        );

        return Result::success($result, "buscar servicios anteriores");
    }

    public static function solicitudServicios($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $usuario = CtrUsuario::getUsuarioApp();
        $resultCount = CtrUsuario::consultar($usuario);
        $perfil = $resultCount['perfil'];
        $empresa = $resultCount['id_empresa'];

        

        if ($perfil == 7) {
            $obj_solSolicitud = new SolSolicitud($id_solicitud);
            $usuario = $obj_solSolicitud->getUsuario('usuario');
            $empresa = $obj_solSolicitud->getIdEmpresa('id_empresa');
        }


        $result = QuerySQL::select(
            <<<SQL
               select sss.id, sss.id_solicitud , ss.id_servicio , ss.nom_servicio,
                    sss.id_usuario_asig , sss.id_usuario_calidad,
                    case when sss.id_usuario_asig is not null then 
                        (select CONCAT(uu.nombres, ' ', uu.apellidos)
                        from usr_usuario uu 
                        where uu.username = sss.id_usuario_asig)
                    else
                        null
                    end nom_usr_asig,  
                    sss.id_usuario_calidad,
                    case when sss.id_usuario_calidad is not null then 
                        (select CONCAT(uu.nombres, ' ', uu.apellidos)
                        from usr_usuario uu 
                        where uu.username = sss.id_usuario_calidad)
                    else
                        null
                    end nom_usr_asig_calidad,                      
                    sss.fecha_programacion , sss.asistio , sss.calificado, decode(sss.calificado, 'S', 'Si', 'N', 'No')  desc_calificado, sss.observacion ,
                    decode(sss.estado, '1', 'Activo', 'Inactivo') estado , sss.estado estado_id, ss.tipo_servicio, ruta_reporte, reporte,
                    sss.observacion_asistio, ss.valor_adicional,
                    case when sss.id_solicitud is not null then
                            (select nvl(CONCAT('<b>VALOR $ </b>', FORMAT(ssa.valor,0), ' <b>MOTIVO :</b> ', ' ',ssa.observacion ),0) valor_adicional_srv
                            from sol_servicios_adicionales ssa
                            where ssa.id_solicitud = sss.id_solicitud
                             and ssa.id_servicio = sss.id_servicio)
                        ELSE
                            0
                        end valor_adicional_srv, sss.observacion_finalizacion,
                        sss.estado_proceso
                    From sol_solicitud_servicio sss, srv_servicios ss  
                    where 1 = 1
                    and sss.id_servicio = ss.id_servicio 
                    and case when :perfil in (1,12) then 
                            sss.id_solicitud =:id_solicitud
                        else
                            case when :perfil in (7) then 
                                :empresa  in ((select ss.id_empresa 
                                                                from sol_solicitud ss
                                                            where sss.id_solicitud = ss.id_solicitud  
                                                             and ss.id_empresa in (select te3.id_empresa
                                                                                    from trc_empresa te3 
                                                                                    where (:empresa = nvl(te3.id_empresa_padre, te3.id_empresa) or  :empresa = te3.id_empresa)
                                                                                    and te3.estado = 1)))
                            else 
                                case when :perfil in (8,9) then 
                                    :empresa = (select ss.id_empresa 
                                                from sol_solicitud ss
                                                where sss.id_solicitud = ss.id_solicitud)
                                else 
                                    case when :perfil in (10,11,15,16) then 
                                        sss.id_usuario_asig = :usuario
                                    else 
                                        case when :perfil in (13) then 
                                            sss.id_usuario_calidad = :usuario
                                        end
                                    end
                                end
                            end
                        end
                    and sss.id_solicitud = :id_solicitud
                    order by sss.estado desc;
            SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "perfil" => $perfil,
                "usuario" => $usuario,
                "empresa" => $empresa,
            ),
            true,
            "S"
        );

        foreach ($result as &$servicio) {
            $servicio['timeline'] = Result::getData(CtrSolSolicitudTimeLine::findAllByService($servicio['id_solicitud'], $servicio['id_servicio'], $usuario));
            $servicio['archivos'] = Result::getData(CtrSolAdjuntos::findByAllByServicio($servicio['id_solicitud'], $servicio['id_servicio']));
        }

        return Result::success($result, "buscar servicios anteriores");
    }

    public static function findById($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select ss.id_solicitud ,ss.id_empresa, fch_solicitud ,  te.razon_social , CONCAT(sc.nombre, ' ', sc.apellido) candidato, ss.doc_candidato 
                    from sol_solicitud ss , trc_empresa te, sol_candidato sc
                    where ss.id_empresa = te.id_empresa
                    and ss.id_solicitud = sc.id_solicitud
                    and ss.id_solicitud =  :id_solicitud
            SQL,
            array("id_solicitud" => $id_solicitud),
            false,
            "N"
        );

        if (isset($result)) {
            $result['servicios'] = Result::getData(CtrSolSolicitudServicio::findById($result['id_solicitud']));
        }

        return Result::success($result, "buscar servicio");
    }

    public static function consultaSolicitudEditar($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                SELECT 
                    ss.id_solicitud,
                    ss.id_combo,
                    sc2.nom_combo,
                    ss.id_empresa,
                    te.razon_social,
                    sc.numero_doc,
                    ss.observacion,
                    ss.usuario,
                    CONCAT(uu.nombres, ' ', uu.apellidos) AS nom_responsable,
                    ss.canal_recepcion,
                    ss.fch_solicitud,
                    ss.obs_calidad,
                    ss.concepto_final,
                    fcn_desc_configurations('tipo_concepto_profesional', ss.concepto_final) AS des_concepto,
                    sc.id_ciudad_act,
                    cc.nombre AS nombre_ciudad,
                    cd.id_dpto,
                    cd.nombre AS nombre_dpto,
                    cp.id_pais,
                    cp.nombre AS nombre_pais,
                    sc.localidad,
                    sc.tipo_id,
                    sc.nombre,
                    sc.apellido,
                    sc.email,
                    sc.telefono,
                    sc.direccion,
                    sc.cargo_desempeno,
                    sc.id_candidato,
                    ss.centro_costo
                    
                FROM sol_solicitud ss
                INNER JOIN sol_candidato sc ON ss.id_solicitud = sc.id_solicitud
                INNER JOIN srv_combos sc2 ON ss.id_combo = sc2.id_combo
                INNER JOIN trc_empresa te ON ss.id_empresa = te.id_empresa
                LEFT JOIN usr_usuario uu ON ss.usuario = uu.username
                LEFT JOIN conf_pais cp ON ss.pais_vacante = cp.id_pais
                LEFT JOIN conf_dpto cd ON ss.pais_vacante = cd.id_pais AND ss.dpto_vacante = cd.id_dpto
                LEFT JOIN conf_ciudad cc ON ss.dpto_vacante = cc.id_dpto AND ss.ciudad_vacante = cc.id_ciudad

                WHERE ss.id_solicitud = :id_solicitud;

            SQL,
            array("id_solicitud" => $id_solicitud),
            false,
            "N"
        );

        if (isset($result)) {
            $result['servicios'] = Result::getData(CtrSolSolicitudServicio::findById($result['id_solicitud']));
        }

        return Result::success($result, "buscar servicio");
    }


    public static function update(
        $id_servicio,
        $id_producto,
        $nom_servicio,
        $tipo_servicio,
        $estado,
        $reporte,
        $ruta_reporte,
        $valor_bogota,
        $valor_fuera_bogota,
        $valor_adicional
    ) {
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SrvServicio($id_servicio);
        $dao->setProperty('id_producto', $id_producto);
        $dao->setProperty('nom_servicio', $nom_servicio);
        $dao->setProperty('tipo_servicio', $tipo_servicio);
        $dao->setProperty('estado', $estado);
        $dao->setProperty('reporte', $reporte);
        $dao->setProperty('ruta_reporte', $ruta_reporte);
        $dao->setProperty('valor_bogota', $valor_bogota);
        $dao->setProperty('valor_fuera_bogota', $valor_fuera_bogota);
        $dao->setProperty('valor_adicional', $valor_adicional);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function cambiarEstado($id_servicio, $estado)
    {
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $resultCount = QuerySQL::select(
            <<<SQL
                    select count(1) cant 
                        from srv_combo_servicios scs , srv_servicios ss 
                        where scs.id_servicio = ss.id_servicio 
                        and scs.activo = 1
                        and ss.id_servicio  = :id_servicio;
                SQL,
            array("id_servicio" => $id_servicio),
            true,
            "N"
        );

        $arrayResult = json_decode(json_encode($resultCount), true);
        $cantidad = $arrayResult[0]['cant'];

        if ($cantidad > 0) {
            return Result::error(__FUNCTION__, "No se puede inactivar el Servicio, tiene Combos Servicios activos");
        } else {

            $result = QuerySQL::update(
                <<<SQL
                update srv_servicios 
                 set estado = :estado 
                where  id_servicio = :id_servicio
            SQL,
                array(
                    "id_servicio" => $id_servicio,
                    "estado" => $estado
                ),
                false,
                "N"
            );

            return Result::success($result, "Cambiar estado producto");
        }
    }



    public static function serviciosCalidad()
    {
        $result = QuerySQL::select(
            <<<SQL
                select sss.id, sss.id_solicitud, sss.id_solicitud , 
                        case when sss.id_solicitud is not null then 
                            (select te.razon_social 
                                from trc_empresa te
                            where te.id_empresa = (select ss.id_empresa  from sol_solicitud ss 
                                                    where ss.id_solicitud = sss.id_solicitud))  
                        else 
                            null
                        end cliente, 
                        case when sss.id_solicitud is not null then 
                            (select concat(sc.nombre, ' ', sc.apellido)
                                from  sol_candidato sc   
                            where sc.id_solicitud = sss.id_solicitud)  
                        else 
                            null
                        end candidato, ss2.doc_candidato, fnc_nombre_combo(ss2.id_combo) AS nombre_combo, sss.id_servicio , ss.nom_servicio, CONCAT(uu.nombres , ' ', uu.apellidos  ) usuario_asig,
                        sss.estado, case when sss.estado is not null then
                                        (select descripcion 
                                            from configurations c 
                                        where categoria = 'estado_servicios'
                                            and c.codigo = sss.estado)
                                    else
                                        null 
                                    end estado_desc, sss.estado_proceso ,
                                    case when sss.estado_proceso  is not null then 
                                            (select descripcion 
                                                from configurations c 
                                            where categoria = 'estado_servicios'
                                                and c.codigo = sss.estado_proceso)
                                    else 
                                        null 
                                    end estado_proceso_desc,
                    case when sss.id_usuario_calidad is not null then 
                        (select CONCAT(uu2.nombres, ' ', uu2.apellidos) 
                        from usr_usuario uu2
                        where username = sss.id_usuario_calidad )  
                     else 
                        null 
                     end usuario_calidad,
                     decode(sss.prioridad,'alta', 'Alta','media','Media','baja','Baja') prioridad
                from sol_solicitud_servicio sss , usr_usuario uu , srv_servicios ss, sol_solicitud ss2
                where 1 = 1
                and sss.estado = 5
                and sss.estado_proceso in (1, 2, 3, 4, 6, 7)
                and sss.id_usuario_asig = uu.username 
                and sss.id_servicio = ss.id_servicio
                and ss2.id_solicitud = sss.id_solicitud;
            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "buscar servicios en calidad");
    }

public static function serviciosCalidadAgrupados()
{
    $result = QuerySQL::select(
        <<<SQL
        SELECT 
            ss2.id_solicitud,
            te.razon_social as cliente,
            CONCAT(sc.nombre, ' ', sc.apellido) as candidato,
            sc.numero_doc as doc_candidato,
            fnc_nombre_combo(ss2.id_combo) AS nombre_combo,
            CONCAT(uu2.nombres, ' ', uu2.apellidos) as id_usuario_calidad,
            
            -- TOTAL de servicios de la solicitud (sin filtrar por estado_proceso)
            (SELECT COUNT(*) 
             FROM sol_solicitud_servicio sss_total 
             WHERE sss_total.id_solicitud = ss2.id_solicitud 
             AND sss_total.estado != 0) as total_servicios,
            
            -- Servicios que están listos para calidad
            COUNT(sss.id) as servicios_listos_calidad,
            
            GROUP_CONCAT(
                CONCAT(
                    sss.id, '|',
                    ss.nom_servicio, '|',
                    COALESCE(sss.estado_proceso, 0), '|',
                    COALESCE(sss.id_usuario_asig, ''), '|',
                    COALESCE(CONCAT(uu.nombres, ' ', uu.apellidos), 'No asignado'), '|',
                    COALESCE(sss.id_usuario_calidad, ''), '|',
                    COALESCE(CONCAT(uu2.nombres, ' ', uu2.apellidos), 'No asignado'), '|',
                    COALESCE(CASE 
                        WHEN sss.prioridad = 'alta' THEN 'Alta'
                        WHEN sss.prioridad = 'media' THEN 'Media' 
                        WHEN sss.prioridad = 'baja' THEN 'Baja'
                        ELSE 'No definida'
                    END, 'No definida')
                ) SEPARATOR ';'
            ) as servicios_info
            
        FROM sol_solicitud_servicio sss 
        LEFT JOIN usr_usuario uu ON sss.id_usuario_asig = uu.username 
        LEFT JOIN srv_servicios ss ON sss.id_servicio = ss.id_servicio
        LEFT JOIN sol_solicitud ss2 ON ss2.id_solicitud = sss.id_solicitud
        LEFT JOIN sol_candidato sc ON sc.id_solicitud = sss.id_solicitud
        LEFT JOIN trc_empresa te ON te.id_empresa = ss2.id_empresa
        LEFT JOIN usr_usuario uu2 ON uu2.username = sss.id_usuario_calidad
        WHERE 1 = 1
            AND sss.estado = 5
            AND sss.estado_proceso IN (1, 2, 3, 4, 6, 7)  -- Solo servicios en calidad
            AND ss2.id_estado_solicitud != 'cancelada'
        GROUP BY 
            ss2.id_solicitud, 
            te.razon_social, 
            sc.nombre, 
            sc.apellido, 
            sc.numero_doc, 
            ss2.id_combo
        ORDER BY ss2.id_solicitud DESC;
        SQL,
        array(),
        true,
        "N"
    );

    return Result::success($result, "servicios agrupados por solicitud");
}

    public static function serviciosAsignar()
    {
        $result = QuerySQL::select(
            <<<SQL
                SELECT sss.id, 
                    sss.id_solicitud, 
                    te.razon_social AS cliente, 
                    CONCAT(sc.nombre, ' ', sc.apellido) AS candidato, 
                    ss2.doc_candidato, 
                    sss.id_servicio, 
                    ss.nom_servicio, 
                    CONCAT(uu.nombres, ' ', uu.apellidos) AS usuario_asig, 
                    sss.estado, 
                    c1.descripcion AS estado_desc, 
                    sss.estado_proceso, 
                    c2.descripcion AS estado_proceso_desc
                FROM sol_solicitud_servicio sss
                LEFT JOIN usr_usuario uu ON uu.username = sss.id_usuario_asig 
                LEFT JOIN srv_servicios ss ON sss.id_servicio = ss.id_servicio
                -- LEFT JOIN sol_solicitud ss2 ON ss2.id_solicitud = sss.id_solicitud
                LEFT JOIN sol_solicitud ss2 
                ON ss2.id_solicitud = sss.id_solicitud 
                AND ss2.id_estado_solicitud != 'cancelada'
                LEFT JOIN trc_empresa te ON te.id_empresa = (SELECT ss.id_empresa FROM sol_solicitud ss WHERE ss.id_solicitud = sss.id_solicitud)
                LEFT JOIN sol_candidato sc ON sc.id_solicitud = sss.id_solicitud
                LEFT JOIN configurations c1 ON c1.categoria = 'estado_servicios' AND c1.codigo = sss.estado
                LEFT JOIN configurations c2 ON c2.categoria = 'estado_servicios' AND c2.codigo = sss.estado_proceso
                LEFT JOIN usr_usuario uu2 ON uu2.username = sss.id_usuario_calidad
                WHERE sss.estado = 1
                AND sss.estado_proceso = 1
                AND ss2.estado = 1  -- Restricción agregada
                AND (sss.id_usuario_asig IS NULL OR sss.id_usuario_asig = '');

            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "buscar para asignar");
    }

    public static function serviciosSeguimiento($username_asig, $perfil, $estado_servicio)
    {
        if ($username_asig == '' ) {
            $username_asig = null;
        } else {
            $username_asig;
        }

        if ($perfil == '' ) {
            $perfil = null;
        } else {
            $perfil;
        }

        if ($estado_servicio == '' ) {
            $estado_servicio = null;
        } else {
            $estado_servicio;
        }
        
        $result = QuerySQL::select(
            <<<SQL
            SELECT sss.id, 
                sss.id_solicitud, 
                te.razon_social AS cliente, 
                CONCAT(sc.nombre, ' ', sc.apellido) AS candidato, 
                ss2.doc_candidato,
                ss2.id_empresa,
                ss2.fch_solicitud,
                ss2.fch_estimada_sol, 
                sss.id_servicio, 
                ss.nom_servicio,
                uu.username,
                uu.perfil,
                CONCAT(uu.nombres, ' ', uu.apellidos) AS usuario_asig,
                CONCAT(uu2.nombres, ' ', uu2.apellidos) AS usuario_asig_calidad,
                sss.estado,
                sss.prioridad, 
                c1.descripcion AS estado_desc, 
                sss.estado_proceso,
                sss.observacion_finalizacion, 
                c2.descripcion AS estado_proceso_desc
            FROM sol_solicitud_servicio sss
            LEFT JOIN usr_usuario uu ON (TRIM(uu.username) = TRIM(sss.id_usuario_asig) and sss.estado <> 5) or TRIM(uu.username) = TRIM(sss.id_usuario_calidad)
            LEFT JOIN usr_usuario uu2 ON TRIM(uu2.username) = TRIM(sss.id_usuario_calidad)
            LEFT JOIN srv_servicios ss ON sss.id_servicio = ss.id_servicio
            LEFT JOIN sol_solicitud ss2 ON ss2.id_solicitud = sss.id_solicitud
            LEFT JOIN trc_empresa te ON te.id_empresa = ss2.id_empresa
            LEFT JOIN sol_candidato sc ON sc.id_solicitud = sss.id_solicitud
            LEFT JOIN configurations c1 ON c1.categoria = 'estado_servicios' AND c1.codigo = sss.estado
            LEFT JOIN configurations c2 ON c2.categoria = 'estado_servicios' AND c2.codigo = sss.estado_proceso
            WHERE sss.estado IN (1, 2, 3, 4, 5, 6, 7, 8)
            AND (
                (:estado_servicio IS NULL AND sss.estado_proceso IN (0, 1, 2, 3, 4, 5, 6))
                OR (:estado_servicio IS NOT NULL AND sss.estado_proceso = :estado_servicio)
            )
            AND ss2.estado = 1
            AND ss2.id_estado_solicitud != 'cancelada'
            AND (:perfil IS NULL OR uu.perfil = :perfil)
            AND (:username_asig IS NULL OR uu.username = :username_asig);
            
            SQL,
            array("username_asig" => $username_asig, "perfil" => $perfil, "estado_servicio" => $estado_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar para asignar");
    }

    public static function usuariosCalidad()
    {
        $result = QuerySQL::select(
            <<<SQL
                select uu.username , CONCAT(uu.nombres , ' ', uu.apellidos  ) nombre
                from usr_usuario uu 
                where uu.perfil = 13
                and uu.estado = 'ACT';
            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "buscar usuarios de calidad");
    }

    public static function usuariosAsignacion($perfil)
    {
        $result = QuerySQL::select(
            <<<SQL
                select uu.username , CONCAT(uu.nombres , ' ', uu.apellidos  ) nombre
                from usr_usuario uu 
                where uu.perfil = :perfil
                and uu.estado = 'ACT';
            SQL,
            array("perfil" => $perfil),
            true,
            "N"
        );

        return Result::success($result, "buscar usuarios de calidad");
    }

    public static function infoServicio($servicio)
    {
        $result = QuerySQL::select(
            <<<SQL
                select sss.id, ss.nom_servicio , CONCAT(uu.nombres , ' ', uu.apellidos  ) usuario_responsable, ss.tipo_servicio
                from sol_solicitud_servicio sss, srv_servicios ss , usr_usuario uu
                where sss.id = :servicio
                and sss.id_servicio = ss.id_servicio 
                and sss.id_usuario_asig = uu.username;
            SQL,
            array("servicio" => $servicio),
            false,
            "N"
        );

        return Result::success($result, "buscar info servicios en calidad");
    }

    public static function idServicio($servicio)
    {
        $result = QuerySQL::select(
            <<<SQL
                select ss.tipo_servicio
                from srv_servicios ss
                where ss.id_servicio = :servicio
            SQL,
            array("servicio" => $servicio),
            false,
            "N"
        );

        return Result::success($result, "buscar info servicios en calidad");
    }

    public static function valUltimoSrv($id_solicitud)
    {
        $result = QuerySQL::select(
            <<<SQL
            SELECT 
                ss.id_solicitud,
                CASE
                    WHEN NULLIF(TRIM(ss.obs_calidad), '') IS NULL
                    AND NULLIF(TRIM(ss.concepto_final), '') IS NULL THEN 'Faltan Observacion y concepto de Calidad'
                    WHEN NULLIF(TRIM(ss.obs_calidad), '') IS NULL THEN 'Falta Observacion de calidad'
                    WHEN NULLIF(TRIM(ss.concepto_final), '') IS NULL THEN 'Falta Concepto de Calidad'
                    ELSE 'Completo'
                END AS validacion
            FROM sol_solicitud ss
            JOIN (
                SELECT id_solicitud, COUNT(*) AS activo
                FROM sol_solicitud_servicio
                WHERE estado != 8
                AND id_solicitud = :id_solicitud
                GROUP BY id_solicitud
            ) sss ON sss.id_solicitud = ss.id_solicitud
            WHERE ss.id_solicitud = :id_solicitud
            AND sss.activo = 1;
            SQL,
            array("id_solicitud" => $id_solicitud),
            false,
            "N"
        );

        return Result::success($result, "buscar info servicios en calidad");
    }


    public static function serviciosFinalizados($username)
    {
        //print_r($username);
        //echo gettype($username);
        $result = QuerySQL::select(
            <<<SQL
                select  sss.id, sss.id_solicitud, ss2.id_empresa, ss2.id_combo, fnc_nombre_combo(ss2.id_combo) AS combo_nombre, te.razon_social, sc.numero_doc, CONCAT(sc.nombre , ' ', sc.apellido )candidato, case when ss2.usuario is not null then 
                    (select CONCAT(uu.nombres, ' ', uu.apellidos)  from usr_usuario uu where uu.username = ss2.usuario)
                    else null end nombre_responsable_sol, sss.id , sss.id_solicitud, sss.id_servicio, ss.nom_servicio , 
                    case when sss.id_usuario_asig is not null then 
                    (select CONCAT(uu.nombres, ' ', uu.apellidos)  from usr_usuario uu where uu.username = sss.id_usuario_asig)
                    else null end nombre_responsable,
                    case when sss.id_usuario_calidad  is not null then 
                    (select CONCAT(uu.nombres, ' ', uu.apellidos)  from usr_usuario uu where uu.username = sss.id_usuario_calidad)
                    else null end nombre_responsable_calidad,
                    sss.observacion_finalizacion ,
                    sss.fecha_asignado , sss.fecha_termina_proveedor, DATEDIFF(sss.fecha_termina_proveedor, sss.fecha_asignado) AS diferencia,
                    -- Estado del proceso
                    CASE 
                        WHEN sss.estado_proceso IS NOT NULL THEN CONCAT(
                            (SELECT descripcion 
                            FROM configurations 
                            WHERE categoria = 'estado_servicios' AND codigo = sss.estado),
                            ' - ',
                            (SELECT descripcion 
                            FROM configurations 
                            WHERE categoria = 'estado_servicios' AND codigo = sss.estado_proceso)
                        )
                        ELSE NULL
                    END AS estado_descripcion
                from sol_solicitud_servicio sss , srv_servicios ss, sol_solicitud ss2  , trc_empresa te, sol_candidato sc
                where sss.calificado = 'S'
                AND (:username IS NULL 
                    OR :username = '' 
                    OR TRIM(sss.id_usuario_asig) = TRIM(:username))
                and ss.id_servicio = sss.id_servicio 
                and sss.id_solicitud = ss2.id_solicitud 
                and ss2.id_empresa  = te.id_empresa 
                and ss2.id_solicitud = sc.id_solicitud 
                and ss2.doc_candidato = sc.numero_doc;

            SQL,
            array("username" => $username),
            true,
            "N"
        );

        return Result::success($result, "buscar info servicios en calidad");
    }




    public static function asigUsrCalidad($id, $id_usuario_calidad, $prioridad)
    {
        if (!isset($id) || $id == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::update(
            <<<SQL
                    update sol_solicitud_servicio
                      set id_usuario_calidad = :id_usuario_calidad,
                          estado_proceso = 2,
                          prioridad = :prioridad
                    where id = :id;
                SQL,
            array(
                "id" => $id,
                "id_usuario_calidad" => $id_usuario_calidad,
                "prioridad" => $prioridad,
            ),
            true,
            "N"
        );

        return Result::success($result, "Asignar servicio calidad");
    }

public static function asigUsrCalidadMasivo($array, $id_usuario_calidad, $prioridad)
{
    // Verificar si el array está vacío
    if (empty($array)) {
        return Result::error(__FUNCTION__, "El array está vacío");
    }

    // Variable para almacenar el resultado de las actualizaciones
    $updatedRecords = [];

    // Envio de correo a usuario de calidad
    $resultCorreos = QuerySQL::select(
    <<<SQL
            SELECT uu.email email, CONCAT(uu.nombres, ' ', uu.apellidos) nom_usuario_calidad
            FROM usr_usuario uu
            WHERE uu.username = :id_usuario_calidad
            AND uu.estado = 'ACT'
            AND uu.email IS NOT NULL;
    SQL,
        array("id_usuario_calidad" => $id_usuario_calidad),
        true,
        "N"
    );

    if (empty($resultCorreos)) {
        return Result::error(__FUNCTION__, "Usuario de calidad no encontrado o sin email");
    }

    $arrayCorreos = json_decode(json_encode($resultCorreos), true);
    $para = $arrayCorreos[0]['email'];
    $responsable = $arrayCorreos[0]['nom_usuario_calidad'];

    // Recorrer el array y actualizar cada registro
    foreach ($array as $record) {
        // Verificar si el registro contiene la propiedad 'id'
        if (isset($record['id']) && !empty($record['id'])) {

            // Nombre del candidato, usuario de calidad y servicio para el template
            $resultCorreo = QuerySQL::select(
            <<<SQL
                SELECT CONCAT(sc.nombre, ' ', sc.apellido) nom_usuario, sc.numero_doc, te.razon_social
                FROM sol_solicitud_servicio sss, sol_candidato sc, sol_solicitud ss, trc_empresa te
                WHERE sss.id = :id
                    AND sss.id_solicitud = sc.id_solicitud
                    AND ss.id_solicitud = sss.id_solicitud
                    AND ss.id_empresa = te.id_empresa;
            SQL,
                array("id" => $record['id']),
                true,
                "N"
            );
            
            $resultServicio = QuerySQL::select(
                <<<SQL
                SELECT ss1.nom_servicio, sss.id_solicitud
                FROM sol_solicitud_servicio sss, srv_servicios ss1 
                WHERE sss.id_servicio = ss1.id_servicio
                AND sss.id = :id;                     
            SQL,
                array("id" => $record['id']),
                true,
                "N"
            );

            if (empty($resultCorreo) || empty($resultServicio)) {
                $updatedRecords[] = false;
                continue;
            }

            $arrayCorreo = json_decode(json_encode($resultCorreo), true);
            $responsableCandidato = $arrayCorreo[0]['nom_usuario'];
            $cliente = $arrayCorreo[0]['razon_social'];
            $identidadCandidato = $arrayCorreo[0]['numero_doc'];

            $arrayServicio = json_decode(json_encode($resultServicio), true);
            $servicio = $arrayServicio[0]['nom_servicio'];
            $solicitud = $arrayServicio[0]['id_solicitud'];

            $text_content1 = "registre los datos de acceso para la realización del servicio"
            . "<br><br>Candidato: ". $responsableCandidato
            . "<br>Cliente: ". $cliente
            . "<br>Documento de identidad: ". $identidadCandidato;

            $mensaje = "Estimado(a) " . $responsable . ", le notificamos que le fue asignado un nuevo servicio " . $servicio . " de la solicitud " . $solicitud . " <br><br>ingrese al link <b> ". $_SERVER["HTTP_HOST"] . " </b>"
                        . "<br><br>". $text_content1;

            // cuerpo de correo
            $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
            $subject = "ASIGNACIÓN DE SERVICIO";
            $text_content = $mensaje;
            $body = '
            <!DOCTYPE html>
            <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <meta name="x-apple-disable-message-reformatting">
                <title></title>
                <!--[if mso]>
                <noscript>
                    <xml>
                        <o:OfficeDocumentSettings>
                            <o:PixelsPerInch>96</o:PixelsPerInch>
                        </o:OfficeDocumentSettings>
                    </xml>
                </noscript>
                <![endif]-->
                <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                </style>
            </head>
            <body style="margin:0;padding:0; padding-top:3%;">
                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                        <td align="center" style="padding:0;">
                            <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                <tr>
                                    <td align="center" style="padding:40px 0 30px 0;background:#748fc5;">
                                        <img width="160" height="120" src="' . $url_imagen . '" alt="" width="90%" style="height:auto;display:block;" />
                                        <!--<h1 style="font-size:24px;margin:0;color:#ffffff;">ESTADO GENERAL DE CARTERA </h1> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:36px 30px 42px 30px;">
                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                            <tr>
                                                <td style="padding:0 0 36px 0;color:#153643;">
                                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">
                                                        ' . $subject . '
                                                    </h1>
                                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                                        ' . $text_content . '<br>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;background:#748fc5;">
                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                            <tr>
                                                <td style="padding:0;width:50%;" align="left">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            </html>';

            // Actualizar el registro en la base de datos
            $result = QuerySQL::update(
                <<<SQL
                UPDATE sol_solicitud_servicio
                SET id_usuario_calidad = :id_usuario_calidad,
                    estado_proceso = 2,
                    prioridad = :prioridad
                WHERE id = :id;
                SQL,
                [
                    "id" => $record['id'],
                    "id_usuario_calidad" => $id_usuario_calidad,
                    "prioridad" => $prioridad,
                ],
                true,
                "N"
            );

            // Agregar el resultado de la actualización al arreglo de resultados
            $updatedRecords[] = $result;
            
            // ENVÍO DE CORREO - USANDO EL MISMO PATRÓN QUE EN cancelarSolicitud
            try {
                $mail = new MAIL($para, "NOTIFICACIÓN ASIGNACIÓN DE SERVICIO", $body);
            } catch (Exception $e) {
                // Si falla la creación del objeto MAIL, continuar sin correo pero registrar
                error_log("Error creando objeto MAIL: " . $e->getMessage());
                continue; // Continuar con el siguiente servicio
            }

            try {
                $mail->send();
                // Si el correo se envía exitosamente, continuar normalmente
            } catch (Exception $e) {
                // Si falla el envío, solo registrar el error pero CONTINUAR
                error_log("Error enviando correo: " . $mail->ErrorInfo);
                // NO retornar aquí - solo continuar
            }
        }
    }

    // Verificar si se realizaron actualizaciones correctamente
    $success = !in_array(false, $updatedRecords);

    if ($success) {
        return Result::success($updatedRecords, "Actualización exitosa de los registros");
    } else {
        return Result::error(__FUNCTION__, "Error al actualizar uno o más registros");
    }
}
    
    public static function asigUsrMasivo($array, $id_usuario_asig)
    {
        // Verificar si el array está vacío
        if (empty($array)) {
            return Result::error(__FUNCTION__, "El array está vacío");
        }
    
        // Variable para almacenar el resultado de las actualizaciones
        $updatedRecords = [];
    
        // Recorrer el array y actualizar cada registro
        foreach ($array as $record) {
            // Verificar si el registro contiene la propiedad 'id_solicitud'
            if (isset($record['id_solicitud']) && !empty($record['id_solicitud'])) {
                // Actualizar el registro en la base de datos
                $result = CtrSolSolicitudServicio::asignar($record['id_solicitud'], $record['id_servicio'], $id_usuario_asig);
                /*$result = QuerySQL::update(
                    <<<SQL
                    UPDATE sol_solicitud_servicio
                    SET id_usuario_asig = :id_usuario_asig,
                        estado_proceso = 0,
                    WHERE id = :id;
                    SQL,
                    [
                        "id" => $record['id'],
                        "id_usuario_asig" => $id_usuario_asig,
                    ],
                    true,
                    "N"
                );*/
    
                // Agregar el resultado de la actualización al arreglo de resultados
                $updatedRecords[] = $result;
            }
        }
    
        // Verificar si se realizaron actualizaciones correctamente
        $success = !in_array(false, $updatedRecords);
    
        if ($success) {
            return Result::success($updatedRecords, "Actualización exitosa de los registros");
        } else {
            return Result::error(__FUNCTION__, "Error al actualizar uno o más registros");
        }
    }

    public static function infoServicioByFact($id)
    {
        if (!isset($id) || $id == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select sss.id, sss.id_solicitud , sss.id_servicio , ss.id_combo , ss.ciudad_vacante , sss.observacion_finalizacion, ss.doc_candidato
                from sol_solicitud_servicio sss , sol_solicitud ss 
                where id = :id
                and sss.id_solicitud = ss.id_solicitud  
                SQL,
            array(
                "id" => $id,
            ),
            false,
            "N"
        );

        return Result::success($result, "Busca la informacion del servicio con el ID");
    }


    public static function serviciosCalificados($filter = array())

    {
        if (!isset($filter['fecha_desde']) || $filter['fecha_desde'] == "")
            $filter['fecha_desde'] = null;

        if (!isset($filter['fecha_hasta']) || $filter['fecha_hasta'] == "")
            $filter['fecha_hasta'] = null;

        if (!isset($filter['proveedor']) || $filter['proveedor'] == "")
            $filter['proveedor'] = 'all';

        $result = QuerySQL::select(
            <<<SQL
            SELECT 
                sss.id, 
                sss.fecha_termina_proveedor,
                ss.nom_servicio,
                te.razon_social,
                CONCAT(sc.nombre, ' ', sc.apellido) AS candidato,
                sc.numero_doc,
                CASE 
                    WHEN sss.estado_proceso IS NOT NULL THEN 
                        (SELECT descripcion 
                        FROM configurations c 
                        WHERE categoria = 'estado_servicios' 
                        AND codigo = sss.estado_proceso)
                    ELSE 
                        NULL
                END AS estado,
                ssc.pregunta1,  
                ssc.pregunta2, 
                ssc.pregunta3, 
                ssc.pregunta4,   
                sss.observacion_finalizacion
            FROM 
                srv_servicios_calificados ssc, 
                sol_solicitud_servicio sss , 
                srv_servicios ss , 
                sol_solicitud ss2 , 
                trc_empresa te , 
                sol_candidato sc 
            WHERE 
                ssc.id_solicitud = sss.id_solicitud 
                AND ssc.id_servicio = sss.id_servicio 
                AND sss.calificado = 'S'
                AND sss.estado = 8
                AND sss.estado_proceso IN (6,7)
                AND sss.id_servicio = ss.id_servicio
                AND ss2.id_solicitud = sss.id_solicitud
                AND ss2.id_empresa = te.id_empresa
                AND ss2.id_solicitud = sc.id_solicitud
                AND sss.id_usuario_asig = :proveedor
                AND DATE(sss.fecha_termina_proveedor) BETWEEN :fecha_desde AND :fecha_hasta
            GROUP BY  
                sss.id, 
                sss.fecha_termina_proveedor,
                ss.nom_servicio,
                te.razon_social,
                CONCAT(sc.nombre, ' ', sc.apellido),
                sc.numero_doc,
                ssc.pregunta1,  
                ssc.pregunta2, 
                ssc.pregunta3, 
                ssc.pregunta4,   
                sss.observacion_finalizacion
            UNION ALL 
            SELECT 
                'Total' AS id, 
                '' AS fecha_termina_proveedor, 
                '' AS nom_servicio, 
                '' AS razon_social, 
                '' AS candidato, 
                '' AS numero_doc, 
                '' AS estado, 
                SUM(ssc.pregunta1), 
                SUM(ssc.pregunta2), 
                SUM(ssc.pregunta3), 
                SUM(ssc.pregunta4), 
                'union all' AS observacion
            FROM 
                srv_servicios_calificados ssc, 
                sol_solicitud_servicio sss , 
                srv_servicios ss , 
                sol_solicitud ss2 , 
                trc_empresa te , 
                sol_candidato sc 
            WHERE 
                ssc.id_solicitud = sss.id_solicitud 
                AND ssc.id_servicio = sss.id_servicio 
                AND sss.calificado = 'S'
                AND sss.estado = 8
                AND sss.estado_proceso IN (6,7)
                AND sss.id_servicio = ss.id_servicio
                AND ss2.id_solicitud = sss.id_solicitud
                AND ss2.id_empresa = te.id_empresa
                AND ss2.id_solicitud = sc.id_solicitud 
                AND sss.id_usuario_asig = :proveedor
                AND DATE(sss.fecha_termina_proveedor) BETWEEN :fecha_desde AND :fecha_hasta;

            SQL,
            array(
                "fecha_desde" => $filter['fecha_desde'],
                "fecha_hasta" => $filter['fecha_hasta'],
                "proveedor"   => $filter['proveedor']
            ),
            true,
            "N"
        );

        return Result::success($result, "buscar servicios calificados");
    }
    public static function serviciosXProductos($id_empresa, $id_producto)
    {
        $empresaPapa = CtrTrcEmpresa::findByIdPadre($id_empresa);
        //print_r($empresaPapa['data'][0]['id_empresa_padre']);
        $empresaPapaId = $empresaPapa['data'][0]['id_empresa_padre'];
        $clientePinta = '';

        if ($empresaPapaId == null && $empresaPapaId == '') {
            $clientePinta = $id_empresa;
        } else {
            $clientePinta = $empresaPapaId;
        }
        $result = QuerySQL::select(
            <<<SQL
                select DISTINCT ss.id_servicio , ss.nom_servicio  
                from trc_combo_cli tcc , srv_combo_servicios scs , srv_servicios ss, srv_producto sp 
                where tcc.id_empresa = :clientePinta
                and sp.id_producto = :id_producto
                and tcc.id_combo = scs.id_combo 
                and scs.activo = 1
                and scs.id_servicio = ss.id_servicio 
                and ss.estado = 1
                and sp.id_producto = ss.id_producto 
                order by 1
            SQL,
            array(
                "clientePinta" => $clientePinta,
                "id_producto" => $id_producto,
            ),
            true,
            "S"
        );

        return Result::success($result, "buscar servicios por empresa y producto");
    }
}
