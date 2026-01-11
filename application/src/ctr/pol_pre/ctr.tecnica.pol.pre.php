<?php

class CtrtecnicaPolPre
{

    public static function crear($id_solicitud, $id_servicio, $pregunta_uno, $pregunta_dos, $pregunta_tres)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido"); 
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido"); 

        $obj_caracteristicaVariable = new tecnicaPolPre();
        $obj_caracteristicaVariable->setProperty('id_solicitud', $id_solicitud);
        $obj_caracteristicaVariable->setProperty('id_servicio', $id_servicio);
        $obj_caracteristicaVariable->setProperty('pregunta_uno', $pregunta_uno);
        $obj_caracteristicaVariable->setProperty('pregunta_dos', $pregunta_dos);
        $obj_caracteristicaVariable->setProperty('pregunta_tres', $pregunta_tres); 

        $result = $obj_caracteristicaVariable->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Actualizar las preguntas de alcohol
    public static function update($id_tecnica, $pregunta_uno, $pregunta_dos, $pregunta_tres)
    {
        if (!isset($id_tecnica) || $id_tecnica == "")
            return Result::error(__FUNCTION__, "id id_tecnica es requerido");


        $dao = new tecnicaPolPre($id_tecnica);
        $dao->setProperty('pregunta_uno', $pregunta_uno);
        $dao->setProperty('pregunta_dos', $pregunta_dos);
        $dao->setProperty('pregunta_tres', $pregunta_tres);        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de actualizar lo del alcohol

    //consultar el registroa a editar
    public static function tecnicaPolPreById($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select o.id_tecnica, 
                        o.id_solicitud, 
                        o.id_servicio, 
                        o.pregunta_uno,
                        fcn_desc_configurations('tipo_tecnica_poligrafo', o.pregunta_uno) descripcion_pregunta_uno,
                        o.pregunta_dos,
                        fcn_desc_configurations('tipo_equipo_poligrafo', o.pregunta_dos) descripcion_pregunta_dos,
                        o.pregunta_tres,
                        fcn_desc_configurations('tipo_comparativa_pol_pre', o.pregunta_tres) descripcion_pregunta_tres
                    from tecnica_pol_pre o 
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
