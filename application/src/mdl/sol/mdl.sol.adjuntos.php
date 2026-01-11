<?php

class SolAdjuntos extends TABLE
{
    protected $id_adjunto;
    protected $id_solicitud;
    protected $id_servicio;
    protected $nombre;
    protected $nombre_encr;
    protected $directorio;
    protected $tamano;
    protected $tipo_doc;
    protected $ext;
    protected $observacion;
    protected $lista;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_adjunto = null)
    {
        parent::__construct("sol_adjuntos", array("id_adjunto"));

        if ($id_adjunto != null) {
            $this->id_adjunto = $id_adjunto;
            $this->select();
        }
    }
}
