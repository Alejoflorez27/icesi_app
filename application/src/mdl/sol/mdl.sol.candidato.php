<?php

class SolCandidato extends TABLE
{

    protected $id_candidato;
    protected $id_solicitud;
    protected $id_ciudad_nac;
    protected $id_ciudad_act;
    protected $localidad;
    protected $tipo_id;
    protected $numero_doc;
    protected $nombre;
    protected $apellido;
    protected $edad;
    protected $fch_nacimiento;
    protected $estado_civil;
    protected $libreta;
    protected $telefono;
    protected $direccion;
    protected $barrio;
    protected $estracto;
    protected $cargo_desempeno;
    protected $nivel_escolar;
    protected $persona_visita;
    protected $parantesco_visita;
    protected $email;
    protected $email1;
    protected $salario_dev;
    protected $salario_actual;
    protected $estado;
    protected $referencia_personal;
    protected $salario_anterior;
    protected $nombre_foto;
    protected $nombre_encr;
    protected $tamano_foto;
    protected $ext;
    protected $directorio;
    protected $jefe_area;
    protected $area;
    protected $arl;
    protected $fecha_visita;
    protected $razon_social;
    protected $nit;
    protected $nombre_representante;
    protected $apellido_representante;
    protected $act_economica;
    protected $capital_suscrito;
    protected $paises_exterior;
    protected $fch_constituida;
    protected $vol_operaciones;
    protected $instalaciones;
    protected $servicio_suministrado;
    protected $tmp_operación;
    protected $horario_operacion;
    protected $num_resolucion;
    protected $certificacion;
    protected $alias;
    protected $id_ciudad_expe;
    protected $fch_expedicion;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_candidato = null)
    {

        parent::__construct("sol_candidato", array("id_candidato"));

        if ($id_candidato != null) {
            $this->id_candidato = $id_candidato;
            $this->select();
        }
    }
}
