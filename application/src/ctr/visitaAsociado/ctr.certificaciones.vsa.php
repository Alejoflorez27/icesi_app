<?php

class CtrCertificacionesVsa
{

    public static function crear($id_solicitud, $id_servicio, $sistema_gestion, $estado, $afirmativo, $numero, $observacion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicios es requerido");
        $obj_info = new certificacionesVsa();
        $obj_info->setProperty('id_solicitud', $id_solicitud);
        $obj_info->setProperty('id_servicio', $id_servicio);
        $obj_info->setProperty('sistema_gestion', $sistema_gestion);
        $obj_info->setProperty('estado', $estado);
        $obj_info->setProperty('afirmativo', $afirmativo);
        $obj_info->setProperty('numero', $numero);
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
                SELECT ve.id_certificacion,
                       ve.id_solicitud,
                       ve.id_servicio,
                       fcn_desc_configurations('tipo_sistema_gestion_visita_asociado', ve.sistema_gestion) sistema_gestion,
                       ve.estado,
                       ve.afirmativo,
                       ve.numero,
                       ve.observacion,
                       ve.usr_create,
                       ve.fch_create
                  FROM certificaciones_vsa ve
                 WHERE ve.id_solicitud = :id_solicitud
                   AND ve.id_servicio = :id_servicio

            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar las certificaciones");
    }

    public static function findByIdInfo($id_certificacion)
    {
        if (!isset($id_certificacion) || $id_certificacion == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                    SELECT ve.id_certificacion,
                           ve.id_solicitud,
                           ve.id_servicio,
                           ve.sistema_gestion,
                           ve.estado,
                           ve.afirmativo,
                           ve.numero,
                           ve.observacion,
                           ve.usr_create,
                           ve.fch_create
                      FROM certificaciones_vsa ve, sol_solicitud sc
                     WHERE ve.id_certificacion  = :id_certificacion
                       AND ve.id_solicitud  = sc.id_solicitud
            SQL,
            array("id_certificacion" => $id_certificacion),
            false,
            "N"
        );

        return Result::success($result, "buscar factor de riesgo");
    }

    public static function delete($id_certificacion)
    {
        if (!isset($id_certificacion) || $id_certificacion == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new certificacionesVsa($id_certificacion);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Actualizar el egreso del candidato
    public static function update(
        $id_certificacion,
        $sistema_gestion,
        $estado,
        $afirmativo,
        $numero,
        $observacion

    ) {
        if (!isset($id_certificacion) || $id_certificacion == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new certificacionesVsa($id_certificacion);
        $dao->setProperty('sistema_gestion', $sistema_gestion);
        $dao->setProperty('estado', $estado);
        $dao->setProperty('afirmativo', $afirmativo);
        $dao->setProperty('numero', $numero);
        $dao->setProperty('observacion', $observacion);        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
