<?php

class CtrSolLaboral
{
    //Crear una Laboral
    public static function crear($id_solicitud, 
                                 $id_servicio, 
                                 $nombre_empresa, 
                                 $telefono_empresa, 
                                 $fch_ingreso, 
                                 $fch_retiro, 
                                 $cargo_ingreso, 
                                 $cargo_finalizo,
                                 $tipo_contrato, 
                                 $jefe_inmediato, 
                                 $cargo_jefe,
                                 $numero_jefe, 
                                 $funciones_desarrolladas,
                                 $tipo_retiro, 
                                 $motivo_retiro,
                                 $estado_empresa,
                                 $tmp_total_laborado,
                                 $horario_trabajo,
                                 $observaciones,
                                 $nom_funcionario_valida,
                                 $cargo_funcionario_valida,
                                 $concepto,
                                 $id_ciudad_act)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        /*if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");*/

        $obj_solLaboral = new SolLaboral();
        $obj_solLaboral->setProperty('id_solicitud', $id_solicitud);
        $obj_solLaboral->setProperty('id_servicio', $id_servicio);
        $obj_solLaboral->setProperty('nombre_empresa', $nombre_empresa);
        $obj_solLaboral->setProperty('telefono_empresa', $telefono_empresa);
        $obj_solLaboral->setProperty('fch_ingreso', $fch_ingreso);
        $obj_solLaboral->setProperty('fch_retiro', $fch_retiro);
        $obj_solLaboral->setProperty('cargo_ingreso', $cargo_ingreso);
        $obj_solLaboral->setProperty('cargo_finalizo', $cargo_finalizo);
        $obj_solLaboral->setProperty('tipo_contrato', $tipo_contrato);
        $obj_solLaboral->setProperty('jefe_inmediato', $jefe_inmediato);
        $obj_solLaboral->setProperty('cargo_jefe', $cargo_jefe);
        $obj_solLaboral->setProperty('numero_jefe', $numero_jefe);
        $obj_solLaboral->setProperty('funciones_desarrolladas', $funciones_desarrolladas);
        $obj_solLaboral->setProperty('tipo_retiro', $tipo_retiro);
        $obj_solLaboral->setProperty('motivo_retiro', $motivo_retiro);
        $obj_solLaboral->setProperty('estado_empresa', $estado_empresa);
        $obj_solLaboral->setProperty('tmp_total_laborado', $tmp_total_laborado);
        $obj_solLaboral->setProperty('horario_trabajo', $horario_trabajo);
        $obj_solLaboral->setProperty('observaciones', $observaciones);
        $obj_solLaboral->setProperty('nom_funcionario_valida', $nom_funcionario_valida);
        $obj_solLaboral->setProperty('cargo_funcionario_valida', $cargo_funcionario_valida);
        $obj_solLaboral->setProperty('concepto', $concepto);
        $obj_solLaboral->setProperty('id_ciudad_act', $id_ciudad_act);


        $result = $obj_solLaboral->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una laboral

    //listar laboral
    public static function findAll($estado = null)
    {

        $result = QuerySQL::select(
            <<<SQL
                select  sl.id_laboral ,sl.id_solicitud, sl.nombre_empresa , sl.telefono_empresa, sl.fch_ingreso, sl.fch_retiro, sl.cargo_ingreso, sl.cargo_finalizo, 
                sl.tipo_contrato, sl.jefe_inmediato, sl.cargo_jefe, sl.numero_jefe, sl.funciones_desarrolladas, sl.motivo_retiro 
                    from sol_laboral sl , sol_candidato sc 
                    where sl.id_solicitud  = sc.id_solicitud   
            SQL,
            null,
            true,
            "N"
        );

        return Result::success($result, "buscar laboral");
    }//Fin de listar los laborales

