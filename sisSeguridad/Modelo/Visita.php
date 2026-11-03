<?php

class Visita {
    private $VisitaId = 0;
    private $Institucion = 0;
    private $IdTipoVisita = 0;
    private $FechaProgramada = "";
    private $VisitaProgramada = "";
    private $HoraProgramada = "";
    private $Estado = 0;
    private $IdMotivoVisita = 0;
    private $Observacion = "";
    private $usuregistra = 0;
    private $fecharegistra = "";
    private $usuactualiza = 0;
    private $fechaactualiza = "";
    private $usuelimina = 0;
    private $fechaelimina = "";

    public function __construct() {
        $this->VisitaId = 0;
        $this->Institucion = 0;
        $this->IdTipoVisita = 0;
        $this->FechaProgramada = "";
        $this->VisitaProgramada = "";
        $this->HoraProgramada = "";
        $this->Estado = 0;
        $this->IdMotivoVisita = 0;
        $this->Observacion = "";
        $this->usuregistra = 0;
        $this->fecharegistra = "";
        $this->usuactualiza = 0;
        $this->fechaactualiza = "";
        $this->usuelimina = 0;
        $this->fechaelimina = "";
    }

    final public function __destruct() {
        $this->Free();
    }

    public function Free() {
        
    }

    public function Clear() {
        $this->VisitaId = 0;
        $this->Institucion = 0;
        $this->IdTipoVisita = 0;
        $this->FechaProgramada = "";
        $this->VisitaProgramada = "";
        $this->HoraProgramada = "";
        $this->Estado = 0;
        $this->IdMotivoVisita = 0;
        $this->Observacion = "";
        $this->usuregistra = 0;
        $this->fecharegistra = "";
        $this->usuactualiza = 0;
        $this->fechaactualiza = "";
        $this->usuelimina = 0;
        $this->fechaelimina = "";
    }

    public function __get($aPropertyName) {
        return $this->{"Get" . $aPropertyName} ();
    }

    public function __set($aPropertyName, $aPropertyValue) {
        $this->{"Set" . $aPropertyName}($aPropertyValue);
    }

    function getVisitaId() {
        return $this->VisitaId;
    }

    function getInstitucion() {
        return $this->Institucion;
    }

    function getIdTipoVisita() {
        return $this->IdTipoVisita;
    }

    function getFechaProgramada() {
        return $this->FechaProgramada;
    }

    function getVisitaProgramada() {
        return $this->VisitaProgramada;
    }

    function getHoraProgramada() {
        return $this->HoraProgramada;
    }

    function getEstado() {
        return $this->Estado;
    }

    function getIdMotivoVisita() {
        return $this->IdMotivoVisita;
    }

    function getObservacion() {
        return $this->Observacion;
    }

    function getUsuregistra() {
        return $this->usuregistra;
    }

    function getFecharegistra() {
        return $this->fecharegistra;
    }

    function getUsuactualiza() {
        return $this->usuactualiza;
    }

    function getFechaactualiza() {
        return $this->fechaactualiza;
    }

    function getUsuelimina() {
        return $this->usuelimina;
    }

    function getFechaelimina() {
        return $this->fechaelimina;
    }

    function setVisitaId($VisitaId) {
        $this->VisitaId = $VisitaId;
    }

    function setInstitucion($Institucion) {
        $this->Institucion = $Institucion;
    }

    function setIdTipoVisita($IdTipoVisita) {
        $this->IdTipoVisita = $IdTipoVisita;
    }

    function setFechaProgramada($FechaProgramada) {
        $this->FechaProgramada = $FechaProgramada;
    }

    function setVisitaProgramada($VisitaProgramada) {
        $this->VisitaProgramada = $VisitaProgramada;
    }

    function setHoraProgramada($HoraProgramada) {
        $this->HoraProgramada = $HoraProgramada;
    }

    function setEstado($Estado) {
        $this->Estado = $Estado;
    }

    function setIdMotivoVisita($IdMotivoVisita) {
        $this->IdMotivoVisita = $IdMotivoVisita;
    }

    function setObservacion($Observacion) {
        $this->Observacion = $Observacion;
    }

    function setUsuregistra($usuregistra) {
        $this->usuregistra = $usuregistra;
    }

    function setFecharegistra($fecharegistra) {
        $this->fecharegistra = $fecharegistra;
    }

    function setUsuactualiza($usuactualiza) {
        $this->usuactualiza = $usuactualiza;
    }

    function setFechaactualiza($fechaactualiza) {
        $this->fechaactualiza = $fechaactualiza;
    }

    function setUsuelimina($usuelimina) {
        $this->usuelimina = $usuelimina;
    }

    function setFechaelimina($fechaelimina) {
        $this->fechaelimina = $fechaelimina;
    }


}

?>
