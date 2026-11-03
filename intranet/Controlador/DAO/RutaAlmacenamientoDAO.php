<?php
require_once(PATH_LIB."/DAO.php");
require_once(PATH_DATA . "/RutaAlmacenamientoData.php");
require_once(PATH_LIB . "/DynamicModel.php");
class RutaAlmacenamientoDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }
    
    //PARAMETROS DE PROYECTO
    public function ListarRutaAlmacenamiento(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = LISTAR_RUTA_ALMACENAMIENTO;
        $this->mParametro = $lParametro;
        //$this->mQuery;exit;
        return parent::SelectListSP($aClearOnFailure);
    }
}

?>
