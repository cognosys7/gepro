<?php

class Usuario {
    private $IdUsuario = 0;
    private $UsuNombre = "";
    private $usuldap = "";
    private $usuclave = "";
    private $usupersona = 0;
    private $UsuEstado = 0;
    private $usuregistra = 0;
    private $usufecregistra = "";
    private $usuactualiza = 0;
    private $usufecactualiza = "";
    private $usuelimina = 0;
    private $usufecelimina = "";

    public function __construct() {
        $this->IdUsuario = 0;
        $this->UsuNombre = "";
        $this->usuldap = "";
        $this->usuclave = "";
        $this->usupersona = 0;
        $this->UsuEstado = 0;
        $this->usuregistra = 0;
        $this->usufecregistra = "";
        $this->usuactualiza = 0;
        $this->usufecactualiza = "";
        $this->usuelimina = 0;
        $this->usufecelimina = "";
    }

    final public function __destruct() {
        $this->Free();
    }

    public function Free() {
        
    }

    public function Clear() {
        $this->IdUsuario = 0;
        $this->UsuNombre = "";
        $this->usuldap = "";
        $this->usuclave = "";
        $this->usupersona = 0;
        $this->UsuEstado = 0;
        $this->usuregistra = 0;
        $this->usufecregistra = "";
        $this->usuactualiza = 0;
        $this->usufecactualiza = "";
        $this->usuelimina = 0;
        $this->usufecelimina = "";
    }

    public function __get($aPropertyName) {
        return $this->{"Get" . $aPropertyName} ();
    }

    public function __set($aPropertyName, $aPropertyValue) {
        $this->{"Set" . $aPropertyName}($aPropertyValue);
    }

    function getIdUsuario() {
        return $this->IdUsuario;
    }

    function getUsuNombre() {
        return $this->UsuNombre;
    }

    function getUsuldap() {
        return $this->usuldap;
    }

    function getUsuclave() {
        return $this->usuclave;
    }

    function getUsupersona() {
        return $this->usupersona;
    }

    function getUsuEstado() {
        return $this->UsuEstado;
    }

    function getUsuregistra() {
        return $this->usuregistra;
    }

    function getUsufecregistra() {
        return $this->usufecregistra;
    }

    function getUsuactualiza() {
        return $this->usuactualiza;
    }

    function getUsufecactualiza() {
        return $this->usufecactualiza;
    }

    function getUsuelimina() {
        return $this->usuelimina;
    }

    function getUsufecelimina() {
        return $this->usufecelimina;
    }

    function setIdUsuario($IdUsuario) {
        $this->IdUsuario = $IdUsuario;
    }

    function setUsuNombre($UsuNombre) {
        $this->UsuNombre = $UsuNombre;
    }

    function setUsuldap($usuldap) {
        $this->usuldap = $usuldap;
    }

    function setUsuclave($usuclave) {
        $this->usuclave = $usuclave;
    }

    function setUsupersona($usupersona) {
        $this->usupersona = $usupersona;
    }

    function setUsuEstado($UsuEstado) {
        $this->UsuEstado = $UsuEstado;
    }

    function setUsuregistra($usuregistra) {
        $this->usuregistra = $usuregistra;
    }

    function setUsufecregistra($usufecregistra) {
        $this->usufecregistra = $usufecregistra;
    }

    function setUsuactualiza($usuactualiza) {
        $this->usuactualiza = $usuactualiza;
    }

    function setUsufecactualiza($usufecactualiza) {
        $this->usufecactualiza = $usufecactualiza;
    }

    function setUsuelimina($usuelimina) {
        $this->usuelimina = $usuelimina;
    }

    function setUsufecelimina($usufecelimina) {
        $this->usufecelimina = $usufecelimina;
    }


}

?>
