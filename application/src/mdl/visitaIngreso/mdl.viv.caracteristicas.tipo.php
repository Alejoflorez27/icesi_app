<?php

class VivcaracteristicasTipo extends TABLE
{

    protected $id_caracteristica_tipo;
    protected $nombre;
    protected $tipo_variable;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_caracteristica_tipo = null)
    {
        parent::__construct("viv_caracteristicas_tipo", array("id_caracteristica_tipo"));

        if ($id_caracteristica_tipo != null) {
            $this->id_caracteristica_tipo = $id_caracteristica_tipo;
            $this->select();
        }
    }
}