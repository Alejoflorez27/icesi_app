<?php

/**
 * Modelo: Objetivo
 * Gestión de objetivos de aprendizaje
 */
class TrcObjetivo extends TABLE
{
    protected $id_objetivo;
    protected $id_competencia;
    protected $nombre;
    protected $descripcion;
    protected $created_at;
    protected $updated_at;

    public function __construct($idObjetivo = null)
    {
        parent::__construct("objetivos", array("id_objetivo"));

        if ($idObjetivo != null) {
            $this->id_objetivo = $idObjetivo;
            $this->select();
        }
    }

    public function getIdObjetivo()
    {
        return $this->id_objetivo;
    }

    public function setIdObjetivo($id_objetivo)
    {
        $this->id_objetivo = $id_objetivo;
    }

    public function getIdCompetencia()
    {
        return $this->id_competencia;
    }

    public function setIdCompetencia($id_competencia)
    {
        $this->id_competencia = $id_competencia;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
}
