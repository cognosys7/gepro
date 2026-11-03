<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa         : www.cognosys.com.pe
//  Autores         : Julio C�sar Meza Yangali - mezayangali@gmail.com 
//                    Edgar David Pisfil Ahumada                 
//  Prop�sito       : GEN_DIRECTORIOLN de la tabla GEN_DIRECTORIO
//  Fecha           : jueves, 4 de enero de 2018 11:05:07
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
/******************************************************************************/
    require_once(PATH_CONTROLADOR_DAO . "/GEN_DIRECTORIODAO.php");
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
        $PaginaFormulario = "GEN_DIRECTORIO";
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
				$DES_DIRECTORIO          =   isset($_REQUEST['DES_DIRECTORIO'])? VerificarInputs($_REQUEST['DES_DIRECTORIO']) : "";
				$FEC_APROBACION          =   isset($_REQUEST['FEC_APROBACION'])? VerificarInputs($_REQUEST['FEC_APROBACION']) : "";
				$EST_DIRECTORIO          =   isset($_REQUEST['EST_DIRECTORIO'])? VerificarInputs($_REQUEST['EST_DIRECTORIO']) : "";			
            /* FLEXIGRID */
            //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
																		$ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            
            
            /*******************************************************************
             *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
            /*******************************************************************/ 
            if ($ActionFlex == "LoadJsonList")
            {            
                $lDataSet      = array();
                $ogridDAO   = new GEN_DIRECTORIO_DAO();    
                $Prueba="ActionFlex";				
				
                if($_POST['query']<>'%')
                {
                    if(strlen(VerificarInputs($_POST['query'])) > 0)
                    {
						

								if ($_POST['qtype'] == 'DES_DIRECTORIO') 
								{
									$_POST['qtype'] = 'DIR.DES_DIRECTORIO';
								}								
								if ($_POST['qtype'] == 'EST_DIRECTORIO') 
								{
									$_POST['qtype'] = 'DIR.EST_DIRECTORIO';
								}								

						
                        $lparametro = " AND ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ".$ScriptFLX;
                    }
                    else
                    {
                        $lparametro  = $ScriptFLX;
                    }
                } 
                else
                {
                    $lparametro  = $ScriptFLX;
                }             
                $lparametroP                 = array();
                $lparametroP['Script']       = $lparametro;
                $procedure_parametrosP = array(
                      array(&$lparametroP['Script'], SQLSRV_PARAM_IN)
                );
                $ogridDAO->Count_GEN_DIRECTORIO($lDataSet, $procedure_parametrosP); //JCMY
					$nTotal = $lDataSet[0]->IDE_DIRECTORIO;                     
				
                $lCollection->Add('nTotal', $nTotal);
                GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_GEN_DIRECTORIO',$nTotal, $_POST['page'],$lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
                exit;                
            }
            
            /*******************************************************************
             *        METODO PARA INSERTAR UN REGISTRO 
            /*******************************************************************/ 
            if ($Action == "RegistraDatos")
            {
                /*ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA*/     
				
						if (strlen($FEC_APROBACION)>0)
						{
							$FEC_APROBACION      = cambiafecha($FEC_APROBACION);
						}
						else
						{
							$FEC_APROBACION      = "";
						}
			
                /*FIN DE ACTIVACION*/

                $DataSet_GEN_DIRECTORIOM     = array();
                $Objeto_GEN_DIRECTORIO_DAO  = new GEN_DIRECTORIO_DAO();
                $lstparametrosM   = array();
				 if (strlen(rtrim($DES_DIRECTORIO)) > 0)  {	
					$lstparametrosM['DES_DIRECTORIO'] 		= $DES_DIRECTORIO;
				 }	
				 if (strlen(rtrim($FEC_APROBACION)) > 0)  {	
					$lstparametrosM['FEC_APROBACION'] 		= $FEC_APROBACION;
				 }	
				 if (strlen(rtrim($EST_DIRECTORIO)) > 0)  {	
					$lstparametrosM['EST_DIRECTORIO'] 		= $EST_DIRECTORIO;
				 }			        $lstparametrosM['Usuario']           = $usuario;
                $lstparametrosM['PCODIGO']           = str_repeat("0", 100);
                $lstparametrosM['PMENSAJE']          = str_repeat("0", 200);
				
                $procedure_parametrosMS = array(
					array(&$lstparametrosM['DES_DIRECTORIO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['FEC_APROBACION'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['EST_DIRECTORIO'],       SQLSRV_PARAM_IN)                    , array(&$lstparametrosM['Usuario'],            SQLSRV_PARAM_IN)
                    , array(&$lstparametrosM['PCODIGO'],            SQLSRV_PARAM_OUT)
                    , array(&$lstparametrosM['PMENSAJE'],           SQLSRV_PARAM_OUT)                
                );
                $Objeto_GEN_DIRECTORIO_DAO->Insert_GEN_DIRECTORIO($DataSet_GEN_DIRECTORIO, $procedure_parametrosMS); //JCMY
				
				$CodMensaje = $procedure_parametrosMS[4][0];		
								
                $mensaje    = $procedure_parametrosMS[5][0];
				
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
                $DataSet_GEN_DIRECTORIO        = array();  
                $Objeto_GEN_DIRECTORIO_DAO     = new GEN_DIRECTORIO_DAO();
                $lstparametrosM     = array();
                $lstparametrosM['SeleccionarID']       = $SeleccionarID;
                $procedure_parametrosMS = array(                  
                      array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                );            
                $Objeto_GEN_DIRECTORIO_DAO->SelPk_GEN_DIRECTORIO($DataSet_GEN_DIRECTORIO, $procedure_parametrosMS); // JCMY
                //var_dump($procedure_parametrosMS);
                $listaContador  = count($DataSet_GEN_DIRECTORIO) > 0 ? true : false; //JCMY
                //var_dump($listaContador);exit;
                if (($listaContador == true) || ($listaContador > 0)) 
                {                   
                    //Recuperando Valores del arreglo $DataSet_GEN_DIRECTORIO
					
							$DES_DIRECTORIO  =  $DataSet_GEN_DIRECTORIO[0]->DES_DIRECTORIO;
							$FEC_APROBACION  =  $DataSet_GEN_DIRECTORIO[0]->FEC_APROBACION;
							$EST_DIRECTORIO  =  $DataSet_GEN_DIRECTORIO[0]->EST_DIRECTORIO;					
                }                                    
                $lCollection->Add('SeleccionarID',$SeleccionarID);
						$lCollection->Add('DES_DIRECTORIO', $DES_DIRECTORIO);
						$lCollection->Add('FEC_APROBACION', $FEC_APROBACION);
						$lCollection->Add('EST_DIRECTORIO', $EST_DIRECTORIO);				
            } 
            
            /*******************************************************************
             *        METODO PARA ACTUALIZAR UN REGISTRO 
            /*******************************************************************/ 
            if ($Action == "ActualizarForm")
            {                
                /*ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA*/  
				
						if (strlen($FEC_APROBACION)>0)
						{
							$FEC_APROBACION      = cambiafecha($FEC_APROBACION);
						}
						else
						{
							$FEC_APROBACION      = "";
						}
			
                //var_dump($FechaHoraRegistro);exit;        
                /*FIN DE ACTIVACION*/
                $DataSet_GEN_DIRECTORIO     = array();  
                $Objeto_GEN_DIRECTORIO_DAO  = new GEN_DIRECTORIO_DAO();  
				
				$lstparametrosM['SeleccionarID'] = $SeleccionarID;
				 if (strlen(rtrim($DES_DIRECTORIO)) > 0)  {	
					$lstparametrosM['DES_DIRECTORIO'] = $DES_DIRECTORIO;
				 }	
				 if (strlen(rtrim($FEC_APROBACION)) > 0)  {	
					$lstparametrosM['FEC_APROBACION'] = $FEC_APROBACION;
				 }	
				 if (strlen(rtrim($EST_DIRECTORIO)) > 0)  {	
					$lstparametrosM['EST_DIRECTORIO'] = $EST_DIRECTORIO;
				 }			
                $lstparametrosM['Usuario']           = $usuario;
                $lstparametrosM['PCODIGO']           = str_repeat("0", 100);
                $lstparametrosM['PMENSAJE']          = str_repeat("0", 200); 
								
                $procedure_parametrosMS = array(
                      array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['DES_DIRECTORIO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['FEC_APROBACION'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['EST_DIRECTORIO'], SQLSRV_PARAM_IN)				
                    , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)

                );                        
                $Objeto_GEN_DIRECTORIO_DAO->Update_GEN_DIRECTORIO($DataSet_GEN_DIRECTORIO, $procedure_parametrosMS);   //JCMY

				$CodMensaje = $procedure_parametrosMS[5][0];
								
				$mensaje = $procedure_parametrosMS[6][0];
				
                $lCollection->Add('CodMensaje', $CodMensaje);
                $lCollection->Add('Mensaje', $mensaje);
            }     
            
            /*******************************************************************
             *          METODO ELIMINAR REGISTRO     
            /*******************************************************************/ 
            if ($Action == "EliminaRegistro")
                {
                    $DataSet_GEN_DIRECTORIO                     = array();
                    $Objeto_GEN_DIRECTORIO_DAO                  = new GEN_DIRECTORIO_DAO();
                    $lstparametrosM                 = array();
                    $lstparametrosM['SeleccionarID'] = $SeleccionarID;                
                    $lstparametrosM['Usuario']      = $usuario;
                    $lstparametrosM['PCODIGO']      = str_repeat("0", 100);
                    $lstparametrosM['PMENSAJE']     = str_repeat("0", 200);
                    $procedure_parametrosMS = array(
                          array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                        , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                        , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                        , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
                    );
                    $Objeto_GEN_DIRECTORIO_DAO->Delete_GEN_DIRECTORIO($DataSet_GEN_DIRECTORIO, $procedure_parametrosMS); //JCMY
                    $CodMensaje = $procedure_parametrosMS[2][0];
                    $mensaje    = $procedure_parametrosMS[3][0];
                    $lCollection->Add('CodMensaje', $CodMensaje);
                    $lCollection->Add('Mensaje', $mensaje);
                }        
            $lCollection->Add('PaginaFormulario', $PaginaFormulario);
            $lCollection->Add('Mensaje', $mensaje);
            $lCollection->Add('PermisoOK', $PermisoOK);



/********************************************************************************
 *          SECCION DE CODIGO PARA LAS LISTAS DEPLEGABLES O COMBOS
/*******************************************************************************/    			            

        }           
    }    
    //var_dump($lstDepartamento);exit;
