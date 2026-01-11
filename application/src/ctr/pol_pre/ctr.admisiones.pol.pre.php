<?php

class CtrAdmisionesPolPre
{

    public static function crear($id_solicitud, $id_servicio, $item_poligrafia, $admitio, $resumen)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido"); 
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido"); 

        $obj_caracteristicaVariable = new admisionesPolPre();
        $obj_caracteristicaVariable->setProperty('id_solicitud', $id_solicitud);
        $obj_caracteristicaVariable->setProperty('id_servicio', $id_servicio);
        $obj_caracteristicaVariable->setProperty('item_poligrafia', $item_poligrafia);
        $obj_caracteristicaVariable->setProperty('admitio', $admitio);
        $obj_caracteristicaVariable->setProperty('resumen', $resumen);

        $result = $obj_caracteristicaVariable->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function update($id_admision, $item_poligrafia, $admitio, $resumen)
    {
        if (!isset($id_admision) || $id_admision == "")
            return Result::error(__FUNCTION__, "id id_admision es requerido");


        $dao = new admisionesPolPre($id_admision);
        $dao->setProperty('item_poligrafia', $item_poligrafia);
        $dao->setProperty('admitio', $admitio);
        $dao->setProperty('resumen', $resumen);      

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function update_items($id_solicitud, $id_servicio, $item_poligrafia, $admitio, $resumen)
    {
        /*if (!isset($id_admision) || $id_admision == "")
            return Result::error(__FUNCTION__, "id id_admision es requerido");
        */

        $respuesta = CtrAdmisionesPolPre::admisionesPolPreByIdItem($id_solicitud, $id_servicio, $item_poligrafia);
        /*print_r($respuesta);
        print_r($respuesta['data']['id_admision']);
        */

        $dao = new admisionesPolPre($respuesta['data']['id_admision']);
        $dao->setProperty('item_poligrafia', $item_poligrafia);
        $dao->setProperty('admitio', $admitio);
        $dao->setProperty('resumen', $resumen);      

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function admisionesPolPreById($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select o.id_admision, 
                        o.id_solicitud, 
                        o.id_servicio,
                        o.item_poligrafia,
                        o.admitio, 
                        o.resumen
                    from admisiones_pol_pre o 
                    where o.id_solicitud  = :id_solicitud
                    and o.id_servicio = :id_servicio
                    and o.admitio = 1
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar observación");
    }

    public static function admisionesPolPreByIdItem($id_solicitud, $id_servicio, $item_poligrafia)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        if (!isset($item_poligrafia) || $item_poligrafia == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select o.id_admision, 
                        o.id_solicitud, 
                        o.id_servicio,
                        o.item_poligrafia,
                        o.admitio, 
                        o.resumen
                    from admisiones_pol_pre o 
                    where o.id_solicitud  = :id_solicitud
                    and o.id_servicio = :id_servicio
                    and o.item_poligrafia = :item_poligrafia
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio, "item_poligrafia" => $item_poligrafia),
            false,
            "N"
        );

        return Result::success($result, "buscar observación");
    }

}
