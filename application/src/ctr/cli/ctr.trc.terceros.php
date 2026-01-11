<?php

class CtrTrcTerceros
{

    public static function crear($nom_tercero,$id_empresa)
    {
        if (!isset( $nom_tercero) || $nom_tercero == "")
            return BaseResponse::error(__FUNCTION__, "nombre del tercero es requerido");


        $obj_trcTerceros = new TrcTerceros();
        $obj_trcTerceros->setProperty('nom_tercero', $nom_tercero);
        $obj_trcTerceros->setProperty('id_empresa', $id_empresa);
       // $obj_trcTerceros->setProperty('estado', $estado);

        $result = $obj_trcTerceros->insert();
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
                select id_tercero, id_empresa,nom_tercero,estado, usr_create, fch_create
                from trc_terceros te
                where  (te.estado = :estado or :estado = -1)  

            SQL,
            array("estado" => $estado),
            true,
            "N"
        );

        return Result::success($result, "buscar empresa todos");
    }

    public static function findById($id_empresa =null)
    {
         
        $result = QuerySQL::select(
            <<<SQL
                select id_tercero, id_empresa,nom_tercero,estado estado_ter, usr_create, fch_create
                from trc_terceros te
                where  (te.id_empresa = :id_empresa)
            SQL,
            array("id_empresa" => $id_empresa),
            true,
            "N"
        );

        return Result::success($result, "buscar tercero");
    }

    public static function findByIdSube($id_empresa =null)
    {
        $result = QuerySQL::select(
            <<<SQL
                select te.razon_social, te.numero_doc, te.rep_legal, te.email_emp , cc.nombre, te.estado estado_sube, te.id_empresa
                from trc_empresa te, conf_ciudad cc
                where  (id_empresa_padre = :id_empresa)
                and cc.id_ciudad = te.id_ciudad
            SQL,
            array("id_empresa" => $id_empresa),
            true,
            "N"
        );

        return Result::success($result, "buscar subempresa");
    }

    public static function cambiarEstado($id_tercero, $estado_ter)
    {
        if (!isset($id_tercero) || $id_tercero == "")
        {
            return Result::error(__FUNCTION__, "id es requerido");
        }else  {
            $result = QuerySQL::update(
                <<<SQL
                update trc_terceros 
                 set estado = :estado_ter 
                where  id_tercero = :id_tercero
            SQL,
                array(
                    "id_tercero" => $id_tercero,
                    "estado_ter" => $estado_ter
                ),
                false,
                "N"
            );
                
            return Result::success($result, "Cambiar estado tercero");
        
        }
    }

}
