<?php

class Catalogo {

    private $IdCatalogo = 0;
    private $CatGrupo = 0;
    private $CatSubGrupo = 0;
    private $CatTipo = 0;
    private $CatDescripcion = "";
    private $CatEstado = 0;
    private $CatUsuRegistra = 0;
    private $CatFecRegistra = "";
    private $CatUsuActualiza = 0;
    private $CatFecActualiza = "";
    private $CatUsuElimina = 0;
    private $CatFecElimina = "";
    

    public function __construct() {
        $this->IdCatalogo = 0;
        $this->CatGrupo = 0;
        $this->CatSubGrupo = 0;
        $this->CatTipo = 0;
        $this->CatDescripcion = "";
        $this->CatEstado = 0;
        $this->CatUsuRegistra = 0;
        $this->CatFecRegistra = "";
        $this->CatUsuActualiza = 0;
        $this->CatFecActualiza = "";
        $this->CatUsuElimina = 0;
        $this->CatFecElimina = "";
        
    }

    final public function __destruct() {
        $this->Free();
    }

    public function Free() {
        
    }

    public function Clear() {
        $this->IdCatalogo = 0;
        $this->CatGrupo = 0;
        $this->CatSubGrupo = 0;
        $this->CatTipo = 0;
        $this->CatDescripcion = "";
        $this->CatEstado = 0;
        $this->CatUsuRegistra = 0;
        $this->CatFecRegistra = "";
        $this->CatUsuActualiza = 0;
        $this->CatFecActualiza = "";
        $this->CatUsuElimina = 0;
        $this->CatFecElimina = "";
    }

    public function __get($aPropertyName) {
        return $this->{'Get' . $aPropertyName} ();
    }

    public function __set($aPropertyName, $aPropertyValue) {
        $this->{'Set' . $aPropertyName}($aPropertyValue);
    }
    
    function getIdCatalogo() {
        return $this->IdCatalogo;
    }

    function getCatGrupo() {
        return $this->CatGrupo;
    }

    function getCatSubGrupo() {
        return $this->CatSubGrupo;
    }

    function getCatTipo() {
        return $this->CatTipo;
    }

    function getCatDescripcion() {
        return $this->CatDescripcion;
    }

    function getCatEstado() {
        return $this->CatEstado;
    }

    function getCatUsuRegistra() {
        return $this->CatUsuRegistra;
    }

    function getCatFecRegistra() {
        return $this->CatFecRegistra;
    }

    function getCatUsuActualiza() {
        return $this->CatUsuActualiza;
    }

    function getCatFecActualiza() {
        return $this->CatFecActualiza;
    }

    function getCatUsuElimina() {
        return $this->CatUsuElimina;
    }

    function getCatFecElimina() {
        return $this->CatFecElimina;
    }

    function setIdCatalogo($IdCatalogo) {
        $this->IdCatalogo = $IdCatalogo;
    }

    function setCatGrupo($CatGrupo) {
        $this->CatGrupo = $CatGrupo;
    }

    function setCatSubGrupo($CatSubGrupo) {
        $this->CatSubGrupo = $CatSubGrupo;
    }

    function setCatTipo($CatTipo) {
        $this->CatTipo = $CatTipo;
    }

    function setCatDescripcion($CatDescripcion) {
        $this->CatDescripcion = $CatDescripcion;
    }

    function setCatEstado($CatEstado) {
        $this->CatEstado = $CatEstado;
    }

    function setCatUsuRegistra($CatUsuRegistra) {
        $this->CatUsuRegistra = $CatUsuRegistra;
    }

    function setCatFecRegistra($CatFecRegistra) {
        $this->CatFecRegistra = $CatFecRegistra;
    }

    function setCatUsuActualiza($CatUsuActualiza) {
        $this->CatUsuActualiza = $CatUsuActualiza;
    }

    function setCatFecActualiza($CatFecActualiza) {
        $this->CatFecActualiza = $CatFecActualiza;
    }

    function setCatUsuElimina($CatUsuElimina) {
        $this->CatUsuElimina = $CatUsuElimina;
    }

    function setCatFecElimina($CatFecElimina) {
        $this->CatFecElimina = $CatFecElimina;
    }



}

?>