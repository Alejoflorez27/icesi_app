<?php

class CtrpreguntaComoHojaVidaPolPre
{

    public static function crear($id_solicitud, $id_servicio, $pregunta_uno, $pregunta_dos, $pregunta_tres, $pregunta_cuatro, $pregunta_cinco, $pregunta_kaizen, $pregunta_seis, $pregunta_siete, $pregunta_ocho)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido"); 
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido"); 

        $obj_caracteristicaVariable = new preguntaComoHojaVidaPolPre();
        $obj_caracteristicaVariable->setProperty('id_solicitud', $id_solicitud);
        $obj_caracteristicaVariable->setProperty('id_servicio', $id_servicio);
        $obj_caracteristicaVariable->setProperty('pregunta_uno', $pregunta_uno);
        $obj_caracteristicaVariable->setProperty('pregunta_dos', $pregunta_dos);
        $obj_caracteristicaVariable->setProperty('pregunta_tres', $pregunta_tres);
        $obj_caracteristicaVariable->setProperty('pregunta_cuatro', $pregunta_cuatro);
        $obj_caracteristicaVariable->setProperty('pregunta_cinco', $pregunta_cinco);
        $obj_caracteristicaVariable->setProperty('pregunta_kaizen', $pregunta_kaizen);
        $obj_caracteristicaVariable->setProperty('pregunta_seis', $pregunta_seis);
        $obj_caracteristicaVariable->setProperty('pregunta_siete', $pregunta_siete);
        $obj_caracteristicaVariable->setProperty('pregunta_ocho', $pregunta_ocho);

        $result = $obj_caracteristicaVariable->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Actualizar las preguntas de alcohol
    public static function update($id_preg_como_hv_pol, $pregunta_uno, $pregunta_dos, $pregunta_tres, $pregunta_cuatro, $pregunta_cinco, $pregunta_kaizen, $pregunta_seis, $pregunta_siete, $pregunta_ocho)
    {
        if (!isset($id_preg_como_hv_pol) || $id_preg_como_hv_pol == "")
            return Result::error(__FUNCTION__, "id id_preg_como_hv_pol es requerido");

        $dao = new preguntaComoHojaVidaPolPre($id_preg_como_hv_pol);
        $dao->setProperty('pregunta_uno', $pregunta_uno);
        $dao->setProperty('pregunta_dos', $pregunta_dos);
        $dao->setProperty('pregunta_tres', $pregunta_tres);
        $dao->setProperty('pregunta_cuatro', $pregunta_cuatro);
        $dao->setProperty('pregunta_cinco', $pregunta_cinco);
        $dao->setProperty('pregunta_kaizen', $pregunta_kaizen);
        $dao->setProperty('pregunta_seis', $pregunta_seis);
        $dao->setProperty('pregunta_siete', $pregunta_siete);
        $dao->setProperty('pregunta_ocho', $pregunta_ocho);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de actualizar lo del alcohol

    //consultar el registroa a editar
    public static function comoHojaVidaPolPreById($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select o.id_preg_como_hv_pol, 
                        o.id_solicitud, 
                        o.id_servicio, 
                        o.pregunta_uno,
                        o.pregunta_dos,
                        o.pregunta_tres,
                        o.pregunta_cuatro,
                        o.pregunta_cinco,
                        o.pregunta_kaizen,
                        o.pregunta_seis,
                        o.pregunta_siete,
                        o.pregunta_ocho
                    from preguntas_como_hoja_vida_pol_pre o 
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
