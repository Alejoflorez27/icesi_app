<?php

class VivConceptoProfesional extends TABLE
{

    protected $id_concepto;
    protected $id_solicitud;
    protected $id_servicio;
    protected $expectativas;
    protected $metas;
    protected $medio_hv;
    protected $condicion_laboral;
    protected $concepto_final;
    protected $observacion;
    protected $requisito;
    protected $calificacion;
    protected $hallazgo;
    protected $concepto_pertenece;
    protected $pregunta_uno;
    protected $pregunta_dos;
    protected $pregunta_tres;
    protected $otro_dos;
    protected $otro_tres;
    protected $asociado_confiable;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_concepto = null)
    {

        parent::__construct("viv_concepto_profesional", array("id_concepto"));

        if ($id_concepto != null) {
            $this->id_concepto = $id_concepto;
            $this->select();
        }
    }
}
