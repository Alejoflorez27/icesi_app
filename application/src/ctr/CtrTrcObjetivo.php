<?php

class CtrTrcObjetivo
{
    public static function listar()
    {
        $result = QuerySQL::select(
            <<<SQL
                SELECT
                    o.id_objetivo,
                    o.id_competencia,
                    o.nombre,
                    o.descripcion,
                    c.nombre AS competencia,
                    COUNT(DISTINCT co.id_curso) AS total_cursos
                FROM objetivos o
                INNER JOIN competencias c ON c.id_competencia = o.id_competencia
                LEFT JOIN curso_objetivo co ON co.id_objetivo = o.id_objetivo
                GROUP BY
                    o.id_objetivo,
                    o.id_competencia,
                    o.nombre,
                    o.descripcion,
                    c.nombre
                ORDER BY o.nombre
            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "listar objetivos");
    }

    public static function obtener($id_objetivo)
    {
        if (!isset($id_objetivo) || $id_objetivo == "")
            return Result::error(__FUNCTION__, "id_objetivo es requerido");

        $result = QuerySQL::select(
            <<<SQL
                SELECT
                    o.id_objetivo,
                    o.id_competencia,
                    o.nombre,
                    o.descripcion
                FROM objetivos o
                WHERE o.id_objetivo = :id_objetivo
            SQL,
            array(
                "id_objetivo" => $id_objetivo
            ),
            false,
            "N"
        );

        return Result::success($result, "obtener objetivo");
    }

    public static function crear($id_competencia, $nombre, $descripcion)
    {
        if (!isset($id_competencia) || $id_competencia == "")
            return BaseResponse::error(__FUNCTION__, "Competencia es requerida");

        if (!isset($nombre) || $nombre == "")
            return BaseResponse::error(__FUNCTION__, "Nombre es requerido");

        $obj_objetivo = new TrcObjetivo();
        $obj_objetivo->setProperty('id_competencia', $id_competencia);
        $obj_objetivo->setProperty('nombre', $nombre);
        $obj_objetivo->setProperty('descripcion', $descripcion);

        $result = $obj_objetivo->insert();

        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function actualizar($id_objetivo, $id_competencia, $nombre, $descripcion)
    {
        if (!isset($id_objetivo) || $id_objetivo == "")
            return Result::error(__FUNCTION__, "id_objetivo es requerido");

        if (!isset($id_competencia) || $id_competencia == "")
            return Result::error(__FUNCTION__, "Competencia es requerida");

        if (!isset($nombre) || $nombre == "")
            return Result::error(__FUNCTION__, "Nombre es requerido");

        $dao = new TrcObjetivo($id_objetivo);
        $dao->setProperty('id_competencia', $id_competencia);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('descripcion', $descripcion);

        $result = $dao->update();

        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function eliminar($id_objetivo)
    {
        if (!isset($id_objetivo) || $id_objetivo == "")
            return Result::error(__FUNCTION__, "id_objetivo es requerido");

        $dao = new TrcObjetivo($id_objetivo);

        $result = $dao->delete();

        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }
}
