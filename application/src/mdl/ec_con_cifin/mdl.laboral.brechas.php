<?php

class laboralBrechas extends TABLE
{

    protected $id_laboral_brechas;
    protected $id_solicitud;
    protected $id_servicio;
    protected $pregunta_uno;
    protected $pregunta_dos;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_laboral_brechas = null)
    {

        parent::__construct("laboral_brechas", array("id_laboral_brechas"));

        if ($id_laboral_brechas != null) {
            $this->id_laboral_brechas = $id_laboral_brechas;
            $this->select();
        }
    }
}