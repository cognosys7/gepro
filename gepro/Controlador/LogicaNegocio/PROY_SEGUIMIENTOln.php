<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    	  : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. julio César Meza Yangali                     
//  Propósito       : PROY_SEGUIMIENTOln de la tabla PROY_SEGUIMIENTO
//  Fecha           : sábado, 3 de julio de 2021 19:46:22
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : sábado, 3 de julio de 2021 19:46:22
//
//******************************************************************************/
    require_once(PATH_CONTROLADOR_DAO . "/PROY_SEGUIMIENTODAO.php");
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

//// busqueda lni
/*EDGAR*/


    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "PROY_SEGUIMIENTO";
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
				$FEC_SEGUIMIENTO          =   isset($_REQUEST['FEC_SEGUIMIENTO'])? VerificarInputs($_REQUEST['FEC_SEGUIMIENTO']) : "";
				$DES_SEGUIMIENTO          =   isset($_REQUEST['DES_SEGUIMIENTO'])? VerificarInputs($_REQUEST['DES_SEGUIMIENTO']) : "";
				$EST_SEGUIMIENTO          =   isset($_REQUEST['EST_SEGUIMIENTO'])? VerificarInputs($_REQUEST['EST_SEGUIMIENTO']) : "";			
            /* FLEXIGRID */
            //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
																		$ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            
            
