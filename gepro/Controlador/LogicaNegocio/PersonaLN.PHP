<?php
    require_once(PATH_CONTROLADOR_DAO . "/PersonaDAO.php");
    require_once(RECURSOSGEN_LIB . "/Fechas.php");
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    //require_once(RECURSOSGEN_LIB . "/util.php");
    //require_once(PATH_LIB . '/util.php');    
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    /*AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES*/
    require_once(PATH_CONTROLADOR_DAO . "/UbigeoDAO.php");
    
    
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "Persona";
        $PermisoOK        = 0;

        //OBTENGOS LOS POST ANTIREFRESH
        if (!empty($_POST['Mensaje'])) {    $mensaje = $_POST['Mensaje'];} else { $mensaje = 0;}
        
        //OBTENGO LAS SESIONES
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
        
        //OBTIENE LOS PERMISOS Y NIVELES DE ACCESO
        $PermisosPerfil         = CallNomPerfil($perfilsession);        
        //VERIFICA EL ACCESO
        if (($PermisosPerfil == "ADMINISTRADOR") || ($PermisosPerfil == "MACRO 1 - 8") || ($PermisosPerfil == "MACRO INVITADO") || ($PermisosPerfil == "MACRO 2") || ($PermisosPerfil == "MACRO 3") || ($PermisosPerfil == "MACRO 4")                 || ($PermisosPerfil == "MACRO 5") || ($PermisosPerfil == "MACRO 6") || ($PermisosPerfil == "MACRO 7") || ($PermisosPerfil == "MACRO 8") || ($PermisosPerfil == "MACRO 9"))
        {
            $PermisoOK = 1;
        }
        
        if ($PermisoOK == 1)       {
            /*******************************************************************
             *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS
            /*******************************************************************/             
            //ACCIONES PARA EL FORMULARIO
            $Action             = isset($_REQUEST['ActionForm'])? VerificarInputs($_REQUEST['ActionForm']) : "";
            $ActionFlex         = isset($_REQUEST['Accion'])? VerificarInputs($_REQUEST['Accion']) : "";            
            /*******************************************************************
             *     RECUPERACION DE DATOS DEL FORMULARIO
            /*******************************************************************/ 
            $SeleccionarID          =   isset($_REQUEST['SeleccionarID'])? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
            $Departamento           =   isset($_REQUEST['Departamento'])? VerificarInputs($_REQUEST['Departamento']) : "";
            $Provincia              =   isset($_REQUEST['Provincia'])? VerificarInputs($_REQUEST['Provincia']) : "";
            $Distrito               =   isset($_REQUEST['Distrito'])? VerificarInputs($_REQUEST['Distrito']) : "";
            $Nombre                 =   isset($_REQUEST['Nombre'])? VerificarInputs($_REQUEST['Nombre']) : "";
            $Descipcion             =   isset($_REQUEST['Descipcion'])? VerificarInputs($_REQUEST['Descipcion']) : "";
            $Sexo                   =   isset($_REQUEST['Sexo'])? VerificarInputs($_REQUEST['Sexo']) : "";
            $Estudios               =   isset($_REQUEST['Estudios'])? VerificarInputs($_REQUEST['Estudios']) : "";
            $FechaNacimiento        =   isset($_REQUEST['FechaNacimiento'])? VerificarInputs($_REQUEST['FechaNacimiento']) : "";
            $FechaHoraRegistro      =   isset($_REQUEST['FechaHoraRegistro'])? VerificarInputs($_REQUEST['FechaHoraRegistro']) : "";
            /* FLEXIGRID */
            //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
            $ScriptFLX = "";// AND P1.IdProveedor = $fIdProveedor ";
            
            /*******************************************************************
             *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
            /*******************************************************************/ 
            if ($ActionFlex == "LoadJsonList")
            {            
                $lDato      = array();
                $ogridDAO   = new PersonaDAO();    
                $Prueba="ActionFlex";
                if($_POST['query']<>'%')
                {
                    if(strlen(VerificarInputs($_POST['query'])) > 0)
                    {
                        $lFiltro = " AND ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ".$ScriptFLX;
                    }
                    else
                    {
                        $lFiltro  = $ScriptFLX;
                    }
                } 
                else
                {
                    $lFiltro  = $ScriptFLX;
                }             
                $lParametroP                 = array();
                $lParametroP['Script']       = $lFiltro;
                $procedure_paramsP = array(
                      array(&$lParametroP['Script'], SQLSRV_PARAM_IN)
                );
                $ogridDAO->Cuenta($lDato, $procedure_paramsP);
                $nTotal = $lDato[0]->IdPersona;                          
                $lCollection->Add('nTotal', $nTotal);
                
                
                GenerarDatosParaFlexigridSP($ogridDAO, 'Lista',$nTotal, $_POST['page'],$lFiltro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']);
                exit;                
            }
            
            /*******************************************************************
             *        METODO PARA INSERTAR UN REGISTRO 
            /*******************************************************************/ 
            if ($Action == "RegistraDatos")
            {
                /*ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA*/            
                if (strlen($FechaNacimiento)>0)
                {
                    $FechaNacimiento      = cambiafecha($FechaNacimiento);
                }
                else
                {
                    $FechaNacimiento      = "";
                }
                if (strlen($FechaHoraRegistro)>0)
                {
                    $FechaHoraRegistro      = cambiafecha($FechaHoraRegistro);
                }
                else
                {
                    $FechaHoraRegistro      = "";
                }
                /*FIN DE ACTIVACION*/

                $lstPersonaM     = array();
                $objPersonaMDAO  = new PersonaDAO();
                $lstParametrosM   = array();
                $lstParametrosM['Departamento']         = $Departamento;
                $lstParametrosM['Provincia']            = $Provincia;
                $lstParametrosM['Distrito']             = $Distrito;
                $lstParametrosM['Nombre']               = $Nombre;
                $lstParametrosM['Descipcion']           = $Descipcion;            
                $lstParametrosM['Sexo']                 = $Sexo;
                $lstParametrosM['Estudios']             = $Estudios;
                $lstParametrosM['FechaNacimiento']      = $FechaNacimiento;
                $lstParametrosM['FechaHoraRegistro']    = $FechaHoraRegistro;
                $lstParametrosM['PCODIGO']           = str_repeat("\0", 100);
                $lstParametrosM['PMENSAJE']          = str_repeat("\0", 200);
                $procedure_paramsMS = array(
                      array(&$lstParametrosM['Departamento'],       SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Provincia'],          SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Distrito'],           SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Nombre'],             SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Descipcion'],         SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Sexo'],               SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Estudios'],           SQLSRV_PARAM_IN)                
                    , array(&$lstParametrosM['FechaNacimiento'],    SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['FechaHoraRegistro'],  SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Usuario'],            SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['PCODIGO'],            SQLSRV_PARAM_OUT)
                    , array(&$lstParametrosM['PMENSAJE'],           SQLSRV_PARAM_OUT)                
                );
                
                var_dump($procedure_filtrosMS);
                exit;
            
            
                $objPersonaMDAO->Inserta($lstPersonaM, $procedure_paramsMS);
                $CodMensaje = $procedure_paramsMS[10][0];
                $mensaje    = $procedure_paramsMS[11][0];
                $lCollection->Add('CodMensaje', $CodMensaje);
                $lCollection->Add('Mensaje', $mensaje);
            }
            
            /*******************************************************************
             *  METODO MOSTRAR DATOS DE UN REGISTRO EXISTENTE EN EL FORMULARIO
            /*******************************************************************/ 
            //
            //LIMPIANDO LAS VARIABLES DE RECUPERACION DE DATOS        
            //$LfIdProveedor= NULL; //Habilitar cuando la tabla depende de otra superior            
            if ($Action == "ModificarRegistro")
            {                      
                //var_dump($SeleccionarID); 
                $lstPersonaM        = array();  
                $objPersonaMDAO     = new PersonaDAO();
                $lstParametrosM     = array();
                $lstParametrosM['SeleccionarID']       = $SeleccionarID;
                $procedure_paramsMS = array(                  
                      array(&$lstParametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                );            
                $objPersonaMDAO->Selecciona($lstPersonaM, $procedure_paramsMS);
                //var_dump($procedure_paramsMS);
                $listaContador  = count($lstPersonaM) > 0 ? true : false;
                var_dump($listaContador);exit;
                
                
                if (($listaContador == true) || ($listaContador > 0)) 
                {                   
                    //Recuperando Valores del arreglo $lstPersonaM
                    $IdPersona          = $lstPersonaM[0]->IdPersona;
                    $Departamento       = $lstPersonaM[0]->Departamento;
                    $Provincia          = $lstPersonaM[0]->Provincia;
                    $Distrito           = $lstPersonaM[0]->Distrito;
                    $Nombre             = $lstPersonaM[0]->Nombre;                
                    $Descipcion         = $lstPersonaM[0]->Descipcion;
                    $Sexo               = $lstPersonaM[0]->Sexo;
                    $Estudios           = $lstPersonaM[0]->Estudios;
                    $FechaNacimiento    = $lstPersonaM[0]->FechaNacimiento;
                    $FechaHoraRegistro  = $lstPersonaM[0]->FechaHoraRegistro;                    
                }                                    
                $lCollection->Add('SeleccionarID',$SeleccionarID);
                $lCollection->Add('IdPersona', $IdPersona);
                $lCollection->Add('Departamento', $Departamento);
                $lCollection->Add('Provincia', $Provincia);
                $lCollection->Add('Distrito', $Distrito);
                $lCollection->Add('Nombre', $Nombre);
                $lCollection->Add('Descipcion', $Descipcion);
                $lCollection->Add('Sexo',  $Sexo);
                $lCollection->Add('Estudios',  $Estudios);
                $lCollection->Add('FechaNacimiento',  $FechaNacimiento);
                $lCollection->Add('FechaHoraRegistro',  $FechaHoraRegistro);
            } 
            
            /*******************************************************************
             *        METODO PARA ACTUALIZAR UN REGISTRO 
            /*******************************************************************/ 
            if ($Action == "ActualizarForm")
            {                
                /*ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA*/            
                if (strlen($FechaNacimiento)>0)
                {
                    $FechaNacimiento      = cambiafecha($FechaNacimiento);
                }
                else
                {
                    $FechaNacimiento      = "";
                }
                if (strlen($FechaHoraRegistro)>0)
                {
                    $FechaHoraRegistro      = cambiafecha($FechaHoraRegistro);
                }
                else
                {
                    $FechaHoraRegistro      = "";
                }
                //var_dump($FechaHoraRegistro);exit;        
                /*FIN DE ACTIVACION*/
                $lstPersonaM     = array();  
                $objPersonaMDAO  = new PersonaDAO();                
                $lstParametrosM['SeleccionarID']        = $SeleccionarID;
                $lstParametrosM['Departamento']         = $Departamento;
                $lstParametrosM['Provincia']            = $Provincia;
                $lstParametrosM['Distrito']             = $Distrito;
                $lstParametrosM['Nombre']               = $Nombre;
                $lstParametrosM['Descipcion']           = $Descipcion;            
                $lstParametrosM['Sexo']                 = $Sexo;
                $lstParametrosM['Estudios']             = $Estudios;
                $lstParametrosM['FechaNacimiento']      = $FechaNacimiento;
                $lstParametrosM['FechaHoraRegistro']    = $FechaHoraRegistro;
                $lstParametrosM['Usuario']           = $usuario;
                $lstParametrosM['PCODIGO']           = str_repeat("\0", 100);
                $lstParametrosM['PMENSAJE']          = str_repeat("\0", 200);                                
                $procedure_paramsMS = array(
                      array(&$lstParametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Departamento'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Provincia'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Distrito'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Nombre'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Descipcion'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Sexo'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Estudios'], SQLSRV_PARAM_IN)                
                    , array(&$lstParametrosM['FechaNacimiento'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['FechaHoraRegistro'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lstParametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)

                );                        
                $objPersonaMDAO->Actualiza($lstPersonaM, $procedure_paramsMS);            
                $CodMensaje = $procedure_paramsMS[11][0];
                $mensaje    = $procedure_paramsMS[12][0];
                $lCollection->Add('CodMensaje', $CodMensaje);
                $lCollection->Add('Mensaje', $mensaje);
            }     
            
            /*******************************************************************
             *          METODO ELIMINAR REGISTRO     
            /*******************************************************************/ 
            if ($Action == "EliminaRegistro")
                {
                    $lstPersonaM                     = array();
                    $objPersonaMDAO                  = new PersonaDAO();
                    $lstParametrosM                 = array();
                    $lstParametrosM['SeleccionarID'] = $SeleccionarID;                
                    $lstParametrosM['Usuario']      = $usuario;
                    $lstParametrosM['PCODIGO']      = str_repeat("\0", 100);
                    $lstParametrosM['PMENSAJE']     = str_repeat("\0", 200);
                    $procedure_paramsMS = array(
                          array(&$lstParametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                        , array(&$lstParametrosM['Usuario'], SQLSRV_PARAM_IN)
                        , array(&$lstParametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                        , array(&$lstParametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
                    );
                    $objPersonaMDAO->Elimina($lstPersonaM, $procedure_paramsMS);
                    $CodMensaje = $procedure_paramsMS[2][0];
                    $mensaje    = $procedure_paramsMS[3][0];
                    $lCollection->Add('CodMensaje', $CodMensaje);
                    $lCollection->Add('Mensaje', $mensaje);
                }        
            $lCollection->Add('PaginaFormulario', $PaginaFormulario);
            $lCollection->Add('Mensaje', $mensaje);
            $lCollection->Add('PermisoOK', $PermisoOK);
            

/********************************************************************************
 *          SECCION DE CODIGO PARA LAS LISTAS DEPLEGABLES O COMBOS
/*******************************************************************************/    
            
            
            /**********************LISTADO DE DEPARTAMENTOS*********************/        
            $objDepartamentoDAO   = new UbigeoDAO();
            $lstDepartamento      = array();            
            $objDepartamentoDAO->SelectListDepartamento($lstDepartamento);        
            $lCollection->Add('lstDepartamento', $lstDepartamento);
            
            
            
            
            /********************* LISTADO DE PROVINCIAS  *********************/        
            $objProvinciaDAO   = new UbigeoDAO();
            $lstParametrosProvincia    = array();            
            $lstParametrosProvincia['IdUbigeo']     = $Departamento;
            $procedure_lstParametrosP = array(
                  array(&$lstParametrosProvincia['IdUbigeo'], SQLSRV_PARAM_IN)
            );
            $objProvinciaDAO->SelectListProvincia($lstProvincia,$procedure_lstParametrosP);                    
            $lCollection->Add('lstProvincia', $lstProvincia);      
            
            /*********************** AJAX DE PROVINCIAS  **********************/
            if ($ActionFlex == "LoadProvinciaAjax")
            {
                $DepartamentoID           = isset($_REQUEST['Id'])? VerificarInputs($_REQUEST['Id']) : 0;
                //echo $DepartamentoID;
                $lstProvincia     = array();
                $objProvinciaDAO   = new UbigeoDAO();
                $lstParametros     = array();
                $lstParametros['IdUbigeo']     = $DepartamentoID;
                $procedure_paramsU = array(
                      array(&$lstParametros['IdUbigeo'], SQLSRV_PARAM_IN)
                );
                $objProvinciaDAO->SelectListProvincia($lstProvincia,$procedure_paramsU);
                $lCollection->Add('lstProvincia',$lstProvincia);                
            }                      
                        
            /********************* LISTADO DE DISTRITOS *********************/            
            $objDistritoDAO   = new UbigeoDAO();
            $lstParametrosDistrito    = array();            
            $lstParametrosDistrito['IdUbigeo']     = $Provincia;
            $procedure_lstParametrosD = array(
                  array(&$lstParametrosDistrito['IdUbigeo'], SQLSRV_PARAM_IN)
            );
            $objDistritoDAO->SelectListDistrito($lstDistrito,$procedure_lstParametrosD);                    
            $lCollection->Add('lstDistrito', $lstDistrito);   
            
            /*********************** AJAX DE DISTRITO  **********************/            
            if ($ActionFlex == "LoadDistritoAjax")
            {
                $ProvinciaID = isset($_REQUEST['Id'])? VerificarInputs($_REQUEST['Id']) : 0;                                
                $lstDistrito      = array();
                $objDistritoDAO    = new UbigeoDAO();
                $lstParametros   = array();
                $lstParametros['IdUbigeo']     = $ProvinciaID;
                $procedure_paramsU = array(
                      array(&$lstParametros['IdUbigeo'], SQLSRV_PARAM_IN)
                );
                $objDistritoDAO->SelectListDistrito($lstDistrito,$procedure_paramsU);
                $lCollection->Add('lstDistrito',$lstDistrito);
            }            
        }           
    }    
    //var_dump($lstDepartamento);exit;