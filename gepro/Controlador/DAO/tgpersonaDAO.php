
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : tgpersonaDAO  de la tabla tgpersona
  //  Fecha           : martes, 24 de julio de 2018 08:12:19 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //****************************************************************************** */

require_once(RECURSOSGEN_LIB . "/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/tgpersonaData.php");

class tgpersona_DAO extends DAO {

    public function __construct($aHostname = DB_HOSTNAME, $aDatabase = DB_DATABASE, $aUsername = DB_USERNAME, $aPassword = DB_PASSWORD, $aUseSingleton = true, $aDriver = DB_DRIVER) {
        parent::__construct($aHostname, $aDatabase, $aUsername, $aPassword, $aUseSingleton, $aDriver);
    }

    ////Seleccionar count
    public function Count_tgpersona(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Count_tgpersona;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    //Seleccionar un Registro Por Clave Primaria
    public function SelPk_tgpersona(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelPk_tgpersona;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    //Seleccionar Registros Por Condición Generada Por el Usuario
    public function SelCampos_tgpersona(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelCampos_tgpersona;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    
/***EDGAR---**************/    
    //Seleccionar Registros Por Condición Generada Por el Usuario
    public function SelCampos_tgpersona2(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelCampos_tgpersona2;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
/***EDGAR---**************/
    
    
//    //Seleccionar Datos para Grilla
//    public function SelGrd_tgpersona(&$lDataSet, $lParametro, $aClearOnFailure = true) {
//        $this->mObject = new DynamicModel();
//        $this->mList = &$lDataSet;
//        $this->mQuery = SelGrd_tgpersona;
//        $this->mParametro = $lParametro;
//        //$this->mQuery;exit;
//        return parent::SelectListSP($aClearOnFailure);
//    }
//
//    //MANTENIMIENTO
//    public function Insert_tgpersona(&$lDataSet, $lParametro, $aClearOnFailure = true) {
//        $this->mObject = new DynamicModel();
//        $this->mList = &$lDataSet;
//        $this->mQuery = Insert_tgpersona;
//        $this->mParametro = $lParametro;
//        //$this->mQuery;exit;
//        return parent::ExecuteSP($aClearOnFailure);
//    }
//
//    public function Update_tgpersona(&$lDataSet, $lParametro, $aClearOnFailure = true) {
//        $this->mObject = new DynamicModel();
//        $this->mList = &$lDataSet;
//        $this->mQuery = Update_tgpersona;
//        $this->mParametro = $lParametro;
//        //$this->mQuery;exit;
//        return parent::ExecuteSP($aClearOnFailure);
//    }
//
//    public function Delete_tgpersona(&$lDataSet, $lParametro, $aClearOnFailure = true) {
//        $this->mObject = new DynamicModel();
//        $this->mList = &$lDataSet;
//        $this->mQuery = Delete_tgpersona;
//        $this->mParametro = $lParametro;
//        //$this->mQuery;exit;
//        return parent::ExecuteSP($aClearOnFailure);
//    }

}
