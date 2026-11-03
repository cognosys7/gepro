<?php

class UsuarioPerfil {
    private $idusuperfil = 0;
    private $upsperfil = 0;
    private $upsusuario = 0;
    private $upsestado = 0;
    private $upsusuregistra = 0;
    private $upsfecharegistra = "";
    private $upsusuactualiza = 0;
    private $upsfechaactualiza = "";
    private $upsusuelimina = 0;
    private $upsfechaelimina = "";

    public function __construct() {
        $this->idusuperfil = 0;
        $this->upsperfil = 0;
        $this->upsusuario = 0;
        $this->upsestado = 0;
        $this->upsusuregistra = 0;
        $this->upsfecharegistra = "";
        $this->upsusuactualiza = 0;
        $this->upsfechaactualiza = "";
        $this->upsusuelimina = 0;
        $this->upsfechaelimina = "";
    }

    final public function __destruct() {
        $this->Free();
    }

    public function Free() {
        
    }

    public function Clear() {
        $this->idusuperfil = 0;
        $this->upsperfil = 0;
        $this->upsusuario = 0;
        $this->upsestado = 0;
        $this->upsusuregistra = 0;
        $this->upsfecharegistra = "";
        $this->upsusuactualiza = 0;
        $this->upsfechaactualiza = "";
        $this->upsusuelimina = 0;
        $this->upsfechaelimina = "";
    }

    public function __get($aPropertyName) {
        return $this->{"Get" . $aPropertyName} ();
    }

    public function __set($aPropertyName, $aPropertyValue) {
        $this->{"Set" . $aPropertyName}($aPropertyValue);
    }

    function getIdusuperfil() {
        return $this->idusuperfil;
    }

    function getUpsperfil() {
        return $this->upsperfil;
    }

    function getUpsusuario() {
        return $this->upsusuario;
    }

    function getUpsestado() {
        return $this->upsestado;
    }

    function getUpsusuregistra() {
        return $this->upsusuregistra;
    }

    function getUpsfecharegistra() {
        return $this->upsfecharegistra;
    }

    function getUpsusuactualiza() {
        return $this->upsusuactualiza;
    }

    function getUpsfechaactualiza() {
        return $this->upsfechaactualiza;
    }

    function getUpsusuelimina() {
        return $this->upsusuelimina;
    }

    function getUpsfechaelimina() {
        return $this->upsfechaelimina;
    }

    function setIdusuperfil($idusuperfil) {
        $this->idusuperfil = $idusuperfil;
    }

    function setUpsperfil($upsperfil) {
        $this->upsperfil = $upsperfil;
    }

    function setUpsusuario($upsusuario) {
        $this->upsusuario = $upsusuario;
    }

    function setUpsestado($upsestado) {
        $this->upsestado = $upsestado;
    }

    function setUpsusuregistra($upsusuregistra) {
        $this->upsusuregistra = $upsusuregistra;
    }

    function setUpsfecharegistra($upsfecharegistra) {
        $this->upsfecharegistra = $upsfecharegistra;
    }

    function setUpsusuactualiza($upsusuactualiza) {
        $this->upsusuactualiza = $upsusuactualiza;
    }

    function setUpsfechaactualiza($upsfechaactualiza) {
        $this->upsfechaactualiza = $upsfechaactualiza;
    }

    function setUpsusuelimina($upsusuelimina) {
        $this->upsusuelimina = $upsusuelimina;
    }

    function setUpsfechaelimina($upsfechaelimina) {
        $this->upsfechaelimina = $upsfechaelimina;
    }


}

?>
