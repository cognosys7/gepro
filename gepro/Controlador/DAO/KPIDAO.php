<?php
require_once(RECURSOSGEN_LIB."/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/KPIData.php");

class KPIDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }
    
    /*
    * @param type $lDato
    * @param type $lParametro
    * @param type $aClearOnFailure
    * @return type
    */
    public function SelectListKPI01(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = SELECT_KPI01;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    /*
    * @param type $lDato
    * @param type $lParametro
    * @param type $aClearOnFailure
    * @return type
    */    
    public function SelectListKPI02(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = SELECT_KPI02;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
}
