<?php
    require_once(PATH_CONTROLADOR_DAO . "/IntranetDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/SistemaDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/UsuarioDAO.php");
    require_once(PATH_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    require_once(PATH_LIB . '/functions.php');
    function EjecutaLN() 
    {
        $lCollection = Collection::Singleton();
        ValidaSession();

        $usuariosession = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
        
        //LISTADO DE CUMPLES
        $Fecha  = date("d/m/Y");
        $Year   = date("Y");
        $Mes    = date("m");
        $Rango1 = " WHERE A.rownum BETWEEN 1 AND 3";
        $objUsuarioDAO  = new UsuarioDAO();
        $lstUsuarios1   = array();
        $Script         = " and (month(PerFecNacimiento) = $Mes and CONVERT(VARCHAR(5), PerFecNacimiento,103)+'/$Year' >= '$Fecha')";
        $lstParametrosR1            = array();
        $lstParametrosR1['Script']  = $Script;
        $lstParametrosR1['Rango']   = $Rango1;
        $procedure_paramsRS1 = array(
              array(&$lstParametrosR1['Script'], SQLSRV_PARAM_IN)
            , array(&$lstParametrosR1['Rango'], SQLSRV_PARAM_IN)
        );
        $objUsuarioDAO->VerificaCumpleUsuarios($lstUsuarios1, $procedure_paramsRS1);
        
        //LISTADO DE SISTEMAS
        $lstSistemas     = array();
        $objSistemasDAO  = new SistemaDAO();
        $objSistemasDAO->ListadoSistemasUsuarios($lstSistemas, $usuariosession);
        
        $objIntranetDAO  = new IntranetDAO();
        
        //LISTADO DE NOTICIAS
        $lstNoticias     = array();
        $lstParametrosN                          = array();
        $lstParametrosN['Top']                   = 3;
        $lstParametrosN['PCODIGO']               = str_repeat("\0", 100);
        $lstParametrosN['PMENSAJE']              = str_repeat("\0", 200);
        $procedure_paramsN = array(
            array(&$lstParametrosN['Top'], SQLSRV_PARAM_IN)
            , array(&$lstParametrosN['PCODIGO'], SQLSRV_PARAM_OUT)
            , array(&$lstParametrosN['PMENSAJE'], SQLSRV_PARAM_OUT)
        );
        $objIntranetDAO->ListaNoticia($lstNoticias,$procedure_paramsN);
        
        //LISTADO DE COMUNICADOS PANTALLA PRINCIPAL
        $lstComunicadosPrincipal    = array();
        $objIntranetDAO->ListaComunicadoPrincipal($lstComunicadosPrincipal);
        
        //LISTADO DE COMUNICADOS PANTALLA PRINCIPAL
        $lstComunicados   = array();
        $lstParametrosCM                          = array();
        $lstParametrosCM['Top']                   = 2;
        $lstParametrosCM['PCODIGO']               = str_repeat("\0", 100);
        $lstParametrosCM['PMENSAJE']              = str_repeat("\0", 200);
        $procedure_paramsCM = array(
            array(&$lstParametrosCM['Top'], SQLSRV_PARAM_IN)
            , array(&$lstParametrosCM['PCODIGO'], SQLSRV_PARAM_OUT)
            , array(&$lstParametrosCM['PMENSAJE'], SQLSRV_PARAM_OUT)
        );
        $objIntranetDAO->ListaComunicados($lstComunicados,$procedure_paramsCM);
        
        //LISTADO DE ENLACES
        $lstEnlaces      = array();
        $objIntranetDAO->ListaEnlace($lstEnlaces);
        
        //PASADA DE PARAMETROS
        $lCollection->Add('lstCumples1', $lstUsuarios1);
        $lCollection->Add('lstSistemas', $lstSistemas);
        $lCollection->Add('lstNoticias', $lstNoticias);
        $lCollection->Add('lstEnlaces', $lstEnlaces);
        $lCollection->Add('lstComunicadosPrincipal', $lstComunicadosPrincipal);
        $lCollection->Add('lstComunicados', $lstComunicados);
    }
?>