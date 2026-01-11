<?php

class respFuenteConsultada extends TABLE
{

    protected $id_resp_fuente;
    protected $id_pre_fuente;
    protected $id_solicitud;
    protected $id_servicio;
    protected $respuesta;
    protected $nombre_variable;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_resp_fuente = null)
    {

        parent::__construct("resp_fuente_consultada", array("id_resp_fuente"));

        if ($id_resp_fuente != null) {
            $this->id_resp_fuente = $id_resp_fuente;
            $this->select();
        }
    }
}