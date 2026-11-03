<?php
require_once(RECURSOSGEN_LIB."/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/PerfilUbigeoData.php");

class PerfilUbigeoDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }
    
    //PARAMETROS DE PROYECTO
    public function VerPerfilUbigeoSeleccionado(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = VERIFICA_PERFIL_UBIGEO_SELECCIONADO;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function VerPerfilSeleccionado(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = VERIFICA_PERFIL_SELECCIONADO;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
//    //MANTENIMIENTO
    public function InsertaPerfilUbigeo(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = INSERTA_DATOS_PERFIL_UBIGEO;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
    public function ActualizaPerfilUbigeo(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = ACTUALIZA_DATOS_PERFIL_UBIGEO;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
    public function EliminaPerfilUbigeo(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = ELIMINA_DATOS_PERFIL_UBIGEO;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
//    //FLEXIGRID
//    public function CuentaPerfil(&$lDato, $lParametro, $aClearOnFailure = true) {
//        $this->mObject = new DynamicModel();
//        $this->mList = &$lDato;
//        $this->mQuery = CUENTA_PERFIL;
//        $this->mParametro = $lParametro;
//        //$this->mQuery;exit;
//        return parent::SelectListSP($aClearOnFailure);
//    }
//    
//    public function ListPerfilFlexigrid(&$lDato, $lParametro, $aClearOnFailure = true) {
//        $this->mObject = new DynamicModel();
//        $this->mList = &$lDato;
//        $this->mQuery = LISTA_PERFIL_FLEXIGRID;
//        $this->mParametro = $lParametro;
//        //$this->mQuery;exit;
//        return parent::SelectListSP($aClearOnFailure);
//    }
    
    public function CuentaPerfilUbigeo(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = CUENTA_PERFIL_UBIGEO;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function ListaPerfilUbigeoFlexigrid(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = LISTA_PERFIL_UBIGEO_FLEXIGRID;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
}

?>
