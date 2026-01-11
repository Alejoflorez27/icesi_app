<?php

class CtrVivPasivos
{
    //Crear un egreso del candidato o de su familia
    public static function crear($id_solicitud, $id_servicio, $concepto_pasivo, $otros, $tipo_familiar, $otro_propietario, $valor_pasivo, $plazo_pasivo, $couta, $estado_obligacion, $valor_mora)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");

        $obj_vivPasivo = new VivPasivos();
        $obj_vivPasivo->setProperty('id_solicitud', $id_solicitud);
        $obj_vivPasivo->setProperty('id_servicio', $id_servicio);
        $obj_vivPasivo->setProperty('concepto_pasivo', $concepto_pasivo);
        $obj_vivPasivo->setProperty('otros', $otros);
        $obj_vivPasivo->setProperty('tipo_familiar', $tipo_familiar);
        $obj_vivPasivo->setProperty('otro_propietario', $otro_propietario);
        $obj_vivPasivo->setProperty('valor_pasivo', $valor_pasivo);
        $obj_vivPasivo->setProperty('plazo_pasivo', $plazo_pasivo);
        $obj_vivPasivo->setProperty('couta', $couta);
        $obj_vivPasivo->setProperty('estado_obligacion', $estado_obligacion);
        $obj_vivPasivo->setProperty('valor_mora', $valor_mora);
        

        $result = $obj_vivPasivo->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una distribucion de la vivienda

    //listar los egresos del candidato y su familia
    public static function findAllCandidato($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT vp.id_pasivo,
                    vp.id_solicitud,
                    vp.id_servicio,
                    vp.concepto_pasivo,
                    vp.otros,
                    vp.tipo_familiar,
                    vp.otro_propietario,
                    vp.valor_pasivo,
                    vp.plazo_pasivo,
                    vp.couta,
                    vp.estado_obligacion,
                    vp.valor_mora,
                    fcn_desc_configurations('tipo_pasivo_vi', vp.concepto_pasivo) descripcion_tipo_pasivo,
                    fcn_desc_configurations('tipo_responsable_egreso_vi', vp.tipo_familiar) descripcion_tipo_responsable,
                    fcn_desc_configurations('tipo_plazo_pasivo_vi', vp.plazo_pasivo) descripcion_tipo_plazo,
                    fcn_desc_configurations('tipo_estado_obligacion', vp.estado_obligacion) descripcion_tipo_estado_obigacion
                FROM viv_pasivos vp
                WHERE vp.id_solicitud = :id_solicitud
                and vp.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar pasivo del candidato y su familia");
    }//Fin de listar los estudios del candidato

        //listar los egresos del candidato y su familia
        public static function findAllFuncionario($id_solicitud, $id_servicio)
        {
    
            $result = QuerySQL::select(
                <<<SQL
                    SELECT vp.id_pasivo,
                        vp.id_solicitud,
                        vp.id_servicio,
                        vp.concepto_pasivo,
                        vp.otros,
                        vp.tipo_familiar,
                        vp.otro_propietario,
                        vp.valor_pasivo,
                        vp.plazo_pasivo,
                        vp.couta,
                        vp.estado_obligacion,
                        vp.valor_mora,
                        fcn_desc_configurations('tipo_pasivo_vi', vp.concepto_pasivo) descripcion_tipo_pasivo,
                        fcn_desc_configurations('tipo_responsable_egreso_vm', vp.tipo_familiar) descripcion_tipo_responsable,
                        fcn_desc_configurations('tipo_plazo_pasivo_vi', vp.plazo_pasivo) descripcion_tipo_plazo,
                        fcn_desc_configurations('tipo_estado_obligacion', vp.estado_obligacion) descripcion_tipo_estado_obigacion
                    FROM viv_pasivos vp
                    WHERE vp.id_solicitud = :id_solicitud
                    and vp.id_servicio = :id_servicio
                SQL,
                array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
                true,
                "N"
            );
    
            return Result::success($result, "buscar pasivo del candidato y su familia");
        }//Fin de listar los estudios del candidato
    

