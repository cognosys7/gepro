<?php
require_once(SEG_CONTROLADOR_DAO . "/SeguridadDAO.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(PATH_LIB . '/util.php');

/*ESTO PARA LOS MODULOS GENERALES*/
function ValidaSession() 
{
    $lCollection        = Collection::Singleton();
    $usuariosession     = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
    //$usuariosession == 460;
    if ($usuariosession == "") 
    {
        //header("Location:".INTRANET."/");
        //exit;
        ?>
        <script language="JavaScript" type="text/javascript">
            top.window.location='<?php echo INTRANET."/";?>';
        </script>
    <?php
    }
    else
    {
        //----------------------------------------------LLAMO AL DAO DE LA SEGURIDAD
        $objSeguridadDAO      = new SeguridadSegDAO();

        $lstUsuario           = array();
        //LLAMO A LOS PARAMETROS
        $lParametroU          = array();
        $lParametroU['IdUsuario']    = $usuariosession;
        $procedure_paramsU    = array(
            array(&$lParametroU['IdUsuario'], SQLSRV_PARAM_IN)
        );
        $objSeguridadDAO->VerificaUsuarioSelect($lstUsuario,$procedure_paramsU);
        $DatosPersona         = $lstUsuario[0]->Usuario; 
        
        $lstSistema           = array();
        //LLAMO A LOS PARAMETROS
        $lParametroS          = array();
        $lParametroS['nomSistema']    = NOMBRESISTEMA;
        $procedure_paramsS    = array(
            array(&$lParametroS['nomSistema'], SQLSRV_PARAM_IN)
        );
        $objSeguridadDAO->VerificaSistemaActual($lstSistema, $procedure_paramsS);
        $CodSistema           =  $lstSistema[0]->IdSistema; 
        
        
        //----------------------------------------------LLAMO AL DAO DEL PERFIL
        $lstPerfil            = array();
        //LLAMO A LOS PARAMETROS
        $lParametroP          = array();
        $lParametroP['IdUsuario']    = $usuariosession;
        $lParametroP['IdSistema']    = $CodSistema;
        $procedure_paramsP    = array(
            array(&$lParametroP['IdUsuario'], SQLSRV_PARAM_IN),
            array(&$lParametroP['IdSistema'], SQLSRV_PARAM_IN)
        );
        $objSeguridadDAO->VerificaUsuarioPerfil($lstPerfil, $procedure_paramsP);
        $CodigoPerfil         =  $lstPerfil[0]->upsperfil;
        $CodigoModulo         =  $lstPerfil[0]->pefmodulo;
        
        $_SESSION['CodSistema']= $CodSistema;
        if ($CodigoPerfil <> 0)
        {
            $_SESSION['CodPerfil']= $CodigoPerfil;
        }
        
        $lCollection->Add('DatosPersona', $DatosPersona);
        $lCollection->Add('CodigoPerfil', $CodigoPerfil);
        $lCollection->Add('CodigoModulo', $CodigoModulo);
    }
}

function ValidaSession2() 
{
    $usuariosession = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
    if ($usuariosession != "") 
    {
        header("Location:".MAINPROY."/Vista/mainpage.php");
        exit;
    }
}

/*CONSTRUYO EL MENU DEL SISTEMA*/
function GeneraMenus($Modulo,$Nivel,$Opcion) 
{
    //LLAMO AL DAO DE LA SEGURIDAD
    $objSeguridadDAO  = new SeguridadSegDAO();
    $lstMenus    = array();
    if ($Nivel == 1)
    {
        $Script = " and OpcModulo = $Modulo and OpcNivel = 1";
    }
    if ($Nivel == 2)
    {
        $Script = " and OpcModulo = $Modulo and OpcNivel = 2 and OpcPadre = '$Opcion'";
    }
    if ($Nivel == 3)
    {
        $Script = " and OpcModulo = $Modulo and IdOpcion = '$Opcion'";
    }
    //LLAMO A LOS PARAMETROS
    $lParametroO          = array();
    $lParametroO['Script']    = $Script;
    $procedure_paramsO    = array(
        array(&$lParametroO['Script'], SQLSRV_PARAM_IN)
    );
    $objSeguridadDAO->ListaMenus($lstMenus, $procedure_paramsO);
    return $lstMenus;
}

/*VERIFICO LOS ACCESOS AL MENU DEL SISTEMA*/
function VerificaAccesoMenu($Opcion,$Perfil) 
{
    //LLAMO AL DAO DE LA SEGURIDAD
    $objSeguridadDAO    = new SeguridadSegDAO();
    $lstAcceso          = array();
    //LLAMO A LOS PARAMETROS
    $lParametroA        = array();
    $lParametroA['IdOpcion']    = $Opcion;
    $lParametroA['IdPerfil']    = $Perfil;
    $procedure_paramsA  = array(
        array(&$lParametroA['IdOpcion'], SQLSRV_PARAM_IN),
        array(&$lParametroA['IdPerfil'], SQLSRV_PARAM_IN)
    );
    $objSeguridadDAO->VerificaAccesoOpcionPerfil($lstAcceso,$procedure_paramsA);
    $listaAcceso  = count($lstAcceso) > 0 ? true : false;
    if (($listaAcceso == true) || ($listaAcceso > 0)) {
        $valor = 1;
    }
    else
    {
        $valor = 0;
    }
    return $valor;
}

function CallNomPerfil($Codigo)
{
    $lstLista      = array();
    $objetoDAO     = new SeguridadSegDAO();
    //LLAMO A LOS PARAMETROS
    $lParametroP        = array();
    $lParametroP['IdPerfil']    = $Codigo;
    $procedure_paramsP  = array(
        array(&$lParametroP['IdPerfil'], SQLSRV_PARAM_IN)
    );
    $objetoDAO->VerificaPerfilxID($lstLista,$procedure_paramsP);
    $listaResult   = count($lstLista) > 0 ? true : false;
    if (($listaResult == true) || ($listaResult > 0)) 
    {
        $Resultado = $lstLista[0]->pefnombre;
    }
    else
    {
        $Resultado = "";
    }
    return $Resultado;
}
?>