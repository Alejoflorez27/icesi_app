<?php

class CtrCursoObjetivo
{
    public static function listar()
    {
        $result = QuerySQL::select(
            <<<SQL
                SELECT
                    co.id_curso_objetivo,
                    co.id_curso,
                    c.nombre AS curso,
                    co.id_objetivo,
                    o.nombre AS objetivo,
                    comp.nombre AS competencia,
                    co.nivel
                FROM curso_objetivo co
                INNER JOIN cursos c ON c.id_curso = co.id_curso
                INNER JOIN objetivos o ON o.id_objetivo = co.id_objetivo
                INNER JOIN competencias comp ON comp.id_competencia = o.id_competencia
                ORDER BY c.nombre, o.nombre
            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "listar curso objetivo");
    }

    public static function listarPorCurso($id_curso)
    {
        if (!isset($id_curso) || $id_curso == "")
            return Result::error(__FUNCTION__, "id_curso es requerido");

        $result = QuerySQL::select(
            <<<SQL
                SELECT
                    co.id_curso_objetivo,
                    co.id_curso,
                    co.id_objetivo,
                    o.nombre AS objetivo,
                    comp.nombre AS competencia,
                    co.nivel
                FROM curso_objetivo co
                INNER JOIN objetivos o ON o.id_objetivo = co.id_objetivo
                INNER JOIN competencias comp ON comp.id_competencia = o.id_competencia
                WHERE co.id_curso = :id_curso
                ORDER BY o.nombre
            SQL,
            array(
                "id_curso" => $id_curso
            ),
            true,
            "N"
        );

        return Result::success($result, "listar objetivos por curso");
    }

    public static function crear($id_curso, $id_objetivo, $nivel)
    {
        if (!isset($id_curso) || $id_curso == "")
            return BaseResponse::error(__FUNCTION__, "Curso es requerido");

        if (!isset($id_objetivo) || $id_objetivo == "")
            return BaseResponse::error(__FUNCTION__, "Objetivo es requerido");

        if (!isset($nivel) || $nivel == "")
            return BaseResponse::error(__FUNCTION__, "Nivel es requerido");

        if (!in_array($nivel, array('I', 'F', 'V')))
            return BaseResponse::error(__FUNCTION__, "Nivel no válido");

        $existe = QuerySQL::select(
            <<<SQL
                SELECT COUNT(*) AS total
                FROM curso_objetivo
                WHERE id_curso = :id_curso
                  AND id_objetivo = :id_objetivo
            SQL,
            array(
                "id_curso" => $id_curso,
                "id_objetivo" => $id_objetivo
            ),
            false,
            "N"
        );

        if (($existe['total'] ?? 0) > 0)
            return BaseResponse::error(__FUNCTION__, "La relación curso-objetivo ya existe");

        $obj = new TrcCursoObjetivo();
        $obj->setProperty('id_curso', $id_curso);
        $obj->setProperty('id_objetivo', $id_objetivo);
        $obj->setProperty('nivel', $nivel);

        $result = $obj->insert();

        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function actualizar($id_curso_objetivo, $id_objetivo, $nivel)
    {
        if (!isset($id_curso_objetivo) || $id_curso_objetivo == "")
            return Result::error(__FUNCTION__, "id_curso_objetivo es requerido");

        if (!isset($id_objetivo) || $id_objetivo == "")
            return Result::error(__FUNCTION__, "Objetivo es requerido");

        if (!isset($nivel) || $nivel == "")
            return Result::error(__FUNCTION__, "Nivel es requerido");

        if (!in_array($nivel, array('I', 'F', 'V')))
            return Result::error(__FUNCTION__, "Nivel no válido");

        $dao = new TrcCursoObjetivo($id_curso_objetivo);
        $dao->setProperty('id_objetivo', $id_objetivo);
        $dao->setProperty('nivel', $nivel);

        $result = $dao->update();

        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function eliminar($id_curso_objetivo)
    {
        if (!isset($id_curso_objetivo) || $id_curso_objetivo == "")
            return Result::error(__FUNCTION__, "id_curso_objetivo es requerido");

        $dao = new TrcCursoObjetivo($id_curso_objetivo);
        $result = $dao->delete();

        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }
}
