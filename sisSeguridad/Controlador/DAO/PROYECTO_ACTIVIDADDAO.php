
<?php

require_once(RECURSOSGEN_LIB . "/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/PROYECTO_ACTIVIDADData.php");

class PROYECTO_ACTIVIDAD_DAO extends DAO {

    public function __construct($aHostname = DB_HOSTNAME, $aDatabase = DB_DATABASE, $aUsername = DB_USERNAME, $aPassword = DB_PASSWORD, $aUseSingleton = true, $aDriver = DB_DRIVER) {
        parent::__construct($aHostname, $aDatabase, $aUsername, $aPassword, $aUseSingleton, $aDriver);
    }

    ////Seleccionar count
    public function Count_PROYECTO_ACTIVIDAD(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Count_PROYECTO_ACTIVIDAD;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    //Seleccionar un Registro Por Clave Primaria
    public function SelPk_PROYECTO_ACTIVIDAD(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelPk_PROYECTO_ACTIVIDAD;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    //Seleccionar Registros Por Condici�n Generada Por el Usuario    
      public function SelCampos_PROYECTO_ACTIVIDAD(&$lDataSet, $lParametro, $aClearOnFailure = true) {
      $this->mObject = new DynamicModel();
      $this->mList = &$lDataSet;
      $this->mQuery = SelCampos_PROYECTO_ACTIVIDAD;
      $this->mParametro = $lParametro;
      //$this->mQuery;exit;
      return parent::SelectListSP($aClearOnFailure);
      }
     
    //Seleccionar Registros Por Condici�n Generada Por el Usuario
    public function SelCampos_PROYECTO_ACTIVIDAD2(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelCampos_PROYECTO_ACTIVIDAD2;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    //Seleccionar Datos para Grilla
    public function SelGrd_PROYECTO_ACTIVIDAD(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelGrd_PROYECTO_ACTIVIDAD;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    //MANTENIMIENTO
    public function Insert_PROYECTO_ACTIVIDAD(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Insert_PROYECTO_ACTIVIDAD;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }

    public function Update_PROYECTO_ACTIVIDAD(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Update_PROYECTO_ACTIVIDAD;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }

    public function Delete_PROYECTO_ACTIVIDAD(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = Delete_PROYECTO_ACTIVIDAD;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::ExecuteSP($aClearOnFailure);
    }

}
