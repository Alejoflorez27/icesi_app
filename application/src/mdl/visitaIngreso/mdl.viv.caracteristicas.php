<?php
//carasteristicas de la vivienda
class Vivcaracteristicas extends TABLE
{

    protected $id_caracteristica;
    protected $id_solicitud;
    protected $id_servicio;
    protected $tipo_vivienda;
    protected $tipo_tenencia;
    protected $tipo_tamano_vivienda;
    protected $tipo_vivienda_estado;
    protected $aclaracion_viv;
    protected $direccion;
    protected $telefono;
    protected $barrio;
    protected $estrato;
    protected $zona;
    protected $ambiente;
    protected $sector;
    protected $lugar;
    protected $limpieza;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_caracteristica = null)
    {
        parent::__construct("viv_caracteristicas", array("id_caracteristica"));

        if ($id_caracteristica != null) {
            $this->id_caracteristica = $id_caracteristica;
            $this->select();
        }
    }
}