<?php

class CtrTrcCurso
{
    public static function listar()
    {
        $result = QuerySQL::select(
            <<<SQL
                SELECT 
                    c.id_curso,
                    c.id_programa,
                    c.codigo,
                    c.nombre,
                    c.descripcion,
                    c.creditos,
                    p.nombre AS programa
                FROM cursos c
                INNER JOIN programas p ON p.id_programa = c.id_programa
                ORDER BY c.nombre
            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "listar cursos");
    }

    public static function obtener($id_curso)
    {
        if (!isset($id_curso) || $id_curso == "")
            return Result::error(__FUNCTION__, "id_curso es requerido");

        $result = QuerySQL::select(
            <<<SQL
                SELECT
                    c.id_curso,
                    c.id_programa,
                    c.codigo,
                    c.nombre,
                    c.descripcion,
                    c.creditos
                FROM cursos c
                WHERE c.id_curso = :id_curso
            SQL,
            array(
                "id_curso" => $id_curso
            ),
            false,
            "N"
        );

        return Result::success($result, "obtener curso");
    }

    public static function crear($id_programa, $nombre, $codigo, $descripcion, $creditos)
    {
        if (!isset($id_programa) || $id_programa == "")
            return BaseResponse::error(__FUNCTION__, "Programa es requerido");

        if (!isset($nombre) || $nombre == "")
            return BaseResponse::error(__FUNCTION__, "Nombre es requerido");

        if (!isset($codigo) || $codigo == "")
            return BaseResponse::error(__FUNCTION__, "Código es requerido");

        $obj_curso = new TrcCurso();
        $obj_curso->setProperty('id_programa', $id_programa);
        $obj_curso->setProperty('nombre', $nombre);
        $obj_curso->setProperty('codigo', $codigo);
        $obj_curso->setProperty('descripcion', $descripcion);
        $obj_curso->setProperty('creditos', ($creditos == "" || $creditos == null) ? 0 : $creditos);

        $result = $obj_curso->insert();

        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function actualizar($id_curso, $id_programa, $nombre, $codigo, $descripcion, $creditos)
    {
        if (!isset($id_curso) || $id_curso == "")
            return Result::error(__FUNCTION__, "id_curso es requerido");

        if (!isset($id_programa) || $id_programa == "")
            return Result::error(__FUNCTION__, "Programa es requerido");

        if (!isset($nombre) || $nombre == "")
            return Result::error(__FUNCTION__, "Nombre es requerido");

        if (!isset($codigo) || $codigo == "")
            return Result::error(__FUNCTION__, "Código es requerido");

        $dao = new TrcCurso($id_curso);
        $dao->setProperty('id_programa', $id_programa);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('codigo', $codigo);
        $dao->setProperty('descripcion', $descripcion);
        $dao->setProperty('creditos', ($creditos == "" || $creditos == null) ? 0 : $creditos);

        $result = $dao->update();

        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function eliminar($id_curso)
    {
        if (!isset($id_curso) || $id_curso == "")
            return Result::error(__FUNCTION__, "id_curso es requerido");

        $dao = new TrcCurso($id_curso);

        $result = $dao->delete();

        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }
}
