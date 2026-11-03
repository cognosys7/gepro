<?php
/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa	    : www.cognosys.com.pe
//  Autores         : Hector Lopez Sanchez                    
//  Propósito       : SEG_ENTIDAD_USUARIODAO  de la tabla SEG_ENTIDAD_USUARIO
//  Fecha           : miércoles, 21 de febrero de 2018 06:14:41 p.m.
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//*******************************************************************************/
 



require_once(RECURSOSGEN_LIB . "/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/RPT_INTERVENCIONESData.php"); 

class RPT_INTERVENCIONES_DAO extends DAO { 
        
    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }   

    
	//Seleccionar Datos para Grilla
    public function Rpt_Formato1_RPT_INTERVENCIONES(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Rpt_Formato1_RPT_INTERVENCIONES;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }    

    
}