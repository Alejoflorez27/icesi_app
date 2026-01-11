<?php

class SolFormacion extends TABLE
{

    protected $id_formacion;
    protected $id_solicitud;
    protected $id_servicio;
    protected $nivel_escolaridad;
    protected $nombre_institucion;
    protected $programa_academico;
    protected $fch_grado;
    protected $acta_folio;
    protected $nom_funcionario;
    protected $tel_funcionario;
    protected $obs_academica;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_formacion = null)
    {

        parent::__construct("sol_formacion", array("id_formacion"));

        if ($id_formacion != null) {
            $this->id_formacion = $id_formacion;
            $this->select();
        }
    }
}