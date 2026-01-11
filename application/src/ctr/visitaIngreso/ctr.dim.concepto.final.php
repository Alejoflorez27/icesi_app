<?php

class CtrDimConceptoFinal
{
    //Crear una distribucion de la vivienda
    public static function crear($id_solicitud, $id_servicio, $id_dimension, $observacion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido");

        $obj_dimConceptoFinal = new DimConceptoFinal();
        $obj_dimConceptoFinal->setProperty('id_solicitud', $id_solicitud);
        $obj_dimConceptoFinal->setProperty('id_servicio', $id_servicio);
        $obj_dimConceptoFinal->setProperty('id_dimension', $id_dimension);
        $obj_dimConceptoFinal->setProperty('observacion', $observacion);
        
        $result = $obj_dimConceptoFinal->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una distribucion de la vivienda


    //Actualizar la dotacion mobiliaria
    public static function update($id_dim_concepto, $observacion)
    {
        if (!isset($id_dim_concepto) || $id_dim_concepto == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new DimConceptoFinal($id_dim_concepto);
        $dao->setProperty('observacion', $observacion);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la dotacion mobiliaria

    //Editar un registro de formacion academica del candidato
    public static function DimConceptoById($id_solicitud, $id_servicio, $id_dimension)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
            if (!isset($id_dimension) || $id_dimension == "")
            return Result::error(__FUNCTION__, "id dimension es requerido");
        $result = QuerySQL::select(
            <<<SQL
                    select dcf.id_dim_concepto, 
                        dcf.id_solicitud, 
                        dcf.id_servicio, 
                        dcf.id_dimension, 
                        dcf.observacion 
                        from dim_concepto_final dcf
                        where dcf.id_solicitud  = :id_solicitud
                        and dcf.id_servicio = :id_servicio
                        and dcf.id_dimension = :id_dimension 
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio, "id_dimension" => $id_dimension),
            false,
            "N"
        );

        return Result::success($result, "buscar concepto por la dimension");
    }//Fin de Editar un registro de formacion academica del candidato

    public static function DimConceptoValidacion($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        $result = QuerySQL::select(
            <<<SQL
                    select dcf.id_dim_concepto, 
                        dcf.id_solicitud, 
                        dcf.id_servicio, 
                        dcf.id_dimension, 
                        dcf.observacion 
                        from dim_concepto_final dcf
                        where dcf.id_solicitud  = :id_solicitud
                        and dcf.id_servicio = :id_servicio
                        -- and dcf.id_dimension = :id_dimension 
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            false,
            "N"
        );

        return Result::success($result, "buscar concepto por la dimension");
    }

    public static function ConceptoFinalDim($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        $result = QuerySQL::select(
            <<<SQL
                    SELECT d.nombre_dimension ,
                           dcf.id_dim_concepto, 
                           dcf.id_solicitud, 
                           dcf.id_servicio, 
                           dcf.id_dimension, 
                           dcf.observacion 
                      FROM dim_concepto_final dcf,
                           dimensiones d 
                     WHERE 1 = 1
                       AND d.id_dimension = dcf.id_dimension 
                       AND dcf.id_solicitud = :id_solicitud
                       AND dcf.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            false,
            "N"
        );

        return Result::success($result, "buscar concepto por la dimension");
    }//Fin de Editar un registro de formacion academica del candidato
     
    //Traer todos los conceptos asociados PDF
     public static function DimConceptoAll($id_solicitud, $id_servicio)
     {
         if (!isset($id_solicitud) || $id_solicitud == "")
             return Result::error(__FUNCTION__, "id solicitud es requerido");
         if (!isset($id_servicio) || $id_servicio == "")
             return Result::error(__FUNCTION__, "id servicio es requerido");
            
         $result = QuerySQL::select(
             <<<SQL
                     select dcf.id_dim_concepto, 
                         dcf.id_solicitud, 
                         dcf.id_servicio, 
                         dcf.id_dimension, 
                         dcf.observacion 
                         from dim_concepto_final dcf
                         where dcf.id_solicitud  = :id_solicitud
                         and dcf.id_servicio = :id_servicio 
             SQL,
             array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
             false,
             "N"
         );
 
         return Result::success($result, "buscar concepto por la dimension");
     }//Fin de Editar un registro de formacion academica del candidato
}
