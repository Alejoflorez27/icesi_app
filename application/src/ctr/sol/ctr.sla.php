<?php

class CtrSla
{

    public static function crear($inicio_verde,
                                 $fin_verde,
                                 $inicio_amarillo,
                                 $fin_amarillo,
                                 $inicio_rojo,
                                 $fin_rojo)
    {
        if (!isset($inicio_verde) || $inicio_verde == "")
            return Result::error(__FUNCTION__, "inicio_verde es requerido"); 
        if (!isset($fin_verde) || $fin_verde == "")
            return Result::error(__FUNCTION__, "fin_verde es requerido"); 

        $obj_sla = new sla();
        $obj_sla->setProperty('inicio_verde', $inicio_verde);
        $obj_sla->setProperty('fin_verde', $fin_verde);
        $obj_sla->setProperty('inicio_amarillo', $inicio_amarillo);
        $obj_sla->setProperty('fin_amarillo', $fin_amarillo);
        $obj_sla->setProperty('inicio_rojo', $inicio_rojo);
        $obj_sla->setProperty('fin_rojo', $fin_rojo); 

        $result = $obj_sla->insert();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function update($id_sla, 
                                  $inicio_verde,
                                  $fin_verde,
                                  $inicio_amarillo,
                                  $fin_amarillo,
                                  $inicio_rojo,
                                  $fin_rojo)
    {
        if (!isset($id_sla ) || $id_sla  == "")
            return Result::error(__FUNCTION__, "id id_sla  es requerido");


        $dao = new sla($id_sla);
        $dao->setProperty('inicio_verde', $inicio_verde);
        $dao->setProperty('fin_verde', $fin_verde);
        $dao->setProperty('inicio_amarillo', $inicio_amarillo);
        $dao->setProperty('fin_amarillo', $fin_amarillo);
        $dao->setProperty('inicio_rojo', $inicio_rojo);
        $dao->setProperty('fin_rojo', $fin_rojo);        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //consultar SLA
    public static function tecnicaPolPreById()
    {

        $result = QuerySQL::select(
            <<<SQL
                select o.id_sla, 
                        o.inicio_verde,
                        o.fin_verde,
                        o.inicio_amarillo,
                        o.fin_amarillo,
                        o.inicio_rojo,
                        o.fin_rojo
                from sla o 
                where 1=1
            SQL,
            array(),
            false,
            "N"
        );

        return Result::success($result, "buscar SLA");
    }

}
