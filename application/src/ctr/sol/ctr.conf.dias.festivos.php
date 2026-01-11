<?php

class CtrConfDiasFestivos
{
    public static function val($ano, $mes, $fecha)
    {
        if (isset($ano, $ano) && $mes != "" && $mes != "" && $fecha != "" && $fecha != ""){
            $obj_ref = new ConfDiasFestivos($ano, $mes, $fecha);
            return $obj_ref->getFecha();
        } else {
            return array("success" => false, "action" => "VAL", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function crear($ano, $mes, $fecha, $descripcion)
    {
        if (!isset($fecha) || $fecha == "")
            return Result::error(__FUNCTION__, "fecha es requerido"); 

        $obj_ref = new ConfDiasFestivos();
        $obj_ref->setProperty('ano', $ano);
        $obj_ref->setProperty('mes', $mes);
        $obj_ref->setProperty('fecha', $fecha);
        $obj_ref->setProperty('descripcion', $descripcion);
        /*$obj_ref->setProperty('usr_create', $usr_create);
        $obj_ref->setProperty('fch_create', $fch_create); */

        $result = $obj_ref->insert();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findByIdInfo($id_dias)
    {
        if (!isset($id_dias) || $id_dias == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                    select ve.id_dias,
                            ve.fecha,
                            ve.descripcion,
                            ve.usr_create,
                            ve.fch_create
                            from conf_dias_festivos ve
                                WHERE ve.id_dias  = :id_dias
            SQL,
            array("id_dias" => $id_dias),
            true,
            "N"
        );

        return Result::success($result, "buscar concepto operativo");
    }

    public static function findAll()
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT ve.id_dias,
                        ve.ano,
                        ve.mes,
                        ve.fecha,
                        ve.descripcion,
                        ve.usr_create,
                        ve.fch_create
                FROM conf_dias_festivos ve
                WHERE 1=1
                ORDER BY ve.id_dias ASC;

            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "buscar los dias festivos");
    }

    //Actualizar el festivo
    public static function update(
        $id_dias,
        $ano,
        $mes,
        $fecha,
        $descripcion

    ) {
        if (!isset($id_dias) || $id_dias == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new ConfDiasFestivos($id_dias);
        $dao->setProperty('ano', $ano);
        $dao->setProperty('mes', $mes);
        $dao->setProperty('fecha', $fecha);        
        $dao->setProperty('descripcion', $descripcion);       

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos

    public static function delete($id_dias)
    {
        if (!isset($id_dias) || $id_dias == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new ConfDiasFestivos($id_dias);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

}

