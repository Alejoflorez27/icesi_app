<?php

class CtrPreguntaInfiltracionPolPre
{

    public static function crear($id_solicitud, $id_servicio, $pregunta_uno)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido"); 
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido"); 

        $obj_caracteristicaVariable = new preguntaInfiltracionPolPre();
        $obj_caracteristicaVariable->setProperty('id_solicitud', $id_solicitud);
        $obj_caracteristicaVariable->setProperty('id_servicio', $id_servicio);
        $obj_caracteristicaVariable->setProperty('pregunta_uno', $pregunta_uno);

        $result = $obj_caracteristicaVariable->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Actualizar las preguntas de alcohol
    public static function update($id_preg_infiltracion_pol, $pregunta_uno)
    {
        if (!isset($id_preg_infiltracion_pol) || $id_preg_infiltracion_pol == "")
            return Result::error(__FUNCTION__, "id id_preg_infiltracion_pol es requerido");

        $dao = new preguntaInfiltracionPolPre($id_preg_infiltracion_pol);
        $dao->setProperty('pregunta_uno', $pregunta_uno);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de actualizar lo del alcohol

    //consultar el registroa a editar
    public static function infiltracionPolPreById($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select o.id_preg_infiltracion_pol, 
                        o.id_solicitud, 
                        o.id_servicio, 
                        o.pregunta_uno
                    from preguntas_infiltracion_pol_pre o 
                    where o.id_solicitud  = :id_solicitud
                    and o.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            false,
            "N"
        );

        return Result::success($result, "buscar observación");
    }//Fin de Editar un registro de formacion academica del candidato

}
