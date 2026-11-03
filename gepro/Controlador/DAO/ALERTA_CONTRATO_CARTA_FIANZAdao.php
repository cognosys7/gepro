
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : AMSAC
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : ALERTA_CONTRATO_CARTA_FIANZAdao  de la vista BIBD_CONT_CONCEPTO_ALERTA
  //  Fecha           : miércoles, 8 de agosto de 2019 8:21:49
  //  Modificado      : 16 de agosto 2019
  //
  //****************************************************************************** */

require_once(RECURSOSGEN_LIB . "/DAO.php");
require_once(RECURSOSGEN_LIB . "/DynamicModel.php");
require_once(PATH_DATA . "/ALERTA_CONTRATO_CARTA_FIANZAdata.php");

class ALERTA_CONTRATO_CARTA_FIANZA_DAO extends DAO {

    public function __construct($aHostname = DB_HOSTNAME, $aDatabase = DB_DATABASE, $aUsername = DB_USERNAME, $aPassword = DB_PASSWORD, $aUseSingleton = true, $aDriver = DB_DRIVER) {
        parent::__construct($aHostname, $aDatabase, $aUsername, $aPassword, $aUseSingleton, $aDriver);
    }

    
    //Seleccionar Registros Por Condición Generada Por el Usuario
    public function SelCampos_ALERTA_CONTRATO_CARTA_FIANZA(&$lDataSet, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDataSet;
        $this->mQuery = SelCampos_ALERTA_CONTRATO_CARTA_FIANZA;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }

   

}
