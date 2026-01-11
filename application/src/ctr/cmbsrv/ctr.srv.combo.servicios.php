<?php

class CtrSrvComboServicios
{

    public static function crear($id_servicio, $id_combo)
    {
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido");

        if (!isset($id_combo) || $id_combo == "")
            return BaseResponse::error(__FUNCTION__, "Id combo es requerido");


        $obj_srvCombServicios = new SrvComboServicios();
        $obj_srvCombServicios->setProperty('id_servicio', $id_servicio);
        $obj_srvCombServicios->setProperty('id_combo', $id_combo);
        $obj_srvCombServicios->setProperty('activo', 1);

        $result = $obj_srvCombServicios->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    public static function delete($id_servicio, $id_combo)
    {

        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido");

        if (!isset($id_combo) || $id_combo == "")
            return BaseResponse::error(__FUNCTION__, "Id combo es requerido");

        $result = QuerySQL::update(
            <<<SQL
                update srv_combo_servicios
                 set activo = 0
                where ( id_servicio = :id_servicio
                    and id_combo = :id_combo )
            SQL,
            array("id_servicio" => $id_servicio,
                "id_combo" => $id_combo),
            true,
            "N"
        );
        return Result::success($result, "Actualizar combo servicio");
    }

    //Verifcacion el combo tiene laboral o academico
    public static function verificacionCombo($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");

        $result = QuerySQL::select(
            <<<SQL
            SELECT scs.*
            FROM sol_solicitud ss, srv_combos sc, srv_combo_servicios scs
            WHERE ss.id_combo = sc.id_combo
            AND ss.id_solicitud = :id_solicitud
            AND scs.id_combo = ss.id_combo
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "buscar observación");
    }
}
