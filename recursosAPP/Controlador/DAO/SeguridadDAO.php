<?php
require_once(RECURSOSGEN_LIB."/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(SEG_MODELO . "/SistemaSeg.php");
require_once(SEG_DATA . "/SeguridadSegData.php");

class SeguridadSegDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }
       
    public function VerificaSistemaActual(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = VERIFICA_SISTEMA_XNOM;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function VerificaUsuarioSelect(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = SELECT_USUARIO_SELEC;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function VerificaUsuarioPerfil(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = VERIFICA_USUARIO_PERFIL;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function VerificaPerfilxID(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = VERIFICA_PERFIL_XID;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function ListaMenus(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = LISTA_MENUS;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function VerificaAccesoOpcionPerfil(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = VERIFICA_ACCESO_OPCION_PERFIL;
        $this->mParametro = $lParametro;
        return parent::SelectListSP($aClearOnFailure);
    }
 
}

?>
