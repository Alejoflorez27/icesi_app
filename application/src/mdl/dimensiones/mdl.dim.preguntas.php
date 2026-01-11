<?php

class DimPreguntas extends TABLE
{

    protected $id_pregunta;
    protected $id_dimension;
    protected $nombre_pregunta;
    protected $descripcion;
    protected $puntaje;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_pregunta = null)
    {

        parent::__construct("dim_preguntas", array("id_pregunta"));

        if ($id_pregunta != null) {
            $this->id_pregunta = $id_pregunta;
            $this->select();
        }
    }
}