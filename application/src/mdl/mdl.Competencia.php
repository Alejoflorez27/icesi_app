<?php

/**
 * Modelo: Competencia
 * Gestión de competencias académicas
 */
class TrcCompetencia extends TABLE
{
    protected $id_competencia;
    protected $nombre;
    protected $descripcion;
    protected $created_at;
    protected $updated_at;

    public function __construct($idCompetencia = null)
    {
        parent::__construct("competencias", array("id_competencia"));

        if ($idCompetencia != null) {
            $this->id_competencia = $idCompetencia;
            $this->select();
        }
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
