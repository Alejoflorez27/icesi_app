<?php

class InfoOblFin extends TABLE
{

    protected $id_info_obl_fin;
    protected $id_solicitud;
    protected $id_servicio;
    protected $entidad;
    protected $producto_clase;
    protected $fch_expedicion;
    protected $fch_terminacion;
    protected $cupo_inicial;
    protected $saldo_pendiente;
    protected $pago_minimo;
    protected $estado_obligacion;
    protected $calidad;
    protected $valor_mora;
    protected $edad_mora;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_info_obl_fin = null)
    {

        parent::__construct("info_obl_fin", array("id_info_obl_fin"));

        if ($id_info_obl_fin != null) {
            $this->id_info_obl_fin = $id_info_obl_fin;
            $this->select();
        }
    }
}