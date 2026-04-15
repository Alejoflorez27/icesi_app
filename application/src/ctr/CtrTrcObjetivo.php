<?php

/**
 * Controlador: Objetivos de Aprendizaje
 */
class CtrTrcObjetivo
{
    public static function listar()
    {
        try {
            $sql = "SELECT o.*, c.nombre as competencia 
                    FROM objetivos o
                    LEFT JOIN competencias c ON o.id_competencia = c.id_competencia
                    ORDER BY o.nombre";
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
            if (!isset($_POST['id_objetivo'])) {
                return Result::error("ID del objetivo requerido", 400);
            }

            $idObjetivo = intval($_POST['id_objetivo']);
            $objetivo = new TrcObjetivo($idObjetivo);
            
            if (empty($objetivo->getIdObjetivo())) {
                return Result::error("Objetivo no encontrado", 404);
            }

            $datos = [
                'id_objetivo' => $objetivo->getIdObjetivo(),
                'id_competencia' => $objetivo->getIdCompetencia(),
                'nombre' => $objetivo->getNombre(),
                'descripcion' => $objetivo->getDescripcion()
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

            $objetivo = new TrcObjetivo();
            $objetivo->setIdCompetencia($_POST['id_competencia'] ?? null);
            $objetivo->setNombre($_POST['nombre']);
            $objetivo->setDescripcion($_POST['descripcion'] ?? null);
            
            if ($objetivo->guardar()) {
                return BaseResponse::message("Objetivo creado exitosamente");
            } else {
                return BaseResponse::error("Error al crear el objetivo");
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

            if (!isset($_POST['id_objetivo']) || !isset($_POST['nombre'])) {
                return BaseResponse::error("Datos incompletos");
            }

            $objetivo = new TrcObjetivo($_POST['id_objetivo']);
            if (empty($objetivo->getIdObjetivo())) {
                return BaseResponse::error("Objetivo no encontrado");
            }

            $objetivo->setIdCompetencia($_POST['id_competencia'] ?? $objetivo->getIdCompetencia());
            $objetivo->setNombre($_POST['nombre']);
            $objetivo->setDescripcion($_POST['descripcion'] ?? $objetivo->getDescripcion());
            
            if ($objetivo->guardar()) {
                return BaseResponse::message("Objetivo actualizado exitosamente");
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

            if (!isset($_POST['id_objetivo'])) {
                return BaseResponse::error("ID requerido");
            }

            $objetivo = new TrcObjetivo($_POST['id_objetivo']);
            if (empty($objetivo->getIdObjetivo())) {
                return BaseResponse::error("Objetivo no encontrado");
            }

            if ($objetivo->eliminar()) {
                return BaseResponse::message("Objetivo eliminado exitosamente");
            } else {
                return BaseResponse::error("Error al eliminar");
            }
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }
}
