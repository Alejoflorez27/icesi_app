<?php

/**
 * Controlador: Programas Académicos
 */
class CtrTrcPrograma
{
    public static function listar()
    {
        try {
            $sql = "SELECT * FROM programas ORDER BY nombre";
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
            if (!isset($_POST['id_programa'])) {
                return Result::error("ID del programa requerido", 400);
            }

            $idPrograma = intval($_POST['id_programa']);
            $programa = new TrcPrograma($idPrograma);
            
            if (empty($programa->getIdPrograma())) {
                return Result::error("Programa no encontrado", 404);
            }

            $datos = [
                'id_programa' => $programa->getIdPrograma(),
                'nombre' => $programa->getNombre(),
                'codigo' => $programa->getCodigo(),
                'descripcion' => $programa->getDescripcion(),
                'activa' => $programa->getActiva()
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

            $programa = new TrcPrograma();
            $programa->setNombre($_POST['nombre']);
            $programa->setCodigo($_POST['codigo'] ?? null);
            $programa->setDescripcion($_POST['descripcion'] ?? null);
            $programa->setActiva($_POST['activa'] ?? 1);
            
            if ($programa->guardar()) {
                return BaseResponse::message("Programa creado exitosamente");
            } else {
                return BaseResponse::error("Error al crear el programa");
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

            if (!isset($_POST['id_programa']) || !isset($_POST['nombre'])) {
                return BaseResponse::error("Datos incompletos");
            }

            $programa = new TrcPrograma($_POST['id_programa']);
            if (empty($programa->getIdPrograma())) {
                return BaseResponse::error("Programa no encontrado");
            }

            $programa->setNombre($_POST['nombre']);
            $programa->setCodigo($_POST['codigo'] ?? $programa->getCodigo());
            $programa->setDescripcion($_POST['descripcion'] ?? $programa->getDescripcion());
            $programa->setActiva($_POST['activa'] ?? $programa->getActiva());
            
            if ($programa->guardar()) {
                return BaseResponse::message("Programa actualizado exitosamente");
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

            if (!isset($_POST['id_programa'])) {
                return BaseResponse::error("ID requerido");
            }

            $programa = new TrcPrograma($_POST['id_programa']);
            if (empty($programa->getIdPrograma())) {
                return BaseResponse::error("Programa no encontrado");
            }

            if ($programa->eliminar()) {
                return BaseResponse::message("Programa eliminado exitosamente");
            } else {
                return BaseResponse::error("Error al eliminar");
            }
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }
}
