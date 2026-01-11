<?php

class refPersonales extends TABLE
{

    protected $id_ref_personal;
    protected $id_solicitud;
    protected $id_servicio;
    protected $referencia_personal;
    protected $nombre;
    protected $telefono;
    protected $concepto;
    protected $observacion_adicional;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_ref_personal = null)
    {

        parent::__construct("ref_personales", array("id_ref_personal"));

        if ($id_ref_personal != null) {
            $this->id_ref_personal = $id_ref_personal;
            $this->select();
        }
    }
}