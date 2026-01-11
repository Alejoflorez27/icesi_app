<?php

class VivRiesgosFinanciero extends TABLE
{

    protected $id_financiero;
    protected $id_solicitud;
    protected $id_servicio;
    protected $persona_evaluada;
    protected $concepto_financiero;
    protected $estado;
    protected $descripcion_financiero;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_financiero = null)
    {

        parent::__construct("viv_riesgos_financieros", array("id_financiero"));

        if ($id_financiero != null) {
            $this->id_financiero = $id_financiero;
            $this->select();
        }
    }
}