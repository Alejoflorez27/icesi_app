<?php

class SolFamiliar extends TABLE
{

    protected $id_familia;
    protected $id_solicitud;
    protected $id_servicio;
    protected $id_ciudad_act;
    protected $parentesco;
    protected $nombre;
    protected $apellido;
    protected $edad;
    protected $estado_civil;
    protected $nivel_escolar;
    protected $ocupacion;
    protected $empresa;
    protected $viv_candidato;
    protected $depende_candidato;
    protected $telefono;
    protected $residencia;
    protected $horario;
    protected $identificacion;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_familia = null)
    {

        parent::__construct("sol_familiar", array("id_familia"));

        if ($id_familia != null) {
            $this->id_familia = $id_familia;
            $this->select();
        }
    }
}