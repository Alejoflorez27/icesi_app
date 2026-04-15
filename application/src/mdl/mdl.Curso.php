<?php

/**
 * Modelo: Curso
 * Gestión de cursos académicos
 */
class TrcCurso extends TABLE
{
    protected $id_curso;
    protected $id_programa;
    protected $nombre;
    protected $codigo;
    protected $descripcion;
    protected $creditos;
    protected $created_at;
    protected $updated_at;
    
    public function __construct($idCurso = null)
    {
        parent::__construct("cursos", array("id_curso"));
        
        if ($idCurso != null) {
            $this->id_curso = $idCurso;
            $this->select();
        }
    }
    
    public function getIdCurso()
    {
        return $this->id_curso;
    }

    public function setIdCurso($id_curso)
    {
        $this->id_curso = $id_curso;
    }

    public function getIdPrograma()
    {
        return $this->id_programa;
    }

    public function setIdPrograma($id_programa)
    {
        $this->id_programa = $id_programa;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getCreditos()
    {
        return $this->creditos;
    }

    public function setCreditos($creditos)
    {
        $this->creditos = $creditos;
    }
}