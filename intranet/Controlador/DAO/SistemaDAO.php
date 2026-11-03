<?php
require_once(PATH_LIB."/DAO.php");
require_once(PATH_DATA . "/SistemaData.php");
require_once(PATH_LIB . "/DynamicModel.php");

class SistemaDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }
    
    public function ListadoSistemasUsuarios(&$Registro, $Usuario, $aClearOnFailure=true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$Registro;
        $this->mQuery  = sprintf(LISTADO_SISTEMAS_USUARIOS, $Usuario);
        //echo $this->mQuery;exit;
        return parent::SelectList($aClearOnFailure);
    }

}

?>
