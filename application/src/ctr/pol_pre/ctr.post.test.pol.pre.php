<?php

class CtrPosTestPolPre
{

    public static function crear($id_solicitud, $id_servicio, $post_test, $comportamiento, $tipo_datos, $aplica)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido"); 
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido"); 

        $obj_caracteristicaVariable = new posTestPolPre();
        $obj_caracteristicaVariable->setProperty('id_solicitud', $id_solicitud);
        $obj_caracteristicaVariable->setProperty('id_servicio', $id_servicio);
        $obj_caracteristicaVariable->setProperty('post_test', $post_test);
        $obj_caracteristicaVariable->setProperty('comportamiento', $comportamiento);
        $obj_caracteristicaVariable->setProperty('tipo_datos', $tipo_datos);
        $obj_caracteristicaVariable->setProperty('aplica', $aplica);  

        $result = $obj_caracteristicaVariable->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function update($id_post_test, $post_test, $comportamiento, $tipo_datos, $aplica)
    {
        if (!isset($id_post_test) || $id_post_test == "")
            return Result::error(__FUNCTION__, "id id_post_test es requerido");


        $dao = new posTestPolPre($id_post_test);
        $dao->setProperty('post_test', $post_test); 
        $dao->setProperty('comportamiento', $comportamiento);
        $dao->setProperty('tipo_datos', $tipo_datos);
        $dao->setProperty('aplica', $aplica);     

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function posTestPolPreById($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select o.id_post_test, 
                        o.id_solicitud, 
                        o.id_servicio, 
                        o.post_test,
                        o.comportamiento,
                        o.tipo_datos,
                        fcn_desc_configurations('tipo_calidad_datos_pol_pre', o.tipo_datos) descripcion_datos,
                        o.aplica
                    from post_test_pol_pre o 
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
