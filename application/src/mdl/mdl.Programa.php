<?php

/**
 * Modelo: Programa
 * Gestión de programas académicos
 */
class TrcPrograma extends TABLE
{
    protected $id_programa;
    protected $nombre;
    protected $codigo;
    protected $descripcion;
    protected $activa;
    protected $created_at;
    protected $updated_at;

    public function __construct($idPrograma = null)
    {
        parent::__construct("programas", array("id_programa"));

        if ($idPrograma != null) {
            $this->id_programa = $idPrograma;
            $this->select();
        }
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

    public function getActiva()
    {
        return $this->activa;
    }

    public function setActiva($activa)
    {
        $this->activa = $activa;
    }
}
