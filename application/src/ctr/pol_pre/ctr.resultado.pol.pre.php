<?php

class CtrResultadoPolPre
{

    public static function crear($id_solicitud, $id_servicio, $resultado)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido"); 
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido"); 

        $obj_caracteristicaVariable = new resultadoPolPre();
        $obj_caracteristicaVariable->setProperty('id_solicitud', $id_solicitud);
        $obj_caracteristicaVariable->setProperty('id_servicio', $id_servicio);
        $obj_caracteristicaVariable->setProperty('resultado', $resultado);

        $result = $obj_caracteristicaVariable->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function update($id_resultado, $resultado)
    {
        if (!isset($id_resultado) || $id_resultado == "")
            return Result::error(__FUNCTION__, "id id_resultado es requerido");


        $dao = new resultadoPolPre($id_resultado);
        $dao->setProperty('resultado', $resultado);      

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function resultadoPolPreById($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select o.id_resultado, 
                        o.id_solicitud, 
                        o.id_servicio, 
                        o.resultado
                    from resultado_pol_pre o 
                    where o.id_solicitud  = :id_solicitud
                    and o.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            false,
            "N"
        );

        return Result::success($result, "buscar observación");
    }

}
