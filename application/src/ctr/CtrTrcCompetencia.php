<?php

class CtrTrcCompetencia
{
    public static function listar()
    {
        $result = QuerySQL::select(
            <<<SQL
                SELECT
                    c.id_competencia,
                    c.nombre,
                    c.descripcion,
                    COUNT(DISTINCT o.id_objetivo) AS total_objetivos
                FROM competencias c
                LEFT JOIN objetivos o ON o.id_competencia = c.id_competencia
                GROUP BY
                    c.id_competencia,
                    c.nombre,
                    c.descripcion
                ORDER BY c.nombre
            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "listar competencias");
    }

    public static function obtener($id_competencia)
    {
        if (!isset($id_competencia) || $id_competencia == "")
            return Result::error(__FUNCTION__, "id_competencia es requerido");

        $result = QuerySQL::select(
            <<<SQL
                SELECT
                    c.id_competencia,
                    c.nombre,
                    c.descripcion
                FROM competencias c
                WHERE c.id_competencia = :id_competencia
            SQL,
            array(
                "id_competencia" => $id_competencia
            ),
            false,
            "N"
        );

        return Result::success($result, "obtener competencia");
    }

    public static function crear($nombre, $descripcion)
    {
        if (!isset($nombre) || $nombre == "")
            return BaseResponse::error(__FUNCTION__, "Nombre es requerido");

        $obj_competencia = new TrcCompetencia();
        $obj_competencia->setProperty('nombre', $nombre);
        $obj_competencia->setProperty('descripcion', $descripcion);

        $result = $obj_competencia->insert();

        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function actualizar($id_competencia, $nombre, $descripcion)
    {
        if (!isset($id_competencia) || $id_competencia == "")
            return Result::error(__FUNCTION__, "id_competencia es requerido");

        if (!isset($nombre) || $nombre == "")
            return Result::error(__FUNCTION__, "Nombre es requerido");

        $dao = new TrcCompetencia($id_competencia);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('descripcion', $descripcion);

        $result = $dao->update();

        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function eliminar($id_competencia)
    {
        if (!isset($id_competencia) || $id_competencia == "")
            return Result::error(__FUNCTION__, "id_competencia es requerido");

        $dao = new TrcCompetencia($id_competencia);

        $result = $dao->delete();

        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }
}
