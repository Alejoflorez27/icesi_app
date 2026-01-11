<?php

class CtrVivSector
{

    public static function crear(
        $id_solicitud,
        $id_servicio, 
        $sector, 
        $estracto, 
        $estado_sector, 
        $ubicacion_sector, 
        $tmp_ida_trabajo, 
        $tmp_en_vivienda, 
        $zonas_verdes,
        $vias_principales, 
        $concepto_vecino
        )
    {

        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido");

        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido");

        if (!isset($sector) || $sector == "")
            return BaseResponse::error(__FUNCTION__, "sector de la vivienda es requerido");

        if (!isset($estracto) || $estracto == "")
            return BaseResponse::error(__FUNCTION__, "Estracto del sector es requerido");

        if (!isset($estado_sector) || $estado_sector == "")
            return BaseResponse::error(__FUNCTION__, "Estado del Sector es requerido");

        if (!isset($ubicacion_sector) || $ubicacion_sector == "")
            return BaseResponse::error(__FUNCTION__, "La ubicacion del sector es requerido");

        if (!isset($tmp_ida_trabajo) || $tmp_ida_trabajo == "")
            return BaseResponse::error(__FUNCTION__, "tiempo de ida al trabajo es requerido");

        if (!isset($tmp_en_vivienda) || $tmp_en_vivienda == "")
            return BaseResponse::error(__FUNCTION__, "tiempo en la vivienda es requerido");

        if (!isset($zonas_verdes) || $zonas_verdes == "")
            return BaseResponse::error(__FUNCTION__, "Zonas Verdes es requerido");

        if (!isset($vias_principales) || $vias_principales == "")
            return BaseResponse::error(__FUNCTION__, "Vías principales es requerido");

        if (!isset($concepto_vecino) || $concepto_vecino == "")
            return BaseResponse::error(__FUNCTION__, "Concepto Vecino es requerido");

        $obj_vivSectores = new VivSector();
        $obj_vivSectores->setProperty('id_solicitud', $id_solicitud);
        $obj_vivSectores->setProperty('id_servicio', $id_servicio);
        $obj_vivSectores->setProperty('sector', $sector);
        $obj_vivSectores->setProperty('estracto', $estracto);
        $obj_vivSectores->setProperty('estado_sector', $estado_sector);
        $obj_vivSectores->setProperty('ubicacion_sector', $ubicacion_sector);
        $obj_vivSectores->setProperty('tmp_ida_trabajo', $tmp_ida_trabajo);
        $obj_vivSectores->setProperty('tmp_en_vivienda', $tmp_en_vivienda);
        $obj_vivSectores->setProperty('zonas_verdes', $zonas_verdes);
        $obj_vivSectores->setProperty('vias_principales', $vias_principales);
        $obj_vivSectores->setProperty('concepto_vecino', $concepto_vecino);

        $result = $obj_vivSectores->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findAll($id_solicitud, $id_servicio)
    {
        $result = QuerySQL::select(
            <<<SQL
            SELECT vs.id_sector,
            	   vs.id_solicitud,
            	   vs.id_servicio,
            	   vs.sector,
            	   vs.estracto,
            	   vs.estado_sector,
            	   vs.ubicacion_sector,
            	   vs.tmp_ida_trabajo,
            	   vs.tmp_en_vivienda,
            	   vs.zonas_verdes,
            	   vs.vias_principales,
            	   vs.concepto_vecino,
            	   fcn_desc_configurations('tipo_sector', vs.sector) descripcion_tipo_sector,
            	   fcn_desc_configurations('tipo_ubicacion_sector', vs.ubicacion_sector) descripcion_ubicacion_sector,
            	   fcn_desc_configurations('tipo_tmp_ida_trabajo', vs.tmp_ida_trabajo) descripcion_tmp_ida_trabajo
            FROM viv_sectores vs
            WHERE vs.id_solicitud = :id_solicitud 
            AND vs.id_servicio = :id_servicio 
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar combo");
    }

    static public function consultarTodos()
    {
        $obj_vivCaracteristica = new VivcaracteristicasTipo();
        return $obj_vivCaracteristica->selectAll();
    }

    public static function findById($id_sector)
    {
        if (!isset($id_sector) || $id_sector == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select vs.* 
                from viv_sectores vs
                where vs.id_sector = :id_sector;
            SQL,
            array("id_sector" => $id_sector),
            false,
            "N"
        );

        return Result::success($result, "buscar Caracteristica Vivienda");
    }


    public static function update(
        $id_sector,
        $id_solicitud, 
        $sector, 
        $estracto, 
        $estado_sector, 
        $ubicacion_sector, 
        $tmp_ida_trabajo, 
        $tmp_en_vivienda, 
        $zonas_verdes,
        $vias_principales, 
        $concepto_vecino
    ) {
        if (!isset($id_sector) || $id_sector == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivSector($id_sector);
        $dao->setProperty('id_solicitud', $id_solicitud);
        $dao->setProperty('sector', $sector);
        $dao->setProperty('estracto', $estracto);
        $dao->setProperty('estado_sector', $estado_sector);
        $dao->setProperty('ubicacion_sector', $ubicacion_sector);
        $dao->setProperty('tmp_ida_trabajo', $tmp_ida_trabajo);
        $dao->setProperty('tmp_en_vivienda', $tmp_en_vivienda);
        $dao->setProperty('zonas_verdes', $zonas_verdes);
        $dao->setProperty('vias_principales', $vias_principales);
        $dao->setProperty('concepto_vecino', $concepto_vecino);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    public static function findAllByCombo($id_sector, $categoria, $id_solicitud, $id_servicio)
    {
        if (!isset($id_sector) || $id_sector == "")
            return Result::error(__FUNCTION__, "caracteristica es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select vsv.*, c.descripcion
                from viv_sectores_variables vsv, configurations c
                where (vsv.id_sector = :id_sector)
                and vsv.id_solicitud = :id_solicitud 
                and vsv.id_servicio = :id_servicio
                and vsv.categoria = :categoria
                and vsv.activo = 1
                and vsv.categoria = c.categoria
                and vsv.codigo = c.codigo;
            SQL,
            array("id_sector" => $id_sector, "categoria" => $categoria, "id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );
        return Result::success($result, "buscar aspectos por caracteristica");
    }
    public static function findAllByComboviv($id_sector, $id_solicitud, $id_servicio)
    {
        if (!isset($id_sector) || $id_sector == "")
            return Result::error(__FUNCTION__, "caracteristica es requerido");

        $result = QuerySQL::select(
            <<<SQL
                    select vcv.* 
                    from viv_sectores_variables vcv
                    where vcv.id_solicitud = :id_solicitud 
                    and vcv.id_servicio = :id_servicio
                    and vcv.id_sector = :id_sector
                    and vcv.activo = 1
            SQL,
            array("id_sector" => $id_sector,"id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );
        return Result::success($result, "buscar aspectos por caracteristica");
    }

    public static function findAByAspecto($id_sector, $categoria, $codigo, $id_solicitud, $id_servicio)
    {
        if (!isset($id_sector) || $id_sector == "")
            return Result::error(__FUNCTION__, "caracteristica es requerido");

        $result = QuerySQL::select(
            <<<SQL
                    SELECT vcv.id_sector_variable, 
                        vcv.id_solicitud,
                        vcv.id_servicio,
                        vcv.id_sector,
                        vcv.categoria,
                        vcv.codigo,
                        vcv.activo
                    FROM viv_sectores_variables vcv 
                    WHERE (vcv.id_sector = :id_sector)
                    and vcv.codigo = :codigo
                    and vcv.id_solicitud = :id_solicitud 
                    and vcv.id_servicio = :id_servicio
                    and vcv.categoria = :categoria
            SQL,
            array("id_sector" => $id_sector, "categoria" => $categoria, "codigo" => $codigo, "id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );
        return Result::success($result, "buscar aspectos por codigo");
    }


}