    //Trae el nombre de la empresa y retorna el tipo de contrato
    public static function descripcionLaboral_visitas($id_solicitud/*, $id_servicio*/){

        $result = QuerySQL::select(
            <<<SQL

            select sl.id_laboral,
            	   sl.id_solicitud,
            	   sl.id_servicio,
            	   sl.nombre_empresa,
            	   sl.telefono_empresa,
            	   sl.fch_ingreso,
            	   sl.fch_retiro,
            	   sl.cargo_ingreso,
            	   sl.cargo_finalizo,
            	   fcn_desc_configurations('tipo_contrato', sl.tipo_contrato)tipo_contrato,
            	   sl.jefe_inmediato,
            	   sl.cargo_jefe,
            	   sl.numero_jefe,
            	   sl.funciones_desarrolladas,
            	   fcn_desc_configurations('tipo_motivo_retiro', sl.tipo_retiro)tipo_retiro,
            	   sl.motivo_retiro,
                   fcn_desc_configurations('tipo_estado_empresa', sl.estado_empresa)estado_empresa,
                   sl.tmp_total_laborado,
                   fcn_desc_configurations('tipo_horario_trabajo', sl.horario_trabajo)horario_trabajo,
                   sl.observaciones,
                   sl.nom_funcionario_valida,
                   sl.cargo_funcionario_valida,
                   sl.concepto,
                   sl.id_ciudad_act,
            	   sl.fch_create,
            	   sl.usr_create
            from sol_laboral sl
            where sl.id_solicitud = :id_solicitud
              -- and sl.id_servicio = :id_servicio
              ORDER BY fch_ingreso DESC
            
            SQL,
        array("id_solicitud" => $id_solicitud/*,"id_servicio" => $id_servicio*/),
            true,
            "N"
        );
    
        return Result::success($result, "buscar Laboral Visitas");
    
    }

    //Trae el nombre de la empresa y retorna el tipo de contrato
    public static function descripcionLaboral_pol_pre($id_solicitud){

        $result = QuerySQL::select(
            <<<SQL

            SELECT
                sl.id_laboral,
                sl.id_solicitud,
                sl.id_servicio,
                sl.nombre_empresa,
                sl.telefono_empresa,
                sl.fch_ingreso,
                sl.fch_retiro,
                sl.cargo_ingreso,
                sl.cargo_finalizo,
                fcn_desc_configurations('tipo_contrato', sl.tipo_contrato) AS tipo_contrato,
                sl.jefe_inmediato,
                sl.cargo_jefe,
                sl.numero_jefe,
                sl.funciones_desarrolladas,
                fcn_desc_configurations('tipo_motivo_retiro', sl.tipo_retiro) AS tipo_retiro,
                sl.motivo_retiro,
                fcn_desc_configurations('tipo_estado_empresa', sl.estado_empresa) AS estado_empresa,
                sl.tmp_total_laborado,
                fcn_desc_configurations('tipo_horario_trabajo', sl.horario_trabajo) AS horario_trabajo,
                sl.observaciones,
                sl.nom_funcionario_valida,
                sl.cargo_funcionario_valida,
                sl.concepto,
                -- sl.id_ciudad_act,
                sl.fch_create,
                sl.usr_create,
                cc.nombre AS id_ciudad_act                          
            FROM
                sol_laboral sl
            LEFT JOIN
                conf_ciudad cc ON cc.id_ciudad = sl.id_ciudad_act
            WHERE
                sl.id_solicitud = :id_solicitud;

            
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );
    
        return Result::success($result, "buscar información laboral");
    
    }

