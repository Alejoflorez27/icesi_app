<?php

class CtrFotografiaVsa
{

    public static function crear($id_solicitud, $id_servicio, $requisito, $calificacion, $observacion, $respuesta_abierta)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicios es requerido");
        $obj_info = new fotografiaVsa();
        $obj_info->setProperty('id_solicitud', $id_solicitud);
        $obj_info->setProperty('id_servicio', $id_servicio);
        $obj_info->setProperty('requisito', $requisito);
        $obj_info->setProperty('calificacion', $calificacion);
        $obj_info->setProperty('observacion', $observacion);
        $obj_info->setProperty('respuesta_abierta', $respuesta_abierta);

        $result = $obj_info->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findAll($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT ve.id_fotografia,
                        ve.id_solicitud,
                        ve.id_servicio,
                        fcn_desc_configurations('tipo_concepto_asociado_visita_asociado', ve.requisito) requisito,
                        fcn_desc_configurations('tipo_calificacion_visita_asociado', ve.calificacion) calificacion,
                        -- ve.calificacion,
                        ve.observacion,
                        ve.respuesta_abierta,
                        ve.usr_create,
                        ve.fch_create
                FROM fotografia_vsa ve
                WHERE ve.id_solicitud = :id_solicitud
                and ve.id_servicio = :id_servicio
                ORDER BY ve.requisito ASC;

            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar los factores de riesgo");
    }

    public static function ExiteVariable($descripcion ,$id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
            select 1 existe
                from fotografia_vsa dr 
                where dr.requisito  = :descripcion 
                and dr.id_solicitud = :id_solicitud
            SQL,
            array("descripcion" => $descripcion,
                  "id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "validar si existe");
    }


    public static function findByIdInfo($id_fotografia)
    {
        if (!isset($id_fotografia) || $id_fotografia == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                    select ve.id_fotografia,
                        ve.id_solicitud,
                        ve.id_servicio,
                        ve.requisito,
                        ve.calificacion,
                        ve.observacion,
                        ve.respuesta_abierta,
                        ve.usr_create,
                        ve.fch_create
                        from fotografia_vsa ve, sol_solicitud sc
                            WHERE ve.id_fotografia  = :id_fotografia
                            and ve.id_solicitud  = sc.id_solicitud
            SQL,
            array("id_fotografia" => $id_fotografia),
            false,
            "N"
        );

        return Result::success($result, "buscar factor de riesgo");
    }

    public static function delete($id_fotografia)
    {
        if (!isset($id_fotografia) || $id_fotografia == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new fotografiaVsa($id_fotografia);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Actualizar el egreso del candidato
    public static function update(
        $id_fotografia,
        $requisito,
        $calificacion,
        $observacion,
        $respuesta_abierta

    ) {
        if (!isset($id_fotografia) || $id_fotografia == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new fotografiaVsa($id_fotografia);
        $dao->setProperty('requisito', $requisito);
        $dao->setProperty('calificacion', $calificacion);
        $dao->setProperty('observacion', $observacion);
        $dao->setProperty('respuesta_abierta', $respuesta_abierta);        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
