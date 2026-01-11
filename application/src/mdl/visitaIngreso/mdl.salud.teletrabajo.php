<?php

class saludTeletrabajo extends TABLE
{

    protected $id_salud;
    protected $id_solicitud;
    protected $id_servicio;
    protected $aspecto;
    protected $observacion;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_salud = null)
    {

        parent::__construct("salud_teletrabajo", array("id_salud"));

        if ($id_salud != null) {
            $this->id_salud = $id_salud;
            $this->select();
        }
    }
}