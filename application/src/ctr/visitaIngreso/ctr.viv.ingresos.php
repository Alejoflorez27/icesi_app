<?php

class CtrVivIngresos
{
    //Crear una ingreso de la vivienda
    public static function crear($id_solicitud, $id_servicio, $tipo_familiar, $valor_ingreso, $ingreso_proveniente)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");
        $obj_vivIngreeso = new VivIngresos();
        $obj_vivIngreeso->setProperty('id_solicitud', $id_solicitud);
        $obj_vivIngreeso->setProperty('id_servicio', $id_servicio);
        $obj_vivIngreeso->setProperty('tipo_familiar', $tipo_familiar);
        $obj_vivIngreeso->setProperty('valor_ingreso', $valor_ingreso);
        $obj_vivIngreeso->setProperty('ingreso_proveniente', $ingreso_proveniente);
        

        $result = $obj_vivIngreeso->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una ingresos de la vivienda

    //listar los ingresos del candidato y su familia
    public static function findAll($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT vi.id_ingreso,
            	   vi.id_solicitud,
            	   vi.id_servicio,
            	   vi.tipo_familiar AS descripcion_tipo_integrante,
            	   vi.valor_ingreso,
            	   vi.ingreso_proveniente,
            	   vi.usr_create,
            	   vi.fch_create 
            FROM viv_ingresos vi
            WHERE vi.id_solicitud = :id_solicitud
            and vi.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar ingresos del candidato y su familia");
    }//Fin de listar los estudios del candidato

    //listar los ingresos del candidato y su familia por no exists
    public static function findAllNoExists($tipo_parentesco)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT * FROM configurations c 
            WHERE categoria = :tipo_parentesco
            AND estado = 'ACT'
            AND NOT EXISTS (SELECT 1 
                            FROM viv_ingresos vi
                            WHERE vi.tipo_familiar = c.codigo )
            SQL,
            array("tipo_parentesco" => $tipo_parentesco),
            true,
            "N"
        );

        return Result::success($result, "buscar ingresos del candidato no repetido");
    }//Fin de listar los estudios del candidato


    //Editar un registro de ingresos  del candidato
    public static function findByIdIngresos($id_ingreso)
    {
        if (!isset($id_ingreso) || $id_ingreso == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL

                        SELECT vi.id_ingreso,
                            vi.id_solicitud,
                            vi.id_servicio,
                            vi.tipo_familiar,
                            vi.valor_ingreso,
                            vi.ingreso_proveniente,
                            vi.usr_create,
                            vi.fch_create 
                        FROM viv_ingresos vi, sol_solicitud sc
                        WHERE vi.id_ingreso  = :id_ingreso
                        and vi.id_solicitud  = sc.id_solicitud
            SQL,
            array("id_ingreso" => $id_ingreso),
            false,
            "N"
        );

        return Result::success($result, "buscar dotación mobiliaria");
    }//Fin de Editar un registro de formacion academica del candidato

    //Borrar un registro por id
    public static function delete($id_ingreso)
    {
        if (!isset($id_ingreso) || $id_ingreso == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivIngresos($id_ingreso);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar el ingreso del candidato
    public static function update(
        $id_ingreso,
        $tipo_familiar,
        $valor_ingreso,
        $ingreso_proveniente

    ) {
        if (!isset($id_ingreso) || $id_ingreso == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivIngresos($id_ingreso);
        $dao->setProperty('tipo_familiar', $tipo_familiar);
        $dao->setProperty('valor_ingreso', $valor_ingreso);
        $dao->setProperty('ingreso_proveniente', $ingreso_proveniente);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la dotacion mobiliaria
}
