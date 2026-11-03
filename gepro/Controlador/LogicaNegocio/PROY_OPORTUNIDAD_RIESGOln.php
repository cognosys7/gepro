<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    	  : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. julio C�sar Meza Yangali                     
//  Prop�sito       : PROY_OPORTUNIDAD_RIESGOln de la tabla PROY_OPORTUNIDAD_RIESGO
//  Fecha           : s�bado, 3 de julio de 2021 3:55:17
//  Desde el Modelo : PDM - Modelo F�sico de Datos - SGPAM
//  Modificado      : s�bado, 3 de julio de 2021 3:55:17
//
//******************************************************************************/
    require_once(PATH_CONTROLADOR_DAO . "/PROY_OPORTUNIDAD_RIESGODAO.php");
    require_once(RECURSOSGEN_LIB . "/Fechas.php");
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(RECURSOSGEN_LIB . "/util.php");
    require_once(PATH_LIB . '/util.php');    
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    /*AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES*/
	

			require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php"); 



/* EDGAR - invoca a la libreria de funciones generales */
    require_once("include/LNinclude.php");

    require_once("include/PROYECTOlni.php"); 

    require_once(PATH_CONTROLADOR_DAO . "/GEN_PROBABILIDAD_RIESGODAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/GEN_IMPACTO_RIESGODAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/GEN_PRIORIDAD_RIESGODAO.php");

