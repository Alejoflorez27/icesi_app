<?php

class CtrSeguridadInformaticaVsa
{

    public static function crear($id_solicitud, $id_servicio, $requisito, $calificacion, $observacion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicios es requerido");
        $obj_info = new seguridadInformaticaVsa();
        $obj_info->setProperty('id_solicitud', $id_solicitud);
        $obj_info->setProperty('id_servicio', $id_servicio);
        $obj_info->setProperty('requisito', $requisito);
        $obj_info->setProperty('calificacion', $calificacion);
        $obj_info->setProperty('observacion', $observacion);

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
                SELECT ve.id_seguridad,
                        ve.id_solicitud,
                        ve.id_servicio,
                        fcn_desc_configurations('tipo_seguridad_informatica_visita_asociado', ve.requisito) requisito,
                        fcn_desc_configurations('tipo_calificacion_visita_asociado', ve.calificacion) calificacion,
                        -- ve.calificacion,
                        ve.observacion,
                        ve.usr_create,
                        ve.fch_create
                FROM seguridad_informatica_vsa ve
                WHERE ve.id_solicitud = :id_solicitud
                and ve.id_servicio = :id_servicio
                ORDER BY ve.requisito ASC;

            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar los conceptos de seguridad informatica");
    }
    public static function ExiteVariable($descripcion ,$id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
            select 1 existe
                from seguridad_informatica_vsa dr 
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

    public static function findByIdInfo($id_seguridad)
    {
        if (!isset($id_seguridad) || $id_seguridad == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                    select ve.id_seguridad,
                        ve.id_solicitud,
                        ve.id_servicio,
                        ve.requisito,
                        ve.calificacion,
                        ve.observacion,
                        ve.usr_create,
                        ve.fch_create
                        from seguridad_informatica_vsa ve, sol_solicitud sc
                            WHERE ve.id_seguridad  = :id_seguridad
                            and ve.id_solicitud  = sc.id_solicitud
            SQL,
            array("id_seguridad" => $id_seguridad),
            false,
            "N"
        );

        return Result::success($result, "buscar concepto de seguridad informatica");
    }

    public static function delete($id_seguridad)
    {
        if (!isset($id_seguridad) || $id_seguridad == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new seguridadInformaticaVsa($id_seguridad);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Actualizar el egreso del candidato
    public static function update(
        $id_seguridad,
        $requisito,
        $calificacion,
        $observacion

    ) {
        if (!isset($id_seguridad) || $id_seguridad == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new seguridadInformaticaVsa($id_seguridad);
        $dao->setProperty('requisito', $requisito);
        $dao->setProperty('calificacion', $calificacion);
        $dao->setProperty('observacion', $observacion);        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
