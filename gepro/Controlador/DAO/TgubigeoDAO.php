
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
//                    Hector Lopez Sanchez                    
//  Propósito       : DAO de la tabla TGUBIGEO
//  Fecha           : lunes, 23 de octubre de 2017 18:52:30
//  Desde el Modelo : PDM AMSAC
//  Modificado      : 16 de Octubre 2017
//
//*******************************************************************************/

require_once(RECURSOSGEN_LIB . "/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/TGUBIGEOData.php"); 

class TGUBIGEODAO extends DAO { 
        
    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }   
    ////Seleccionar count
    public function Count_TGUBIGEO(&$lDataSet, $lFiltro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mDataSet = &$lDataSet;
        $this->mQuery = Count_TGUBIGEO;
        $this->mFiltro = $lFiltro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
	
	//Seleccionar un Registro Por Clave Primaria
    public function SelPk_TGUBIGEO(&$lDataSet, $lFiltro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mDataSet = &$lDataSet;
        $this->mQuery = SelPk_TGUBIGEO;
        $this->mFiltro = $lFiltro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

	//Seleccionar Registros Por Condición Generada Por el Usuario
    public function SelCampos_TGUBIGEO(&$lDataSet, $lFiltro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mDataSet = &$lDataSet;
        $this->mQuery = Count_TGUBIGEO;
        $this->mFiltro = $lFiltro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
	//Seleccionar Datos para Grilla
    public function SelGrd_TGUBIGEO(&$lDataSet, $lFiltro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mDataSet = &$lDataSet;
        $this->mQuery = SelGrd_TGUBIGEO;
        $this->mFiltro = $lFiltro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    

        
    //MANTENIMIENTO
    public function Insert_TGUBIGEO(&$lDataSet, $lFiltro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mDataSet = &$lDataSet;
        $this->mQuery = Insert_TGUBIGEO;
        $this->mFiltro = $lFiltro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
    public function Update_TGUBIGEO(&$lDataSet, $lFiltro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mDataSet = &$lDataSet;
        $this->mQuery = Update_TGUBIGEO;
        $this->mFiltro = $lFiltro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
    public function Delete_TGUBIGEO(&$lDataSet, $lFiltro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mDataSet = &$lDataSet;
        $this->mQuery = Delete_TGUBIGEO;
        $this->mFiltro = $lFiltro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
}