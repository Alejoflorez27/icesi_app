<?php

/**
 * Controlador: Cursos Académicos
 */
class CtrTrcCurso
{
    public static function listar()
    {
        try {
            $sql = "SELECT c.*, p.nombre as programa 
                    FROM cursos c
                    LEFT JOIN programas p ON c.id_programa = p.id_programa
                    ORDER BY c.nombre";
            $resultado = new Conexion();
            $resultado = $resultado->set($sql);
            return Result::message("success", $resultado->resultado, 200);
        } catch (Exception $e) {
            return Result::error($e->getMessage(), 500);
        }
    }

    public static function obtener()
    {
        try {
            if (!isset($_POST['id_curso'])) {
                return Result::error("ID del curso requerido", 400);
            }

            $idCurso = intval($_POST['id_curso']);
            $curso = new TrcCurso($idCurso);
            
            if (empty($curso->getIdCurso())) {
                return Result::error("Curso no encontrado", 404);
            }

            $datos = [
                'id_curso' => $curso->getIdCurso(),
                'id_programa' => $curso->getIdPrograma(),
                'nombre' => $curso->getNombre(),
                'codigo' => $curso->getCodigo(),
                'descripcion' => $curso->getDescripcion(),
                'creditos' => $curso->getCreditos()
            ];

            return Result::message("success", $datos, 200);
        } catch (Exception $e) {
            return Result::error($e->getMessage(), 500);
        }
    }

    public static function crear()
    {
        try {
            if (!ValidateToken::autentication()) {
                return BaseResponse::error("No autorizado");
            }

            if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
                return BaseResponse::error("Nombre requerido");
            }

            $curso = new TrcCurso();
            $curso->setIdPrograma($_POST['id_programa'] ?? null);
            $curso->setNombre($_POST['nombre']);
            $curso->setCodigo($_POST['codigo'] ?? null);
            $curso->setDescripcion($_POST['descripcion'] ?? null);
            $curso->setCreditos($_POST['creditos'] ?? 0);
            
            if ($curso->guardar()) {
                return BaseResponse::message("Curso creado exitosamente");
            } else {
                return BaseResponse::error("Error al crear el curso");
            }
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public static function actualizar()
    {
        try {
            if (!ValidateToken::autentication()) {
                return BaseResponse::error("No autorizado");
            }

            if (!isset($_POST['id_curso']) || !isset($_POST['nombre'])) {
                return BaseResponse::error("Datos incompletos");
            }

            $curso = new TrcCurso($_POST['id_curso']);
            if (empty($curso->getIdCurso())) {
                return BaseResponse::error("Curso no encontrado");
            }

            $curso->setIdPrograma($_POST['id_programa'] ?? $curso->getIdPrograma());
            $curso->setNombre($_POST['nombre']);
            $curso->setCodigo($_POST['codigo'] ?? $curso->getCodigo());
            $curso->setDescripcion($_POST['descripcion'] ?? $curso->getDescripcion());
            $curso->setCreditos($_POST['creditos'] ?? $curso->getCreditos());
            
            if ($curso->guardar()) {
                return BaseResponse::message("Curso actualizado exitosamente");
            } else {
                return BaseResponse::error("Error al actualizar");
            }
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public static function eliminar()
    {
        try {
            if (!ValidateToken::autentication()) {
                return BaseResponse::error("No autorizado");
            }

            if (!isset($_POST['id_curso'])) {
                return BaseResponse::error("ID requerido");
            }

            $curso = new TrcCurso($_POST['id_curso']);
            if (empty($curso->getIdCurso())) {
                return BaseResponse::error("Curso no encontrado");
            }

            if ($curso->eliminar()) {
                return BaseResponse::message("Curso eliminado exitosamente");
            } else {
                return BaseResponse::error("Error al eliminar");
            }
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }
}
