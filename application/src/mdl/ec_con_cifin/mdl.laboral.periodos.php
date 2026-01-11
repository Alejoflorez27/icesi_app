<?php

class laboralPeriodos extends TABLE
{

    protected $id_laboral_periodos;
    protected $id_solicitud;
    protected $id_servicio;
    protected $periodo;
    protected $tmp_periodo;
    protected $descripcion;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_laboral_periodos = null)
    {

        parent::__construct("laboral_periodos", array("id_laboral_periodos"));

        if ($id_laboral_periodos != null) {
            $this->id_laboral_periodos = $id_laboral_periodos;
            $this->select();
        }
    }
}