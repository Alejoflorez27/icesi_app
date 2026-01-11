<?php

class PerfilMenu extends TABLE
{

    protected $perfil, $nodo,
    $usuario_sistema, $fecha_sistema;

    public function __construct($perfil = null, $nodo = null)
    {

        parent::__construct("usr_perfil_menu", array("perfil", "nodo"));

        if ($perfil != null && $nodo != null) {
            $this->perfil = $perfil;
            $this->nodo = $nodo;
            $this->select();
        }
    }

    /*
     * ****************************************
     *  Getter and Setter
     * ****************************************
     */

    public function getPerfil()
    {
        return $this->perfil;
    }

    public function getNodo()
    {
        return $this->nodo;
    }

    public function getUsuario_sistema()
    {
        return $this->usuario_sistema;
    }

    public function getFecha_sistema()
    {
        return $this->fecha_sistema;
    }

    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }

    public function setNodo($nodo)
    {
        $this->nodo = $nodo;
    }

    public function setUsuario_sistema($usuario_sistema)
    {
        $this->usuario_sistema = $usuario_sistema;
    }

    public function setFecha_sistema($fecha_sistema)
    {
        $this->fecha_sistema = $fecha_sistema;
    }

}
