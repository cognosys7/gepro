<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_CONTRATO_GASTO_DIRDAO  de la tabla PROY_CONTRATO_GASTO_DIR
  //  Fecha           : martes, 28 de mayo de 2019 21:00:04
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-I
  //  Modificado      : 16 de Octubre 2017
  //
  //****************************************************************************** */

require_once(RECURSOSGEN_LIB . "/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/PROY_CONTRATO_GASTO_DIRData.php");

class PROY_CONTRATO_GASTO_DIR_DAO extends DAO {

    public function __construct($aHostname = DB_HOSTNAME, $aDatabase = DB_DATABASE, $aUsername = DB_USERNAME, $aPassword = DB_PASSWORD, $aUseSingleton = true, $aDriver = DB_DRIVER) {
        parent::__construct($aHostname, $aDatabase, $aUsername, $aPassword, $aUseSingleton, $aDriver);
    }

    ////Seleccionar count
    public function Count_PROY_CONTRATO_GASTO_DIR(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Count_PROY_CONTRATO_GASTO_DIR;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    //Seleccionar un Registro Por Clave Primaria
    public function SelPk_PROY_CONTRATO_GASTO_DIR(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelPk_PROY_CONTRATO_GASTO_DIR;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    //Seleccionar Registros Por Condición Generada Por el Usuario
    public function SelCampos_PROY_CONTRATO_GASTO_DIR(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelCampos_PROY_CONTRATO_GASTO_DIR;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    //Seleccionar Datos para Grilla
    public function SelGrd_PROY_CONTRATO_GASTO_DIR(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelGrd_PROY_CONTRATO_GASTO_DIR;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    //Seleccionar Datos para Grilla busqueda
    public function SelGrd_PROY_CONTRATO_GASTO_DIR_busqueda(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelGrd_PROY_CONTRATO_GASTO_DIR_busqueda;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    //MANTENIMIENTO
    public function Insert_PROY_CONTRATO_GASTO_DIR(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Insert_PROY_CONTRATO_GASTO_DIR;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }

    public function Update_PROY_CONTRATO_GASTO_DIR(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Update_PROY_CONTRATO_GASTO_DIR;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }

    public function Delete_PROY_CONTRATO_GASTO_DIR(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Delete_PROY_CONTRATO_GASTO_DIR;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }

}