/*EDGAR*/
         ////// GRILLA PREDETERMINADA
         $TipoGrilla = 'SelGrd_PROY_SEGUIMIENTO';
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
                $ogridDAO   = new PROY_SEGUIMIENTO_DAO();    
                $Prueba="ActionFlex";				
				
                if($_POST['query']<>'%')
                {
                    if(strlen(VerificarInputs($_POST['query'])) > 0)
                    {
						

								if ($_POST['qtype'] == 'DescripcionSeguimiento') 
								{
									$_POST['qtype'] = 'T.DES_SEGUIMIENTO';
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
                $ogridDAO->Count_PROY_SEGUIMIENTO($lDataSet, $procedure_parametrosP); //JCMY
					$nTotal = $lDataSet[0]->IDE_SEGUIMIENTO;                     
				
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
				
						if (strlen($FEC_SEGUIMIENTO)>0)
						{
							$FEC_SEGUIMIENTO      = cambiafecha($FEC_SEGUIMIENTO);
						}
						else
						{
							$FEC_SEGUIMIENTO      = "";
						}
			
                /*FIN DE ACTIVACION*/

                $DataSet_PROY_SEGUIMIENTOM     = array();
                $Objeto_PROY_SEGUIMIENTO_DAO  = new PROY_SEGUIMIENTO_DAO();
                $lstparametrosM   = array();
				 if (strlen(rtrim($IDE_PROYECTO)) > 0)  {	
					$lstparametrosM['IDE_PROYECTO'] 		= $IDE_PROYECTO;
				 }	
				 if (strlen(rtrim($FEC_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['FEC_SEGUIMIENTO'] 		= $FEC_SEGUIMIENTO;
				 }	
				 if (strlen(rtrim($DES_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['DES_SEGUIMIENTO'] 		= $DES_SEGUIMIENTO;
				 }	
				 if (strlen(rtrim($EST_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['EST_SEGUIMIENTO'] 		= $EST_SEGUIMIENTO;
				 }			        $lstparametrosM['Usuario']           = $usuario;
                $lstparametrosM['PCODIGO']           = str_repeat("0", 100);
                $lstparametrosM['PMENSAJE']          = str_repeat("0", 200);
				
                $procedure_parametrosMS = array(
					array(&$lstparametrosM['IDE_PROYECTO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['FEC_SEGUIMIENTO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['DES_SEGUIMIENTO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['EST_SEGUIMIENTO'],       SQLSRV_PARAM_IN)

                    , array(&$lstparametrosM['Usuario'],            SQLSRV_PARAM_IN)
                    , array(&$lstparametrosM['PCODIGO'],            SQLSRV_PARAM_OUT)
                    , array(&$lstparametrosM['PMENSAJE'],           SQLSRV_PARAM_OUT)                
                );
                $Objeto_PROY_SEGUIMIENTO_DAO->Insert_PROY_SEGUIMIENTO($DataSet_PROY_SEGUIMIENTO, $procedure_parametrosMS); //JCMY
				
				$CodMensaje = $procedure_parametrosMS[5][0];		
								
                $mensaje    = $procedure_parametrosMS[6][0];
				
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
                $DataSet_PROY_SEGUIMIENTO        = array();  
                $Objeto_PROY_SEGUIMIENTO_DAO     = new PROY_SEGUIMIENTO_DAO();
                $lstparametrosM     = array();
                $lstparametrosM['SeleccionarID']       = $SeleccionarID;
                $procedure_parametrosMS = array(                  
                      array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                );            
                $Objeto_PROY_SEGUIMIENTO_DAO->SelPk_PROY_SEGUIMIENTO($DataSet_PROY_SEGUIMIENTO, $procedure_parametrosMS); // JCMY
                //var_dump($procedure_parametrosMS);
                $listaContador  = count($DataSet_PROY_SEGUIMIENTO) > 0 ? true : false; //JCMY
                //var_dump($listaContador);exit;
                if (($listaContador == true) || ($listaContador > 0)) 
                {                   
                    //Recuperando Valores del arreglo $DataSet_PROY_SEGUIMIENTO
					
							$IDE_PROYECTO  =  $DataSet_PROY_SEGUIMIENTO[0]->IDE_PROYECTO;
							$FEC_SEGUIMIENTO  =  $DataSet_PROY_SEGUIMIENTO[0]->FEC_SEGUIMIENTO;
							$DES_SEGUIMIENTO  =  $DataSet_PROY_SEGUIMIENTO[0]->DES_SEGUIMIENTO;
							$EST_SEGUIMIENTO  =  $DataSet_PROY_SEGUIMIENTO[0]->EST_SEGUIMIENTO;					
                }                                    
                $lCollection->Add('SeleccionarID',$SeleccionarID);
						$lCollection->Add('IDE_PROYECTO', $IDE_PROYECTO);
						$lCollection->Add('FEC_SEGUIMIENTO', $FEC_SEGUIMIENTO);
						$lCollection->Add('DES_SEGUIMIENTO', $DES_SEGUIMIENTO);
						$lCollection->Add('EST_SEGUIMIENTO', $EST_SEGUIMIENTO);				
            
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
				
						if (strlen($FEC_SEGUIMIENTO)>0)
						{
							$FEC_SEGUIMIENTO      = cambiafecha($FEC_SEGUIMIENTO);
						}
						else
						{
							$FEC_SEGUIMIENTO      = "";
						}
			
                //var_dump($FechaHoraRegistro);exit;        
                /*FIN DE ACTIVACION*/
                $DataSet_PROY_SEGUIMIENTO     = array();  
                $Objeto_PROY_SEGUIMIENTO_DAO  = new PROY_SEGUIMIENTO_DAO();  
				
				$lstparametrosM['SeleccionarID'] = $SeleccionarID;
				 if (strlen(rtrim($IDE_PROYECTO)) > 0)  {	
					$lstparametrosM['IDE_PROYECTO'] = $IDE_PROYECTO;
				 }	
				 if (strlen(rtrim($FEC_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['FEC_SEGUIMIENTO'] = $FEC_SEGUIMIENTO;
				 }	
				 if (strlen(rtrim($DES_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['DES_SEGUIMIENTO'] = $DES_SEGUIMIENTO;
				 }	
				 if (strlen(rtrim($EST_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['EST_SEGUIMIENTO'] = $EST_SEGUIMIENTO;
				 }			
                $lstparametrosM['Usuario']           = $usuario;
                $lstparametrosM['PCODIGO']           = str_repeat("0", 100);
                $lstparametrosM['PMENSAJE']          = str_repeat("0", 200); 
								
                $procedure_parametrosMS = array(
                      array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['IDE_PROYECTO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['FEC_SEGUIMIENTO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['DES_SEGUIMIENTO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['EST_SEGUIMIENTO'], SQLSRV_PARAM_IN)				
                    , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)

                );                        
                $Objeto_PROY_SEGUIMIENTO_DAO->Update_PROY_SEGUIMIENTO($DataSet_PROY_SEGUIMIENTO, $procedure_parametrosMS);   //JCMY

				$CodMensaje = $procedure_parametrosMS[6][0];
								
				$mensaje = $procedure_parametrosMS[7][0];
				
                $lCollection->Add('CodMensaje', $CodMensaje);
                $lCollection->Add('Mensaje', $mensaje);
            }     
            
            /*******************************************************************
             *          METODO ELIMINAR REGISTRO     
            /*******************************************************************/ 
            if ($Action == "EliminaRegistro")
                {
                    $DataSet_PROY_SEGUIMIENTO                     = array();
                    $Objeto_PROY_SEGUIMIENTO_DAO                  = new PROY_SEGUIMIENTO_DAO();
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
                    $Objeto_PROY_SEGUIMIENTO_DAO->Delete_PROY_SEGUIMIENTO($DataSet_PROY_SEGUIMIENTO, $procedure_parametrosMS); //JCMY
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

									
					/*					*/
									
					/*					*/
									
					/*					*/
									
					/*					*/
										
						$DataSet_GEN_TABLAS_1    = array(); 
						$Objeto_EST_SEGUIMIENTO_DAO  	    = new GEN_TABLAS_DAO();
						$lstparametrosM         = array();   
						$lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
						$lstparametrosM['filtro'] = "AND COD_TABLA = '99'";
						
						$procedure_parametrosMS = array(                  
							array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
							,array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
						);	
						
						$Objeto_EST_SEGUIMIENTO_DAO ->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1,$procedure_parametrosMS);       
						$lCollection->Add('DataSet_GEN_TABLAS_1',$DataSet_GEN_TABLAS_1);	
											
					/*					*/

			 
 
 
        /* EDGAR */
        $lCollection->Add('crud', crud( $usuario , $PermisosPerfil , $Pedido , $SeleccionarID ) ) ;
        /* EDGAR */
                 

        }           
    }    
    //var_dump($lstDepartamento);exit;
