<?php

/**
 * API: Análisis de Currículo
 * Endpoints para visualización de relaciones y análisis
 */

$action = $_REQUEST['action'] ?? '';
$ctr = new CtrCurriculo();

switch ($action) {
    case 'dashboard':
        CtrAPI::response(
            200,
            'success',
            'Dashboard cargado correctamente',
            $ctr->dashboard()
        );
        break;
    
    case 'listarCursos':
        $filtros = [
            'programa' => $_REQUEST['programa'] ?? '',
            'competencia' => $_REQUEST['competencia'] ?? '',
            'objetivo' => $_REQUEST['objetivo'] ?? '',
            'nivel' => $_REQUEST['nivel'] ?? ''
        ];
        
        CtrAPI::response(
            200,
            'success',
            'Cursos obtenidos correctamente',
            $ctr->listarCursos($filtros)
        );
        break;
    
    case 'analisisCobertura':
        CtrAPI::response(
            200,
            'success',
            'Análisis de cobertura obtenido correctamente',
            $ctr->obtenerAnalisisCobertura()
        );
        break;
    
    default:
        CtrAPI::response(400, 'error', 'Acción no válida');
}
