<?php

class CtrFtFacturacionDetalle
{


    public static function new(
        $factura,
        $id_solicitud,
        $id_combo_cli,
        $valor,
        $destino_factura,
        $estado = 0,
        $id_servicio = null
    ) {


        if (!isset($factura) || $factura == "")
            return Result::error(__FUNCTION__, "factura es requerido");

        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "solicitud es requerido");

        if (!isset($id_combo_cli) || $id_combo_cli == "")
            return Result::error(__FUNCTION__, "Id combo es requerido");

        if (!isset($valor) || $valor == "")
            return Result::error(__FUNCTION__, "valor es requerido");

        if (!is_numeric($valor))
            return Result::error(__FUNCTION__, "valor debe ser numerico");


        $dao = new FtFacturacionDetalle();
        $dao->setProperty("factura", $factura);
        $dao->setProperty("id_solicitud", $id_solicitud);
        $dao->setProperty("id_servicio", $id_servicio);
        $dao->setProperty("id_combo_cli", $id_combo_cli);
        $dao->setProperty("valor", $valor);
        $dao->setProperty("estado", $estado);
        $dao->setProperty("destino_factura", $destino_factura);


        $result =  $dao->insert();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findAllByFactura($factura)
    {
        $result = QuerySQL::select(
            <<<SQL
                select fd.*,
                0 valor_combo_unckeck, decode(fd.estado, 0,'Prefacturado', 1,'Aprobado', 2,'Rechazado', 3,'Facturado') des_estado
                from ft_facturacion_detalle fd, sol_solicitud s 
                where fd.id_solicitud = s.id_solicitud
                and fd.factura = :factura
            SQL,
            array("factura" => $factura),
            true,
            "N"
        );

        return Result::success($result, "buscar servicios facturados por factura");
    }

    public static function delete(
        $factura,
        $id_solicitud
    ) {
        if (!isset($factura) || $factura == "")
            return Result::error(__FUNCTION__, "factura es requerido");

        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "servicio es requerido");


        $dao = new FtFacturacionDetalle($factura, $id_solicitud);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function facturar(
        $factura,
        $id_solicitud
    ) {
        if (!isset($factura) || $factura == "")
            return Result::error(__FUNCTION__, "factura es requerido");

        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "servicio es requerido");


        $dao = new FtFacturacionDetalle($factura, $id_solicitud);
        $dao->setProperty("estado", 3);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    public static function aprobar(
        $factura,
        $id_solicitud
    ) {
        if (!isset($factura) || $factura == "")
            return Result::error(__FUNCTION__, "factura es requerido");

        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "servicio es requerido");
           
            $dao = new FtFacturacionDetalle($factura, $id_solicitud);
            $dao->setProperty('estado', 1);
    
            $result =  $dao->update();
            if ($result['success']) {
                return Result::success($result);
            } else {
                return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
            }
    }

    public static function rechazar(
        $factura,
        $id_solicitud
    ) {
        if (!isset($factura) || $factura == "")
            return Result::error(__FUNCTION__, "factura es requerido");

        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "servicio es requerido");


        $dao = new FtFacturacionDetalle($factura, $id_solicitud);
        $dao->setProperty("estado", 2);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }




    
}
