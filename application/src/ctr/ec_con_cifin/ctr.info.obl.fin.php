<?php

class CtrInfoOblFin
{
    //Crear un activo del candidato o de su familia
    public static function crear($id_solicitud, $id_servicio, $entidad, $producto_clase, $fch_expedicion, $fch_terminacion, $cupo_inicial, $saldo_pendiente, $pago_minimo, $estado_obligacion, $calidad, $valor_mora, $edad_mora)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        $obj_infoOblFin = new InfoOblFin();
        $obj_infoOblFin->setProperty('id_solicitud', $id_solicitud);
        $obj_infoOblFin->setProperty('id_servicio', $id_servicio);
        $obj_infoOblFin->setProperty('entidad', $entidad);
        $obj_infoOblFin->setProperty('producto_clase', $producto_clase);
        $obj_infoOblFin->setProperty('fch_expedicion', $fch_expedicion);
        $obj_infoOblFin->setProperty('fch_terminacion', $fch_terminacion);
        $obj_infoOblFin->setProperty('cupo_inicial', $cupo_inicial);
        $obj_infoOblFin->setProperty('saldo_pendiente', $saldo_pendiente);
        $obj_infoOblFin->setProperty('pago_minimo', $pago_minimo);
        $obj_infoOblFin->setProperty('estado_obligacion', $estado_obligacion);
        $obj_infoOblFin->setProperty('calidad', $calidad);
        $obj_infoOblFin->setProperty('valor_mora', $valor_mora);
        $obj_infoOblFin->setProperty('edad_mora', $edad_mora);
        

        $result = $obj_infoOblFin->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una activo de la vivienda

    //listar las obligaciones financieras del candidato
    public static function findAll($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT iof.*,
                    fcn_desc_configurations('tipo_estado_obligacion', iof.estado_obligacion) descripcion_estado_obligacion
                FROM info_obl_fin iof 
                WHERE iof.id_solicitud = :id_solicitud
                AND iof.id_servicio = :id_servicio 
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar las obligaciones financieras");
    }//Fin de listar las obligaciones financieras
    
    //totales de la confiabilidad financiera
    public static function totales($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT 
                SUM(CAST(cupo_inicial AS DECIMAL(18, 2))) AS suma_cupo_inicial,
                SUM(CAST(saldo_pendiente AS DECIMAL(18, 2))) AS suma_saldo_pendiente,
                SUM(CAST(pago_minimo AS DECIMAL(18, 2))) AS suma_pago_minimo,
                SUM(CAST(valor_mora AS DECIMAL(18, 2))) AS suma_valor_mora
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
    public static function delete($id_info_obl_fin)
    {
        if (!isset($id_info_obl_fin) || $id_info_obl_fin == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new InfoOblFin($id_info_obl_fin);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar el egreso del candidato
    public static function update(
        $id_info_obl_fin,
        $entidad, 
        $producto_clase, 
        $fch_expedicion, 
        $fch_terminacion, 
        $cupo_inicial, 
        $saldo_pendiente, 
        $pago_minimo, 
        $estado_obligacion, 
        $calidad, 
        $valor_mora, 
        $edad_mora

    ) {
        if (!isset($id_info_obl_fin) || $id_info_obl_fin == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new InfoOblFin($id_info_obl_fin);
        $dao->setProperty('entidad', $entidad);
        $dao->setProperty('producto_clase', $producto_clase);
        $dao->setProperty('fch_expedicion', $fch_expedicion);
        $dao->setProperty('fch_terminacion', $fch_terminacion);
        $dao->setProperty('cupo_inicial', $cupo_inicial);
        $dao->setProperty('saldo_pendiente', $saldo_pendiente);
        $dao->setProperty('pago_minimo', $pago_minimo);
        $dao->setProperty('estado_obligacion', $estado_obligacion);
        $dao->setProperty('calidad', $calidad);
        $dao->setProperty('valor_mora', $valor_mora);
        $dao->setProperty('edad_mora', $edad_mora);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
