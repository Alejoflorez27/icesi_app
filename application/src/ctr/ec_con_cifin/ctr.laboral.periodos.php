<?php

class CtrLaboralPeriodos
{
    //Crear un activo del candidato o de su familia
    public static function crear($id_solicitud, $id_servicio, $periodo, $tmp_periodo, $descripcion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        $obj_periodo = new laboralPeriodos();
        $obj_periodo->setProperty('id_solicitud', $id_solicitud);
        $obj_periodo->setProperty('id_servicio', $id_servicio);
        $obj_periodo->setProperty('periodo', $periodo);
        $obj_periodo->setProperty('tmp_periodo', $tmp_periodo);
        $obj_periodo->setProperty('descripcion', $descripcion);
        

        $result = $obj_periodo->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una activo de la vivienda

    //listar los periodos de lo laboral
    public static function descripcionLaboral_periodo($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT lp.id_laboral_periodos,
                lp.id_solicitud,
                lp.id_servicio,
                fcn_desc_configurations('tipo_periodo_laboral', lp.periodo)periodo,
                fcn_desc_configurations('tipo_tmp_aproximado', lp.tmp_periodo)tmp_periodo,
                lp.descripcion,
                lp.usr_create,
                lp.fch_create
            FROM laboral_periodos lp
            WHERE lp.id_solicitud = :id_solicitud
            AND lp.id_servicio = :id_servicio;
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar las obligaciones financieras");
    }//Fin de listar las obligaciones financieras

    //Editar un registro de formacion academica del candidato
    public static function findByIdLaboralPeriodo($id_laboral_periodos)
    {
        if (!isset($id_laboral_periodos) || $id_laboral_periodos == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
            SELECT  lp.id_laboral_periodos,
                    lp.id_solicitud,
                    lp.id_servicio,
                    lp.periodo,
                    lp.tmp_periodo,
                    lp.descripcion,
                    lp.usr_create,
                    lp.fch_create
            FROM laboral_periodos lp , sol_candidato sc 
            WHERE lp.id_solicitud = sc.id_solicitud
            AND lp.id_laboral_periodos = :id_laboral_periodos;
            SQL,
            array("id_laboral_periodos" => $id_laboral_periodos),
            false,
            "N"
        );

        return Result::success($result, "buscar laboral");
    }//Fin de Editar un registro de laboral
    
    //totales de la confiabilidad financiera
    public static function totales($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT 
                SUM(CAST(cupo_inicial AS DECIMAL(10, 2))) AS suma_cupo_inicial,
                SUM(CAST(saldo_pendiente AS DECIMAL(10, 2))) AS suma_saldo_pendiente,
                SUM(CAST(pago_minimo AS DECIMAL(10, 2))) AS suma_pago_minimo,
                SUM(CAST(valor_mora AS DECIMAL(10, 2))) AS suma_valor_mora
            FROM info_obl_fin
            WHERE id_solicitud = :id_solicitud
            AND id_servicio =:id_servicio;
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "suma de los totales confiabilidad fiananciera");
    }//Fin totales de la confiabilidad fianciera

    //Editar un registro de activos  del candidato
    public static function findByIdInfoOblFin($id_info_obl_fin)
    {
        if (!isset($id_info_obl_fin) || $id_info_obl_fin == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select iof.*,
                       fcn_desc_configurations('tipo_estado_obligacion', iof.estado_obligacion) descripcion_estado_obligacion
                    from info_obl_fin iof, sol_solicitud sc
                    where iof.id_solicitud  = sc.id_solicitud
                    and  iof.id_info_obl_fin  = :id_info_obl_fin

            SQL,
            array("id_info_obl_fin" => $id_info_obl_fin),
            false,
            "N"
        );

        return Result::success($result, "buscar obligaciones financieras");
    }//Fin de Editar un registro de activos del candidato

    //Borrar un registro por id
    public static function delete($id_laboral_periodos)
    {
        if (!isset($id_laboral_periodos) || $id_laboral_periodos == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new laboralPeriodos($id_laboral_periodos);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar el egreso del candidato
    public static function update(
        $id_laboral_periodos,
        $periodo, 
        $tmp_periodo, 
        $descripcion
    ) {
        if (!isset($id_laboral_periodos) || $id_laboral_periodos == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new laboralPeriodos($id_laboral_periodos);
        $dao->setProperty('periodo', $periodo);
        $dao->setProperty('tmp_periodo', $tmp_periodo);
        $dao->setProperty('descripcion', $descripcion);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
