<?php
class TrcComboCli extends TABLE
{

    protected $id_combo_cli;
    protected $id_combo;
    protected $id_empresa;
    protected $valor_bogota;
    protected $valor_externo;
    protected $estado;
    protected $visible;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_combo_cli = null)
    {

        parent::__construct("trc_combo_cli", array("id_combo_cli"));

        if ($id_combo_cli != null) {
            $this->id_combo_cli = $id_combo_cli;
            $this->select();
        }
    }
}
