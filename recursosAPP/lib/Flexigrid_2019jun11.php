 <?php
if ( !function_exists('json_decode') ){
    function json_decode($content, $assoc=false){
        require_once 'JSON.php';
        if ( $assoc ){
            $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        } else {
            $json = new Services_JSON;
        }
        return $json->decode($content);
    }
}

if ( !function_exists('json_encode') ){
    function json_encode($content){
        require_once 'JSON.php';
        $json = new Services_JSON;       
        return $json->encode($content);
    }
}

function GenerarDatosParaFlexigridSP($objDAO, $sMetodo, $Total, $nPagina, $lFiltro, $nItemsPorPagina, $sCampoOrden, $sOrden) 
{
    $lstDatos   = array();
    $lstData    = array();
    $lstFilas   = array();
    $lParametro = array();
    
    $lParametro['rp'] = $nItemsPorPagina;
    $lParametro['sortname'] = $sCampoOrden;
    $lParametro['sortorder'] = $sOrden;
    $lParametro['page'] = $nPagina;
    $lParametro['where'] = $lFiltro;
    $lParametro['codigoMensaje'] = str_repeat("\0", 100);
    $lParametro['Mensaje'] = str_repeat("\0", 200);
    $lParametro['nTotal'] = intval(-2);

    // preparar el array de parametros del procedimiento considerar que se deben pasar por referencia
    $procedure_params = array(
        array(&$lParametro['rp'], SQLSRV_PARAM_IN)
        , array(&$lParametro['sortname'], SQLSRV_PARAM_IN)
        , array(&$lParametro['sortorder'], SQLSRV_PARAM_IN)
        , array(&$lParametro['page'], SQLSRV_PARAM_IN)
        , array(&$lParametro['where'], SQLSRV_PARAM_IN)
        , array(&$lParametro['codigoMensaje'], SQLSRV_PARAM_OUT)
        , array(&$lParametro['Mensaje'], SQLSRV_PARAM_OUT)
        , array(&$lParametro['nTotal'], SQLSRV_PARAM_OUT)
    );
    
    $objDAO->$sMetodo($lstDatos, $procedure_params);
    
    //OBTENGO EL TOTAL DE LA CONSULTA
    $nTotal = ($Total == -1) ? $procedure_params[7][0] : $Total;
    //$nTotal           = $procedure_params[7][0];
    $lstData['page']  = $nPagina;
    $lstData['total'] = $nTotal;
    if(count($lstDatos)){
        foreach ($lstDatos as $obj) 
        {
            $lst    = array();
            $lst['id'] = $obj->ID;
            $lista  = array();
            $lista  = $obj->GetPropertyList();
            $a = array();
            foreach($lista as $valor)
                $a[]=$valor;        
                $lst["cell"]    = $a;
                $lstFilas[]     = $lst;
        }
    }
    $lstData['rows'] = $lstFilas;
    $lstData = json_encode($lstData);
    
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header('Content-type: application/json; charset=utf-8');
    header("Content-type: text/x-json");
    echo $lstData;
}

function GenerarDatosParaFlexigridSP1($objDAO, $sMetodo, $Total, $nPagina, $lFiltro, $lParam, $nItemsPorPagina, $sCampoOrden, $sOrden) 
{
    $lstDatos   = array();
    $lstData    = array();
    $lstFilas   = array();
    $lParametro = array();
    
    $lParametro['rp'] = $nItemsPorPagina;
    $lParametro['sortname'] = $sCampoOrden;
    $lParametro['sortorder'] = $sOrden;
    $lParametro['page']   = $nPagina;
    $lParametro['where']  = $lFiltro;
    $lParametro['Param1'] = $lParam;
    $lParametro['codigoMensaje'] = str_repeat("\0", 100);
    $lParametro['Mensaje'] = str_repeat("\0", 200);
    $lParametro['nTotal'] = intval(-2);
    
//    $lParametro['pAuxiliar'] = 210;

    // preparar el array de parametros del procedimiento considerar que se deben pasar por referencia
    $procedure_params = array(
        array(&$lParametro['rp'], SQLSRV_PARAM_IN)
        , array(&$lParametro['sortname'], SQLSRV_PARAM_IN)
        , array(&$lParametro['sortorder'], SQLSRV_PARAM_IN)
        , array(&$lParametro['page'], SQLSRV_PARAM_IN)
        , array(&$lParametro['where'], SQLSRV_PARAM_IN)
        , array(&$lParametro['Param1'], SQLSRV_PARAM_IN)
        , array(&$lParametro['codigoMensaje'], SQLSRV_PARAM_OUT)
        , array(&$lParametro['Mensaje'], SQLSRV_PARAM_OUT)
        , array(&$lParametro['nTotal'], SQLSRV_PARAM_OUT)
        
//        , array(&$lParametro['pAuxiliar'], SQLSRV_PARAM_OUT)
    );
    
    $objDAO->$sMetodo($lstDatos, $procedure_params);
    
    //OBTENGO EL TOTAL DE LA CONSULTA
    $nTotal = ($Total == -1) ? $procedure_params[8][0] : $Total;
    //$nTotal           = $procedure_params[7][0];
    $lstData['page']  = $nPagina;
    $lstData['total'] = $nTotal;
    if(count($lstDatos)>0)
    foreach ($lstDatos as $obj) 
    {
        $lst    = array();
        $lst['id'] = $obj->ID;
        $lista  = array();
        $lista  = $obj->GetPropertyList();
        $a = array();
        foreach($lista as $valor)
            $a[]=$valor;        
            $lst["cell"]    = $a;
            $lstFilas[]     = $lst;
    }
    $lstData['rows'] = $lstFilas;
    $lstData = json_encode($lstData);
    
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header('Content-type: application/json; charset=utf-8');
    header("Content-type: text/x-json");
    echo $lstData;
}

