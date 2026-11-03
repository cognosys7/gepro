<?php
    require_once(PATH_CONTROLADOR_DAO . "/UsuarioDAO.php");
    require_once(PATH_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    require_once(PATH_LIB . '/functions.php');
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection        = Collection::Singleton();
        $PaginaFormulario   = "Cumples";
        
        $Year   = date("Y");
        $Mes    = date("m");
        if ($Mes == 12)
        {
            $Mes2 = 1; 
        }
        else
        {
            $Mes2 = $Mes + 1;
        }
        $Fecha  = date("d/m/Y");
        $objUsuarioDAO  = new UsuarioDAO();
        $lstUsuarios    = array();
        $Script         = "(month(PerFecNacimiento) = $Mes or month(PerFecNacimiento) = $Mes2) and CONVERT(VARCHAR(5), PerFecNacimiento,103)+'/$Year' >= '$Fecha'";
        $lstParametrosR            = array();
        $lstParametrosR['Script']   = $Script;
        $procedure_paramsRS = array(
              array(&$lstParametrosR['Script'], SQLSRV_PARAM_IN)
        );
        $objUsuarioDAO->VerificaCumpleUsuarios2($lstUsuarios, $procedure_paramsRS);
        
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('lstCumples', $lstUsuarios);
    }
?>