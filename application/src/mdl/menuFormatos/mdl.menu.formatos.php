<?php

class menuFormatos extends TABLE
{

    protected $id_menu;
    protected $id_servicio;
    protected $url;
    protected $nombre;
    protected $estado;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_menu = null)
    {

        parent::__construct("menu_formatos", array("id_menu"));

        if ($id_menu != null) {
            $this->id_menu = $id_menu;
            $this->select();
        }
    }
}