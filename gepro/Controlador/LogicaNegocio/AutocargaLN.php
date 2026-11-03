<?php
require_once(PATH_CONTROLADOR_DAO . "/InstitucionDAO.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . '/util.php');
function EjecutaLN() 
{
    ValidaSession();
    //MUESTRA LAS INSTITUCIONES
    if ((isset($_REQUEST["Accion"])) && (trim($_REQUEST["Accion"]) == "LoadCompInstitucionAjax")) 
    {
        $lstAjax                        = array();
        $items[]                        = array();
        //INICIO DE PARAMETRO CONTADOR
        $lParametroP                    = array();
        $lParametroP['Institucion']     = strtolower($_GET["term"]);
        $procedure_paramsP = array(
              array(&$lParametroP['Institucion'], SQLSRV_PARAM_IN)
        );
        $objAjaxDAO  = new InstitucionDAO();
        $objAjaxDAO->VerficaInstitucionAutocomplate($lstAjax,$procedure_paramsP);
        $contarVDF = count($lstAjax) > 0 ? true : false;
        if (($contarVDF == true) || ($contarVDF > 0))
        {
            foreach ($lstAjax as $objEmpAjax) 
            {
                $Codigo     = $objEmpAjax->IdInstitucion;
                $Dato1      = $objEmpAjax->InsNombre;
                $Dato2      = $objEmpAjax->InsAbreviatura;
                $Descripcion = $Dato1." ".$Dato2;
                array_push($items,array("id"=>$Codigo,"label"=>$Descripcion,"value"=>$Descripcion));
            }
        }
        echo json_encode($items);
    }
    exit;
}
?>