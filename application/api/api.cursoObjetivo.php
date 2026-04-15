<?php

/**
 * API: Relación Curso-Objetivo
 * Endpoints para gestión de la asignación de objetivos a cursos
 */

$action = $_REQUEST['action'] ?? '';
$ctr = new CtrCrudCursoObjetivo();

switch ($action) {
    case 'listar':
        CtrAPI::response(
            200,
            'success',
            'Relaciones obtenidas correctamente',
            $ctr->listar()
        );
        break;
    
    case 'obtenerObjetivosCurso':
        $idCurso = $_REQUEST['id_curso'] ?? null;
        if (!$idCurso) {
            CtrAPI::response(400, 'error', 'ID de curso requerido');
        }
        
        $mdl = new MdlCursoObjetivo();
        CtrAPI::response(
            200,
            'success',
            'Objetivos del curso obtenidos correctamente',
            $mdl->obtenerObjetivosCurso($idCurso)
        );
        break;
    
    case 'obtenerCursosObjetivo':
        $idObjetivo = $_REQUEST['id_objetivo'] ?? null;
        if (!$idObjetivo) {
            CtrAPI::response(400, 'error', 'ID de objetivo requerido');
        }
        
        $mdl = new MdlCursoObjetivo();
        CtrAPI::response(
            200,
            'success',
            'Cursos del objetivo obtenidos correctamente',
            $mdl->obtenerCursosObjetivo($idObjetivo)
        );
        break;
    
    case 'crear':
        $datos = [
            'id_curso' => $_REQUEST['id_curso'] ?? null,
            'id_objetivo' => $_REQUEST['id_objetivo'] ?? null,
            'nivel' => $_REQUEST['nivel'] ?? null
        ];
        
        if (!$datos['id_curso'] || !$datos['id_objetivo'] || !$datos['nivel']) {
            CtrAPI::response(400, 'error', 'Datos incompletos');
        }
        
        // Validar que el nivel sea válido
        if (!in_array($datos['nivel'], ['I', 'F', 'V'])) {
            CtrAPI::response(400, 'error', 'Nivel debe ser I, F o V');
        }
        
        if ($ctr->crear($datos)) {
            CtrAPI::response(201, 'success', 'Relación creada correctamente');
        } else {
            CtrAPI::response(500, 'error', 'Error al crear la relación');
        }
        break;
    
    case 'actualizar':
        $id = $_REQUEST['id'] ?? null;
        if (!$id) {
            CtrAPI::response(400, 'error', 'ID requerido');
        }
        
        $datos = [
            'id_curso' => $_REQUEST['id_curso'] ?? null,
            'id_objetivo' => $_REQUEST['id_objetivo'] ?? null,
            'nivel' => $_REQUEST['nivel'] ?? null
        ];
        
        // Validar que el nivel sea válido
        if (!in_array($datos['nivel'], ['I', 'F', 'V'])) {
            CtrAPI::response(400, 'error', 'Nivel debe ser I, F o V');
        }
        
        if ($ctr->actualizar($id, $datos)) {
            CtrAPI::response(200, 'success', 'Relación actualizada correctamente');
        } else {
            CtrAPI::response(500, 'error', 'Error al actualizar la relación');
        }
        break;
    
    case 'eliminar':
        $id = $_REQUEST['id'] ?? null;
        if (!$id) {
            CtrAPI::response(400, 'error', 'ID requerido');
        }
        
        if ($ctr->eliminar($id)) {
            CtrAPI::response(200, 'success', 'Relación eliminada correctamente');
        } else {
            CtrAPI::response(500, 'error', 'Error al eliminar la relación');
        }
        break;
    
    case 'eliminarPorCursoObjetivo':
        $idCurso = $_REQUEST['id_curso'] ?? null;
        $idObjetivo = $_REQUEST['id_objetivo'] ?? null;
        
        if (!$idCurso || !$idObjetivo) {
            CtrAPI::response(400, 'error', 'ID de curso e objetivo requeridos');
        }
        
        $mdl = new MdlCursoObjetivo();
        if ($mdl->eliminarPorCursoObjetivo($idCurso, $idObjetivo)) {
            CtrAPI::response(200, 'success', 'Relación eliminada correctamente');
        } else {
            CtrAPI::response(500, 'error', 'Error al eliminar la relación');
        }
        break;
    
    default:
        CtrAPI::response(400, 'error', 'Acción no válida');
}
