<?php

/**
 * Modelo: CursoObjetivo
 * Gestión de la relación entre cursos y objetivos
 */
class TrcCursoObjetivo extends TABLE
{
    protected $id_curso_objetivo;
    protected $id_curso;
    protected $id_objetivo;
    protected $nivel;
    protected $created_at;
    protected $updated_at;

    public function __construct($idCursoObjetivo = null)
    {
        parent::__construct("curso_objetivo", array("id_curso_objetivo"));

        if ($idCursoObjetivo != null) {
            $this->id_curso_objetivo = $idCursoObjetivo;
            $this->select();
        }
    }

    public function getIdCursoObjetivo()
    {
        return $this->id_curso_objetivo;
    }

    public function setIdCursoObjetivo($id_curso_objetivo)
    {
        $this->id_curso_objetivo = $id_curso_objetivo;
    }

    public function getIdCurso()
    {
        return $this->id_curso;
    }

    public function setIdCurso($id_curso)
    {
        $this->id_curso = $id_curso;
    }

    public function getIdObjetivo()
    {
        return $this->id_objetivo;
    }

    public function setIdObjetivo($id_objetivo)
    {
        $this->id_objetivo = $id_objetivo;
    }

    public function getNivel()
    {
        return $this->nivel;
    }

    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }
}