    //Trae el nombre de la empresa y retorna el tipo de contrato
    public static function descripcionLaboral($id_solicitud){

        $result = QuerySQL::select(
            <<<SQL
            select sl.id_laboral,
            	   sl.id_solicitud,
            	   sl.id_servicio,
            	   sl.nombre_empresa,
            	   sl.telefono_empresa,
            	   sl.fch_ingreso,
            	   sl.fch_retiro,
            	   sl.cargo_ingreso,
            	   sl.cargo_finalizo,
            	   fcn_desc_configurations('tipo_contrato', sl.tipo_contrato)tipo_contrato,
            	   sl.jefe_inmediato,
            	   sl.cargo_jefe,
            	   sl.numero_jefe,
            	   sl.funciones_desarrolladas,
            	   fcn_desc_configurations('tipo_motivo_retiro', sl.tipo_retiro)tipo_retiro,
            	   sl.motivo_retiro,
                   fcn_desc_configurations('tipo_estado_empresa', sl.estado_empresa)estado_empresa,
                   sl.tmp_total_laborado,
                   fcn_desc_configurations('tipo_horario_trabajo', sl.horario_trabajo)horario_trabajo,
                   sl.observaciones,
                   sl.nom_funcionario_valida,
                   sl.cargo_funcionario_valida,
                   sl.concepto,
                   sl.id_ciudad_act,
            	   sl.fch_create,
            	   sl.usr_create
            from sol_laboral sl
            where sl.id_solicitud = :id_solicitud
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );
    
        return Result::success($result, "buscar información laboral");
    
    }

    //Editar un registro de formacion academica del candidato
    public static function findByIdLaboral($id_laboral)
    {
        if (!isset($id_laboral) || $id_laboral == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select  sl.id_laboral, 
                        sl.id_solicitud, 
                        sl.nombre_empresa, 
                        sl.telefono_empresa, 
                        sl.fch_ingreso, 
                        sl.fch_retiro, 
                        sl.cargo_ingreso, 
                        sl.cargo_finalizo, 
                        sl.tipo_contrato, 
                        sl.jefe_inmediato, 
                        sl.cargo_jefe, 
                        sl.numero_jefe, 
                        sl.funciones_desarrolladas, 
                        sl.motivo_retiro,
                        sl.estado_empresa,
                        sl.tmp_total_laborado,
                        sl.horario_trabajo,
                        sl.observaciones,
                        sl.nom_funcionario_valida,
                        sl.cargo_funcionario_valida,
                        sl.concepto,
                        sl.id_ciudad_act,
                        sl.tipo_retiro
                    from sol_laboral sl , sol_candidato sc 
                    where sl.id_solicitud  = sc.id_solicitud
                    and  sl.id_laboral  = :id_laboral
            SQL,
            array("id_laboral" => $id_laboral),
            false,
            "N"
        );

        return Result::success($result, "buscar laboral");
    }//Fin de Editar un registro de laboral

    //Editar un registro de formacion academica del candidato
    public static function findByIdLaboralPolPre($id_laboral)
    {
        if (!isset($id_laboral) || $id_laboral == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
            SELECT
                sl.id_laboral,
                sl.id_solicitud,
                sl.nombre_empresa,
                sl.telefono_empresa,
                sl.fch_ingreso,
                sl.fch_retiro,
                sl.cargo_ingreso,
                sl.cargo_finalizo,
                sl.tipo_contrato,
                sl.jefe_inmediato,
                sl.cargo_jefe,
                sl.numero_jefe,
                sl.funciones_desarrolladas,
                sl.motivo_retiro,
                sl.estado_empresa,
                sl.tmp_total_laborado,
                sl.horario_trabajo,
                sl.observaciones,
                sl.nom_funcionario_valida,
                sl.cargo_funcionario_valida,
                sl.concepto,
                sl.id_ciudad_act,
                cc.id_dpto,
                cd.id_pais,
                sl.tipo_retiro
            FROM
                sol_laboral sl
            JOIN
                sol_candidato sc ON sl.id_solicitud = sc.id_solicitud
            LEFT JOIN
                conf_ciudad cc ON sl.id_ciudad_act = cc.id_ciudad
            LEFT JOIN
                conf_dpto cd ON cc.id_dpto = cd.id_dpto
            LEFT JOIN
                conf_pais cp ON cd.id_pais = cp.id_pais
            WHERE

                sl.id_laboral = :id_laboral;

            SQL,
            array("id_laboral" => $id_laboral),
            false,
            "N"
        );

        return Result::success($result, "buscar laboral");
    }//Fin de Editar un registro de laboral

