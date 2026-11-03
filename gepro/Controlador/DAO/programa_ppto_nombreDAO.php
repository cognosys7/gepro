
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : MODULO DE PLANIFICACION
//  Entidad         : AUTORIDAD PARA LA RECONSTRUCCIÓN CON CAMBIOS. PRESIDENCIA DEL CONSEJO DE MINISTROS
//  Autores         : ING. EDGAR DAVID PISFIL AHUMADA             
//  Propósito       : programa_ppto_nombreDAO  de la tabla programa_ppto_nombre
//  Fecha           : viernes, 26 de octubre de 2018 13:10:56
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//*******************************************************************************/

require_once(RECURSOSGEN_LIB . "/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/programa_ppto_nombreData.php"); 

class programa_ppto_nombre_DAO extends DAO { 
        
    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }   
    ////Seleccionar count
    public function Count_programa_ppto_nombre(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Count_programa_ppto_nombre;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
	
	//Seleccionar un Registro Por Clave Primaria
    public function SelPk_programa_ppto_nombre(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelPk_programa_ppto_nombre;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

	//Seleccionar Registros Por Condición Generada Por el Usuario
    public function SelCampos_programa_ppto_nombre(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelCampos_programa_ppto_nombre;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
	//Seleccionar Datos para Grilla
    public function SelGrd_programa_ppto_nombre(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelGrd_programa_ppto_nombre;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    

        
    //MANTENIMIENTO
    public function Insert_programa_ppto_nombre(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Insert_programa_ppto_nombre;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
    public function Update_programa_ppto_nombre(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Update_programa_ppto_nombre;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
    public function Delete_programa_ppto_nombre(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Delete_programa_ppto_nombre;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }
    
}