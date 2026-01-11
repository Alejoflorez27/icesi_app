<?php

class dimVarPreguntaSalud extends TABLE
{

    protected $id_variable_salud;
    protected $nombre_pregunta;
    protected $id_pregunta;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_variable_salud = null)
    {
        parent::__construct("dim_var_pregunta_salud", array("id_variable_salud"));

        if ($id_variable_salud != null) {
            $this->id_variable_salud = $id_variable_salud;
            $this->select();
        }
    }
}