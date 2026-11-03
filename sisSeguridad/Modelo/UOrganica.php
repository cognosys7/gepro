<?php

class UnidadOrganica {
    private $IdUnidadOrganica = 0;
    private $UorNombre = "";
    private $UorAbreviatura = 0;
    private $UorEstado = 0;

    public function __construct() {
        $this->IdUnidadOrganica = 0;
        $this->UorNombre = "";
        $this->UorAbreviatura = 0;
        $this->UorEstado = 0;

    }

    final public function __destruct() {
        $this->Free();
    }

    public function Free() {
        
    }

    public function Clear() {
        $this->IdUnidadOrganica = 0;
        $this->UorNombre = "";
        $this->UorAbreviatura = 0;
        $this->UorEstado = 0;
    }

    public function __get($aPropertyName) {
        return $this->{"Get" . $aPropertyName} ();
    }

    public function __set($aPropertyName, $aPropertyValue) {
        $this->{"Set" . $aPropertyName}($aPropertyValue);
    }

    function getIdUnidadOrganica() {
        return $this->IdUnidadOrganica;
    }

    function getUorNombre() {
        return $this->UorNombre;
    }

    function getUorAbreviatura() {
        return $this->UorAbreviatura;
    }

    function getUorEstado() {
        return $this->UorEstado;
    }

    function setIdUnidadOrganica($IdUnidadOrganica) {
        $this->IdUnidadOrganica = $IdUnidadOrganica;
    }

    function setUorNombre($UorNombre) {
        $this->UorNombre = $UorNombre;
    }

    function setUorAbreviatura($UorAbreviatura) {
        $this->UorAbreviatura = $UorAbreviatura;
    }

    function setUorEstado($UorEstado) {
        $this->UorEstado = $UorEstado;
    }


}

?>