    //totales de los pasivos y los activos
    public static function totales($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT subconsulta.id_solicitud,
                subconsulta.id_servicio,
                subconsulta.suma_valor_activo,
                viv_pasivos.suma_valor_pasivo
            FROM (
                SELECT va.id_solicitud,
                    va.id_servicio,
                    SUM(va.valor_activo) AS suma_valor_activo
                FROM viv_activos va
                WHERE va.id_solicitud = :id_solicitud
                AND va.id_servicio = :id_servicio
                GROUP BY va.id_solicitud, va.id_servicio
            ) AS subconsulta
            LEFT JOIN (
                SELECT op.id_solicitud,
                    op.id_servicio,
                    SUM(op.valor_pasivo) AS suma_valor_pasivo
                FROM viv_pasivos op
                WHERE op.id_solicitud = :id_solicitud
                AND op.id_servicio = :id_servicio
                GROUP BY op.id_solicitud, op.id_servicio
            ) AS viv_pasivos ON subconsulta.id_solicitud = viv_pasivos.id_solicitud AND subconsulta.id_servicio = viv_pasivos.id_servicio;
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "suma de los totales");
    }//Fin totales de los pasivos y los activos



    //listar los ingresos del candidato y su familia por no exists
    public static function findAllNoExists($tipo_pasivo_vi)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT * FROM configurations c 
            WHERE categoria = :tipo_pasivo_vi
            AND estado = 'ACT'
            AND NOT EXISTS (SELECT 1 
                            FROM viv_pasivos vp
                            WHERE vp.concepto_pasivo = c.codigo )
            SQL,
            array("tipo_pasivo_vi" => $tipo_pasivo_vi),
            true,
            "N"
        );

        return Result::success($result, "buscar pasivos del candidato no repetido");
    }//Fin de listar los estudios del candidato

    //Editar un registro de egresos  del candidato
    public static function findByIdPasivos($id_pasivo)
    {
        if (!isset($id_pasivo) || $id_pasivo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select vp.*, c.descripcion AS descripcion_tipo_concepto
                    from viv_pasivos vp, sol_solicitud sc, configurations c
                    where vp.id_solicitud  = sc.id_solicitud
                    and  vp.id_pasivo  = :id_pasivo
                    and c.codigo =  vp.concepto_pasivo
                    and c.categoria = 'tipo_pasivo_vi'
            SQL,
            array("id_pasivo" => $id_pasivo),
            false,
            "N"
        );

        return Result::success($result, "buscar Pasivos");
    }//Fin de Editar un registro de egresos del candidato

    //Editar un registro de egresos  del candidato
    public static function findByIdPasivosPolPre($id_pasivo)
    {
        if (!isset($id_pasivo) || $id_pasivo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select vp.*
                    from viv_pasivos vp, sol_solicitud sc
                    where vp.id_solicitud  = sc.id_solicitud
                    and  vp.id_pasivo  = :id_pasivo
                    
            SQL,
            array("id_pasivo" => $id_pasivo),
            false,
            "N"
        );

        return Result::success($result, "buscar Pasivos");
    }//Fin de Editar un registro de egresos del candidato

    //Editar un registro de egresos  del candidato
    public static function findByIdPasivosPolRutina($id_pasivo)
    {
        if (!isset($id_pasivo) || $id_pasivo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select vp.*
                    from viv_pasivos vp, sol_solicitud sc
                    where vp.id_solicitud  = sc.id_solicitud
                    and  vp.id_pasivo  = :id_pasivo
                    
            SQL,
            array("id_pasivo" => $id_pasivo),
            false,
            "N"
        );

        return Result::success($result, "buscar Pasivos");
    }//Fin de Editar un registro de egresos del candidato

    //Borrar un registro por id
    public static function delete($id_pasivo)
    {
        if (!isset($id_pasivo) || $id_pasivo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivPasivos($id_pasivo);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar el egreso del candidato
    public static function update(
        $id_pasivo,
        $concepto_pasivo,
        $otros,
        $tipo_familiar,
        $otro_propietario,
        $valor_pasivo,
        $plazo_pasivo,
        $couta,
        $estado_obligacion,
        $valor_mora

    ) {
        if (!isset($id_pasivo) || $id_pasivo == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivPasivos($id_pasivo);
        $dao->setProperty('concepto_pasivo', $concepto_pasivo);
        $dao->setProperty('otros', $otros);
        $dao->setProperty('tipo_familiar', $tipo_familiar);
        $dao->setProperty('otro_propietario', $otro_propietario);
        $dao->setProperty('valor_pasivo', $valor_pasivo);
        $dao->setProperty('plazo_pasivo', $plazo_pasivo);
        $dao->setProperty('couta', $couta);
        $dao->setProperty('estado_obligacion', $estado_obligacion);
        $dao->setProperty('valor_mora', $valor_mora);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos

    //Actualizar el egreso del candidato
    public static function updatePolPre(
        $id_pasivo,
        $otros

    ) {
        if (!isset($id_pasivo) || $id_pasivo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivPasivos($id_pasivo);
        $dao->setProperty('otros', $otros);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos

    //Actualizar el egreso del candidato
    public static function updatePolRutina(
        $id_pasivo,
        $otros

    ) {
        if (!isset($id_pasivo) || $id_pasivo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivPasivos($id_pasivo);
        $dao->setProperty('otros', $otros);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