    //Borrar un registro por id
    public static function delete($id_laboral)
    {
        if (!isset($id_laboral) || $id_laboral == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolLaboral($id_laboral);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar la información laboral del candidato
    public static function update(
        $id_laboral,
        $nombre_empresa,
        $telefono_empresa,
        $fch_ingreso,
        $fch_retiro,
        $cargo_ingreso,
        $cargo_finalizo,
        $tipo_contrato,
        $jefe_inmediato,
        $cargo_jefe,
        $numero_jefe,
        $funciones_desarrolladas,
        $tipo_retiro
    ) {
        if (!isset($id_laboral) || $id_laboral == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolLaboral($id_laboral);
        $dao->setProperty('nombre_empresa', $nombre_empresa);
        $dao->setProperty('telefono_empresa', $telefono_empresa);
        $dao->setProperty('fch_ingreso', $fch_ingreso);
        $dao->setProperty('fch_retiro', $fch_retiro);
        $dao->setProperty('cargo_ingreso', $cargo_ingreso);
        $dao->setProperty('cargo_finalizo', $cargo_finalizo);
        $dao->setProperty('tipo_contrato', $tipo_contrato);
        $dao->setProperty('jefe_inmediato', $jefe_inmediato);
        $dao->setProperty('cargo_jefe', $cargo_jefe);
        $dao->setProperty('numero_jefe', $numero_jefe);
        $dao->setProperty('funciones_desarrolladas', $funciones_desarrolladas);
        $dao->setProperty('tipo_retiro', $tipo_retiro); 

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la información laboral del candidato

    //Actualizar la información laboral del candidato visita ingreso
    public static function update_visita_ingreso(
        $id_laboral,
        $nombre_empresa,
        $telefono_empresa,
        $fch_ingreso,
        $fch_retiro,
        $cargo_finalizo,
        $tipo_contrato,
        $jefe_inmediato,
        $cargo_jefe,
        $numero_jefe,
        $tipo_retiro,
        $motivo_retiro
    ) {
        if (!isset($id_laboral) || $id_laboral == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolLaboral($id_laboral);
        $dao->setProperty('nombre_empresa', $nombre_empresa);
        $dao->setProperty('telefono_empresa', $telefono_empresa);
        $dao->setProperty('fch_ingreso', $fch_ingreso);
        $dao->setProperty('fch_retiro', $fch_retiro);
        $dao->setProperty('cargo_finalizo', $cargo_finalizo);
        $dao->setProperty('tipo_contrato', $tipo_contrato);
        $dao->setProperty('jefe_inmediato', $jefe_inmediato);
        $dao->setProperty('cargo_jefe', $cargo_jefe);
        $dao->setProperty('numero_jefe', $numero_jefe);
        $dao->setProperty('tipo_retiro', $tipo_retiro); 
        $dao->setProperty('motivo_retiro', $motivo_retiro); 

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la información laboral del candidato visita ingreso

    //Actualizar la información laboral del candidato
    public static function update_ver_laboral(
        $id_laboral,
        $nombre_empresa,
        $telefono_empresa,
        $fch_ingreso,
        $fch_retiro,
        $cargo_ingreso,
        $cargo_finalizo,
        $tipo_contrato,
        $jefe_inmediato,
        $cargo_jefe,
        $numero_jefe,
        $funciones_desarrolladas,
        $tipo_retiro,
        $estado_empresa,
        $tmp_total_laborado,
        $horario_trabajo,
        $observaciones,
        $nom_funcionario_valida,
        $cargo_funcionario_valida,
        $concepto

    ) {
        if (!isset($id_laboral) || $id_laboral == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolLaboral($id_laboral);
        $dao->setProperty('nombre_empresa', $nombre_empresa);
        $dao->setProperty('telefono_empresa', $telefono_empresa);
        $dao->setProperty('fch_ingreso', $fch_ingreso);
        $dao->setProperty('fch_retiro', $fch_retiro);
        $dao->setProperty('cargo_ingreso', $cargo_ingreso);
        $dao->setProperty('cargo_finalizo', $cargo_finalizo);
        $dao->setProperty('tipo_contrato', $tipo_contrato);
        $dao->setProperty('jefe_inmediato', $jefe_inmediato);
        $dao->setProperty('cargo_jefe', $cargo_jefe);
        $dao->setProperty('numero_jefe', $numero_jefe);
        $dao->setProperty('funciones_desarrolladas', $funciones_desarrolladas);
        $dao->setProperty('tipo_retiro', $tipo_retiro); 
        $dao->setProperty('estado_empresa', $estado_empresa);
        $dao->setProperty('tmp_total_laborado', $tmp_total_laborado);
        $dao->setProperty('horario_trabajo', $horario_trabajo);
        $dao->setProperty('observaciones', $observaciones);
        $dao->setProperty('nom_funcionario_valida', $nom_funcionario_valida);
        $dao->setProperty('cargo_funcionario_valida', $cargo_funcionario_valida);
        $dao->setProperty('concepto', $concepto); 

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la información laboral del candidato

    //Actualizar la Formacion Academica
    public static function update_pol_pre(
        $id_laboral,
        $nombre_empresa,
        $fch_ingreso,
        $fch_retiro,
        $cargo_ingreso,
        $cargo_finalizo,
        $funciones_desarrolladas,
        $tipo_retiro,
        $motivo_retiro,
        $tmp_total_laborado,
        $observaciones,
        $id_ciudad_act

    ) {
        if (!isset($id_laboral) || $id_laboral == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolLaboral($id_laboral);
        $dao->setProperty('nombre_empresa', $nombre_empresa);
        $dao->setProperty('fch_ingreso', $fch_ingreso);
        $dao->setProperty('fch_retiro', $fch_retiro);
        $dao->setProperty('cargo_ingreso', $cargo_ingreso);
        $dao->setProperty('cargo_finalizo', $cargo_finalizo);
        $dao->setProperty('funciones_desarrolladas', $funciones_desarrolladas);
        $dao->setProperty('tipo_retiro', $tipo_retiro); 
        $dao->setProperty('motivo_retiro', $motivo_retiro);
        $dao->setProperty('tmp_total_laborado', $tmp_total_laborado);
        $dao->setProperty('observaciones', $observaciones);
        $dao->setProperty('id_ciudad_act', $id_ciudad_act); 

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la Laboral

    //Actualizar la Formacion Academica
    public static function update_pol_rutina(
        $id_laboral,
        $nombre_empresa,
        $fch_ingreso,
        $cargo_ingreso,
        $cargo_finalizo,
        $funciones_desarrolladas,
        $tmp_total_laborado,
        $observaciones,
        $id_ciudad_act

    ) {
        if (!isset($id_laboral) || $id_laboral == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolLaboral($id_laboral);
        $dao->setProperty('nombre_empresa', $nombre_empresa);
        $dao->setProperty('fch_ingreso', $fch_ingreso);
        $dao->setProperty('cargo_ingreso', $cargo_ingreso);
        $dao->setProperty('cargo_finalizo', $cargo_finalizo);
        $dao->setProperty('funciones_desarrolladas', $funciones_desarrolladas);
        $dao->setProperty('tmp_total_laborado', $tmp_total_laborado);
        $dao->setProperty('observaciones', $observaciones);
        $dao->setProperty('id_ciudad_act', $id_ciudad_act); 

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la Laboral
}
