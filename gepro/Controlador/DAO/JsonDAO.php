<?php
require_once(RECURSOSGEN_LIB."/DAO.php");
require_once(PATH_DATA . "/JsonData.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");

class JsonDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }
    
    public function SelectGrafico02A(&$lDato,$lParametro,$aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery  = sprintf(SELECT_GRAFICO_02_A
                , $lParametro['AsEstadoAtencion']);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function SelectGrafico03A(&$lDato,$lParametro,$aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery  = sprintf(SELECT_GRAFICO_03_A
                , $lParametro['AsEstadoAtencion']);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }
    
    /**
     * @param type $lDato
     * @param type $lParametro
     * @param type $aClearOnFailure
     * @return type
     */
        public function SelectJsonGrafico01A(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = SELECT_JSON01;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    /**
     * @param type $lDato
     * @param type $lParametro
     * @param type $aClearOnFailure
     * @return type
     */
        public function SelectJsonGrafico02A(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = SELECT_JSON02;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    /**
     * @param type $lDato
     * @param type $lParametro
     * @param type $aClearOnFailure
     * @return type
     */
        public function SelectJsonGrafico03A(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = SELECT_JSON03;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

    /**
     * @param type $lDato
     * @param type $lParametro
     * @param type $aClearOnFailure
     * @return type
     */
        public function SelectJsonGrafico04A(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = SELECT_JSON04;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
}

?>