function GenerarDatosParaFlexigridSP2($objDAO, $sMetodo, $Total, $nPagina, $lFiltro, $lParam1, $lParam2, $nItemsPorPagina, $sCampoOrden, $sOrden) 
{
    $lstDatos   = array();
    $lstData    = array();  
    $lstFilas   = array();
    $lParametro = array();
    
    $lParametro['rp'] = $nItemsPorPagina;
    $lParametro['sortname'] = $sCampoOrden;
    $lParametro['sortorder'] = $sOrden;
    $lParametro['page']   = $nPagina;
    $lParametro['where']  = $lFiltro;
    $lParametro['Param1'] = $lParam1;
    $lParametro['Param2'] = $lParam2;
    $lParametro['codigoMensaje'] = str_repeat("\0", 100);
    $lParametro['Mensaje'] = str_repeat("\0", 200);
    $lParametro['nTotal'] = intval(-2);

    // preparar el array de parametros del procedimiento considerar que se deben pasar por referencia
    $procedure_params = array(
        array(&$lParametro['rp'], SQLSRV_PARAM_IN)
        , array(&$lParametro['sortname'], SQLSRV_PARAM_IN)
        , array(&$lParametro['sortorder'], SQLSRV_PARAM_IN)
        , array(&$lParametro['page'], SQLSRV_PARAM_IN)
        , array(&$lParametro['where'], SQLSRV_PARAM_IN)
        , array(&$lParametro['Param1'], SQLSRV_PARAM_IN)
        , array(&$lParametro['Param2'], SQLSRV_PARAM_IN)
        , array(&$lParametro['codigoMensaje'], SQLSRV_PARAM_OUT)
        , array(&$lParametro['Mensaje'], SQLSRV_PARAM_OUT)
        , array(&$lParametro['nTotal'], SQLSRV_PARAM_OUT)
    );
    
    $objDAO->$sMetodo($lstDatos, $procedure_params);
    
    //OBTENGO EL TOTAL DE LA CONSULTA
    $nTotal = ($Total == -1) ? $procedure_params[9][0] : $Total;
    //$nTotal           = $procedure_params[7][0];
    
    //var_dump($nTotal);exit;
    $lstData['page']  = $nPagina;
    $lstData['total'] = $nTotal;
    if(count($lstDatos)>0)
    foreach ($lstDatos as $obj) 
    {
        $lst    = array();
        $lst['id'] = $obj->ID;
        $lista  = array();
        $lista  = $obj->GetPropertyList();
        $a = array();
        foreach($lista as $valor)
            $a[]=$valor;        
            $lst["cell"]    = $a;
            $lstFilas[]     = $lst;
    }
    $lstData['rows'] = $lstFilas;
    $lstData = json_encode($lstData);
    
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header('Content-type: application/json; charset=utf-8');
    header("Content-type: text/x-json");
    echo $lstData;
}

