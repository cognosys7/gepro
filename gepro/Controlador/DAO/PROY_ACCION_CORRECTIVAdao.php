<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    	  : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. julio César Meza Yangali                    
//  Propósito       : PROY_ACCION_CORRECTIVAdao de la tabla PROY_ACCION_CORRECTIVA
//  Fecha           : sábado, 3 de julio de 2021 2:15:11
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : sábado, 3 de julio de 2021 2:15:11
//
//******************************************************************************/

require_once(RECURSOSGEN_LIB . "/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/PROY_ACCION_CORRECTIVAData.php"); 

class PROY_ACCION_CORRECTIVA_DAO extends DAO { 
        
    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }   
    
    
    ////Seleccionar count
    public function Count_PROY_ACCION_CORRECTIVA(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Count_PROY_ACCION_CORRECTIVA;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
	
	//Seleccionar un Registro Por Clave Primaria
    public function SelPk_PROY_ACCION_CORRECTIVA(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelPk_PROY_ACCION_CORRECTIVA;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }


	//Seleccionar Registros Por Condición Generada Por el Usuario
    public function SelCampos_PROY_ACCION_CORRECTIVA(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelCampos_PROY_ACCION_CORRECTIVA;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    
	//Seleccionar Datos para Grilla
    public function SelGrd_PROY_ACCION_CORRECTIVA(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelGrd_PROY_ACCION_CORRECTIVA;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
      
    //MANTENIMIENTO
    public function Insert_PROY_ACCION_CORRECTIVA(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Insert_PROY_ACCION_CORRECTIVA;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
    
    public function Update_PROY_ACCION_CORRECTIVA(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Update_PROY_ACCION_CORRECTIVA;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
    
    public function Delete_PROY_ACCION_CORRECTIVA(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Delete_PROY_ACCION_CORRECTIVA;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
}
