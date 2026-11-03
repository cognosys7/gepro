<?php

    require_once(PATH_CONTROLADOR_DAO . "/UsuarioDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/PersonaDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/CatalogoDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/ReniecDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/UnidadOrganicaDAO.php");
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(RECURSOSGEN_LIB . '/Fechas.php');
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    require_once(PATH_LIB . '/util.php');
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "Usuarios";
        $PermisoOK        = 0;
        $Buscado          = 0;
        $EncontradoU      = 0;
        $modificar        = 0;
                
        //OBTENGOS LOS POST ANTIREFRESH
        if (!empty($_POST['Tabs'])) {       $tabs = $_POST['Tabs'];} else { $tabs = 0;}
        if (!empty($_POST['Mensaje'])) {    $mensaje = $_POST['Mensaje'];} else { $mensaje = 0;}
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
        
        //OBTENGO LOS POST DEL FORMULARIO
        $Action               = isset($_POST['ActionForm']) ? htmlspecialchars($_POST['ActionForm']) : "";
        $Codigo               = isset($_POST['Codigo']) ? htmlspecialchars($_POST['Codigo']) : 0; //CODIGO DE USUARIO
        $CodigoP              = isset($_POST['CodigoP']) ? htmlspecialchars($_POST['CodigoP']) : 0; //CODIGO DE PERSONA
        $CodigoT              = isset($_POST['CodigoT']) ? htmlspecialchars($_POST['CodigoT']) : 0; //CODIGO DE PERSONAL
        $TipBusk              = isset($_POST['TipBusk']) ? htmlspecialchars($_POST['TipBusk']) : 0;
        $TipDocumBusqueda     = isset($_POST['TipDocumBusqueda']) ? htmlspecialchars($_POST['TipDocumBusqueda']) : 0;
        $DniBusqueda          = isset($_POST['DniBusqueda']) ? htmlspecialchars($_POST['DniBusqueda']) : "";
        
        //POST PARA VISITA NO PROGRAMADA
        $TipoDocumentoRecep   = isset($_POST['TipoDocumentoRecep']) ? htmlspecialchars($_POST['TipoDocumentoRecep']) : "";
        $NumDocumentoRecep    = isset($_POST['NumDocumentoRecep']) ? htmlspecialchars($_POST['NumDocumentoRecep']) : "";
        $ApellidosPRecep      = isset($_POST['ApellidosPRecep']) ? htmlspecialchars($_POST['ApellidosPRecep']) : "";
        $ApellidosMRecep      = isset($_POST['ApellidosMRecep']) ? htmlspecialchars($_POST['ApellidosMRecep']) : "";
        $NombresRecep         = isset($_POST['NombresRecep']) ? htmlspecialchars($_POST['NombresRecep']) : "";
        $fechaNacimiento      = isset($_POST['fechaNacimiento']) ? htmlspecialchars($_POST['fechaNacimiento']) : "";
        $usuLDAP              = isset($_POST['usuLDAP']) ? htmlspecialchars($_POST['usuLDAP']) : "";
        $cboUOrganica         = isset($_POST['cboUOrganica']) ? htmlspecialchars($_POST['cboUOrganica']) : "";
        $sexo                 = isset($_POST['sexo']) ? htmlspecialchars($_POST['sexo']) : "";
        
        //LLAMO AL DAO DE LA SEGURIDAD
        $PermisosPerfil         = CallNomPerfil($perfilsession);
        if (($PermisosPerfil == "ADMINISTRADOR" OR $PermisosPerfil == "GESTOR DE USUARIOS"))
        {
            $PermisoOK = 1;
        }
        
        if ($PermisoOK == 1)
        {
            //OBTENGO LOS TIPOS DE DOCUMENTOS
            $lstCatalogo1     = array();
            $lstCatalogo2     = array();
            $lstCatalogo3     = array();
            $lstCatalogo4     = array();
            $objCatalogoDAO   = new CatalogoDAO();
            $objCatalogoDAO->VerificaCatalogoNombre($lstCatalogo1,"INFORMACION GENERAL");
            $Grupo            = $lstCatalogo1[0]->CatGrupo;
            //LISTADO DE TIPOS DE DOCUMENTOS
            $objCatalogoDAO->VerificaCatalogoNombreGrupo($lstCatalogo2,$Grupo,"TIPOS DE DOCUMENTOS DE IDENTIDAD");
            $SubGrupo         = $lstCatalogo2[0]->CatSubGrupo;
            $objCatalogoDAO->ListaCatalogoGrupoSubGrupo($lstCatalogo3,$Grupo,$SubGrupo);
            //OBTENGO EL ESTADO INICIAL
            $objCatalogoDAO->VerificaCatalogoNombreSubGrupo($lstCatalogo4,$Grupo,$SubGrupo,"DOCUMENTO  NACIONAL DE IDENTIDAD");
            $DNIVal           = $lstCatalogo4[0]->IdCatalogo;
            
            /* FLEXIGRID */
            $ScriptFLX = " ";
            if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'LoadJsonList')) 
            {
                $lDato       = array();
                $oUsuarioDAO = new UsuarioDAO();
                if($_POST['query']<>'%')
                {
                    if(strlen(trim($_POST['query'])) > 0)
                    {
                        $lFiltro = " AND ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ".$ScriptFLX;
                    }
                    else
                    {
                        $lFiltro  = "";
                    }
                } 
                else
                {
                    $lFiltro  = "";
                }
                //LLAMO AL CONTADOR
                //PARAMETRO PARA CONTADOR
                $lParametroP                    = array();
                $lParametroP['Script']          = $lFiltro;
                $procedure_paramsP = array(
                      array(&$lParametroP['Script'], SQLSRV_PARAM_IN)
                );
                $oUsuarioDAO->CuentaUsuarios($lDato, $procedure_paramsP);
                $nTotal = $lDato[0]->idusuario;
                GenerarDatosParaFlexigridSP($oUsuarioDAO, 'ListaUsuarios',$nTotal, $_POST['page'],$lFiltro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']);
                exit;
            }           

            //OBTENGO UN LISTADO DE LOS SISTEMAS Y MODULOS
            $lstUOrganica     = array();
            $objUnidadOrganicaDAO   = new UnidadOrganicaDAO();
            $objUnidadOrganicaDAO->ListaUnidadOrganica($lstUOrganica);
            
            //DATOS PARA LA BUSK FORM
            $lstBuskPersonaForm                 = array();
            $objPersonaDAO                      = new PersonaDAO();
            
            //PASO DE VARIABLES POR DEFECTO
            $PerApePaterno      = "";
            $PerApeMaterno      = "";
            $PerNombres         = "";
            $PerSexo            = "";
            $PerFecNacimiento   = "";
            $PerDocumento       = "";
            $PerNroDocumento    = "";
            $UorNombre          = "";
            $usuldap            = "";
            $prhunidadorganica  = "";
            
            if ($Action == "BuscarVisitaForm")
            {
                $tabs                           = 1;
                $Buscado                        = 1;
                //BUSCO POR LOS FORMS SELECCIONADOS
                if ($TipBusk == 1)
                {
                    //BUSCO POR LOS DATOS DE LA PERSONA
                    $lstBuskPersonaForm          = array();
                    //PARAMETRO PARA PERSONA
                    $lParametroP                 = array();
                    $lParametroP['Documento']    = $TipDocumBusqueda;
                    $lParametroP['NroDocumento'] = $DniBusqueda;
                    $procedure_paramsP = array(
                          array(&$lParametroP['Documento'], SQLSRV_PARAM_IN)
                        , array(&$lParametroP['NroDocumento'], SQLSRV_PARAM_IN)
                    );
                    //CIERRE DE PARAMETRO
                    
                    $objPersonaDAO->VerificaDatosPersona($lstBuskPersonaForm, $procedure_paramsP);
                    $listaPersonas  = count($lstBuskPersonaForm) > 0 ? true : false;
                    if (($listaPersonas == true) || ($listaPersonas > 0)) 
                    {
                        $CodigoP               = $lstBuskPersonaForm[0]->IdPersona;
                        $PerApePaterno         = $lstBuskPersonaForm[0]->PerApePaterno;
                        $PerApeMaterno         = $lstBuskPersonaForm[0]->PerApeMaterno;
                        $PerNombres            = $lstBuskPersonaForm[0]->PerNombres;
                        $PerSexo               = $lstBuskPersonaForm[0]->PerSexo;
                        if (strlen($lstBuskPersonaForm[0]->PerFecNacimiento)>0)
                        {
                            $PerFecNacimiento  = $lstBuskPersonaForm[0]->PerFecNacimiento;
                        }
                        else
                        {
                            $PerFecNacimiento  = "";
                        }
                        $PerDocumento          = $lstBuskPersonaForm[0]->PerDocumento;
                        $PerNroDocumento       = $lstBuskPersonaForm[0]->PerNroDocumento;
                        
                        //VERIFICO SI SE TIENE EN LA TABLA IDUSUARIO
                        $lstUsuario            = array();
                        $objUsuarioDAO         = new UsuarioDAO();
                        //LLAMO A LOS PARAMETROS
                        $lParametroU           = array();
                        $lParametroU['IdPersona']    = $CodigoP;
                        $procedure_paramsU     = array(
                            array(&$lParametroU['IdPersona'], SQLSRV_PARAM_IN)
                        );
                        $objUsuarioDAO->VerificaUsuarioIdPersonaSelect($lstUsuario,$procedure_paramsU);
                        $listaPersonasUser  = count($lstUsuario) > 0 ? true : false;
                        if (($listaPersonasUser == true) || ($listaPersonasUser > 0)) 
                        {
                            $EncontradoU        = 1;
                            $UorNombre          = $lstUsuario[0]->UorNombre;
                            $usuldap            = $lstUsuario[0]->usuldap;
                        }
                        else
                        {
                            $EncontradoU        = 0;
                            $UorNombre          = "";
                        }
                    }
                    else
                    {
                        if ($DNIVal == $TipDocumBusqueda)
                        {
                            //BUSCO POR RENIEC
                            //BUSCO POR LOS DATOS DE LA PERSONA EN RENIEC
                            $lstPersona                 = array();
                            $lstBuskPersonaFormReniec   = array();
                            $lParametroPR               = array();
                            $objReniecDAO               = new ReniecDAO();
                            $lParametroPR['DNI']        = $DniBusqueda;
                            $procedure_paramsPR = array(
                                  array(&$lParametroPR['DNI'], SQLSRV_PARAM_IN)
                            );
                            $objReniecDAO->VerificaDNIReniec($lstBuskPersonaFormReniec, $procedure_paramsPR);
                            $listaPersonasR  = count($lstBuskPersonaFormReniec) > 0 ? true : false;
                            if (($listaPersonasR == true) || ($listaPersonasR > 0)) 
                            {
                                $DNIR               = $lstBuskPersonaFormReniec[0]->Dni;
                                $ApepR              = $lstBuskPersonaFormReniec[0]->ApellidoPaterno;
                                $ApemR              = $lstBuskPersonaFormReniec[0]->ApellidoMaterno;
                                $NomR               = $lstBuskPersonaFormReniec[0]->Nombres;
                                $FechaNR            = date_format($lstBuskPersonaFormReniec[0]->FechaNacimiento, 'd-m-Y');
                                $SexoR              = $lstBuskPersonaFormReniec[0]->Sexo;

                                if ($SexoR == 2)
                                {
                                    $SexoR = 0;
                                }
                                //REGISTRO EN LA TABLA DE TGPERSONA
                                //PARAMETRO PARA PERSONA
                                $lParametroP                    = array();
                                $lParametroP['TipoDocumento']   = $DNIVal;
                                $lParametroP['NroDocumento']    = $DNIR;
                                $lParametroP['ApellidoP']       = $ApepR;
                                $lParametroP['ApellidoM']       = $ApemR;
                                $lParametroP['Nombre']          = $NomR;
                                $lParametroP['UsuarioReg']      = $usuario;
                                $lParametroP['FechaNacim']      = $FechaNR;
                                $lParametroP['Sexo']            = $SexoR;
                                $lParametroP['CODPERSONA']      = str_repeat("\0", 100);
                                $lParametroP['PCODIGO']         = str_repeat("\0", 100);
                                $lParametroP['PMENSAJE']        = str_repeat("\0", 200);
                                $procedure_paramsP = array(
                                      array(&$lParametroP['TipoDocumento'], SQLSRV_PARAM_IN)
                                    , array(&$lParametroP['NroDocumento'], SQLSRV_PARAM_IN)
                                    , array(&$lParametroP['ApellidoP'], SQLSRV_PARAM_IN)
                                    , array(&$lParametroP['ApellidoM'], SQLSRV_PARAM_IN)
                                    , array(&$lParametroP['Nombre'], SQLSRV_PARAM_IN)
                                    , array(&$lParametroP['UsuarioReg'], SQLSRV_PARAM_IN)
                                    , array(&$lParametroP['FechaNacim'], SQLSRV_PARAM_IN)
                                    , array(&$lParametroP['Sexo'], SQLSRV_PARAM_IN)
                                    , array(&$lParametroP['CODPERSONA'], SQLSRV_PARAM_OUT)
                                    , array(&$lParametroP['PCODIGO'], SQLSRV_PARAM_OUT)
                                    , array(&$lParametroP['PMENSAJE'], SQLSRV_PARAM_OUT)
                                );
                                $objPersonaDAO->InsertaPersonadeReniec($lstPersona, $procedure_paramsP);
                                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Aform=BuscarVisitaForm&TBusk=1&TDoc=".$DNIVal."&NDoc=".$DNIR); 
                                exit;
                            }
                            else
                            {
                                $EncontradoU = 0;
                            }
                        }
                        else
                        {
                            $EncontradoU = 0;
                        }
                    }
                }
            }
            
            if ($Action == "RegistraUsuario")
            {
                $lstUsuario      = array();
                $objUsuarioDAO   = new UsuarioDAO();

                //CLAVE DE USUARIO
                $Clave           = md5($NumDocumentoRecep.$NumDocumentoRecep.'Cognosys@SAC');
                
                $tabs = 0;
                //PARAMETRO PARA REGISTRO DE SISTEMA
                $lParametroS                        = array();
                $lParametroS['CodigoP']             = $CodigoP;
                $lParametroS['TipoDocumentoRecep']  = $TipoDocumentoRecep;
                $lParametroS['NumDocumentoRecep']   = $NumDocumentoRecep;
                $lParametroS['ApellidosPRecep']     = $ApellidosPRecep;
                $lParametroS['ApellidosMRecep']     = $ApellidosMRecep;
                $lParametroS['NombresRecep']        = $NombresRecep;
                $lParametroS['ClaveUsuario']        = $Clave;
                $lParametroS['sexo']                = $sexo;
                $lParametroS['fechaNacimiento']     = cambiafecha($fechaNacimiento);
                $lParametroS['usuLDAP']             = $usuLDAP;
                $lParametroS['cboUOrganica']        = $cboUOrganica;
                $lParametroS['Usuario']             = $usuario;
                $lParametroS['PCODIGO']             = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']            = str_repeat("\0", 200);
                $procedure_paramsP = array(
                      array(&$lParametroS['CodigoP'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['TipoDocumentoRecep'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['NumDocumentoRecep'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['ApellidosPRecep'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['ApellidosMRecep'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['NombresRecep'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['ClaveUsuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['sexo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['fechaNacimiento'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['usuLDAP'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['cboUOrganica'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );// var_dump($lParametroS); exit;
                $objUsuarioDAO->InsertaUsuarioPersonal($lstUsuario, $procedure_paramsP);
                $mensaje = $procedure_paramsP[12][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }

            if ($Action == "ActualizaUsuario")
            {
                $lstUsuario      = array();
                $objUsuarioDAO   = new UsuarioDAO();
                $tabs = 0;
                //PARAMETRO PARA REGISTRO DE SISTEMA
                $lParametroS                        = array();
                $lParametroS['Codigo']              = $Codigo;
                $lParametroS['CodigoP']             = $CodigoP;
                $lParametroS['CodigoT']             = $CodigoT;
                
                $lParametroS['ApellidosPRecep']     = $ApellidosPRecep;
                $lParametroS['ApellidosMRecep']     = $ApellidosMRecep;
                $lParametroS['NombresRecep']        = $NombresRecep;
                $lParametroS['sexo']                = $sexo;
                
//                if (strlen($fechaNacimiento)>0)
//                {
                    $lParametroS['fechaNacimiento'] = cambiafecha($fechaNacimiento);
//                }
//                else
//                {
//                    $lParametroS['fechaNacimiento'] = "";
//                }
                    
                $lParametroS['usuLDAP']             = $usuLDAP;
                $lParametroS['cboUOrganica']        = $cboUOrganica;
                $lParametroS['Usuario']             = $usuario;
                $lParametroS['PCODIGO']             = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']            = str_repeat("\0", 200);
                $procedure_paramsP = array(
                      array(&$lParametroS['Codigo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['CodigoP'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['CodigoT'], SQLSRV_PARAM_IN)
                    
                    , array(&$lParametroS['ApellidosPRecep'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['ApellidosMRecep'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['NombresRecep'], SQLSRV_PARAM_IN)
                    
                    , array(&$lParametroS['sexo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['fechaNacimiento'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['usuLDAP'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['cboUOrganica'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                ); //var_dump($lParametroS); exit;
                $objUsuarioDAO->ActualizaUsuarioPersonal($lstUsuario, $procedure_paramsP);
                $mensaje = $procedure_paramsP[8][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }
            
            if ($Action == "EliminaUsuario")
            {
                $lstUsuario      = array();
                $objUsuarioDAO   = new UsuarioDAO();
                //SE ACTUALIZA
                $tabs    = 0;
                //PARAMETRO PARA INSTITUCION
                $lParametroS                    = array();
                $lParametroS['Codigo']          = $Codigo;
                $lParametroS['CodigoT']          = $CodigoT;
                $lParametroS['Usuario']         = $usuario;
                $lParametroS['PCODIGO']         = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']        = str_repeat("\0", 200);
                $procedure_paramsP = array(
                      array(&$lParametroS['Codigo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['CodigoT'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objUsuarioDAO->EliminaUsuarioPersonal($lstUsuario, $procedure_paramsP);
                $mensaje = $procedure_paramsP[3][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }
            
            if ($Action == "ReiniciaClave")
            {
                $lstUsuario      = array();
                $objUsuarioDAO   = new UsuarioDAO();
                //SE ACTUALIZA
                $tabs    = 0;
                //PARAMETRO PARA INSTITUCION
                $lParametroS                    = array();
                $lParametroS['Codigo']          = $Codigo;
                $lParametroS['Usuario']         = $usuario;
                $lParametroS['PCODIGO']         = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']        = str_repeat("\0", 200);
                $procedure_paramsP = array(
                      array(&$lParametroS['Codigo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objUsuarioDAO->ReiniciaClave($lstUsuario, $procedure_paramsP);
                $mensaje = $procedure_paramsP[2][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }

            if ($Action == "ModificaUsuario")
            {
                $tabs           = 1;
                $modificar      = 1;
                
                $lParametroP                = array();
                $objUsuarioDAO              = new UsuarioDAO();
                $lParametroP['IdUsuario']    = $Codigo;
                $procedure_paramsP = array
                (
                      array(&$lParametroP['IdUsuario'], SQLSRV_PARAM_IN)
                );
                $lstUsuario       = array();
                $objUsuarioDAO->VerificaUsuarioSelect($lstUsuario,$procedure_paramsP);
                $listaPerfil  = count($lstUsuario) > 0 ? true : false;
                if (($listaPerfil == true) || ($listaPerfil > 0)) 
                {
                    $Codigo                = $lstUsuario[0]->idusuario;
                    $CodigoP               = $lstUsuario[0]->IdPersona;
                    $CodigoT               = $lstUsuario[0]->idpersonal;
                    $PerApePaterno         = $lstUsuario[0]->PerApePaterno;
                    $PerApeMaterno         = $lstUsuario[0]->PerApeMaterno;
                    $PerNombres            = $lstUsuario[0]->PerNombres;
                    $PerSexo               = $lstUsuario[0]->PerSexo;
                    if (strlen($lstUsuario[0]->PerFecNacimiento)>0)
                    {
                        $PerFecNacimiento  = $lstUsuario[0]->PerFecNacimiento;
                    }
                    else
                    {
                        $PerFecNacimiento  = "";
                    }
                    $TipDocumBusqueda      = $lstUsuario[0]->PerDocumento;
                    $DniBusqueda           = $lstUsuario[0]->PerNroDocumento;
                    $usuldap               = $lstUsuario[0]->usuldap;
                    $prhunidadorganica     = $lstUsuario[0]->prhunidadorganica;
                }
            }
            
            //ENVIO LA LISTA DE UNIDADES ORGANICAS
            $lCollection->Add('lstUOrganica', $lstUOrganica);
            //ENVIO LOS DATOS DE BUSQUEDA DE FORMULARIO PRINCIPAL
            $lCollection->Add('CodigoP', $CodigoP);
            $lCollection->Add('CodigoT', $CodigoT);
            $lCollection->Add('PerApePaterno', $PerApePaterno);
            $lCollection->Add('PerApeMaterno', $PerApeMaterno);
            $lCollection->Add('PerNombres', $PerNombres);
            $lCollection->Add('PerSexo', $PerSexo);
            $lCollection->Add('PerFecNacimiento', $PerFecNacimiento);
            $lCollection->Add('PerDocumento', $PerDocumento);
            $lCollection->Add('PerNroDocumento', $PerNroDocumento);
            $lCollection->Add('UorNombre', $UorNombre);
            $lCollection->Add('usuldap', $usuldap);
            $lCollection->Add('prhunidadorganica', $prhunidadorganica);
            //ENVIO EL LISTADO DE TIPO DE DOCUMENTOS
            $lCollection->Add('lstTipoDocumentos', $lstCatalogo3);
            
            //ENVIO EL VALOR DEL DNI
            $lCollection->Add('DNIVal', $DNIVal);
            
            //ENVIO LOS VALORES DEL FORM
            $lCollection->Add('Buscado', $Buscado);
            $lCollection->Add('EncontradoU', $EncontradoU);
            $lCollection->Add('TipBusk', $TipBusk);
            $lCollection->Add('TipDocumBusqueda', $TipDocumBusqueda);
            $lCollection->Add('DniBusqueda', $DniBusqueda);
            $lCollection->Add('modificar', $modificar);
        }
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('Tabs', $tabs);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('Codigo', $Codigo);
        $lCollection->Add('PermisoOK', $PermisoOK);
        
    }
?>