<?php

class Sistema {
    private $IdSistema = 0;
    private $SisNombre = "";
    private $sisurl = "";
    private $sisabreviatura = "";
    private $sisestado = 0;
    private $sisusuregistra = 0;
    private $sisfecharegistra = "";
    private $sisusuactualiza = 0;
    private $sisfechaactualiza = "";
    private $sisusuelimina = 0;
    private $sisfechaelimina = "";

    public function __construct() {
        $this->IdSistema = 0;
        $this->SisNombre = "";
        $this->sisurl = "";
        $this->sisabreviatura = "";
        $this->sisestado = 0;
        $this->sisusuregistra = 0;
        $this->sisfecharegistra = "";
        $this->sisusuactualiza = 0;
        $this->sisfechaactualiza = "";
        $this->sisusuelimina = 0;
        $this->sisfechaelimina = "";
    }

    final public function __destruct() {
        $this->Free();
    }

    public function Free() {
        
    }

    public function Clear() {
        $this->IdSistema = 0;
        $this->SisNombre = "";
        $this->sisurl = "";
        $this->sisabreviatura = "";
        $this->sisestado = 0;
        $this->sisusuregistra = 0;
        $this->sisfecharegistra = "";
        $this->sisusuactualiza = 0;
        $this->sisfechaactualiza = "";
        $this->sisusuelimina = 0;
        $this->sisfechaelimina = "";
    }

    public function __get($aPropertyName) {
        return $this->{"Get" . $aPropertyName} ();
    }

    public function __set($aPropertyName, $aPropertyValue) {
        $this->{"Set" . $aPropertyName}($aPropertyValue);
    }

    function getIdSistema() {
        return $this->IdSistema;
    }

    function getSisNombre() {
        return $this->SisNombre;
    }

    function getSisurl() {
        return $this->sisurl;
    }

    function getSisabreviatura() {
        return $this->sisabreviatura;
    }

    function getSisestado() {
        return $this->sisestado;
    }

    function getSisusuregistra() {
        return $this->sisusuregistra;
    }

    function getSisfecharegistra() {
        return $this->sisfecharegistra;
    }

    function getSisusuactualiza() {
        return $this->sisusuactualiza;
    }

    function getSisfechaactualiza() {
        return $this->sisfechaactualiza;
    }

    function getSisusuelimina() {
        return $this->sisusuelimina;
    }

    function getSisfechaelimina() {
        return $this->sisfechaelimina;
    }

    function setIdSistema($IdSistema) {
        $this->IdSistema = $IdSistema;
    }

    function setSisNombre($SisNombre) {
        $this->SisNombre = $SisNombre;
    }

    function setSisurl($sisurl) {
        $this->sisurl = $sisurl;
    }

    function setSisabreviatura($sisabreviatura) {
        $this->sisabreviatura = $sisabreviatura;
    }

    function setSisestado($sisestado) {
        $this->sisestado = $sisestado;
    }

    function setSisusuregistra($sisusuregistra) {
        $this->sisusuregistra = $sisusuregistra;
    }

    function setSisfecharegistra($sisfecharegistra) {
        $this->sisfecharegistra = $sisfecharegistra;
    }

    function setSisusuactualiza($sisusuactualiza) {
        $this->sisusuactualiza = $sisusuactualiza;
    }

    function setSisfechaactualiza($sisfechaactualiza) {
        $this->sisfechaactualiza = $sisfechaactualiza;
    }

    function setSisusuelimina($sisusuelimina) {
        $this->sisusuelimina = $sisusuelimina;
    }

    function setSisfechaelimina($sisfechaelimina) {
        $this->sisfechaelimina = $sisfechaelimina;
    }
    
}

?>
