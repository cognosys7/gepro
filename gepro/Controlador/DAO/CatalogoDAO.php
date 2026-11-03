<?php
require_once(RECURSOSGEN_LIB."/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/CatalogoData.php");

class CatalogoDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=false, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }

    public function VerificaCatalogoSeleccionado(&$Registro, $Codigo, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(VERIFICA_CATALOGO_SELECCIONADO, $Codigo);
        return parent::SelectList($aClearOnFailure);
    }
    
    public function VerificaCatalogoNombre(&$Registro, $Descripcion, $aClearOnFailure=true) 
    {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(VERIFICA_CATALOGO_NOMBRE, $Descripcion);
        //echo $this->mQuery;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function VerificaCatalogoNombreGrupo(&$Registro, $Grupo, $Descripcion, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(VERIFICA_CATALOGO_NOMBRE_GRUPO, $Descripcion, $Grupo);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function ListaCatalogoGrupoSubGrupoScript(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = LISTA_CATALOGO_GRUPO_SUBGRUPO_SCRIPT;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function VerificaCatalogoNombreSubGrupo(&$Registro, $Grupo, $SubGrupo, $Descripcion, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(VERIFICA_CATALOGO_NOMBRE_SUBGRUPO, $Descripcion, $Grupo, $SubGrupo);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
}

?>
