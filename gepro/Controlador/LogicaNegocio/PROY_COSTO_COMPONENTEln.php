<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    	  : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. julio César Meza Yangali                     
//  Propósito       : PROY_COSTO_COMPONENTEln de la tabla PROY_COSTO_COMPONENTE
//  Fecha           : sábado, 3 de julio de 2021 6:37:49
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : sábado, 3 de julio de 2021 6:37:49
//
//******************************************************************************/
    require_once(PATH_CONTROLADOR_DAO . "/PROY_COSTO_COMPONENTEDAO.php");
    require_once(RECURSOSGEN_LIB . "/Fechas.php");
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(RECURSOSGEN_LIB . "/util.php");
    require_once(PATH_LIB . '/util.php');    
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    /*AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES*/
	

			require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php"); 
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
        $PaginaFormulario = "PROY_COSTO_COMPONENTE";
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
				$FEC_CAMBIO          =   isset($_REQUEST['FEC_CAMBIO'])? VerificarInputs($_REQUEST['FEC_CAMBIO']) : "";
				$PCT_AVANCE_FISICO          =   isset($_REQUEST['PCT_AVANCE_FISICO'])? VerificarInputs($_REQUEST['PCT_AVANCE_FISICO']) : "";
				$IMP_CTO_PLAN_CIERRE          =   isset($_REQUEST['IMP_CTO_PLAN_CIERRE'])? VerificarInputs($_REQUEST['IMP_CTO_PLAN_CIERRE']) : "";
				$IMP_CTO_PERFIL          =   isset($_REQUEST['IMP_CTO_PERFIL'])? VerificarInputs($_REQUEST['IMP_CTO_PERFIL']) : "";
				$IMP_CTO_EXPEDIENTE          =   isset($_REQUEST['IMP_CTO_EXPEDIENTE'])? VerificarInputs($_REQUEST['IMP_CTO_EXPEDIENTE']) : "";
				$IMP_CTO_OBRA          =   isset($_REQUEST['IMP_CTO_OBRA'])? VerificarInputs($_REQUEST['IMP_CTO_OBRA']) : "";
				$IMP_CTO_SUPERVISION          =   isset($_REQUEST['IMP_CTO_SUPERVISION'])? VerificarInputs($_REQUEST['IMP_CTO_SUPERVISION']) : "";
				$IMP_CTO_GESTION_PROY          =   isset($_REQUEST['IMP_CTO_GESTION_PROY'])? VerificarInputs($_REQUEST['IMP_CTO_GESTION_PROY']) : "";
				$IMP_CTO_CAPACITACION          =   isset($_REQUEST['IMP_CTO_CAPACITACION'])? VerificarInputs($_REQUEST['IMP_CTO_CAPACITACION']) : "";
				$IMP_CTO_POST_CIERRE          =   isset($_REQUEST['IMP_CTO_POST_CIERRE'])? VerificarInputs($_REQUEST['IMP_CTO_POST_CIERRE']) : "";
				$TIP_COMPONENTE_ACT          =   isset($_REQUEST['TIP_COMPONENTE_ACT'])? VerificarInputs($_REQUEST['TIP_COMPONENTE_ACT']) : "";
				$DES_ACTUALIZACION          =   isset($_REQUEST['DES_ACTUALIZACION'])? VerificarInputs($_REQUEST['DES_ACTUALIZACION']) : "";
				$EST_CAMBIO          =   isset($_REQUEST['EST_CAMBIO'])? VerificarInputs($_REQUEST['EST_CAMBIO']) : "";			
            /* FLEXIGRID */
            //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
																		$ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            
            
