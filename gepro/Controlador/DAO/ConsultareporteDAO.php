<?php
require_once(RECURSOSGEN_LIB . "/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/ConsultareporteData.php");

class ConsultareporteDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }
    /**
     * ALNIX DIC 2015
     * @param type $lDato
     * @param type $lParametro
     * @param type $aClearOnFailure
     * @return type
     */
    public function SelectPivot_01(&$lDato,$lParametro=null,$aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery  = SELECT_PIVOT_01;
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    /**
     * ALNIX DIC 2015
     * @param type $lDato
     * @param type $lParametro
     * @param type $aClearOnFailure
     * @return type
     */
       
     public function SelectReporte_01(&$lDato,$lParametro,$aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery  = SELECT_REPORTE_01;
        $this->mParametro = $lParametro;
        //echo $this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    /**
     * ALNIX DIC 2015
     * @param type $lDato
     * @param type $lParametro
     * @param type $aClearOnFailure
     * @return type
     */
    public function SelectPapeletaAnio(&$lDato,$lParametro=null,$aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery  = SELECT_PAPELETA_ANIO;
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    /**
     * ALNIX DIC 2015
     * @param type $lDato
     * @param type $lParametro
     * @param type $aClearOnFailure
     * @return type
     */
    public function SelectPapeletaMes(&$lDato,$lParametro=null,$aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery  = SELECT_PAPELETA_MES;
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function SelectPapeletaMotivo(&$lDato,$lParametro=null,$aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery  = SELECT_PAPELETA_MOTIVO;
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function SelectPapeletaOficina(&$lDato,$lParametro=null,$aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery  = SELECT_PAPELETA_OFICINA;
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    public function SelectPapeletaSituacion(&$lDato,$lParametro=null,$aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery  = SELECT_PAPELETA_SITUACION;
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function SelectPapeletaEstado(&$lDato,$lParametro=null,$aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery  = SELECT_PAPELETA_ESTADO;
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
}
