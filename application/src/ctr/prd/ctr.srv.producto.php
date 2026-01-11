<?php

class CtrSrvProducto
{

    public static function crear($nom_prod, $estado)
    {
        if (!isset($nom_prod) || $nom_prod == "")
            return BaseResponse::error(__FUNCTION__, "nombre del producto es requerido");

        $obj_srvProducto = new SrvProducto();
        $obj_srvProducto->setProperty('nom_prod', $nom_prod);
        $obj_srvProducto->setProperty('estado', $estado);

        $result = $obj_srvProducto->insert();
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
                select id_producto , nom_prod , estado, usr_create , fch_create 
                from srv_producto sp     
                where (sp.estado = :estado or :estado = -1)   
            SQL,
            array("estado" => $estado),
            true,
            "S"
        );

        return Result::success($result, "buscar producto");
    }

    public static function delete($id_producto)
    {
        if (!isset($id_producto) || $id_producto == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SrvProducto($id_producto);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findById($id_producto)
    {
        if (!isset($id_producto) || $id_producto == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select id_producto , nom_prod , estado
                from srv_producto sp 
                where  sp.id_producto = :id_producto
            SQL,
            array("id_producto" => $id_producto),
            false,
            "N"
        );

        return Result::success($result, "buscar producto");
    }


    public static function update(
        $id_producto,
        $nom_prod,
        $estado
    ) {
        if (!isset($id_producto) || $id_producto == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SrvProducto($id_producto);
        $dao->setProperty('nom_prod', $nom_prod);
        $dao->setProperty('estado', $estado);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    public static function cambiarEstado($id_producto, $estado)
    {
        if (!isset($id_producto) || $id_producto == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $resultCount = QuerySQL::select(
            <<<SQL
                    select count(1) cant
                    from srv_servicios ss 
                    where id_producto = :id_producto
                     and ss.estado = 1;
                SQL,
            array("id_producto" => $id_producto),
            true,
            "N"
        );

        $arrayResult = json_decode(json_encode($resultCount), true);
        $cantidad = $arrayResult[0]['cant'];

        if ($cantidad > 0) {
            return Result::error(__FUNCTION__, "No se puede inactivar el Producto, tiene Servicios activos");
        } else {

            $result = QuerySQL::update(
                <<<SQL
                update srv_producto 
                 set estado = :estado 
                where  id_producto = :id_producto
            SQL,
                array(
                    "id_producto" => $id_producto,
                    "estado" => $estado
                ),
                false,
                "N"
            );

            return Result::success($result, "Cambiar estado producto");
        }
    }

    public static function findProdXClt($id_cliente)
    {
        if (!isset($id_cliente) || $id_cliente == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select DISTINCT sp.id_producto , sp.nom_prod 
                from trc_combo_cli tcc , srv_combo_servicios scs , srv_servicios ss, srv_producto sp 
                where tcc.id_empresa = :id_cliente
                and tcc.id_combo = scs.id_combo 
                and scs.activo = 1
                and scs.id_servicio = ss.id_servicio 
                and ss.estado = 1
                and sp.id_producto = ss.id_producto 
                order by 1
            SQL,
            array("id_cliente" => $id_cliente),
            true,
            "S"
        );

        return Result::success($result, "buscar producto por cliente");
    }

    public static function findProdXCltAdd($id_cliente, $id_solicitud)
    {
        if (!isset($id_cliente) || $id_cliente == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $empresaPapa = CtrTrcEmpresa::findByIdPadre($id_cliente);

        //print_r($empresaPapa['data'][0]['id_empresa_padre']);
        $empresaPapaId = $empresaPapa['data'][0]['id_empresa_padre'];
        $clientePinta = '';

        if ($empresaPapaId == null && $empresaPapaId == '') {
            $clientePinta = $id_cliente;
        } else {
            $clientePinta = $empresaPapaId;
        }
        

        $result = QuerySQL::select(
            <<<SQL
                select DISTINCT sp.id_producto , sp.nom_prod 
                from trc_combo_cli tcc , srv_combo_servicios scs , srv_servicios ss, srv_producto sp 
                where tcc.id_empresa = :clientePinta
                and tcc.id_combo = scs.id_combo 
                and scs.activo = 1
                and scs.id_servicio = ss.id_servicio 
                and ss.estado = 1
                and sp.id_producto = ss.id_producto 
                and scs.id_servicio not in (select sss.id_servicio  from sol_solicitud_servicio sss
                                            where sss.id_solicitud = :id_solicitud)
                order by 1
            SQL,
            array("clientePinta" => $clientePinta,
            "id_solicitud" => $id_solicitud
        
        ),
            true,
            "S"
        );

        return Result::success($result, "buscar producto por cliente");
    }
}
