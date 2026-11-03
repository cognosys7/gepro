<?php

require_once(RECURSOSGEN_LIB."/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_MODELO . "/Acceso.php");
require_once(PATH_DATA . "/AccesoData.php");

class AccesoDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }
    public function AgregaQuitaAcceso(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = AGREGAR_QUITAR_ACCESO;
        $this->mParametro = $lParametro;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
}

?>
