<?php
require_once(PATH_LIB."/DAO.php");
require_once(PATH_DATA . "/IntranetData.php");
require_once(PATH_LIB . "/DynamicModel.php");

class IntranetDAO extends DAO {

    public function __construct($aHostname=DB_HOSTNAME, $aDatabase=DB_DATABASE, $aUsername=DB_USERNAME, $aPassword=DB_PASSWORD, $aUseSingleton=true, $aDriver=DB_DRIVER) {
        parent::__construct($aHostname,$aDatabase,$aUsername,$aPassword,$aUseSingleton,$aDriver);
    }
    
    public function ListaNoticia(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = LISTA_NOTICIAS_TOP;
       $this->mParametro = $lParametro;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function ListaNoticiaImagenes(&$lDato, $lParametro,$aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = LISTA_NOTICIA_IMAGENES;
        $this->mParametro = $lParametro;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function VerificaNoticiaxId(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = VERIFICA_NOTICIA_XID;
        $this->mParametro = $lParametro;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function ListaComunicadoPrincipal(&$lDato, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = VERIFICA_COMUNICADO_PRINCIPAL;
        return parent::SelectList($aClearOnFailure);
    }
    
    public function ListaComunicados(&$lDato, $lParametro, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = LISTA_COMUNICADO_TOP;
        $this->mParametro = $lParametro;
        return parent::SelectListSP($aClearOnFailure);
    }
    
    public function ListaEnlace(&$lDato, $aClearOnFailure = true) {
        $this->mObject = new DynamicModel();
        $this->mList = &$lDato;
        $this->mQuery = VERIFICA_ENLACE;
        return parent::SelectList($aClearOnFailure);
    }
    
    
}

?>
