<?php

class FtFacturacion extends TABLE
{

    protected $id;
    protected $id_empresa;
    protected $fecha_facturacion;
    protected $fecha_vencimiento;
    protected $valor_neto;
    protected $estado;
    protected $motivo_aprobacion = '';
    protected $motivo_rechazo = '';

    protected $fch_create;
    protected $usr_create;
    

    public function __construct(int $id = null)
    {
        parent::__construct("ft_facturacion", array("id"));

        if ($id != null) {
            $this->id = $id;
            $this->select();
        }
    }
}