//// busqueda lni
/*EDGAR*/


    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "PROY_OPORTUNIDAD_RIESGO";
        $PermisoOK        = 0;


  
    //OBTENGOS LOS POST ANTIREFRESH
    if (!empty($_POST['Mensaje'])) { $mensaje = $_POST['Mensaje']; } else { $mensaje = 0;}
    
    //OBTENGO LAS SESIONES
    if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
    if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
    if (!empty($_SESSION['personal'])) { $personal = $_SESSION['personal'];} else { $personal = 0;}
    if (!empty($_SESSION['Oc'])) { $Opcionsession = $_SESSION['Oc'];} else { $Opcionsession = 0;}	
    $PermisosPerfil = CallNomPerfil($perfilsession);
    $PermisoOK = VerificaAccesoMenu($Opcionsession,$perfilsession);// echo $PermisosPerfil; die;


        
        if ($PermisoOK == 1)       {
            /*******************************************************************
             *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
            /*******************************************************************/             
            //ACCIONES PARA EL FORMULARIO
            $Action             = isset($_REQUEST['ActionForm'])? VerificarInputs($_REQUEST['ActionForm']) : "";
            $ActionFlex         = isset($_REQUEST['Accion'])? VerificarInputs($_REQUEST['Accion']) : "";
			


/* EDGAR */
        $PIDE = isset($_REQUEST['PIDE']) ? VerificarInputs($_REQUEST['PIDE']) : "";
        $lCollection->Add('PIDE', $PIDE);
        
        ////// TIPO DE VENTANA: MANTENIMIENTO O BUSQUEDA-SELECCION
        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : "";
        $lCollection->Add('Pedido', $Pedido);
        
        ////// IDE: BUSQUEDA-SELECCION
        $PIDEbuscado = isset($_REQUEST['PIDEbuscado']) ? VerificarInputs($_REQUEST['PIDEbuscado']) : "";
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        
        ////// PARAMETROS DE FILTRO: RECURSIVO, O PERSONALIZACION DE TABLAS 
        $Recursiva_Nivel_Actual = isset($_REQUEST['Recursiva_Nivel_Actual']) ? VerificarInputs($_REQUEST['Recursiva_Nivel_Actual']) : "";
        
/* EDGAR */
     
     
            
            /*******************************************************************
             *     RECUPERACION DE DATOS DEL FORMULARIO
            /*******************************************************************/ 
				$SeleccionarID   =   isset($_REQUEST['SeleccionarID'])? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
				$IDE_PROYECTO          =   isset($_REQUEST['IDE_PROYECTO'])? VerificarInputs($_REQUEST['IDE_PROYECTO']) : "";
				$FEC_RIESGO          =   isset($_REQUEST['FEC_RIESGO'])? VerificarInputs($_REQUEST['FEC_RIESGO']) : "";
				$DES_RIESGO          =   isset($_REQUEST['DES_RIESGO'])? VerificarInputs($_REQUEST['DES_RIESGO']) : "";
				$NUM_PROBABILIDAD          =   isset($_REQUEST['NUM_PROBABILIDAD'])? VerificarInputs($_REQUEST['NUM_PROBABILIDAD']) : "";
				$NUM_IMPACTO          =   isset($_REQUEST['NUM_IMPACTO'])? VerificarInputs($_REQUEST['NUM_IMPACTO']) : "";
				$NUM_VALORACION          =   isset($_REQUEST['NUM_VALORACION'])? VerificarInputs($_REQUEST['NUM_VALORACION']) : "";
				$DES_ACCION          =   isset($_REQUEST['DES_ACCION'])? VerificarInputs($_REQUEST['DES_ACCION']) : "";
				$EST_RIESGO          =   isset($_REQUEST['EST_RIESGO'])? VerificarInputs($_REQUEST['EST_RIESGO']) : "";			
                $TIP_COMPONENTE      =   isset($_REQUEST['TIP_COMPONENTE'])? VerificarInputs($_REQUEST['TIP_COMPONENTE']) : "";			
            /* FLEXIGRID */
            //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
																		$ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            
            
/*EDGAR*/
         ////// GRILLA PREDETERMINADA
         $TipoGrilla = 'SelGrd_PROY_OPORTUNIDAD_RIESGO';
         $Recursiva_hide = 'true' ;
         $Tabla_DatosPadre = '' ;
        
         ////// SI TIENE UN REGISTRO PADRE, ENTONCES SE DIBUJA CABECERA - NOTA: REVISAR EL ALIAS DEL CAMPO DE LA TABLA PADRE
			if ( $PIDE>0 ){
				$ScriptFLX = $ScriptFLX . " AND T.IDE_PROYECTO = $PIDE"; 
				
			   $Tabla_DatosPadre = Tabla_PROYECTO_Datos($PIDE);

				
			 } 	
 
        
         ////// SI ES UN REGISTRO RECURSIVO
         $Recursiva=0 ;
         
         
         ////// PASE DE PARAMETROS DE GRILLA        
         $lCollection->Add('Tabla_DatosPadre', $Tabla_DatosPadre );
         $lCollection->Add('Recursiva_hide', $Recursiva_hide);

/*EDGAR*/
            
            /*******************************************************************
             *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
            /*******************************************************************/ 
            if ($ActionFlex == "LoadJsonList")
            {            
                $lDataSet      = array();
                $ogridDAO   = new PROY_OPORTUNIDAD_RIESGO_DAO();    
                $Prueba="ActionFlex";				
				
                if($_POST['query']<>'%')
                {
                    if(strlen(VerificarInputs($_POST['query'])) > 0)
                    {
						

								if ($_POST['qtype'] == 'RiesgoIdentificado') 
								{
									$_POST['qtype'] = 'T.DES_RIESGO';
								}								
								if ($_POST['qtype'] == 'AccionProceso') 
								{
									$_POST['qtype'] = 'T.DES_ACCION';
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
                $ogridDAO->Count_PROY_OPORTUNIDAD_RIESGO($lDataSet, $procedure_parametrosP); //JCMY
					$nTotal = $lDataSet[0]->IDE_PROY_OPORTUNIDAD;                     
				
                $lCollection->Add('nTotal', $nTotal);
                GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'],$lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
                exit;                
            }
            
            
            
            /* EDGAR ******************************************************************
             *        METODO PARA EXTRAER DATOS DE UN REGISTRO 
            /* EDGAR ******************************************************************/ 
            if ($Action == "PasarDatos") {
//            echo 'entre'; exit;
//            $Data = Interesados_Datos($PIDEbuscado);
//            $Data1 = Recurso_Datos($Data['IDE_RECURSO']);
            
//            $Bdescripcion = $Data1['DES_RECURSO']  ;
            
//            $lCollection->Add('BIDE', $PIDEbuscado);
//            $lCollection->Add('Bdescripcion', $Bdescripcion);
//            echo 'entre'. $PIDEbuscado . ' - '.$Bdescripcion ; exit;
        }
            
            
            
            /*******************************************************************
             *        METODO PARA INSERTAR UN REGISTRO 
            /*******************************************************************/ 
            if ($Action == "RegistraDatos")
            {
                /*ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA*/     
				
						if (strlen($FEC_RIESGO)>0)
						{
							$FEC_RIESGO      = cambiafecha($FEC_RIESGO);
						}
						else
						{
							$FEC_RIESGO      = "";
						}
			
                /*FIN DE ACTIVACION*/

                $DataSet_PROY_OPORTUNIDAD_RIESGOM     = array();
                $Objeto_PROY_OPORTUNIDAD_RIESGO_DAO  = new PROY_OPORTUNIDAD_RIESGO_DAO();
                $lstparametrosM   = array();
				 if (strlen(rtrim($IDE_PROYECTO)) > 0)  {	
					$lstparametrosM['IDE_PROYECTO'] 		= $IDE_PROYECTO;
				 }	
				 if (strlen(rtrim($FEC_RIESGO)) > 0)  {	
					$lstparametrosM['FEC_RIESGO'] 		= $FEC_RIESGO;
				 }	
				 if (strlen(rtrim($DES_RIESGO)) > 0)  {	
					$lstparametrosM['DES_RIESGO'] 		= $DES_RIESGO;
				 }	
				 if (strlen(rtrim($NUM_PROBABILIDAD)) > 0)  {	
					$lstparametrosM['NUM_PROBABILIDAD'] 		= $NUM_PROBABILIDAD;
				 }	
				 if (strlen(rtrim($NUM_IMPACTO)) > 0)  {	
					$lstparametrosM['NUM_IMPACTO'] 		= $NUM_IMPACTO;
				 }	
				 if (strlen(rtrim($NUM_VALORACION)) > 0)  {	
					$lstparametrosM['NUM_VALORACION'] 		= $NUM_VALORACION;
				 }	
				 if (strlen(rtrim($DES_ACCION)) > 0)  {	
					$lstparametrosM['DES_ACCION'] 		= $DES_ACCION;
				 }	
				 if (strlen(rtrim($EST_RIESGO)) > 0)  {	
					$lstparametrosM['EST_RIESGO'] 		= $EST_RIESGO;
				 }			        
				 if (strlen(rtrim($TIP_COMPONENTE)) > 0)  {	
					$lstparametrosM['TIP_COMPONENTE'] 		= $TIP_COMPONENTE;
				 }			        

                $lstparametrosM['Usuario']           = $usuario;
                $lstparametrosM['PCODIGO']           = str_repeat("0", 100);
                $lstparametrosM['PMENSAJE']          = str_repeat("0", 200);
				
                $procedure_parametrosMS = array(
					array(&$lstparametrosM['IDE_PROYECTO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['FEC_RIESGO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['DES_RIESGO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['NUM_PROBABILIDAD'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['NUM_IMPACTO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['NUM_VALORACION'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['DES_ACCION'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['EST_RIESGO'],       SQLSRV_PARAM_IN),
                    array(&$lstparametrosM['TIP_COMPONENTE'],       SQLSRV_PARAM_IN)

                    , array(&$lstparametrosM['Usuario'],            SQLSRV_PARAM_IN)
                    , array(&$lstparametrosM['PCODIGO'],            SQLSRV_PARAM_OUT)
                    , array(&$lstparametrosM['PMENSAJE'],           SQLSRV_PARAM_OUT)                
                );
                $Objeto_PROY_OPORTUNIDAD_RIESGO_DAO->Insert_PROY_OPORTUNIDAD_RIESGO($DataSet_PROY_OPORTUNIDAD_RIESGO, $procedure_parametrosMS); //JCMY
				
				$CodMensaje = $procedure_parametrosMS[10][0];		
								
                $mensaje    = $procedure_parametrosMS[11][0];
				
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
                $DataSet_PROY_OPORTUNIDAD_RIESGO        = array();  
                $Objeto_PROY_OPORTUNIDAD_RIESGO_DAO     = new PROY_OPORTUNIDAD_RIESGO_DAO();
                $lstparametrosM     = array();
                $lstparametrosM['SeleccionarID']       = $SeleccionarID;
                $procedure_parametrosMS = array(                  
                      array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                );            
                $Objeto_PROY_OPORTUNIDAD_RIESGO_DAO->SelPk_PROY_OPORTUNIDAD_RIESGO($DataSet_PROY_OPORTUNIDAD_RIESGO, $procedure_parametrosMS); // JCMY
                //var_dump($procedure_parametrosMS);
                $listaContador  = count($DataSet_PROY_OPORTUNIDAD_RIESGO) > 0 ? true : false; //JCMY
                //var_dump($listaContador);exit;
                if (($listaContador == true) || ($listaContador > 0)) 
                {                   
                    //Recuperando Valores del arreglo $DataSet_PROY_OPORTUNIDAD_RIESGO
					
							$IDE_PROYECTO  =  $DataSet_PROY_OPORTUNIDAD_RIESGO[0]->IDE_PROYECTO;
							$FEC_RIESGO  =  $DataSet_PROY_OPORTUNIDAD_RIESGO[0]->FEC_RIESGO;
							$DES_RIESGO  =  $DataSet_PROY_OPORTUNIDAD_RIESGO[0]->DES_RIESGO;
							$NUM_PROBABILIDAD  =  $DataSet_PROY_OPORTUNIDAD_RIESGO[0]->NUM_PROBABILIDAD;
							$NUM_IMPACTO  =  $DataSet_PROY_OPORTUNIDAD_RIESGO[0]->NUM_IMPACTO;
							$NUM_VALORACION  =  $DataSet_PROY_OPORTUNIDAD_RIESGO[0]->NUM_VALORACION;
							$DES_ACCION  =  $DataSet_PROY_OPORTUNIDAD_RIESGO[0]->DES_ACCION;
							$EST_RIESGO  =  $DataSet_PROY_OPORTUNIDAD_RIESGO[0]->EST_RIESGO;					
                            $TIP_COMPONENTE  =  $DataSet_PROY_OPORTUNIDAD_RIESGO[0]->TIP_COMPONENTE;					
                }                                    
                $lCollection->Add('SeleccionarID',$SeleccionarID);
						$lCollection->Add('IDE_PROYECTO', $IDE_PROYECTO);
						$lCollection->Add('FEC_RIESGO', $FEC_RIESGO);
						$lCollection->Add('DES_RIESGO', $DES_RIESGO);
						$lCollection->Add('NUM_PROBABILIDAD', $NUM_PROBABILIDAD);
						$lCollection->Add('NUM_IMPACTO', $NUM_IMPACTO);
						$lCollection->Add('NUM_VALORACION', $NUM_VALORACION);
						$lCollection->Add('DES_ACCION', $DES_ACCION);
						$lCollection->Add('EST_RIESGO', $EST_RIESGO);				
                        $lCollection->Add('TIP_COMPONENTE', $TIP_COMPONENTE);				
            
            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            //$Data11 = Comunidad_Datos($IDE_COMUNIDAD);
            
            //$Bdescripcion = $Data11['DES_COMUNIDAD'] ;
            
            //$lCollection->Add('Bdescripcion', $Bdescripcion);
            /* EDGAR */
            
            } 
            
            /*******************************************************************
             *        METODO PARA ACTUALIZAR UN REGISTRO 
            /*******************************************************************/ 
            if ($Action == "ActualizarForm")
            {                
                /*ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA*/  
				
						if (strlen($FEC_RIESGO)>0)
						{
							$FEC_RIESGO      = cambiafecha($FEC_RIESGO);
						}
						else
						{
							$FEC_RIESGO      = "";
						}
			
                //var_dump($FechaHoraRegistro);exit;        
                /*FIN DE ACTIVACION*/
                $DataSet_PROY_OPORTUNIDAD_RIESGO     = array();  
                $Objeto_PROY_OPORTUNIDAD_RIESGO_DAO  = new PROY_OPORTUNIDAD_RIESGO_DAO();  
				
				$lstparametrosM['SeleccionarID'] = $SeleccionarID;
				 if (strlen(rtrim($IDE_PROYECTO)) > 0)  {	
					$lstparametrosM['IDE_PROYECTO'] = $IDE_PROYECTO;
				 }	
				 if (strlen(rtrim($FEC_RIESGO)) > 0)  {	
					$lstparametrosM['FEC_RIESGO'] = $FEC_RIESGO;
				 }	
				 if (strlen(rtrim($DES_RIESGO)) > 0)  {	
					$lstparametrosM['DES_RIESGO'] = $DES_RIESGO;
				 }	
				 if (strlen(rtrim($NUM_PROBABILIDAD)) > 0)  {	
					$lstparametrosM['NUM_PROBABILIDAD'] = $NUM_PROBABILIDAD;
				 }	
				 if (strlen(rtrim($NUM_IMPACTO)) > 0)  {	
					$lstparametrosM['NUM_IMPACTO'] = $NUM_IMPACTO;
				 }	
				 if (strlen(rtrim($NUM_VALORACION)) > 0)  {	
					$lstparametrosM['NUM_VALORACION'] = $NUM_VALORACION;
				 }	
				 if (strlen(rtrim($DES_ACCION)) > 0)  {	
					$lstparametrosM['DES_ACCION'] = $DES_ACCION;
				 }	
				 if (strlen(rtrim($EST_RIESGO)) > 0)  {	
					$lstparametrosM['EST_RIESGO'] = $EST_RIESGO;
				 }
				 if (strlen(rtrim($TIP_COMPONENTE)) > 0)  {	
					$lstparametrosM['TIP_COMPONENTE'] = $TIP_COMPONENTE;
				 }			

                $lstparametrosM['Usuario']           = $usuario;
                $lstparametrosM['PCODIGO']           = str_repeat("0", 100);
                $lstparametrosM['PMENSAJE']          = str_repeat("0", 200); 
								
                $procedure_parametrosMS = array(
                      array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['IDE_PROYECTO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['FEC_RIESGO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['DES_RIESGO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['NUM_PROBABILIDAD'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['NUM_IMPACTO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['NUM_VALORACION'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['DES_ACCION'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['EST_RIESGO'], SQLSRV_PARAM_IN)			
                        ,array(&$lstparametrosM['TIP_COMPONENTE'], SQLSRV_PARAM_IN)				
                    , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)

                );                        
                $Objeto_PROY_OPORTUNIDAD_RIESGO_DAO->Update_PROY_OPORTUNIDAD_RIESGO($DataSet_PROY_OPORTUNIDAD_RIESGO, $procedure_parametrosMS);   //JCMY

				$CodMensaje = $procedure_parametrosMS[11][0];
								
				$mensaje = $procedure_parametrosMS[12][0];
				
                $lCollection->Add('CodMensaje', $CodMensaje);
                $lCollection->Add('Mensaje', $mensaje);
            }     
            
            /*******************************************************************
             *          METODO ELIMINAR REGISTRO     
            /*******************************************************************/ 
            if ($Action == "EliminaRegistro")
                {
                    $DataSet_PROY_OPORTUNIDAD_RIESGO                     = array();
                    $Objeto_PROY_OPORTUNIDAD_RIESGO_DAO                  = new PROY_OPORTUNIDAD_RIESGO_DAO();
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
                    $Objeto_PROY_OPORTUNIDAD_RIESGO_DAO->Delete_PROY_OPORTUNIDAD_RIESGO($DataSet_PROY_OPORTUNIDAD_RIESGO, $procedure_parametrosMS); //JCMY
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

		
									
					/*	ESTADO DEL RIESGO	*/
										
                    $DataSet_GEN_TABLAS_1    = array(); 
                    $Objeto_EST_RIESGO_DAO  	    = new GEN_TABLAS_DAO();
                    $lstparametrosM         = array();   
                    $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
                    $lstparametrosM['filtro'] = "AND COD_TABLA = '99'";
                    
                    $procedure_parametrosMS = array(                  
                        array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                        ,array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
                    );	
                    
                    $Objeto_EST_RIESGO_DAO ->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1,$procedure_parametrosMS);       
                    $lCollection->Add('DataSet_GEN_TABLAS_1',$DataSet_GEN_TABLAS_1);	
											
					/*	COMPONENTE	*/
										
                    $DataSet_GEN_TABLAS_2        = array(); 
                    $Objeto_TIP_COMPONENTE_DAO   = new GEN_TABLAS_DAO();
                    $lstparametrosM              = array();   
                    $lstparametrosM['campos']    = "COD_ITEM,DES_ITEM";
                    $lstparametrosM['filtro']    = "AND COD_TABLA = '105'";
                    
                    $procedure_parametrosMS = array(                  
                        array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                        ,array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
                    );	
                    
                    $Objeto_TIP_COMPONENTE_DAO ->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2,$procedure_parametrosMS);       
                    $lCollection->Add('DataSet_GEN_TABLAS_2',$DataSet_GEN_TABLAS_2);	


                    /*		PROBABILIDAD	*/

			 
                    $DataSet_GEN_PROBABILIDAD_RIESGO_1 = array();
                    $Objeto_IDE_PROBABILIDAD_DAO = new GEN_PROBABILIDAD_RIESGO_DAO();
                    $lstparametrosM = array();
                    $lstparametrosM['campos'] = "IDE_PROBABILIDAD,DES_PROBABILIDAD";
                    $lstparametrosM['filtro'] = "";
            
                    $procedure_parametrosMS = array(
                        array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                        , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
                    );
            
                    $Objeto_IDE_PROBABILIDAD_DAO->SelCampos_GEN_PROBABILIDAD_RIESGO($DataSet_GEN_PROBABILIDAD_RIESGO_1, $procedure_parametrosMS);
                    $lCollection->Add('DataSet_GEN_PROBABILIDAD_RIESGO_1', $DataSet_GEN_PROBABILIDAD_RIESGO_1);
	
                    /*		IMPACTO	 */

                    $DataSet_GEN_IMPACTO_RIESGO_1 = array();
                    $Objeto_IDE_IMPACTO_DAO = new GEN_IMPACTO_RIESGO_DAO();
                    $lstparametrosM = array();
                    $lstparametrosM['campos'] = "IDE_IMPACTO,DES_IMPACTO";
                    $lstparametrosM['filtro'] = "";
            
                    $procedure_parametrosMS = array(
                        array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                        , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
                    );
            
                    $Objeto_IDE_IMPACTO_DAO->SelCampos_GEN_IMPACTO_RIESGO($DataSet_GEN_IMPACTO_RIESGO_1, $procedure_parametrosMS);
                    $lCollection->Add('DataSet_GEN_IMPACTO_RIESGO_1', $DataSet_GEN_IMPACTO_RIESGO_1);           
 

                    /*		VALORACION	 */
                    $DataSet_GEN_PRIORIDAD_RIESGO_1 = array();
                    $Objeto_IDE_PRIORIDAD_DAO = new GEN_PRIORIDAD_RIESGO_DAO();
                    $lstparametrosM = array();
                    $lstparametrosM['campos'] = "IDE_PRIORIDAD,DES_PRIORIDAD";
                    $lstparametrosM['filtro'] = "";

                    $procedure_parametrosMS = array(
                        array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                        , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
                    );

                    $Objeto_IDE_PRIORIDAD_DAO->SelCampos_GEN_PRIORIDAD_RIESGO($DataSet_GEN_PRIORIDAD_RIESGO_1, $procedure_parametrosMS);
                    $lCollection->Add('DataSet_GEN_PRIORIDAD_RIESGO_1', $DataSet_GEN_PRIORIDAD_RIESGO_1);

        /* EDGAR */
        $lCollection->Add('crud', crud( $usuario , $PermisosPerfil , $Pedido , $SeleccionarID ) ) ;
        /* EDGAR */
                 

        }           
    }    
    //var_dump($lstDepartamento);exit;
