<?php

class Acceso {
    private $idacceso = 0;
    private $accopcion = 0;
    private $accperfil = 0;
    private $accestado = 0;
    private $accusuregistra = 0;
    private $accfecharegistra = "";
    private $accusuactualiza = 0;
    private $accfechaactualiza = "";
    private $accusuelimina = 0;
    private $accfechaelimina = "";

    public function __construct() {
        $this->idacceso = 0;
        $this->accopcion = 0;
        $this->accperfil = 0;
        $this->accestado = 0;
        $this->accusuregistra = 0;
        $this->accfecharegistra = "";
        $this->accusuactualiza = 0;
        $this->accfechaactualiza = "";
        $this->accusuelimina = 0;
        $this->accfechaelimina = "";
    }

    final public function __destruct() {
        $this->Free();
    }

    public function Free() {
        
    }

    public function Clear() {
        $this->idacceso = 0;
        $this->accopcion = 0;
        $this->accperfil = 0;
        $this->accestado = 0;
        $this->accusuregistra = 0;
        $this->accfecharegistra = "";
        $this->accusuactualiza = 0;
        $this->accfechaactualiza = "";
        $this->accusuelimina = 0;
        $this->accfechaelimina = "";
    }

    public function __get($aPropertyName) {
        return $this->{"Get" . $aPropertyName} ();
    }

    public function __set($aPropertyName, $aPropertyValue) {
        $this->{"Set" . $aPropertyName}($aPropertyValue);
    }

    function getIdacceso() {
        return $this->idacceso;
    }

    function getAccopcion() {
        return $this->accopcion;
    }

    function getAccperfil() {
        return $this->accperfil;
    }

    function getAccestado() {
        return $this->accestado;
    }

    function getAccusuregistra() {
        return $this->accusuregistra;
    }

    function getAccfecharegistra() {
        return $this->accfecharegistra;
    }

    function getAccusuactualiza() {
        return $this->accusuactualiza;
    }

    function getAccfechaactualiza() {
        return $this->accfechaactualiza;
    }

    function getAccusuelimina() {
        return $this->accusuelimina;
    }

    function getAccfechaelimina() {
        return $this->accfechaelimina;
    }

    function setIdacceso($idacceso) {
        $this->idacceso = $idacceso;
    }

    function setAccopcion($accopcion) {
        $this->accopcion = $accopcion;
    }

    function setAccperfil($accperfil) {
        $this->accperfil = $accperfil;
    }

    function setAccestado($accestado) {
        $this->accestado = $accestado;
    }

    function setAccusuregistra($accusuregistra) {
        $this->accusuregistra = $accusuregistra;
    }

    function setAccfecharegistra($accfecharegistra) {
        $this->accfecharegistra = $accfecharegistra;
    }

    function setAccusuactualiza($accusuactualiza) {
        $this->accusuactualiza = $accusuactualiza;
    }

    function setAccfechaactualiza($accfechaactualiza) {
        $this->accfechaactualiza = $accfechaactualiza;
    }

    function setAccusuelimina($accusuelimina) {
        $this->accusuelimina = $accusuelimina;
    }

    function setAccfechaelimina($accfechaelimina) {
        $this->accfechaelimina = $accfechaelimina;
    }

}

?>
