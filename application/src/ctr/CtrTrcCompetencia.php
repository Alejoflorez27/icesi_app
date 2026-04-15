<?php

/**
 * Controlador: Competencias Académicas
 */
class CtrTrcCompetencia
{
    public static function listar()
    {
        try {
            $sql = "SELECT * FROM competencias ORDER BY nombre";
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
            if (!isset($_POST['id_competencia'])) {
                return Result::error("ID de la competencia requerido", 400);
            }

            $idCompetencia = intval($_POST['id_competencia']);
            $competencia = new TrcCompetencia($idCompetencia);
            
            if (empty($competencia->getIdCompetencia())) {
                return Result::error("Competencia no encontrada", 404);
            }

            $datos = [
                'id_competencia' => $competencia->getIdCompetencia(),
                'nombre' => $competencia->getNombre(),
                'descripcion' => $competencia->getDescripcion()
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

            $competencia = new TrcCompetencia();
            $competencia->setNombre($_POST['nombre']);
            $competencia->setDescripcion($_POST['descripcion'] ?? null);
            
            if ($competencia->guardar()) {
                return BaseResponse::message("Competencia creada exitosamente");
            } else {
                return BaseResponse::error("Error al crear la competencia");
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

            if (!isset($_POST['id_competencia']) || !isset($_POST['nombre'])) {
                return BaseResponse::error("Datos incompletos");
            }

            $competencia = new TrcCompetencia($_POST['id_competencia']);
            if (empty($competencia->getIdCompetencia())) {
                return BaseResponse::error("Competencia no encontrada");
            }

            $competencia->setNombre($_POST['nombre']);
            $competencia->setDescripcion($_POST['descripcion'] ?? $competencia->getDescripcion());
            
            if ($competencia->guardar()) {
                return BaseResponse::message("Competencia actualizada exitosamente");
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

            if (!isset($_POST['id_competencia'])) {
                return BaseResponse::error("ID requerido");
            }

            $competencia = new TrcCompetencia($_POST['id_competencia']);
            if (empty($competencia->getIdCompetencia())) {
                return BaseResponse::error("Competencia no encontrada");
            }

            if ($competencia->eliminar()) {
                return BaseResponse::message("Competencia eliminada exitosamente");
            } else {
                return BaseResponse::error("Error al eliminar");
            }
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }
}
