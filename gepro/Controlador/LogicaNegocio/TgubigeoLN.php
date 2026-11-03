<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa         : www.cognosys.com.pe
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com 
//                    Edgar David Pisfil Ahumada                    
//  Propósito       : LN de la tabla TGUBIGEO
//  Fecha           : lunes, 23 de octubre de 2017 18:52:30
//  Desde el Modelo : PDM AMSAC
//  Modificado      : 16 de Octubre 2017
//
/******************************************************************************/
    require_once(PATH_CONTROLADOR_DAO . "/TGUBIGEODAO.php");
    require_once(RECURSOSGEN_LIB . "/Fechas.php");
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(RECURSOSGEN_LIB . "/util.php");
    require_once(PATH_LIB . '/util.php');    
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    /*AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES*/
	    
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "TGUBIGEO";
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
				$SeleccionarID   =   isset($_REQUEST['SeleccionarID'])? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
				$Ubigeo          =   isset($_REQUEST['Ubigeo'])? VerificarInputs($_REQUEST['Ubigeo']) : "";
				$UbiDepartamento          =   isset($_REQUEST['UbiDepartamento'])? VerificarInputs($_REQUEST['UbiDepartamento']) : "";
				$UbiProvincia          =   isset($_REQUEST['UbiProvincia'])? VerificarInputs($_REQUEST['UbiProvincia']) : "";
				$UbiDistrito          =   isset($_REQUEST['UbiDistrito'])? VerificarInputs($_REQUEST['UbiDistrito']) : "";
				$UbiLocalidad          =   isset($_REQUEST['UbiLocalidad'])? VerificarInputs($_REQUEST['UbiLocalidad']) : "";
				$UbiEstado          =   isset($_REQUEST['UbiEstado'])? VerificarInputs($_REQUEST['UbiEstado']) : "";
				$UbiUsuRegistra          =   isset($_REQUEST['UbiUsuRegistra'])? VerificarInputs($_REQUEST['UbiUsuRegistra']) : "";
				$UbiFecRegistra          =   isset($_REQUEST['UbiFecRegistra'])? VerificarInputs($_REQUEST['UbiFecRegistra']) : "";
				$UbiUsuActualiza          =   isset($_REQUEST['UbiUsuActualiza'])? VerificarInputs($_REQUEST['UbiUsuActualiza']) : "";
				$UbiFecActualiza          =   isset($_REQUEST['UbiFecActualiza'])? VerificarInputs($_REQUEST['UbiFecActualiza']) : "";
				$IdRegion          =   isset($_REQUEST['IdRegion'])? VerificarInputs($_REQUEST['IdRegion']) : "";
				$Latitud          =   isset($_REQUEST['Latitud'])? VerificarInputs($_REQUEST['Latitud']) : "";
				$Longitud          =   isset($_REQUEST['Longitud'])? VerificarInputs($_REQUEST['Longitud']) : "";
				$est_tgubigeo          =   isset($_REQUEST['est_tgubigeo'])? VerificarInputs($_REQUEST['est_tgubigeo']) : "";			
            /* FLEXIGRID */
            //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
            $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;
            
            /*******************************************************************
             *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
            /*******************************************************************/ 
            if ($ActionFlex == "LoadJsonList")
            {            
                $lDato      = array();
                $ogridDAO   = new TGUBIGEODAO();    
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
                $lFiltroP                 = array();
                $lFiltroP['Script']       = $lFiltro;
                $procedure_filtrosP = array(
                      array(&$lFiltroP['Script'], SQLSRV_PARAM_IN)
                );
                $ogridDAO->Count_TGUBIGEO($lDato, $procedure_filtrosP); //JCMY
					$nTotal = $lDato[0]->IdUbigeo;                     
				
                $lCollection->Add('nTotal', $nTotal);
                GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd',$nTotal, $_POST['page'],$lFiltro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
                exit;                
            }
            
            /*******************************************************************
             *        METODO PARA INSERTAR UN REGISTRO 
            /*******************************************************************/ 
            if ($Action == "RegistraDatos")
            {
                /*ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA*/     
				
						if (strlen($UbiFecRegistrao)>0)
						{
							$UbiFecRegistra      = cambiafecha($UbiFecRegistra);
						}
						else
						{
							$UbiFecRegistra      = "";
						}
						if (strlen($UbiFecActualizao)>0)
						{
							$UbiFecActualiza      = cambiafecha($UbiFecActualiza);
						}
						else
						{
							$UbiFecActualiza      = "";
						}
			
                /*FIN DE ACTIVACION*/

                $lstTGUBIGEOM     = array();
                $objTGUBIGEOMDAO  = new TGUBIGEODAO();
                $lstFiltrosM   = array();
					$lstFiltrosM['Ubigeo']         = $Ubigeo;
					$lstFiltrosM['UbiDepartamento']         = $UbiDepartamento;
					$lstFiltrosM['UbiProvincia']         = $UbiProvincia;
					$lstFiltrosM['UbiDistrito']         = $UbiDistrito;
					$lstFiltrosM['UbiLocalidad']         = $UbiLocalidad;
					$lstFiltrosM['UbiEstado']         = $UbiEstado;
					$lstFiltrosM['UbiUsuRegistra']         = $UbiUsuRegistra;
					$lstFiltrosM['UbiFecRegistra']         = $UbiFecRegistra;
					$lstFiltrosM['UbiUsuActualiza']         = $UbiUsuActualiza;
					$lstFiltrosM['UbiFecActualiza']         = $UbiFecActualiza;
					$lstFiltrosM['IdRegion']         = $IdRegion;
					$lstFiltrosM['Latitud']         = $Latitud;
					$lstFiltrosM['Longitud']         = $Longitud;
					$lstFiltrosM['est_tgubigeo']         = $est_tgubigeo;		
                $lstFiltrosM['PCODIGO']           = str_repeat("0", 100);
                $lstFiltrosM['PMENSAJE']          = str_repeat("0", 200);
				
                $procedure_filtrosMS = array(
					array(&$lstFiltrosM['Ubigeo'],       SQLSRV_PARAM_IN),
					array(&$lstFiltrosM['UbiDepartamento'],       SQLSRV_PARAM_IN),
					array(&$lstFiltrosM['UbiProvincia'],       SQLSRV_PARAM_IN),
					array(&$lstFiltrosM['UbiDistrito'],       SQLSRV_PARAM_IN),
					array(&$lstFiltrosM['UbiLocalidad'],       SQLSRV_PARAM_IN),
					array(&$lstFiltrosM['UbiEstado'],       SQLSRV_PARAM_IN),
					array(&$lstFiltrosM['UbiUsuRegistra'],       SQLSRV_PARAM_IN),
					array(&$lstFiltrosM['UbiFecRegistra'],       SQLSRV_PARAM_IN),
					array(&$lstFiltrosM['UbiUsuActualiza'],       SQLSRV_PARAM_IN),
					array(&$lstFiltrosM['UbiFecActualiza'],       SQLSRV_PARAM_IN),
					array(&$lstFiltrosM['IdRegion'],       SQLSRV_PARAM_IN),
					array(&$lstFiltrosM['Latitud'],       SQLSRV_PARAM_IN),
					array(&$lstFiltrosM['Longitud'],       SQLSRV_PARAM_IN),
					array(&$lstFiltrosM['est_tgubigeo'],       SQLSRV_PARAM_IN)                    , array(&$lstFiltrosM['Usuario'],            SQLSRV_PARAM_IN)
                    , array(&$lstFiltrosM['PCODIGO'],            SQLSRV_PARAM_OUT)
                    , array(&$lstFiltrosM['PMENSAJE'],           SQLSRV_PARAM_OUT)                
                );
                $objTGUBIGEOMDAO->Insert_TGUBIGEO($lstTGUBIGEOM, $procedure_filtrosMS); //JCMY
				
				$CodMensaje = $procedure_filtrosMS[15][0];		
								
                $mensaje    = $procedure_filtrosMS[16][0];
				
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
                $lstTGUBIGEOM        = array();  
                $objTGUBIGEOMDAO     = new TGUBIGEODAO();
                $lstFiltrosM     = array();
                $lstFiltrosM['SeleccionarID']       = $SeleccionarID;
                $procedure_filtrosMS = array(                  
                      array(&$lstFiltrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                );            
                $objTGUBIGEOMDAO->SelPk_TGUBIGEO($lstTGUBIGEOM, $procedure_filtrosMS); // JCMY
                //var_dump($procedure_filtrosMS);
                $listaContador  = Count_TGUBIGEO($lstTGUBIGEOM) > 0 ? true : false; //JCMY
                //var_dump($listaContador);exit;
                if (($listaContador == true) || ($listaContador > 0)) 
                {                   
                    //Recuperando Valores del arreglo $lstTGUBIGEOM
					
							$IdUbigeo  =  $lstTGUBIGEOM[0]->IdUbigeo;
							$Ubigeo  =  $lstTGUBIGEOM[0]->Ubigeo;
							$UbiDepartamento  =  $lstTGUBIGEOM[0]->UbiDepartamento;
							$UbiProvincia  =  $lstTGUBIGEOM[0]->UbiProvincia;
							$UbiDistrito  =  $lstTGUBIGEOM[0]->UbiDistrito;
							$UbiLocalidad  =  $lstTGUBIGEOM[0]->UbiLocalidad;
							$UbiEstado  =  $lstTGUBIGEOM[0]->UbiEstado;
							$UbiUsuRegistra  =  $lstTGUBIGEOM[0]->UbiUsuRegistra;
							$UbiFecRegistra  =  $lstTGUBIGEOM[0]->UbiFecRegistra;
							$UbiUsuActualiza  =  $lstTGUBIGEOM[0]->UbiUsuActualiza;
							$UbiFecActualiza  =  $lstTGUBIGEOM[0]->UbiFecActualiza;
							$IdRegion  =  $lstTGUBIGEOM[0]->IdRegion;
							$Latitud  =  $lstTGUBIGEOM[0]->Latitud;
							$Longitud  =  $lstTGUBIGEOM[0]->Longitud;
							$est_tgubigeo  =  $lstTGUBIGEOM[0]->est_tgubigeo;					
                }                                    
                $lCollection->Add('SeleccionarID',$SeleccionarID);
						$lCollection->Add('IdUbigeo', $IdUbigeo);
						$lCollection->Add('Ubigeo', $Ubigeo);
						$lCollection->Add('UbiDepartamento', $UbiDepartamento);
						$lCollection->Add('UbiProvincia', $UbiProvincia);
						$lCollection->Add('UbiDistrito', $UbiDistrito);
						$lCollection->Add('UbiLocalidad', $UbiLocalidad);
						$lCollection->Add('UbiEstado', $UbiEstado);
						$lCollection->Add('UbiUsuRegistra', $UbiUsuRegistra);
						$lCollection->Add('UbiFecRegistra', $UbiFecRegistra);
						$lCollection->Add('UbiUsuActualiza', $UbiUsuActualiza);
						$lCollection->Add('UbiFecActualiza', $UbiFecActualiza);
						$lCollection->Add('IdRegion', $IdRegion);
						$lCollection->Add('Latitud', $Latitud);
						$lCollection->Add('Longitud', $Longitud);
						$lCollection->Add('est_tgubigeo', $est_tgubigeo);				
            } 
            
            /*******************************************************************
             *        METODO PARA ACTUALIZAR UN REGISTRO 
            /*******************************************************************/ 
            if ($Action == "ActualizarForm")
            {                
                /*ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA*/  
				
						if (strlen($UbiFecRegistrao)>0)
						{
							$UbiFecRegistra      = cambiafecha($UbiFecRegistra);
						}
						else
						{
							$UbiFecRegistra      = "";
						}
						if (strlen($UbiFecActualizao)>0)
						{
							$UbiFecActualiza      = cambiafecha($UbiFecActualiza);
						}
						else
						{
							$UbiFecActualiza      = "";
						}
			
                //var_dump($FechaHoraRegistro);exit;        
                /*FIN DE ACTIVACION*/
                $lstTGUBIGEOM     = array();  
                $objTGUBIGEOMDAO  = new TGUBIGEODAO();  
				
				$lstFiltrosM['SeleccionarID'] = $SeleccionarID;
				$lstFiltrosM['IdUbigeo'] = $IdUbigeo;
				$lstFiltrosM['Ubigeo'] = $Ubigeo;
				$lstFiltrosM['UbiDepartamento'] = $UbiDepartamento;
				$lstFiltrosM['UbiProvincia'] = $UbiProvincia;
				$lstFiltrosM['UbiDistrito'] = $UbiDistrito;
				$lstFiltrosM['UbiLocalidad'] = $UbiLocalidad;
				$lstFiltrosM['UbiEstado'] = $UbiEstado;
				$lstFiltrosM['UbiUsuRegistra'] = $UbiUsuRegistra;
				$lstFiltrosM['UbiFecRegistra'] = $UbiFecRegistra;
				$lstFiltrosM['UbiUsuActualiza'] = $UbiUsuActualiza;
				$lstFiltrosM['UbiFecActualiza'] = $UbiFecActualiza;
				$lstFiltrosM['IdRegion'] = $IdRegion;
				$lstFiltrosM['Latitud'] = $Latitud;
				$lstFiltrosM['Longitud'] = $Longitud;
				$lstFiltrosM['est_tgubigeo'] = $est_tgubigeo;		
                $lstFiltrosM['Usuario']           = $usuario;
                $lstFiltrosM['PCODIGO']           = str_repeat("0", 100);
                $lstFiltrosM['PMENSAJE']          = str_repeat("0", 200); 
								
                $procedure_filtrosMS = array(
                      array(&$lstFiltrosM['SeleccionarID'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['IdUbigeo'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['Ubigeo'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['UbiDepartamento'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['UbiProvincia'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['UbiDistrito'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['UbiLocalidad'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['UbiEstado'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['UbiUsuRegistra'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['UbiFecRegistra'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['UbiUsuActualiza'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['UbiFecActualiza'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['IdRegion'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['Latitud'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['Longitud'], SQLSRV_PARAM_IN)
						,array(&$lstFiltrosM['est_tgubigeo'], SQLSRV_PARAM_IN)				
                    , array(&$lstFiltrosM['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lstFiltrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lstFiltrosM['PMENSAJE'], SQLSRV_PARAM_OUT)

                );                        
                $objTGUBIGEOMDAO->Update_TGUBIGEO($lstTGUBIGEOM, $procedure_filtrosMS);   //JCMY

				$CodMensaje = $procedure_filtrosMS[16][0];
								
				$mensaje = $procedure_filtrosMS[17][0];
				
                $lCollection->Add('CodMensaje', $CodMensaje);
                $lCollection->Add('Mensaje', $mensaje);
            }     
            
            /*******************************************************************
             *          METODO ELIMINAR REGISTRO     
            /*******************************************************************/ 
            if ($Action == "EliminaRegistro")
                {
                    $lstTGUBIGEOM                     = array();
                    $objTGUBIGEOMDAO                  = new TGUBIGEODAO();
                    $lstFiltrosM                 = array();
                    $lstFiltrosM['SeleccionarID'] = $SeleccionarID;                
                    $lstFiltrosM['Usuario']      = $usuario;
                    $lstFiltrosM['PCODIGO']      = str_repeat("0", 100);
                    $lstFiltrosM['PMENSAJE']     = str_repeat("0", 200);
                    $procedure_filtrosMS = array(
                          array(&$lstFiltrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                        , array(&$lstFiltrosM['Usuario'], SQLSRV_PARAM_IN)
                        , array(&$lstFiltrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                        , array(&$lstFiltrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
                    );
                    $objTGUBIGEOMDAO->Delete_TGUBIGEO($lstTGUBIGEOM, $procedure_filtrosMS); //JCMY
                    $CodMensaje = $procedure_filtrosMS[2][0];
                    $mensaje    = $procedure_filtrosMS[3][0];
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
         /*   $objDepartamentoDAO   = new UbigeoDAO();
            $lstDepartamento      = array();            
            $objDepartamentoDAO->SelectListDepartamento($lstDepartamento);        
            $lCollection->Add('lstDepartamento', $lstDepartamento); */
            
                      
            
            /********************* LISTADO DE PROVINCIAS  *********************/        
          /*  $objProvinciaDAO   = new UbigeoDAO();
            $lstParametrosProvincia    = array();            
            $lstParametrosProvincia['IdUbigeo']     = $Departamento;
            $procedure_lstParametrosP = array(
                  array(&$lstParametrosProvincia['IdUbigeo'], SQLSRV_PARAM_IN)
            );
            $objProvinciaDAO->SelectListProvincia($lstProvincia,$procedure_lstParametrosP);                    
            $lCollection->Add('lstProvincia', $lstProvincia);      */
            
            /*********************** AJAX DE PROVINCIAS  **********************/
         /*   if ($ActionFlex == "LoadProvinciaAjax")
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
              */          
            /********************* LISTADO DE DISTRITOS *********************/            
         /*   $objDistritoDAO   = new UbigeoDAO();
            $lstParametrosDistrito    = array();            
            $lstParametrosDistrito['IdUbigeo']     = $Provincia;
            $procedure_lstParametrosD = array(
                  array(&$lstParametrosDistrito['IdUbigeo'], SQLSRV_PARAM_IN)
            );
            $objDistritoDAO->SelectListDistrito($lstDistrito,$procedure_lstParametrosD);                    
            $lCollection->Add('lstDistrito', $lstDistrito);   
         */   
            /*********************** AJAX DE DISTRITO  **********************/            
         /*   if ($ActionFlex == "LoadDistritoAjax")
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
				*/
        }           
    }    
    //var_dump($lstDepartamento);exit;