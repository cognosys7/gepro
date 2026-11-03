<?php
require_once(PATH_LIB."/DAO.php");
require_once(PATH_DATA . "/UsuarioData.php");
require_once(PATH_LIB . "/DynamicModel.php");

class UsuarioDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }
    
    public function VerificaUsuarioLogin(&$Registro, $Name, $Clave, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(SELECT_USUARIO_LOGIN, $Name, $Clave);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function RecuperaUsuarioLogin(&$Registro, $DNI, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(RECUPERA_USUARIO_LOGIN, $DNI);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function RecuperaUsuarioLDAP(&$Registro, $DNI, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(RECUPERA_USUARIO_LDAP, $DNI);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    
    public function RecuperaUsuarioLogin2(&$Registro, $Codigo, $Imagen, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(RECUPERA_USUARIO_LOGIN2, $Codigo, $Imagen);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function VerificaPersonalSelect(&$Registro, $Persona, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(SELECT_PERSONAL_SELECT, $Persona);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }

    public function VerificaUsuarioSelect(&$Registro, $Usuario, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(SELECT_USUARIO_SELEC, $Usuario);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
        
    public function VerificaCumpleUsuarios(&$lDato, $lParametro, $aClearOnFailure = true) {
        // PHP 8: la constante esta comentada en UsuarioData.php (el SP no existe); sin ella, lista vacia
        if (!defined('SELECT_CUMPLE_USUARIOS')) { return false; }
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = SELECT_CUMPLE_USUARIOS;
        $this->mParametro = $lParametro;
        //echo $this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function VerificaCumpleUsuarios2(&$lDato, $lParametro, $aClearOnFailure = true) {
        // PHP 8: la constante esta comentada en UsuarioData.php (el SP no existe); sin ella, lista vacia
        if (!defined('SELECT_CUMPLE_USUARIOS2')) { return false; }
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = SELECT_CUMPLE_USUARIOS2;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function ActualizaClaveUsuario(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = USUARIO_CLAVE_UPDATE;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
    public function ActualizaClaveUsuario2(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = USUARIO_CLAVE_UPDATE2;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
    public function ActualizaClaveUsuario3(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = USUARIO_CLAVE_UPDATE3;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }

}

?>
