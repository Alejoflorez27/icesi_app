<?php

class VivPasivos extends TABLE
{

    protected $id_pasivo;
    protected $id_solicitud;
    protected $id_servicio;
    protected $concepto_pasivo;
    protected $otros;
    protected $tipo_familiar;
    protected $otro_propietario;
    protected $valor_pasivo;
    protected $plazo_pasivo;
    protected $couta;
    protected $estado_obligacion;
    protected $valor_mora;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_pasivo = null)
    {

        parent::__construct("viv_pasivos", array("id_pasivo"));

        if ($id_pasivo != null) {
            $this->id_pasivo = $id_pasivo;
            $this->select();
        }
    }
}