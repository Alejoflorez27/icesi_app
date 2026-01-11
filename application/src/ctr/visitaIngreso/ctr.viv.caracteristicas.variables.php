<?php

class CtrVivCaracteristicasVariables
{

    public static function crear($id_solicitud, $id_servicio, $id_caracteristica_tipo, $id_caracteristica, $categoria)
    {
        //print_r($id_caracteristica_tipo);
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido"); 
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido"); 
        if (!isset($id_caracteristica_tipo) || $id_caracteristica_tipo == "")
            return BaseResponse::error(__FUNCTION__, "Id codigo es requerido");
        if (!isset($id_caracteristica) || $id_caracteristica == "")
            return BaseResponse::error(__FUNCTION__, "Id combo es requerido");
        if (!isset($categoria) || $categoria == "")
            return BaseResponse::error(__FUNCTION__, "Id categoria es requerido");

        $obj_caracteristicaVariable = new VivcaracteristicasVariables();
        $obj_caracteristicaVariable->setProperty('id_solicitud', $id_solicitud);
        $obj_caracteristicaVariable->setProperty('id_servicio', $id_servicio);
        $obj_caracteristicaVariable->setProperty('id_caracteristica', $id_caracteristica);
        $obj_caracteristicaVariable->setProperty('categoria', $categoria);
        $obj_caracteristicaVariable->setProperty('codigo', $id_caracteristica_tipo);
        $obj_caracteristicaVariable->setProperty('activo', 1);

        $result = $obj_caracteristicaVariable->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    //Borrar un registro por id
    public static function delete($id_caracteristica_variable)
    {
        if (!isset($id_caracteristica_variable) || $id_caracteristica_variable == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivcaracteristicasVariables($id_caracteristica_variable);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

}
