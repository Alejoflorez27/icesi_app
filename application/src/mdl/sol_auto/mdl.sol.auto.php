<?php

class SolAuto extends TABLE
{

    protected $id_auto;
    protected $id_solicitud;
    protected $usuario ;
    protected $contactar_empleador ;
    protected $instituciones ;
    protected $grabacion ;
    protected $registro_foto ;
    protected $acepto ;
    protected $fch_candidato_auto ;
    protected $nombre_firma ;
    protected $nombre_encr ;
    protected $directorio ;
    protected $tamano ;
    protected $ext ;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_auto = null)
    {

        parent::__construct("sol_auto", array("id_auto"));

        if ($id_auto != null) {
            $this->id_auto = $id_auto;
            $this->select();
        }
    }
}
