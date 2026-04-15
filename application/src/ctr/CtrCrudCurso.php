<?php

/**
 * Controlador: CRUD Cursos
 */
class CtrCrudCurso {
    
    private $mdl;
    
    public function __construct() {
        $this->mdl = new MdlCurso();
    }
    
    public function listar() {
        return $this->mdl->obtenerTodos();
    }
    
    public function obtener($id) {
        return $this->mdl->obtenerPorId($id);
    }
    
    public function crear($datos) {
        return $this->mdl->crear($datos);
    }
    
    public function actualizar($id, $datos) {
        return $this->mdl->actualizar($id, $datos);
    }
    
    public function eliminar($id) {
        return $this->mdl->eliminar($id);
    }
}
