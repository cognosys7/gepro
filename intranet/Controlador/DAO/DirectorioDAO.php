<?php
require_once(PATH_LIB."/DAO.php");
require_once(PATH_DATA . "/DirectorioData.php");
require_once(PATH_LIB . "/DynamicModel.php");

class DirectorioDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }
    
    public function VerificaDirectorioSelect(&$Registro, $Personal, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(VERIFICA_DIRECTORIO_SELECT, $Personal);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function ListadoDirectorio(&$Registro, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(LISTADO_DIRECTORIO);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function InsertarDirectorio(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = INSERTA_DIRECTORIO;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
    public function ActualizaDirectorio(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = DIRECTORIO_UPDATE;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
}

?>
