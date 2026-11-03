<?php

class Reniec {

    private $Dni = "";
    private $ApellidoPaterno = "";
    private $ApellidoMaterno = "";
    private $Nombres = "";
    private $FechaNacimiento = "";
    private $Sexo = 0;
    

    public function __construct() {
        $this->Dni = "";
        $this->ApellidoPaterno = "";
        $this->ApellidoMaterno = "";
        $this->Nombres = "";
        $this->FechaNacimiento = "";
        $this->Sexo = 0;
    }

    final public function __destruct() {
        $this->Free();
    }

    public function Free() {
        
    }

    public function Clear() {
        $this->Dni = "";
        $this->ApellidoPaterno = "";
        $this->ApellidoMaterno = "";
        $this->Nombres = "";
        $this->FechaNacimiento = "";
        $this->Sexo = 0;
    }

    public function __get($aPropertyName) {
        return $this->{'Get' . $aPropertyName} ();
    }

    public function __set($aPropertyName, $aPropertyValue) {
        $this->{'Set' . $aPropertyName}($aPropertyValue);
    }
    
    function getDni() {
        return $this->Dni;
    }

    function getApellidoPaterno() {
        return $this->ApellidoPaterno;
    }

    function getApellidoMaterno() {
        return $this->ApellidoMaterno;
    }

    function getNombres() {
        return $this->Nombres;
    }

    function getFechaNacimiento() {
        return $this->FechaNacimiento;
    }

    function getSexo() {
        return $this->Sexo;
    }

    function setDni($Dni) {
        $this->Dni = $Dni;
    }

    function setApellidoPaterno($ApellidoPaterno) {
        $this->ApellidoPaterno = $ApellidoPaterno;
    }

    function setApellidoMaterno($ApellidoMaterno) {
        $this->ApellidoMaterno = $ApellidoMaterno;
    }

    function setNombres($Nombres) {
        $this->Nombres = $Nombres;
    }

    function setFechaNacimiento($FechaNacimiento) {
        $this->FechaNacimiento = $FechaNacimiento;
    }

    function setSexo($Sexo) {
        $this->Sexo = $Sexo;
    }


}

?>