/*EDGAR*/
         ////// GRILLA PREDETERMINADA
         $TipoGrilla = 'SelGrd_PROY_COSTO_COMPONENTE';
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
                $ogridDAO   = new PROY_COSTO_COMPONENTE_DAO();    
                $Prueba="ActionFlex";				
				
                if($_POST['query']<>'%')
                {
                    if(strlen(VerificarInputs($_POST['query'])) > 0)
                    {
						

								if ($_POST['qtype'] == 'TipoComponente') 
								{
									$_POST['qtype'] = 'T105.DES_ITEM';
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
                $ogridDAO->Count_PROY_COSTO_COMPONENTE($lDataSet, $procedure_parametrosP); //JCMY
					$nTotal = $lDataSet[0]->IDE_PROY_COSTO_COMPONENTE;                     
				
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
				
						if (strlen($FEC_CAMBIO)>0)
						{
							$FEC_CAMBIO      = cambiafecha($FEC_CAMBIO);
						}
						else
						{
							$FEC_CAMBIO      = "";
						}
			
                /*FIN DE ACTIVACION*/

                $DataSet_PROY_COSTO_COMPONENTEM     = array();
                $Objeto_PROY_COSTO_COMPONENTE_DAO  = new PROY_COSTO_COMPONENTE_DAO();
                $lstparametrosM   = array();
				 if (strlen(rtrim($IDE_PROYECTO)) > 0)  {	
					$lstparametrosM['IDE_PROYECTO'] 		= $IDE_PROYECTO;
				 }	
				 if (strlen(rtrim($FEC_CAMBIO)) > 0)  {	
					$lstparametrosM['FEC_CAMBIO'] 		= $FEC_CAMBIO;
				 }	
				 if (strlen(rtrim($PCT_AVANCE_FISICO)) > 0)  {	
					$lstparametrosM['PCT_AVANCE_FISICO'] 		= $PCT_AVANCE_FISICO;
				 }	
				 if (strlen(rtrim($IMP_CTO_PLAN_CIERRE)) > 0)  {	
					$lstparametrosM['IMP_CTO_PLAN_CIERRE'] 		= $IMP_CTO_PLAN_CIERRE;
				 }	
				 if (strlen(rtrim($IMP_CTO_PERFIL)) > 0)  {	
					$lstparametrosM['IMP_CTO_PERFIL'] 		= $IMP_CTO_PERFIL;
				 }	
				 if (strlen(rtrim($IMP_CTO_EXPEDIENTE)) > 0)  {	
					$lstparametrosM['IMP_CTO_EXPEDIENTE'] 		= $IMP_CTO_EXPEDIENTE;
				 }	
				 if (strlen(rtrim($IMP_CTO_OBRA)) > 0)  {	
					$lstparametrosM['IMP_CTO_OBRA'] 		= $IMP_CTO_OBRA;
				 }	
				 if (strlen(rtrim($IMP_CTO_SUPERVISION)) > 0)  {	
					$lstparametrosM['IMP_CTO_SUPERVISION'] 		= $IMP_CTO_SUPERVISION;
				 }	
				 if (strlen(rtrim($IMP_CTO_GESTION_PROY)) > 0)  {	
					$lstparametrosM['IMP_CTO_GESTION_PROY'] 		= $IMP_CTO_GESTION_PROY;
				 }	
				 if (strlen(rtrim($IMP_CTO_CAPACITACION)) > 0)  {	
					$lstparametrosM['IMP_CTO_CAPACITACION'] 		= $IMP_CTO_CAPACITACION;
				 }	
				 if (strlen(rtrim($IMP_CTO_POST_CIERRE)) > 0)  {	
					$lstparametrosM['IMP_CTO_POST_CIERRE'] 		= $IMP_CTO_POST_CIERRE;
				 }	
				 if (strlen(rtrim($TIP_COMPONENTE_ACT)) > 0)  {	
					$lstparametrosM['TIP_COMPONENTE_ACT'] 		= $TIP_COMPONENTE_ACT;
				 }	
				 if (strlen(rtrim($DES_ACTUALIZACION)) > 0)  {	
					$lstparametrosM['DES_ACTUALIZACION'] 		= $DES_ACTUALIZACION;
				 }	
				 if (strlen(rtrim($EST_CAMBIO)) > 0)  {	
					$lstparametrosM['EST_CAMBIO'] 		= $EST_CAMBIO;
				 }			        $lstparametrosM['Usuario']           = $usuario;
                $lstparametrosM['PCODIGO']           = str_repeat("0", 100);
                $lstparametrosM['PMENSAJE']          = str_repeat("0", 200);
				
                $procedure_parametrosMS = array(
					array(&$lstparametrosM['IDE_PROYECTO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['FEC_CAMBIO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['PCT_AVANCE_FISICO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['IMP_CTO_PLAN_CIERRE'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['IMP_CTO_PERFIL'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['IMP_CTO_EXPEDIENTE'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['IMP_CTO_OBRA'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['IMP_CTO_SUPERVISION'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['IMP_CTO_GESTION_PROY'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['IMP_CTO_CAPACITACION'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['IMP_CTO_POST_CIERRE'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['TIP_COMPONENTE_ACT'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['DES_ACTUALIZACION'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['EST_CAMBIO'],       SQLSRV_PARAM_IN)

                    , array(&$lstparametrosM['Usuario'],            SQLSRV_PARAM_IN)
                    , array(&$lstparametrosM['PCODIGO'],            SQLSRV_PARAM_OUT)
                    , array(&$lstparametrosM['PMENSAJE'],           SQLSRV_PARAM_OUT)                
                );
                $Objeto_PROY_COSTO_COMPONENTE_DAO->Insert_PROY_COSTO_COMPONENTE($DataSet_PROY_COSTO_COMPONENTE, $procedure_parametrosMS); //JCMY
				
				$CodMensaje = $procedure_parametrosMS[15][0];		
								
                $mensaje    = $procedure_parametrosMS[16][0];
				
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
                $DataSet_PROY_COSTO_COMPONENTE        = array();  
                $Objeto_PROY_COSTO_COMPONENTE_DAO     = new PROY_COSTO_COMPONENTE_DAO();
                $lstparametrosM     = array();
                $lstparametrosM['SeleccionarID']       = $SeleccionarID;
                $procedure_parametrosMS = array(                  
                      array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                );            
                $Objeto_PROY_COSTO_COMPONENTE_DAO->SelPk_PROY_COSTO_COMPONENTE($DataSet_PROY_COSTO_COMPONENTE, $procedure_parametrosMS); // JCMY
                //var_dump($procedure_parametrosMS);
                $listaContador  = count($DataSet_PROY_COSTO_COMPONENTE) > 0 ? true : false; //JCMY
                //var_dump($listaContador);exit;
                if (($listaContador == true) || ($listaContador > 0)) 
                {                   
                    //Recuperando Valores del arreglo $DataSet_PROY_COSTO_COMPONENTE
					
							$IDE_PROYECTO  =  $DataSet_PROY_COSTO_COMPONENTE[0]->IDE_PROYECTO;
							$FEC_CAMBIO  =  $DataSet_PROY_COSTO_COMPONENTE[0]->FEC_CAMBIO;
							$PCT_AVANCE_FISICO  =  $DataSet_PROY_COSTO_COMPONENTE[0]->PCT_AVANCE_FISICO;
							$IMP_CTO_PLAN_CIERRE  =  $DataSet_PROY_COSTO_COMPONENTE[0]->IMP_CTO_PLAN_CIERRE;
							$IMP_CTO_PERFIL  =  $DataSet_PROY_COSTO_COMPONENTE[0]->IMP_CTO_PERFIL;
							$IMP_CTO_EXPEDIENTE  =  $DataSet_PROY_COSTO_COMPONENTE[0]->IMP_CTO_EXPEDIENTE;
							$IMP_CTO_OBRA  =  $DataSet_PROY_COSTO_COMPONENTE[0]->IMP_CTO_OBRA;
							$IMP_CTO_SUPERVISION  =  $DataSet_PROY_COSTO_COMPONENTE[0]->IMP_CTO_SUPERVISION;
							$IMP_CTO_GESTION_PROY  =  $DataSet_PROY_COSTO_COMPONENTE[0]->IMP_CTO_GESTION_PROY;
							$IMP_CTO_CAPACITACION  =  $DataSet_PROY_COSTO_COMPONENTE[0]->IMP_CTO_CAPACITACION;
							$IMP_CTO_POST_CIERRE  =  $DataSet_PROY_COSTO_COMPONENTE[0]->IMP_CTO_POST_CIERRE;
							$TIP_COMPONENTE_ACT  =  $DataSet_PROY_COSTO_COMPONENTE[0]->TIP_COMPONENTE_ACT;
							$DES_ACTUALIZACION  =  $DataSet_PROY_COSTO_COMPONENTE[0]->DES_ACTUALIZACION;
							$EST_CAMBIO  =  $DataSet_PROY_COSTO_COMPONENTE[0]->EST_CAMBIO;					
                }                                    
                $lCollection->Add('SeleccionarID',$SeleccionarID);
						$lCollection->Add('IDE_PROYECTO', $IDE_PROYECTO);
						$lCollection->Add('FEC_CAMBIO', $FEC_CAMBIO);
						$lCollection->Add('PCT_AVANCE_FISICO', $PCT_AVANCE_FISICO);
						$lCollection->Add('IMP_CTO_PLAN_CIERRE', $IMP_CTO_PLAN_CIERRE);
						$lCollection->Add('IMP_CTO_PERFIL', $IMP_CTO_PERFIL);
						$lCollection->Add('IMP_CTO_EXPEDIENTE', $IMP_CTO_EXPEDIENTE);
						$lCollection->Add('IMP_CTO_OBRA', $IMP_CTO_OBRA);
						$lCollection->Add('IMP_CTO_SUPERVISION', $IMP_CTO_SUPERVISION);
						$lCollection->Add('IMP_CTO_GESTION_PROY', $IMP_CTO_GESTION_PROY);
						$lCollection->Add('IMP_CTO_CAPACITACION', $IMP_CTO_CAPACITACION);
						$lCollection->Add('IMP_CTO_POST_CIERRE', $IMP_CTO_POST_CIERRE);
						$lCollection->Add('TIP_COMPONENTE_ACT', $TIP_COMPONENTE_ACT);
						$lCollection->Add('DES_ACTUALIZACION', $DES_ACTUALIZACION);
						$lCollection->Add('EST_CAMBIO', $EST_CAMBIO);				
            
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
				
						if (strlen($FEC_CAMBIO)>0)
						{
							$FEC_CAMBIO      = cambiafecha($FEC_CAMBIO);
						}
						else
						{
							$FEC_CAMBIO      = "";
						}
			
                //var_dump($FechaHoraRegistro);exit;        
                /*FIN DE ACTIVACION*/
                $DataSet_PROY_COSTO_COMPONENTE     = array();  
                $Objeto_PROY_COSTO_COMPONENTE_DAO  = new PROY_COSTO_COMPONENTE_DAO();  
				
				$lstparametrosM['SeleccionarID'] = $SeleccionarID;
				 if (strlen(rtrim($IDE_PROYECTO)) > 0)  {	
					$lstparametrosM['IDE_PROYECTO'] = $IDE_PROYECTO;
				 }	
				 if (strlen(rtrim($FEC_CAMBIO)) > 0)  {	
					$lstparametrosM['FEC_CAMBIO'] = $FEC_CAMBIO;
				 }	
				 if (strlen(rtrim($PCT_AVANCE_FISICO)) > 0)  {	
					$lstparametrosM['PCT_AVANCE_FISICO'] = $PCT_AVANCE_FISICO;
				 }	
				 if (strlen(rtrim($IMP_CTO_PLAN_CIERRE)) > 0)  {	
					$lstparametrosM['IMP_CTO_PLAN_CIERRE'] = $IMP_CTO_PLAN_CIERRE;
				 }	
				 if (strlen(rtrim($IMP_CTO_PERFIL)) > 0)  {	
					$lstparametrosM['IMP_CTO_PERFIL'] = $IMP_CTO_PERFIL;
				 }	
				 if (strlen(rtrim($IMP_CTO_EXPEDIENTE)) > 0)  {	
					$lstparametrosM['IMP_CTO_EXPEDIENTE'] = $IMP_CTO_EXPEDIENTE;
				 }	
				 if (strlen(rtrim($IMP_CTO_OBRA)) > 0)  {	
					$lstparametrosM['IMP_CTO_OBRA'] = $IMP_CTO_OBRA;
				 }	
				 if (strlen(rtrim($IMP_CTO_SUPERVISION)) > 0)  {	
					$lstparametrosM['IMP_CTO_SUPERVISION'] = $IMP_CTO_SUPERVISION;
				 }	
				 if (strlen(rtrim($IMP_CTO_GESTION_PROY)) > 0)  {	
					$lstparametrosM['IMP_CTO_GESTION_PROY'] = $IMP_CTO_GESTION_PROY;
				 }	
				 if (strlen(rtrim($IMP_CTO_CAPACITACION)) > 0)  {	
					$lstparametrosM['IMP_CTO_CAPACITACION'] = $IMP_CTO_CAPACITACION;
				 }	
				 if (strlen(rtrim($IMP_CTO_POST_CIERRE)) > 0)  {	
					$lstparametrosM['IMP_CTO_POST_CIERRE'] = $IMP_CTO_POST_CIERRE;
				 }	
				 if (strlen(rtrim($TIP_COMPONENTE_ACT)) > 0)  {	
					$lstparametrosM['TIP_COMPONENTE_ACT'] = $TIP_COMPONENTE_ACT;
				 }	
				 if (strlen(rtrim($DES_ACTUALIZACION)) > 0)  {	
					$lstparametrosM['DES_ACTUALIZACION'] = $DES_ACTUALIZACION;
				 }	
				 if (strlen(rtrim($EST_CAMBIO)) > 0)  {	
					$lstparametrosM['EST_CAMBIO'] = $EST_CAMBIO;
				 }			
                $lstparametrosM['Usuario']           = $usuario;
                $lstparametrosM['PCODIGO']           = str_repeat("0", 100);
                $lstparametrosM['PMENSAJE']          = str_repeat("0", 200); 
								
                $procedure_parametrosMS = array(
                      array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['IDE_PROYECTO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['FEC_CAMBIO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['PCT_AVANCE_FISICO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['IMP_CTO_PLAN_CIERRE'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['IMP_CTO_PERFIL'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['IMP_CTO_EXPEDIENTE'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['IMP_CTO_OBRA'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['IMP_CTO_SUPERVISION'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['IMP_CTO_GESTION_PROY'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['IMP_CTO_CAPACITACION'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['IMP_CTO_POST_CIERRE'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['TIP_COMPONENTE_ACT'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['DES_ACTUALIZACION'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['EST_CAMBIO'], SQLSRV_PARAM_IN)				
                    , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)

                );                        
                $Objeto_PROY_COSTO_COMPONENTE_DAO->Update_PROY_COSTO_COMPONENTE($DataSet_PROY_COSTO_COMPONENTE, $procedure_parametrosMS);   //JCMY

				$CodMensaje = $procedure_parametrosMS[16][0];
								
				$mensaje = $procedure_parametrosMS[17][0];
				
                $lCollection->Add('CodMensaje', $CodMensaje);
                $lCollection->Add('Mensaje', $mensaje);
            }     
            
            /*******************************************************************
             *          METODO ELIMINAR REGISTRO     
            /*******************************************************************/ 
            if ($Action == "EliminaRegistro")
                {
                    $DataSet_PROY_COSTO_COMPONENTE                     = array();
                    $Objeto_PROY_COSTO_COMPONENTE_DAO                  = new PROY_COSTO_COMPONENTE_DAO();
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
                    $Objeto_PROY_COSTO_COMPONENTE_DAO->Delete_PROY_COSTO_COMPONENTE($DataSet_PROY_COSTO_COMPONENTE, $procedure_parametrosMS); //JCMY
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
									
					/*					*/
									
					/*					*/
									
					/*					*/
									
					/*					*/
									
					/*					*/
									
					/*					*/
									
					/*					*/
									
					/*					*/
										
						$DataSet_GEN_TABLAS_1    = array(); 
						$Objeto_TIP_COMPONENTE_ACT_DAO  	    = new GEN_TABLAS_DAO();
						$lstparametrosM         = array();   
						$lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
						$lstparametrosM['filtro'] = "AND COD_TABLA = '105'";
						
						$procedure_parametrosMS = array(                  
							array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
							,array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
						);	
						
						$Objeto_TIP_COMPONENTE_ACT_DAO ->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1,$procedure_parametrosMS);       
						$lCollection->Add('DataSet_GEN_TABLAS_1',$DataSet_GEN_TABLAS_1);	
											
					/*					*/
									
					/*					*/
										
						$DataSet_GEN_TABLAS_2    = array(); 
						$Objeto_EST_CAMBIO_DAO  	    = new GEN_TABLAS_DAO();
						$lstparametrosM         = array();   
						$lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
						$lstparametrosM['filtro'] = "AND COD_TABLA = '99'";
						
						$procedure_parametrosMS = array(                  
							array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
							,array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
						);	
						
						$Objeto_EST_CAMBIO_DAO ->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2,$procedure_parametrosMS);       
						$lCollection->Add('DataSet_GEN_TABLAS_2',$DataSet_GEN_TABLAS_2);	
											
					/*					*/

			 
 
 
        /* EDGAR */
        $lCollection->Add('crud', crud( $usuario , $PermisosPerfil , $Pedido , $SeleccionarID ) ) ;
        /* EDGAR */
                 

        }           
    }    
    //var_dump($lstDepartamento);exit;