function GenerarDatosParaFlexigridSP3($objDAO, $sMetodo, $Total, $nPagina, $lFiltro, $lParam1, $lParam2, $lParam3, $nItemsPorPagina, $sCampoOrden, $sOrden) 
{
    $lstDatos   = array();
    $lstData    = array();  
    $lstFilas   = array();
    $lParametro = array();
    
    $lParametro['rp'] = $nItemsPorPagina;
    $lParametro['sortname'] = $sCampoOrden;
    $lParametro['sortorder'] = $sOrden;
    $lParametro['page']   = $nPagina;
    $lParametro['where']  = $lFiltro;
    $lParametro['Param1'] = $lParam1;
    $lParametro['Param2'] = $lParam2;
    $lParametro['Param3'] = $lParam3;
    $lParametro['codigoMensaje'] = str_repeat("\0", 100);
    $lParametro['Mensaje'] = str_repeat("\0", 200);
    $lParametro['nTotal'] = intval(-2);

    // preparar el array de parametros del procedimiento considerar que se deben pasar por referencia
    $procedure_params = array(
        array(&$lParametro['rp'], SQLSRV_PARAM_IN)
        , array(&$lParametro['sortname'], SQLSRV_PARAM_IN)
        , array(&$lParametro['sortorder'], SQLSRV_PARAM_IN)
        , array(&$lParametro['page'], SQLSRV_PARAM_IN)
        , array(&$lParametro['where'], SQLSRV_PARAM_IN)
        , array(&$lParametro['Param1'], SQLSRV_PARAM_IN)
        , array(&$lParametro['Param2'], SQLSRV_PARAM_IN)
        , array(&$lParametro['Param3'], SQLSRV_PARAM_IN)
        , array(&$lParametro['codigoMensaje'], SQLSRV_PARAM_OUT)
        , array(&$lParametro['Mensaje'], SQLSRV_PARAM_OUT)
        , array(&$lParametro['nTotal'], SQLSRV_PARAM_OUT)
    );
    
    $objDAO->$sMetodo($lstDatos, $procedure_params);        
    //OBTENGO EL TOTAL DE LA CONSULTA
    $nTotal = ($Total == -1) ? $procedure_params[10][0] : $Total;
    //$nTotal           = $procedure_params[7][0];
    
    //var_dump($nTotal);exit;
    $lstData['page']  = $nPagina;
    $lstData['total'] = $nTotal;
    if(count($lstDatos)>0)
    foreach ($lstDatos as $obj) 
    {
        $lst    = array();
        $lst['id'] = $obj->ID;
        $lista  = array();
        $lista  = $obj->GetPropertyList();
        $a = array();
        foreach($lista as $valor)
            $a[]=$valor;        
            $lst["cell"]    = $a;
            $lstFilas[]     = $lst;
    }
    $lstData['rows'] = $lstFilas;
    $lstData = json_encode($lstData);
    
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header('Content-type: application/json; charset=utf-8');
    header("Content-type: text/x-json");    
    echo $lstData;
}

function GenerarDatosParaFlexigridSPArray($objDAO, $sMetodo, $Total, $nPagina, $lFiltro, $lParam, $nItemsPorPagina, $sCampoOrden, $sOrden) 
{
    $lstDatos   = array();
    $lstData    = array();
    $lstFilas   = array();
    $lParametro = array();
    
    $lParametro['rp']               = $nItemsPorPagina;
    $lParametro['sortname']         = $sCampoOrden;
    $lParametro['sortorder']        = $sOrden;
    $lParametro['page']             = $nPagina;
    $lParametro['where']            = $lFiltro;
    if (!empty($lParam) && is_array($lParam)) 
    { 
        $iP = 0;
        $lstParametrosGrid = array();
        foreach ($lParam as $ObjetoParametro) 
        {
            $lParametro['Param'.$iP] = $ObjetoParametro[0];
            $lstParametrosGrid       = array(array(&$lParametro['Param'.$iP], SQLSRV_PARAM_IN));
            $iP++;
        }
    }
    $lParametro['codigoMensaje']    = str_repeat("\0", 100);
    $lParametro['Mensaje']          = str_repeat("\0", 200);
    $lParametro['nTotal']           = str_repeat("\0", 200);

    // preparar el array de parametros del procedimiento considerar que se deben pasar por referencia
    $procedure_params = array(
        array(&$lParametro['rp'], SQLSRV_PARAM_IN)
        , array(&$lParametro['sortname'], SQLSRV_PARAM_IN)
        , array(&$lParametro['sortorder'], SQLSRV_PARAM_IN)
        , array(&$lParametro['page'], SQLSRV_PARAM_IN)
        , array(&$lParametro['where'], SQLSRV_PARAM_IN)
        , array(&$lParametro['codigoMensaje'], SQLSRV_PARAM_OUT)
        , array(&$lParametro['Mensaje'], SQLSRV_PARAM_OUT)
        , array(&$lParametro['nTotal'], SQLSRV_PARAM_OUT)
    );
    
    $objDAO->$sMetodo($lstDatos, $procedure_params);
    //OBTENGO EL TOTAL DE LA CONSULTA
    $nTotal           = $Total;
    //$nTotal           = $procedure_params[7][0];
    $lstData['page']  = $nPagina;
    $lstData['total'] = $nTotal;
    foreach ($lstDatos as $obj) 
    {
        $lst    = array();
        $lst['id'] = $obj->ID;
        $lista  = array();
        $lista  = $obj->GetPropertyList();
        $a = array();
        foreach($lista as $valor)
            $a[]=$valor;        
            $lst["cell"]    = $a;
            $lstFilas[]     = $lst;
    }
    $lstData['rows'] = $lstFilas;
    $lstData = json_encode($lstData);
    
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header('Content-type: application/json; charset=utf-8');
    header("Content-type: text/x-json");
    echo $lstData;
}
?>
