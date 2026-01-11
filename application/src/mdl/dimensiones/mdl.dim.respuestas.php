<?php

class DimRespuestas extends TABLE
{

    protected $id_respuesta;
    protected $id_pregunta;
    protected $id_solicitud;
    protected $id_servicio;
    protected $nivel_riesgo;
    protected $respuesta;
    protected $texto_completo;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_respuesta = null)
    {

        parent::__construct("dim_respuestas", array("id_respuesta"));

        if ($id_respuesta != null) {
            $this->id_respuesta = $id_respuesta;
            $this->select();
        }
    }
}