<?php

class DimVarRespuestaSalud extends TABLE
{

    protected $id_var_respuesta_salud;
    protected $id_solicitud;
    protected $id_pregunta;
    protected $id_variable_salud;
    protected $activo;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_var_respuesta_salud = null)
    {
        parent::__construct("dim_var_respuesta_salud", array("id_var_respuesta_salud"));

        if ($id_var_respuesta_salud != null) {
            $this->id_var_respuesta_salud = $id_var_respuesta_salud;
            $this->select();
        }
    }
}