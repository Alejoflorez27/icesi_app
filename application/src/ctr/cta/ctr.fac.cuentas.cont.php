<?php

class CtrFacCuentasCont
{

    public static function crear($item, $concepto, $combo, $ubicacion_cuenta, $estado, $destino_cuenta)
    {
        if (!isset($item) || $item == "")
            return BaseResponse::error(__FUNCTION__, "item es requerido");

        if (!isset($concepto) || $concepto == "")
            return BaseResponse::error(__FUNCTION__, "concepto es requerido");

        if (!isset($combo) || $combo == "")
            return BaseResponse::error(__FUNCTION__, "Combo es requerido");

        if (!isset($ubicacion_cuenta) || $ubicacion_cuenta == "")
            return BaseResponse::error(__FUNCTION__, "Ubicación Cuenta es requerido");

        $obj_facCuentasCont = new FacCuentasCont();
        $obj_facCuentasCont->setProperty('item', $item);
        $obj_facCuentasCont->setProperty('concepto', $concepto);
        $obj_facCuentasCont->setProperty('combo', $combo);
        $obj_facCuentasCont->setProperty('ubicacion_cuenta', $ubicacion_cuenta);
        $obj_facCuentasCont->setProperty('estado', $estado);
        $obj_facCuentasCont->setProperty('destino_cuenta', $destino_cuenta);

        $result = $obj_facCuentasCont->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findAll($estado = null)
    {
        if (!isset($estado) || $estado == "")
            $estado = -1;

        $result = QuerySQL::select(
            <<<SQL
                select fcc.id_cuenta ,fcc.item , fcc.concepto , fcc.combo , sc.nom_combo,
                    fcc.ubicacion_cuenta, fcc.estado , fcc.usr_create , fcc.fch_create  , decode(fcc.destino_cuenta, 'P', 'Proveedor', 'C', 'Cliente') destino_cuenta
                    from fac_cuentas_cont fcc, srv_combos sc 
                    where fcc.combo  = sc.id_combo
                    and (fcc.estado = :estado or :estado = -1)   
            SQL,
            array("estado" => $estado),
            true,
            "N"
        );

        return Result::success($result, "buscar servicio");
    }

    public static function delete($id_cuenta)
    {
        if (!isset($id_cuenta) || $id_cuenta == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new FacCuentasCont($id_cuenta);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findById($id_cuenta)
    {
        if (!isset($id_cuenta) || $id_cuenta == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select fcc.id_cuenta ,fcc.item , fcc.concepto , fcc.combo , sc.nom_combo,
                    fcc.ubicacion_cuenta, fcc.estado , fcc.usr_create , fcc.fch_create , fcc.destino_cuenta
                    from fac_cuentas_cont fcc, srv_combos sc 
                    where fcc.combo  = sc.id_combo
                    and  fcc.id_cuenta = :id_cuenta
            SQL,
            array("id_cuenta" => $id_cuenta),
            false,
            "N"
        );

        return Result::success($result, "buscar cuenta contable");
    }


    public static function update(
        $id_cuenta,
        $item,
        $concepto,
        $combo,
        $ubicacion_cuenta,
        $estado,
        $destino_cuenta
    ) {
        if (!isset($id_cuenta) || $id_cuenta == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new FacCuentasCont($id_cuenta);
        $dao->setProperty('item', $item);
        $dao->setProperty('concepto', $concepto);
        $dao->setProperty('combo', $combo);
        $dao->setProperty('ubicacion_cuenta', $ubicacion_cuenta);
        $dao->setProperty('estado', $estado);
        $dao->setProperty('destino_cuenta', $destino_cuenta);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function cambiarEstado($id_cuenta, $estado)
    {
        if (!isset($id_cuenta) || $id_cuenta == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $resultCount = QuerySQL::select(
            <<<SQL
                    select count(1) cant
                        from fac_cuentas_cont fcc, srv_combos sc 
                        where fcc.combo = sc.id_combo 
                        and sc.estado = 1
                        and fcc.id_cuenta = :id_cuenta;
                SQL,
            array("id_cuenta" => $id_cuenta),
            true,
            "N"
        );

        $arrayResult = json_decode(json_encode($resultCount), true);
        $cantidad = $arrayResult[0]['cant'];

        if ($cantidad > 0) {
            return Result::error(__FUNCTION__, "No se puede inactivar la Cuenta, tiene Combos activos");
        } else {

            $result = QuerySQL::update(
                <<<SQL
                update fac_cuentas_cont 
                 set estado = :estado 
                where  id_cuenta = :id_cuenta
            SQL,
                array(
                    "id_cuenta" => $id_cuenta,
                    "estado" => $estado
                ),
                false,
                "N"
            );

            return Result::success($result, "Cambiar estado producto");
        }
    }
}
