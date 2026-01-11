<?php

class CtrVivEgresos
{
    //Crear un egreso del candidato o de su familia
    public static function crear($id_solicitud, $id_servicio, $concepto_ingreso, $otros, $periocidad, $tipo_familiar, $valor_egreso, $total_egreso)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicios es requerido");
        $obj_vivEgreso = new VivEgresos();
        $obj_vivEgreso->setProperty('id_solicitud', $id_solicitud);
        $obj_vivEgreso->setProperty('id_servicio', $id_servicio);
        $obj_vivEgreso->setProperty('concepto_ingreso', $concepto_ingreso);
        $obj_vivEgreso->setProperty('otros', $otros);
        $obj_vivEgreso->setProperty('periocidad', $periocidad);
        $obj_vivEgreso->setProperty('tipo_familiar', $tipo_familiar);
        $obj_vivEgreso->setProperty('valor_egreso', $valor_egreso);
        $obj_vivEgreso->setProperty('total_egreso', $total_egreso);
        

        $result = $obj_vivEgreso->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una distribucion de la vivienda

    //listar los egresos del candidato y su familia
    public static function findAll($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT ve.id_egreso,
                        ve.id_solicitud,
                        ve.id_servicio,
                        fcn_desc_configurations('tipo_concepto_egreso', ve.concepto_ingreso) descripcion_tipo_concepto,
                        ve.otros,
                        ve.periocidad,
                        fcn_desc_configurations('tipo_periocidad', ve.periocidad) descripcion_tipo_periocidad,
                        ve.concepto_ingreso,
                        ve.tipo_familiar AS descripcion_tipo_integrante,
                        ve.valor_egreso,
                        ve.total_egreso,
                        ve.usr_create,
                        ve.fch_create
                FROM viv_egresos ve
                WHERE ve.id_solicitud = :id_solicitud
                and ve.id_servicio = :id_servicio

            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar egresos del candidato y su familia");
    }//Fin de listar los estudios del candidato

    //listar los ingresos del candidato y su familia por no exists
    public static function findAllNoExists($tipo_concepto_egreso)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT * FROM configurations c 
            WHERE categoria = :tipo_concepto_egreso
            AND estado = 'ACT'
            AND NOT EXISTS (SELECT 1 
                            FROM viv_egresos ve
                            WHERE ve.concepto_ingreso = c.codigo )
            SQL,
            array("tipo_concepto_egreso" => $tipo_concepto_egreso),
            true,
            "N"
        );

        return Result::success($result, "buscar ingresos del candidato no repetido");
    }//Fin de listar los estudios del candidato

    //Editar un registro de egresos  del candidato
    public static function findByIdEgresos($id_egreso)
    {
        if (!isset($id_egreso) || $id_egreso == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                    select ve.id_egreso,
                        ve.id_solicitud,
                        ve.id_servicio,
                        fcn_desc_configurations('tipo_concepto_egreso', ve.concepto_ingreso) descripcion_tipo_concepto,
                        ve.concepto_ingreso,
                        ve.otros,
                        ve.periocidad,
                        ve.tipo_familiar,
                        ve.valor_egreso,
                        ve.total_egreso,
                        ve.usr_create,
                        ve.fch_create
                        from viv_egresos ve, sol_solicitud sc
                            WHERE ve.id_egreso  = :id_egreso
                            and ve.id_solicitud  = sc.id_solicitud
            SQL,
            array("id_egreso" => $id_egreso),
            false,
            "N"
        );

        return Result::success($result, "buscar egreso");
    }//Fin de Editar un registro de egresos del candidato

    //Borrar un registro por id
    public static function delete($id_egreso)
    {
        if (!isset($id_egreso) || $id_egreso == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivEgresos($id_egreso);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar el egreso del candidato
    public static function update(
        $id_egreso,
        $concepto_ingreso,
        $otros,
        $periocidad,
        $tipo_familiar,
        $valor_egreso,
        $total_egreso

    ) {
        if (!isset($id_egreso) || $id_egreso == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivEgresos($id_egreso);
        $dao->setProperty('concepto_ingreso', $concepto_ingreso);
        $dao->setProperty('otros', $otros);
        $dao->setProperty('periocidad', $periocidad);
        $dao->setProperty('tipo_familiar', $tipo_familiar);
        $dao->setProperty('valor_egreso', $valor_egreso);
        $dao->setProperty('total_egreso', $total_egreso);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos

    //Actualizar el egreso del candidato
    public static function update_pol_pre(
        $id_egreso,
        //$concepto_ingreso,
        $otros,
        //$periocidad,
        $tipo_familiar,
        $valor_egreso
        //$total_egreso

    ) {
        if (!isset($id_egreso) || $id_egreso == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivEgresos($id_egreso);
        //$dao->setProperty('concepto_ingreso', $concepto_ingreso);
        $dao->setProperty('otros', $otros);
        //$dao->setProperty('periocidad', $periocidad);
        $dao->setProperty('tipo_familiar', $tipo_familiar);
        $dao->setProperty('valor_egreso', $valor_egreso);
        //$dao->setProperty('total_egreso', $total_egreso);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos

    //Actualizar el egreso del candidato
    public static function update_pol_rutina(
        $id_egreso,
        //$concepto_ingreso,
        $otros,
        //$periocidad,
        $tipo_familiar,
        $valor_egreso
        //$total_egreso

    ) {
        if (!isset($id_egreso) || $id_egreso == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivEgresos($id_egreso);
        //$dao->setProperty('concepto_ingreso', $concepto_ingreso);
        $dao->setProperty('otros', $otros);
        //$dao->setProperty('periocidad', $periocidad);
        $dao->setProperty('tipo_familiar', $tipo_familiar);
        $dao->setProperty('valor_egreso', $valor_egreso);
        //$dao->setProperty('total_egreso', $total_egreso);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
