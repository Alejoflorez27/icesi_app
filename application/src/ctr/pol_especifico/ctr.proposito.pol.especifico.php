<?php

class CtrPropositoPolEspecifico
{

    public static function crear($id_solicitud, $id_servicio, $proposito)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido"); 
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido"); 

        $obj_caracteristicaVariable = new propositoPolEspecifico();
        $obj_caracteristicaVariable->setProperty('id_solicitud', $id_solicitud);
        $obj_caracteristicaVariable->setProperty('id_servicio', $id_servicio);
        $obj_caracteristicaVariable->setProperty('proposito', $proposito);

        $result = $obj_caracteristicaVariable->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function update($id_proposito, $proposito)
    {
        if (!isset($id_proposito) || $id_proposito == "")
            return Result::error(__FUNCTION__, "id id_admision es requerido");


        $dao = new propositoPolEspecifico($id_proposito);
        $dao->setProperty('proposito', $proposito);      

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function propositoPolEspecificoById($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select o.id_proposito, 
                        o.id_solicitud, 
                        o.id_servicio, 
                        o.proposito
                    from proposito_pol_especifico o 
                    where o.id_solicitud  = :id_solicitud
                    and o.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            false,
            "N"
        );

        return Result::success($result, "buscar el proposito del examen");
    }

}
