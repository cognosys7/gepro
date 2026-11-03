<?php

require_once(RECURSOSGEN_LIB."/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_MODELO . "/Reniec.php");
require_once(PATH_DATA . "/ReniecData.php");

class ReniecDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASERENIEC, $aUsername=DB_USERNAMERENIEC, $aPassword=DB_PASSWORDRENIEC, $aUseSingleton=false, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }
    
    public function VerificaDNIReniec(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = VERIFICA_DNI_RENIEC;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
}

?>
