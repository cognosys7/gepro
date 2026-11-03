
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Julio C�sar Meza Yangali - mezayangali@gmail.com
//                    Edgar David Pisfil Ahumada                    
//  Prop�sito       : GEN_INTERVENCION_COMPDAO  de la tabla GEN_INTERVENCION_COMP
//  Fecha           : mi�rcoles, 9 de mayo de 2018 12:05:14
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//*******************************************************************************/

require_once(RECURSOSGEN_LIB . "/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/GEN_INTERVENCION_COMPData.php"); 

class GEN_INTERVENCION_COMP_DAO extends DAO { 
        
    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }   
    ////Seleccionar count
    public function Count_GEN_INTERVENCION_COMP(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Count_GEN_INTERVENCION_COMP;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
	
	//Seleccionar un Registro Por Clave Primaria
    public function SelPk_GEN_INTERVENCION_COMP(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelPk_GEN_INTERVENCION_COMP;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

	//Seleccionar Registros Por Condici�n Generada Por el Usuario
    public function SelCampos_GEN_INTERVENCION_COMP(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelCampos_GEN_INTERVENCION_COMP;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    public function SelCampos2_GEN_INTERVENCION_COMP(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelCampos2_GEN_INTERVENCION_COMP;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
	//Seleccionar Datos para Grilla
    public function SelGrd_GEN_INTERVENCION_COMP(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelGrd_GEN_INTERVENCION_COMP;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    

        
    //MANTENIMIENTO
    public function Insert_GEN_INTERVENCION_COMP(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Insert_GEN_INTERVENCION_COMP;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
    public function Update_GEN_INTERVENCION_COMP(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Update_GEN_INTERVENCION_COMP;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
    public function Delete_GEN_INTERVENCION_COMP(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Delete_GEN_INTERVENCION_COMP;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
}
