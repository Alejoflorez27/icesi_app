<?php

class CtrTrcComboCli
{

    public static function crear($id_combo, $id_empresa, $valor_bogota, $valor_externo, $estado, $visible)
    {   
        if (!isset($id_combo) || $id_combo == "")
            return BaseResponse::error(__FUNCTION__, "Id combo servicio es requerido");

        if (!isset($id_empresa) || $id_empresa == "")
            return BaseResponse::error(__FUNCTION__, "Id empresa es requerido");

        if (!isset($estado) || $estado == "")
            return BaseResponse::error(__FUNCTION__, "Estado es requerido");


        $obj_trcComboCli = new TrcComboCli();
        $obj_trcComboCli->setProperty('id_combo', $id_combo);
        $obj_trcComboCli->setProperty('id_empresa', $id_empresa);
        $obj_trcComboCli->setProperty('valor_bogota', $valor_bogota);
        $obj_trcComboCli->setProperty('valor_externo', $valor_externo);
        $obj_trcComboCli->setProperty('estado', $estado);
        $obj_trcComboCli->setProperty('visible', $visible);


        $resultCount = QuerySQL::select(
            <<<SQL
                    select count(1) cant
                    from trc_combo_cli tcc 
                    where tcc.id_combo = :id_combo
                    and tcc.id_empresa = :id_empresa
                     and tcc.estado = 1;
                SQL,
            array(
                "id_combo" => $id_combo,
                "id_empresa" => $id_empresa
            ),
            true,
            "N"
        );

        $arrayResult = json_decode(json_encode($resultCount), true);
        $cantidad = $arrayResult[0]['cant'];

        if ($cantidad > 0) {
            return Result::error(__FUNCTION__, "No se puede crear este combo, ya existe uno activo para la misma Empresa y mismo Combo Servicio");
        } else {

            $result = $obj_trcComboCli->insert();
            if ($result['success']) {
                return BaseResponse::success($result);
            } else {
                return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
            }
        }
    }

    public static function update(
        $id_combo,
        $valor_bogota,
        $valor_externo,
        $visible
    ) {
        if (!isset($id_combo) || $id_combo == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new TrcComboCli($id_combo);
        $dao->setProperty('valor_bogota', $valor_bogota);
        $dao->setProperty('valor_externo', $valor_externo);
        $dao->setProperty('visible', $visible);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    
    public static function findAll($estado = null)
    {

        if (!isset($estado) || $estado == "")
            $estado = -1;

        $result = QuerySQL::select(
            <<<SQL
                select tcc.id_combo_cli , te.razon_social ,  tcc.id_combo , sc.nom_combo , tcc.valor_bogota , tcc.valor_externo, tcc.estado, tcc.visible , tcc.usr_create , tcc.fch_create 
                from trc_combo_cli tcc ,  srv_combos sc  , trc_empresa te 
                where  sc.id_combo = tcc.id_combo
                and tcc.id_empresa = te.id_empresa 
                    and (tcc.estado = :estado or :estado = -1)   
            SQL,
            array("estado" => $estado),
            true,
            "S"
        );

        return Result::success($result, "buscar producto");
    }


    public static function findAllCliente($idempresa = null)
    {

        if (!isset($idempresa) || $idempresa == "")
            $empresa = -1;

        $result = QuerySQL::select(
            <<<SQL
                select tcc.id_combo_cli , te.razon_social ,  tcc.id_combo , sc.nom_combo , tcc.valor_bogota , tcc.valor_externo, tcc.estado, tcc.visible, tcc.usr_create , tcc.fch_create 
                from trc_combo_cli tcc ,  srv_combos sc  , trc_empresa te 
                where  sc.id_combo = tcc.id_combo
                    and tcc.id_empresa = te.id_empresa 
                    and te.id_empresa in  (select id_empresa from trc_empresa where id_empresa = :id_empresa or id_empresa_padre = :id_empresa)   
            SQL,
            array("id_empresa" => $idempresa),
            true,
            "S"
        );

        return Result::success($result, "buscar producto");
    }

    //prueba de clientes en filtros
    public static function findAllClienteFilter($idempresa = null)
    {
        $empresaPapa = CtrTrcEmpresa::findByIdPadre($idempresa);
        //print_r($empresaPapa['data'][0]['id_empresa_padre']);
        $empresaPapaId = $empresaPapa['data'][0]['id_empresa_padre'];
        $clientePinta = '';

        if ($empresaPapaId == null && $empresaPapaId == '') {
            $clientePinta = $idempresa;
        } else {
            $clientePinta = $empresaPapaId;
        }

        if (!isset($clientePinta) || $clientePinta == "")
            $empresa = -1;

        $result = QuerySQL::select(
            <<<SQL
                select tcc.id_combo_cli , te.razon_social ,  tcc.id_combo , sc.nom_combo , tcc.valor_bogota , tcc.valor_externo, tcc.estado, tcc.visible, tcc.usr_create , tcc.fch_create 
                from trc_combo_cli tcc ,  srv_combos sc  , trc_empresa te 
                where  sc.id_combo = tcc.id_combo
                    and tcc.id_empresa = te.id_empresa 
                    and te.id_empresa in  (select id_empresa from trc_empresa where id_empresa = :clientePinta or id_empresa_padre = :clientePinta)   
            SQL,
            array("clientePinta" => $clientePinta),
            true,
            "S"
        );

        return $result;
    }


    public static function findById($id_comboCli)
    {
        if (!isset($id_comboCli) || $id_comboCli == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select tcc.id_combo_cli , te.razon_social ,  tcc.id_combo , sc.nom_combo , tcc.valor_bogota , tcc.valor_externo, tcc.estado, tcc.visible , tcc.usr_create , tcc.fch_create 
                from trc_combo_cli tcc ,  srv_combos sc  , trc_empresa te 
                where  sc.id_combo = tcc.id_combo
                and tcc.id_empresa = te.id_empresa 
                and  tcc.id_combo_cli = :id_comboCli
            SQL,
            array("id_comboCli" => $id_comboCli),
            false,
            "N"
        );

        return Result::success($result, "buscar combo cliente");
    }

    public static function delete($id_combo_cli)
    {
        if (!isset($id_combo_cli) || $id_combo_cli == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new TrcComboCli($id_combo_cli);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function cambiarEstado($id_combo_cli, $estado)
    {
        if (!isset($id_combo_cli) || $id_combo_cli == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $resultCount = QuerySQL::select(
            <<<SQL
                    select count(1) cant
                    from sol_solicitud ss 
                    where id_combo = :id_combo_cli
                     and ss.estado = 1;
                SQL,
            array("id_combo_cli" => $id_combo_cli),
            true,
            "N"
        );

        $arrayResult = json_decode(json_encode($resultCount), true);
        $cantidad = $arrayResult[0]['cant'];

        if ($cantidad > 0) {
            return Result::error(__FUNCTION__, "No se puede inactivar el Combo Cliente, tiene Solicitudes activas");
        } else {

            $result = QuerySQL::update(
                <<<SQL
                update trc_combo_cli 
                 set estado = :estado 
                where  id_combo_cli = :id_combo_cli
            SQL,
                array(
                    "id_combo_cli" => $id_combo_cli,
                    "estado" => $estado
                ),
                false,
                "N"
            );

            return Result::success($result, "Cambiar estado combo cliente");
        }
    }
}
