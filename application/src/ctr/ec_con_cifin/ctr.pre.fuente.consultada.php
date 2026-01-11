<?php

class CtrPreFuenteConsultada
{

    public static function crear($id_solicitud, $id_pregunta, $id_variable_salud, $activo)
    {
        
        if (!isset($id_variable_salud) || $id_variable_salud == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido");

        if (!isset($id_pregunta) || $id_pregunta == "")
            return BaseResponse::error(__FUNCTION__, "Id combo es requerido");

        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido");
        
        if (!isset($activo) || $activo == "")
            return BaseResponse::error(__FUNCTION__, "Id activo es requerido");  

        $obj_sectorVariable = new DimVarRespuestaSalud();
        $obj_sectorVariable->setProperty('id_pregunta', $id_pregunta);
        $obj_sectorVariable->setProperty('id_variable_salud', $id_variable_salud);
        $obj_sectorVariable->setProperty('id_solicitud', $id_solicitud);
        $obj_sectorVariable->setProperty('activo', $activo);

        $result = $obj_sectorVariable->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    public static function update($id_var_respuesta_salud,$activo)
    {

        if (!isset($id_var_respuesta_salud) || $id_var_respuesta_salud == "")
            return BaseResponse::error(__FUNCTION__, "Id aspectos  es requerido");
        if (!isset($activo) || $activo == "")
            return BaseResponse::error(__FUNCTION__, "activo  es requerido");    


        $result = QuerySQL::update(
            <<<SQL
                update dim_var_respuesta_salud
                set activo = :activo
                where ( id_var_respuesta_salud = :id_var_respuesta_salud)
            SQL,
            array("id_var_respuesta_salud" => $id_var_respuesta_salud, "activo" => $activo),
            true,
            "N"
        );
        return Result::success($result, "Actualizar los Aspectos de salud");
    }

    // la funcion que crea las opcines de los checks
    public static function consultaExiste($id_solicitud, $id_pregunta){
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id_solicitud es requerido");
        if (!isset($id_pregunta) || $id_pregunta == "")
            return Result::error(__FUNCTION__, "id_pregunta es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select DISTINCT(1) as existe
                from  dim_var_respuesta_salud dvrs 
                where dvrs.id_solicitud = :id_solicitud 
                and dvrs.id_pregunta = :id_pregunta 
            SQL,
            array("id_solicitud" => $id_solicitud, "id_pregunta" => $id_pregunta),
            false,
            "N"
        );

        //return Result::success($result, "Devueve siexiste la pregunta");
        //validamos si existen las variables
        if($result['existe'] == 1){
            
            //consulto la lista de variables de acuerdo a la pregunta
            $resultado = CtrDimVarRespuestaSalud::consultaVariable($id_solicitud, $id_pregunta);             
            return Result::success($resultado, "Devuelve SI existe la pregunta");

        }else
        {
            $result2 = QuerySQL::select(
                <<<SQL
                    select id_variable_salud
                    from  dim_var_pregunta_salud dvp
                    where id_pregunta = :id_pregunta  
                SQL,
                array("id_pregunta" => $id_pregunta),
                false,
                "N"
            );   
            
            $result3 = '';
            foreach($result2 as $id_var => $valor){
                 // print_r($valor['id_variable_salud']);
                $id_variable_salud = $valor['id_variable_salud'];
                $result3 = CtrDimVarRespuestaSalud::crear($id_solicitud,$id_pregunta,$id_variable_salud,'0');
            }

            if ($result3['status']=='success'){
                //se consulta las variable que fueron creadas y trae que Id tiene en la respuesta
                $resultado = CtrDimVarRespuestaSalud::consultaVariable($id_solicitud, $id_pregunta);             
                return Result::success($resultado, "Devuelve SI existe la pregunta");
            }

        }

       // print_r($result3);

    }//fin existe

    //consulta las variables si existen
    public static function consultaVariable($id_solicitud, $id_pregunta){
        
        $result1 = QuerySQL::select(
            <<<SQL
                select dvp.id_variable_salud, dvp.nombre_pregunta, dvrs.id_var_respuesta_salud, dvrs.activo 
                from  dim_var_respuesta_salud dvrs, dim_var_pregunta_salud dvp 
                where dvp.id_variable_salud = dvrs.id_variable_salud 
                and dvrs.id_solicitud = :id_solicitud 
                and dvrs.id_pregunta = :id_pregunta  
            SQL,
            array("id_solicitud" => $id_solicitud, "id_pregunta" => $id_pregunta),
            false,
            "N"
        );
       // print_r($result1);                
       return $result1;

    }//fin consultaVariable

    public static function VariablesFuenteConsulta($id_pregunta){
        if (!isset($id_pregunta) || $id_pregunta == "")
            return Result::error(__FUNCTION__, "id pregunta es requerido");

        $result = QuerySQL::select(
            <<<SQL
            SELECT pfc.id_pre_fuente,
                    pfc.id_tipo_consulta,
                    pfc.no_pregunta,
                    pfc.orden,
                    pfc.texto,
                    pfc.variable,
                    pfc.tipo_variable,
                    pfc.usr_create,
                    pfc.fch_create
                
            FROM dim_preguntas dp,
                pre_fuente_consultada pfc
                
            WHERE dp.id_dimension = 11
            AND dp.id_pregunta = :id_pregunta
            AND pfc.no_pregunta = dp.id_pregunta ;
            SQL,
            array("id_pregunta" => $id_pregunta),
            false,
            "N"
        );

        return Result::success($result, "buscar variables salud");
    }
}
