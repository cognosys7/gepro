<?php
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(PATH_CONTROLADOR_DAO . "/KPIDAO.php");
    //require_once(PATH_LIB . '/util.php');
    function EjecutaLN() 
    {
        $lCollection = Collection::Singleton();
        ValidaSession();
        $oKPIDAO = new KPIDAO();
        
        $lParametro = array();
        
        //Seleccionar los KPI a mostrar
        $lKPI01 = array();

        $lstParametros = array();
         
        $procedure_paramsS = array(
            array(&$lstParametros['Perfil'], SQLSRV_PARAM_IN)
        );
        
        $oKPIDAO->SelectListKPI01($lKPI01, $procedure_paramsS);
        $lKPI02 = array();
        $oKPIDAO->SelectListKPI02($lKPI02, $procedure_paramsS);
        //var_dump($lKPI02,$procedure_paramsS);exit;
        $lCollection->Add('lKPI01', $lKPI01);
        $lCollection->Add('lKPI02', $lKPI02);
        
        $PaginaFormulario = "Inicio";
        $PermisoOK        = 1;
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('PermisoOK', $PermisoOK);
    }
?>