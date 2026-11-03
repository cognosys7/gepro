<?php

class Perfil {
    private $idperfil = 0;
    private $pefnombre = "";
    private $pefmodulo = 0;
    private $pefestado = 0;
    private $pefusuregistra = 0;
    private $peffecharegistra = "";
    private $pefusuactualiza = 0;
    private $peffechaactualiza = "";
    private $pefusuelimina = 0;
    private $peffechaelimina = "";

    public function __construct() {
        $this->idperfil = 0;
        $this->pefnombre = "";
        $this->pefmodulo = 0;
        $this->pefestado = 0;
        $this->pefusuregistra = 0;
        $this->peffecharegistra = "";
        $this->pefusuactualiza = 0;
        $this->peffechaactualiza = "";
        $this->pefusuelimina = 0;
        $this->peffechaelimina = "";
    }

    final public function __destruct() {
        $this->Free();
    }

    public function Free() {
        
    }

    public function Clear() {
        $this->idperfil = 0;
        $this->pefnombre = "";
        $this->pefmodulo = 0;
        $this->pefestado = 0;
        $this->pefusuregistra = 0;
        $this->peffecharegistra = "";
        $this->pefusuactualiza = 0;
        $this->peffechaactualiza = "";
        $this->pefusuelimina = 0;
        $this->peffechaelimina = "";
    }

    public function __get($aPropertyName) {
        return $this->{"Get" . $aPropertyName} ();
    }

    public function __set($aPropertyName, $aPropertyValue) {
        $this->{"Set" . $aPropertyName}($aPropertyValue);
    }

    function getIdperfil() {
        return $this->idperfil;
    }

    function getPefnombre() {
        return $this->pefnombre;
    }

    function getPefmodulo() {
        return $this->pefmodulo;
    }

    function getPefestado() {
        return $this->pefestado;
    }

    function getPefusuregistra() {
        return $this->pefusuregistra;
    }

    function getPeffecharegistra() {
        return $this->peffecharegistra;
    }

    function getPefusuactualiza() {
        return $this->pefusuactualiza;
    }

    function getPeffechaactualiza() {
        return $this->peffechaactualiza;
    }

    function getPefusuelimina() {
        return $this->pefusuelimina;
    }

    function getPeffechaelimina() {
        return $this->peffechaelimina;
    }

    function setIdperfil($idperfil) {
        $this->idperfil = $idperfil;
    }

    function setPefnombre($pefnombre) {
        $this->pefnombre = $pefnombre;
    }

    function setPefmodulo($pefmodulo) {
        $this->pefmodulo = $pefmodulo;
    }

    function setPefestado($pefestado) {
        $this->pefestado = $pefestado;
    }

    function setPefusuregistra($pefusuregistra) {
        $this->pefusuregistra = $pefusuregistra;
    }

    function setPeffecharegistra($peffecharegistra) {
        $this->peffecharegistra = $peffecharegistra;
    }

    function setPefusuactualiza($pefusuactualiza) {
        $this->pefusuactualiza = $pefusuactualiza;
    }

    function setPeffechaactualiza($peffechaactualiza) {
        $this->peffechaactualiza = $peffechaactualiza;
    }

    function setPefusuelimina($pefusuelimina) {
        $this->pefusuelimina = $pefusuelimina;
    }

    function setPeffechaelimina($peffechaelimina) {
        $this->peffechaelimina = $peffechaelimina;
    }



}

?>
