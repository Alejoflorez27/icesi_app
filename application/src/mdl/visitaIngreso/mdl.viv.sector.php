<?php
//carasteristicas del sector de la vivienda
class VivSector extends TABLE
{

    protected $id_sector;
    protected $id_solicitud;
    protected $sector;
    protected $estracto;
    protected $estado_sector;
    protected $ubicacion_sector;
    protected $tmp_ida_trabajo;
    protected $tmp_en_vivienda;
    protected $zonas_verdes;
    protected $vias_principales;
    protected $concepto_vecino;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_sector = null)
    {
        parent::__construct("viv_sectores", array("id_sector"));

        if ($id_sector != null) {
            $this->id_sector = $id_sector;
            $this->select();
        }
    }
}