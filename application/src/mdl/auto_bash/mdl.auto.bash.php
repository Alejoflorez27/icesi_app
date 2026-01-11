<?php

class AutoBash extends TABLE
{

    protected $id_auto;
    protected $id_empresa;
    protected $usuario ;
    protected $fch_cliente_auto ;
    protected $nombre_firma ;
    protected $nombre_encr ;
    protected $directorio ;
    protected $tamano ;
    protected $ext ;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_auto = null)
    {

        parent::__construct("auto_bash", array("id_auto"));

        if ($id_auto != null) {
            $this->id_auto = $id_auto;
            $this->select();
        }
    }
}
