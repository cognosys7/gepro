<?php

require_once(RECURSOSGEN_LIB."/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_MODELO . "/Catalogo.php");
require_once(PATH_DATA . "/CatalogoData.php");

class CatalogoDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }

    public function VerificaCatalogoSeleccionado(&$Registro, $Codigo, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(VERIFICA_CATALOGO_SELECCIONADO, $Codigo);
        //echo $this->mQuery;
        return parent::SelectList($aClearOnFailure);
    }
    
    //OK
    public function VerificaCatalogoNombre(&$Registro, $Descripcion, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(VERIFICA_CATALOGO_NOMBRE, $Descripcion);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function VerificaCatalogoNombreGrupo(&$Registro, $Grupo, $Descripcion, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(VERIFICA_CATALOGO_NOMBRE_GRUPO, $Grupo, $Descripcion);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function VerificaCatalogoNombreSubGrupo(&$Registro, $Grupo, $SubGrupo, $Descripcion, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(VERIFICA_CATALOGO_NOMBRE_SUBGRUPO, $Grupo, $SubGrupo, $Descripcion);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function ListaCatalogoGrupoSubGrupo(&$Registro, $Grupo, $SubGrupo, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(LISTA_CATALOGO_GRUPO_SUBGRUPO, $Grupo, $SubGrupo);
        //echo $this->mQuery;
        return parent::SelectList($aClearOnFailure);
    }
   

}

?>
