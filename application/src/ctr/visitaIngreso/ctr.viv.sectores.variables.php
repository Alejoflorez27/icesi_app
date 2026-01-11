<?php

class CtrVivSectoresVariables
{
    public static function crear($id_solicitud, $id_servicio, $id_sector, $categoria, $id_caracteristica_tipo)
    {
        //print_r($id_caracteristica_tipo);
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido"); 
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido"); 
        if (!isset($id_caracteristica_tipo) || $id_caracteristica_tipo == "")
            return BaseResponse::error(__FUNCTION__, "Id codigo es requerido");
        if (!isset($id_sector) || $id_sector == "")
            return BaseResponse::error(__FUNCTION__, "Id sector es requerido");
        if (!isset($categoria) || $categoria == "")
            return BaseResponse::error(__FUNCTION__, "Id categoria es requerido");

        $obj_sectorVariable = new VivSectoresVariables();
        $obj_sectorVariable->setProperty('id_solicitud', $id_solicitud);
        $obj_sectorVariable->setProperty('id_servicio', $id_servicio);
        $obj_sectorVariable->setProperty('id_sector', $id_sector);
        $obj_sectorVariable->setProperty('categoria', $categoria);
        $obj_sectorVariable->setProperty('codigo', $id_caracteristica_tipo);
        $obj_sectorVariable->setProperty('activo', 1);

        $result = $obj_sectorVariable->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    //Borrar un registro por id
    public static function delete($id_sector_variable)
    {
        if (!isset($id_sector_variable) || $id_sector_variable == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivSectoresVariables($id_sector_variable);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id
}
