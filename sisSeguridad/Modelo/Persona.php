<?php

class Persona {
    private $IdPersona = '';
    private $PerApePaterno = '';
    private $PerApeMaterno = '';
    private $PerNombres = '';
    private $PerDocumento = '';
    private $PerNroDocumento = '';

    public function __construct() {
        $this->IdPersona = '';
        $this->PerApePaterno = '';
        $this->PerApeMaterno = '';
        $this->PerNombres = '';
        $this->PerDocumento = '';
        $this->PerNroDocumento = '';
    }

    final public function __destruct() {
        $this->Free();
    }

    public function Free() {
    }

    public function Clear() {
        $this->IdPersona = '';
        $this->PerApePaterno = '';
        $this->PerApeMaterno = '';
        $this->PerNombres = '';
        $this->PerDocumento = '';
        $this->PerNroDocumento = '';
    }

    public function __get($aPropertyName) {
        return $this->{'Get' . $aPropertyName} ();
    }

    public function __set($aPropertyName, $aPropertyValue) {
        $this->{'Set' . $aPropertyName}($aPropertyValue);
    }

    function getIdPersona() {
        return $this->IdPersona;
    }

    function getPerApePaterno() {
        return $this->PerApePaterno;
    }

    function getPerApeMaterno() {
        return $this->PerApeMaterno;
    }

    function getPerNombres() {
        return $this->PerNombres;
    }

    function getPerDocumento() {
        return $this->PerDocumento;
    }

    function getPerNroDocumento() {
        return $this->PerNroDocumento;
    }

    function setIdPersona($IdPersona) {
        $this->IdPersona = $IdPersona;
    }

    function setPerApePaterno($PerApePaterno) {
        $this->PerApePaterno = $PerApePaterno;
    }

    function setPerApeMaterno($PerApeMaterno) {
        $this->PerApeMaterno = $PerApeMaterno;
    }

    function setPerNombres($PerNombres) {
        $this->PerNombres = $PerNombres;
    }

    function setPerDocumento($PerDocumento) {
        $this->PerDocumento = $PerDocumento;
    }

    function setPerNroDocumento($PerNroDocumento) {
        $this->PerNroDocumento = $PerNroDocumento;
    }

}

?>