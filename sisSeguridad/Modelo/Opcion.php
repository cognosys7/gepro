<?php

class Opcion {
    private $idopcion = 0;
    private $opcdescripcion = "";
    private $opcmodulo = 0;
    private $opcenlace = "";
    private $opcdestino = 0;
    private $opcnivel = 0;
    private $opctipoenlace = 0;
    private $opcpadre = 0;
    private $opcorden = 0;
    private $opcimagen = "";
    private $opcestado = 0;
    private $opclightbox = 0;
    private $opcorden2 = 0;
    private $opcusuregistra = 0;
    private $opcfecharegistra = "";
    private $opcusuactualiza = 0;
    private $opcfechaactualiza = "";
    private $opcusuelimina = 0;
    private $opcfechaelimina = "";

    public function __construct() {
        $this->idopcion = 0;
        $this->opcdescripcion = "";
        $this->opcmodulo = 0;
        $this->opcenlace = "";
        $this->opcdestino = 0;
        $this->opcnivel = 0;
        $this->opctipoenlace = 0;
        $this->opcpadre = 0;
        $this->opcorden = 0;
        $this->opcimagen = "";
        $this->opcestado = 0;
        $this->opclightbox = 0;
        $this->opcorden2 = 0;
        $this->opcusuregistra = 0;
        $this->opcfecharegistra = "";
        $this->opcusuactualiza = 0;
        $this->opcfechaactualiza = "";
        $this->opcusuelimina = 0;
        $this->opcfechaelimina = "";
    }

    final public function __destruct() {
        $this->Free();
    }

    public function Free() {
        
    }

    public function Clear() {
        $this->idopcion = 0;
        $this->opcdescripcion = "";
        $this->opcmodulo = 0;
        $this->opcenlace = "";
        $this->opcdestino = 0;
        $this->opcnivel = 0;
        $this->opctipoenlace = 0;
        $this->opcpadre = 0;
        $this->opcorden = 0;
        $this->opcimagen = "";
        $this->opcestado = 0;
        $this->opclightbox = 0;
        $this->opcorden2 = 0;
        $this->opcusuregistra = 0;
        $this->opcfecharegistra = "";
        $this->opcusuactualiza = 0;
        $this->opcfechaactualiza = "";
        $this->opcusuelimina = 0;
        $this->opcfechaelimina = "";
    }

    public function __get($aPropertyName) {
        return $this->{"Get" . $aPropertyName} ();
    }

    public function __set($aPropertyName, $aPropertyValue) {
        $this->{"Set" . $aPropertyName}($aPropertyValue);
    }

    function getIdopcion() {
        return $this->idopcion;
    }

    function getOpcdescripcion() {
        return $this->opcdescripcion;
    }

    function getOpcmodulo() {
        return $this->opcmodulo;
    }

    function getOpcenlace() {
        return $this->opcenlace;
    }

    function getOpcdestino() {
        return $this->opcdestino;
    }

    function getOpcnivel() {
        return $this->opcnivel;
    }

    function getOpctipoenlace() {
        return $this->opctipoenlace;
    }

    function getOpcpadre() {
        return $this->opcpadre;
    }

    function getOpcorden() {
        return $this->opcorden;
    }

    function getOpcimagen() {
        return $this->opcimagen;
    }

    function getOpcestado() {
        return $this->opcestado;
    }

    function getOpclightbox() {
        return $this->opclightbox;
    }

    function getOpcorden2() {
        return $this->opcorden2;
    }

    function getOpcusuregistra() {
        return $this->opcusuregistra;
    }

    function getOpcfecharegistra() {
        return $this->opcfecharegistra;
    }

    function getOpcusuactualiza() {
        return $this->opcusuactualiza;
    }

    function getOpcfechaactualiza() {
        return $this->opcfechaactualiza;
    }

    function getOpcusuelimina() {
        return $this->opcusuelimina;
    }

    function getOpcfechaelimina() {
        return $this->opcfechaelimina;
    }

    function setIdopcion($idopcion) {
        $this->idopcion = $idopcion;
    }

    function setOpcdescripcion($opcdescripcion) {
        $this->opcdescripcion = $opcdescripcion;
    }

    function setOpcmodulo($opcmodulo) {
        $this->opcmodulo = $opcmodulo;
    }

    function setOpcenlace($opcenlace) {
        $this->opcenlace = $opcenlace;
    }

    function setOpcdestino($opcdestino) {
        $this->opcdestino = $opcdestino;
    }

    function setOpcnivel($opcnivel) {
        $this->opcnivel = $opcnivel;
    }

    function setOpctipoenlace($opctipoenlace) {
        $this->opctipoenlace = $opctipoenlace;
    }

    function setOpcpadre($opcpadre) {
        $this->opcpadre = $opcpadre;
    }

    function setOpcorden($opcorden) {
        $this->opcorden = $opcorden;
    }

    function setOpcimagen($opcimagen) {
        $this->opcimagen = $opcimagen;
    }

    function setOpcestado($opcestado) {
        $this->opcestado = $opcestado;
    }

    function setOpclightbox($opclightbox) {
        $this->opclightbox = $opclightbox;
    }

    function setOpcorden2($opcorden2) {
        $this->opcorden2 = $opcorden2;
    }

    function setOpcusuregistra($opcusuregistra) {
        $this->opcusuregistra = $opcusuregistra;
    }

    function setOpcfecharegistra($opcfecharegistra) {
        $this->opcfecharegistra = $opcfecharegistra;
    }

    function setOpcusuactualiza($opcusuactualiza) {
        $this->opcusuactualiza = $opcusuactualiza;
    }

    function setOpcfechaactualiza($opcfechaactualiza) {
        $this->opcfechaactualiza = $opcfechaactualiza;
    }

    function setOpcusuelimina($opcusuelimina) {
        $this->opcusuelimina = $opcusuelimina;
    }

    function setOpcfechaelimina($opcfechaelimina) {
        $this->opcfechaelimina = $opcfechaelimina;
    }

}

?>
