<?php

class CtrVivCaracteristicas
{

    public static function crear($id_solicitud, $id_servicio, $tipo_vivienda, $tipo_tenencia, $tipo_tamano_vivienda, $tipo_vivienda_estado, $aclaracion_viv, $direccion, $telefono, $barrio, $estrato, $zona, $ambiente, $sector, $lugar, $limpieza)
    {

        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido");

        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido");
            
        if (!isset($tipo_vivienda) || $tipo_vivienda == "")
            return BaseResponse::error(__FUNCTION__, "tipo de vivienda es requerido");

        if (!isset($tipo_tenencia) || $tipo_tenencia == "")
            return BaseResponse::error(__FUNCTION__, "tipo de tenencia es requerido");

        if (!isset($tipo_tamano_vivienda) || $tipo_tamano_vivienda == "")
            return BaseResponse::error(__FUNCTION__, "tipo de tamaño es requerido");

        if (!isset($tipo_vivienda_estado) || $tipo_vivienda_estado == "")
            return BaseResponse::error(__FUNCTION__, "tipo de estado es requerido");
        if (!isset($aclaracion_viv) || $aclaracion_viv == "")
            return BaseResponse::error(__FUNCTION__, "Aclaraciones de la vivienda es requerido");

        $obj_vivCaracteristicas = new Vivcaracteristicas();
        $obj_vivCaracteristicas->setProperty('id_solicitud', $id_solicitud);
        $obj_vivCaracteristicas->setProperty('id_servicio', $id_servicio);
        $obj_vivCaracteristicas->setProperty('tipo_vivienda', $tipo_vivienda);
        $obj_vivCaracteristicas->setProperty('tipo_tenencia', $tipo_tenencia);
        $obj_vivCaracteristicas->setProperty('tipo_tamano_vivienda', $tipo_tamano_vivienda);
        $obj_vivCaracteristicas->setProperty('tipo_vivienda_estado', $tipo_vivienda_estado);
        $obj_vivCaracteristicas->setProperty('aclaracion_viv', $aclaracion_viv);
        
        //Nuevos campos
        $obj_vivCaracteristicas->setProperty('direccion', $direccion);
        $obj_vivCaracteristicas->setProperty('telefono', $telefono);
        $obj_vivCaracteristicas->setProperty('barrio', $barrio);
        $obj_vivCaracteristicas->setProperty('estrato', $estrato);
        $obj_vivCaracteristicas->setProperty('zona', $zona);
        $obj_vivCaracteristicas->setProperty('ambiente', $ambiente);
        $obj_vivCaracteristicas->setProperty('sector', $sector);
        $obj_vivCaracteristicas->setProperty('lugar', $lugar);
        $obj_vivCaracteristicas->setProperty('limpieza', $limpieza);

        $result = $obj_vivCaracteristicas->insert();
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
            SELECT vc.id_caracteristica, 
            	   vc.usr_create,
            	   vc.fch_create, 
            	   fcn_desc_configurations('tipo_vivienda', vc.tipo_vivienda) descripcion_tipo_viv,
            	   fcn_desc_configurations('tipo_tenencia', vc.tipo_tenencia) descripcion_tenencia,
            	   fcn_desc_configurations('tipo_tamano_vivienda', vc.tipo_tamano_vivienda) descripcion_tamano,
            	   fcn_desc_configurations('tipo_vivienda_estado', vc.tipo_vivienda_estado) descripcion_estado,
            	   vc.aclaracion_viv,
            	   vc.direccion,
            	   vc.telefono,
            	   vc.barrio,
            	   vc.estrato,
            	   fcn_desc_configurations('tipo_ubicacion_sector', vc.zona) zona,
            	   fcn_desc_configurations('tipo_ambiente_teletrabajo', vc.ambiente) ambiente,
            	   fcn_desc_configurations('tipo_sector', vc.sector) sector,
            	   fcn_desc_configurations('tipo_lugar_teletrabajo', vc.lugar) lugar,
            	   vc.limpieza
            FROM viv_caracteristicas vc 
            WHERE vc.id_solicitud = :id_solicitud
            and vc.id_servicio = :id_servicio
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

    public static function delete($id_combo)
    {
        if (!isset($id_combo) || $id_combo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SrvCombos($id_combo);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findById($id_caracteristica)
    {
        if (!isset($id_caracteristica) || $id_caracteristica == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select vc.id_caracteristica, 
                       vc.tipo_vivienda, 
                       vc.tipo_tenencia, 
                       vc.tipo_tamano_vivienda, 
                       vc.tipo_vivienda_estado, 
                       vc.aclaracion_viv,
                       vc.direccion,
                       vc.telefono,
                       vc.barrio,
                       vc.estrato,
                       vc.zona,
                       vc.ambiente,
                       vc.sector,
                       vc.lugar,
                       vc.limpieza,
                       vc.usr_create, 
                       vc.fch_create 
                from viv_caracteristicas vc  
                where vc.id_caracteristica = :id_caracteristica;
            SQL,
            array("id_caracteristica" => $id_caracteristica),
            false,
            "N"
        );

        return Result::success($result, "buscar Caracteristica Vivienda");
    }


    public static function update(
        $id_caracteristica,
        $id_solicitud,
        $tipo_vivienda,
        $tipo_tenencia,
        $tipo_tamano_vivienda,
        $tipo_vivienda_estado,
        $aclaracion_viv,
        $direccion,
        $telefono,
        $barrio,
        $estrato,
        $zona,
        $ambiente,
        $sector,
        $lugar,
        $limpieza
    ) {
        if (!isset($id_caracteristica) || $id_caracteristica == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new Vivcaracteristicas($id_caracteristica);
        $dao->setProperty('id_solicitud', $id_solicitud);
        $dao->setProperty('tipo_vivienda', $tipo_vivienda);
        $dao->setProperty('tipo_tenencia', $tipo_tenencia);
        $dao->setProperty('tipo_tamano_vivienda', $tipo_tamano_vivienda);
        $dao->setProperty('tipo_vivienda_estado', $tipo_vivienda_estado);
        $dao->setProperty('aclaracion_viv', $aclaracion_viv);
        $dao->setProperty('direccion', $direccion);
        $dao->setProperty('telefono', $telefono);
        $dao->setProperty('barrio', $barrio);
        $dao->setProperty('estrato', $estrato);
        $dao->setProperty('zona', $zona);
        $dao->setProperty('ambiente', $ambiente);
        $dao->setProperty('sector', $sector);
        $dao->setProperty('lugar', $lugar);
        $dao->setProperty('limpieza', $limpieza);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    public static function findAllByCombo($id_caracteristica, $categoria, $id_solicitud, $id_servicio)
    {
        if (!isset($id_caracteristica) || $id_caracteristica == "")
            return Result::error(__FUNCTION__, "caracteristica es requerido");

        $result = QuerySQL::select(
            <<<SQL
                    select vcv.*, c.descripcion  
                    from viv_caracteristicas_variables vcv, configurations c
                    where (vcv.id_caracteristica = :id_caracteristica)
                    and vcv.id_solicitud = :id_solicitud 
                    and vcv.id_servicio = :id_servicio
                    and vcv.categoria = :categoria
                    and vcv.activo = 1
                    and vcv.categoria = c.categoria 
                    and vcv.codigo = c.codigo
            SQL,
            array("id_caracteristica" => $id_caracteristica, "categoria" => $categoria, "id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );
        return Result::success($result, "buscar aspectos por caracteristica");
    }


    public static function findAllByComboviv($id_caracteristica, $id_solicitud, $id_servicio)
    {
        if (!isset($id_caracteristica) || $id_caracteristica == "")
            return Result::error(__FUNCTION__, "caracteristica es requerido");

        $result = QuerySQL::select(
            <<<SQL
                    select vcv.* 
                    from viv_caracteristicas_variables vcv
                    where vcv.id_solicitud = :id_solicitud 
                    and vcv.id_servicio = :id_servicio
                    and vcv.id_caracteristica = :id_caracteristica
                    and vcv.activo = 1
            SQL,
            array("id_caracteristica" => $id_caracteristica,"id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );
        return Result::success($result, "buscar aspectos por caracteristica");
    }


    public static function findAByAspecto($id_caracteristica, $categoria, $codigo, $id_solicitud, $id_servicio)
    {
        if (!isset($id_caracteristica) || $id_caracteristica == "")
            return Result::error(__FUNCTION__, "caracteristica es requerido");

        $result = QuerySQL::select(
            <<<SQL
                    SELECT vcv.id_caracteristica_variable, 
                        vcv.id_solicitud,
                        vcv.id_servicio,
                        vcv.id_caracteristica,
                        vcv.categoria,
                        vcv.codigo,
                        vcv.activo
                    FROM viv_caracteristicas_variables vcv 
                    WHERE (vcv.id_caracteristica = :id_caracteristica)
                    and vcv.codigo = :codigo
                    and vcv.id_solicitud = :id_solicitud 
                    and vcv.id_servicio = :id_servicio
                    and vcv.categoria = :categoria
            SQL,
            array("id_caracteristica" => $id_caracteristica, "categoria" => $categoria, "codigo" => $codigo, "id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );
        return Result::success($result, "buscar aspectos por codigo");
    }

    public static function findAllByComboAspectoFisico($id_caracteristica, $p_aspecto)
    {
        if (!isset($id_caracteristica) || $id_caracteristica == "")
            return Result::error(__FUNCTION__, "caracteristica es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select vcv.* 
                from viv_caracteristicas_variables vcv, viv_caracteristicas_tipo vct
                where (vcv.id_caracteristica = :id_caracteristica)
                and vcv.id_caracteristica_tipo = vct.id_caracteristica_tipo
                and vct.tipo_variable = :p_aspecto
                and vcv.activo = 1
            SQL,
            array("id_caracteristica" => $id_caracteristica, "p_aspecto" => $p_aspecto),
            true,
            "N"
        );
        return Result::success($result, "buscar aspectos por caracteristica");
    }

}
