<?php

class Menu extends TABLE {

    protected $id,
            $etiqueta, $descripcion,
            $html, $href, $padre, $tipo,
            $usuario_sistema, $fecha_sistema;

    function __construct($id = null) {

        parent::__construct("usr_menu", array("id"));

        if ($id != null) {
            $this->id = $id;
            $this->select();
        }
    }

    /*
     * ****************************************
     *  Getter and Setter
     * ****************************************
     */

    function getId() {
        return $this->id;
    }

    function getEtiqueta() {
        return $this->etiqueta;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getHtml() {
        return $this->html;
    }

    function getHref() {
        return $this->href;
    }

    function getPadre() {
        return $this->padre;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getUsuario_sistema() {
        return $this->usuario_sistema;
    }

    function getFecha_sistema() {
        return $this->fecha_sistema;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEtiqueta($etiqueta) {
        $this->etiqueta = $etiqueta;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setHtml($html) {
        $this->html = $html;
    }

    function setHref($href) {
        $this->href = $href;
    }

    function setPadre($padre) {
        $this->padre = $padre;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setUsuario_sistema($usuario_sistema) {
        $this->usuario_sistema = $usuario_sistema;
    }

    function setFecha_sistema($fecha_sistema) {
        $this->fecha_sistema = $fecha_sistema;
    }

}
