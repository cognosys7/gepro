<?php
require_once(RECURSOSGEN_LIB . "/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/ReporteData.php");

class ReporteDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }

    public function SelectPivot_01(&$lDato,$lParametro=null,$aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery  = SELECT_PIVOT_01;
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
       
    public function SelectReporteFamilia(&$lDato,$lParametro,$aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery  = SELECT_REPORTE_FAMILIA;
        $this->mParametro = $lParametro;
        //echo $this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function SelectDepartamento(&$lDato,$lParametro=null,$aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery  = SELECT_DEPARTAMENTO;
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
}
