<?php
require_once(RECURSOSGEN_LIB."/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/UbigeoData.php");

class UbigeoDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }
         
    public function SelectListDepartamento(&$lDato, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = LISTA_DEPARTAMENTO;
        return parent::SelectListSP($aClearOnFailure);
    }
    
//    public function SelectListDepartamentoPerfil(&$lDato, $lParametro, $aClearOnFailure = true) {
//        $this->mObject = new DynamicModel();
//        $this->mList = &$lDato;
//        $this->mQuery = LISTA_DEPARTAMENTO_PERFIL;
//        $this->mParametro = $lParametro;
//        return parent::SelectListSP($aClearOnFailure);
//    }
//    
//    public function SelectListDepartamentoxID(&$lDato, $lParametro, $aClearOnFailure = true) {
//        $this->mObject = new DynamicModel();
//        $this->mList = &$lDato;
//        $this->mQuery = LISTA_DEPARTAMENTO_XID;
//        $this->mParametro = $lParametro;
//        return parent::SelectListSP($aClearOnFailure);
//    }
//
    public function SelectListProvincia(&$lDato,$lParametro, $aClearOnFailure=true) {
        $this->mObject  = new DynamicModel();
        $this->mList    = &$lDato;
        $this->mQuery   = sprintf(LISTA_PROVINCIA);
        $this->mParametro = $lParametro;
        //echo $this->mQuery; exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function SelectListDistrito(&$lDato,$lParametro, $aClearOnFailure=true) {
        $this->mObject  = new DynamicModel();
        $this->mList    = &$lDato;
        $this->mQuery   = sprintf(LISTA_DISTRITO);
        $this->mParametro = $lParametro;
        //echo $this->mQuery; exit;
        return parent::SelectListSP($aClearOnFailure);
    }
//    
//    public function SelectUbigeo(&$lDato,$lParametro, $aClearOnFailure=true) {
//        $this->mObject  = new DynamicModel();
//        $this->mList    = &$lDato;
//        $this->mQuery   = sprintf(UBIGEO_SELECCIONADO);
//        $this->mParametro = $lParametro;
//        //echo $this->mQuery; exit;
//        return parent::SelectListSP($aClearOnFailure);
//    }

}

?>
