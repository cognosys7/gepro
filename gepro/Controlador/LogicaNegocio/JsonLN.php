<?php

require_once(PATH_CONTROLADOR_DAO . "/JsonDAO.php");

function EjecutaLN() {
    /*
     * 
     */
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'LoadJson1')) {
        
        $lParametro = array();
             
        $oJsonDAO = new JsonDAO();

        $lData1 = array();
        
        $lstParametros = array();
        $lstParametros['PCODIGO']      = str_repeat("\0", 100);
        $lstParametros['PMENSAJE']     = str_repeat("\0", 200);
        $procedure_paramsS = array(
            array(&$lstParametros['PCODIGO'], SQLSRV_PARAM_OUT)
            , array(&$lstParametros['PMENSAJE'], SQLSRV_PARAM_OUT)
        );
        $oJsonDAO->SelectJsonGrafico01A($lData1, $procedure_paramsS);
        $lSerie1 = array();

        $lSerie1['name'] = 'REGIÓN';

        $lSeries = array();

        foreach ($lData1 as $oDM) {

            $lSerie1['data'][] = array($oDM->SERIE, ($oDM->TOTAL));
        }

        array_push($lSeries, $lSerie1);

        $sData = json_encode($lSeries);
        $sData = json_encode($lSeries, JSON_NUMERIC_CHECK);
        echo $sData;
        exit;
    }

    /*
     * 
     */
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'LoadJson2')) {
        $oJsonDAO = new JsonDAO();

        $lData1 = array();
        $lstParametros = array();
        $lstParametros['PCODIGO']      = str_repeat("\0", 100);
        $lstParametros['PMENSAJE']     = str_repeat("\0", 200);
        $procedure_paramsS = array(
            array(&$lstParametros['PCODIGO'], SQLSRV_PARAM_OUT)
            , array(&$lstParametros['PMENSAJE'], SQLSRV_PARAM_OUT)
        );
        $oJsonDAO->SelectJsonGrafico02A($lData1, $procedure_paramsS);

        $lSerie1 = array();

        $lSerie1['name'] = 'SITUACÍON';

        $lSeries = array();

        foreach ($lData1 as $oDM) {

            $lSerie1['data'][] = array($oDM->SERIE, ($oDM->TOTAL));
        }

        array_push($lSeries, $lSerie1);
        $sData = json_encode($lSeries);
        $sData = json_encode($lSeries, JSON_NUMERIC_CHECK);
        echo $sData;
        exit;
    }

    /*
     * 
     */
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'LoadJson3')) {
        $oJsonDAO = new JsonDAO();

        $lData1 = array();
        $lstParametros = array();
        $lstParametros['PCODIGO']      = str_repeat("\0", 100);
        $lstParametros['PMENSAJE']     = str_repeat("\0", 200);
        
        $procedure_paramsS = array(
            array(&$lstParametros['PCODIGO'], SQLSRV_PARAM_OUT)
            , array(&$lstParametros['PMENSAJE'], SQLSRV_PARAM_OUT)
        );
        $oJsonDAO->SelectJsonGrafico03A($lData1, $procedure_paramsS);

        $lSerie1 = array();

        $lSerie1['name'] = 'TIPO DE OCURRENCIA';

        $lSeries = array();

        foreach ($lData1 as $oDM) {

            $lSerie1['data'][] = array($oDM->SERIE, ($oDM->TOTAL));
        }

        array_push($lSeries, $lSerie1);
        $sData = json_encode($lSeries);
        $sData = json_encode($lSeries, JSON_NUMERIC_CHECK);
        echo $sData;
        exit;
    }

    /*
     * 
     */
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'LoadJson4')) {
        $oJsonDAO = new JsonDAO();

        $lData1 = array();
        $lstParametros = array();
        $lstParametros['PCODIGO']      = str_repeat("\0", 100);
        $lstParametros['PMENSAJE']     = str_repeat("\0", 200);
        
        $procedure_paramsS = array(
            array(&$lstParametros['PCODIGO'], SQLSRV_PARAM_OUT)
            , array(&$lstParametros['PMENSAJE'], SQLSRV_PARAM_OUT)
        );
        $oJsonDAO->SelectJsonGrafico04A($lData1, $procedure_paramsS);

        $lSerie1 = array();

        $lSerie1['name'] = 'OCURRENCIA';

        $lSeries = array();

        foreach ($lData1 as $oDM) {

            $lSerie1['data'][] = array($oDM->SERIE, ($oDM->TOTAL));
        }

        array_push($lSeries, $lSerie1);
        $sData = json_encode($lSeries);
        $sData = json_encode($lSeries, JSON_NUMERIC_CHECK);
        echo $sData;
        exit;
    }
}

?>