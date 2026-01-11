<?php

class FtFacturacionDetalle extends TABLE
{

    protected $factura;
    protected $id_solicitud;
    protected $id_servicio;
    protected $id_combo_cli;
    protected $valor;
    protected $estado;
    protected $destino_factura;

    protected $fch_create;
    protected $usr_create;
    

    public function __construct(int $factura = null, int $id_solicitud = null)
    {
        parent::__construct("ft_facturacion_detalle", array("factura", "id_solicitud"));

        if ($factura != null && $id_solicitud != null) {
            $this->factura = $factura;
            $this->id_solicitud = $id_solicitud;
            $this->select();
        }
    }
}
