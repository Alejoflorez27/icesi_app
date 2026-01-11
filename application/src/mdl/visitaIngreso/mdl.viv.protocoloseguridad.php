<?php

class VivProtocoloSeguridad extends TABLE
{

    protected $id_seguridad;
    protected $id_solicitud;
    protected $id_servicio;
    protected $concepto_seguridad;
    protected $respuesta;
    protected $descripcion_seguridad;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_seguridad = null)
    {

        parent::__construct("viv_protocolo_seguridad", array("id_seguridad"));

        if ($id_seguridad != null) {
            $this->id_seguridad = $id_seguridad;
            $this->select();
        }
    }
}