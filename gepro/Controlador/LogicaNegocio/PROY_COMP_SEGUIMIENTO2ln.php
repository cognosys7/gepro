<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Edgar David Pisfil Ahumada                                    
//  Propósito       : PROY_COMP_SEGUIMIENTO2LN de la tabla PROY_COMP_SEGUIMIENTO2
//  Fecha           : miércoles, 18 de setiembre de 2019 17:56:29
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM - J8(1)
//  Modificado      : 29 de Junio 2019
//
/******************************************************************************/
    require_once(PATH_CONTROLADOR_DAO . "/PROY_COMP_SEGUIMIENTO2DAO.php");
    require_once(RECURSOSGEN_LIB . "/Fechas.php");
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(RECURSOSGEN_LIB . "/util.php");
    require_once(PATH_LIB . '/util.php');    
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    /*AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES*/
	

			require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php"); 



/*EDGAR*/
//require_once("include/GEN_TABLASLNI.php");
//// busqueda lni
/*EDGAR*/


    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "PROY_COMP_SEGUIMIENTO2";
        $PermisoOK        = 0;


/*HECTOR*/    
    //OBTENGOS LOS POST ANTIREFRESH
    if (!empty($_POST['Mensaje'])) { $mensaje = $_POST['Mensaje']; } else { $mensaje = 0;}
    
    //OBTENGO LAS SESIONES
    if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
    if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
    if (!empty($_SESSION['personal'])) { $personal = $_SESSION['personal'];} else { $personal = 0;}
    if (!empty($_SESSION['Oc'])) { $Opcionsession = $_SESSION['Oc'];} else { $Opcionsession = 0;}	
    $PermisosPerfil = CallNomPerfil($perfilsession);
    $PermisoOK = VerificaAccesoMenu($Opcionsession,$perfilsession);// echo $PermisosPerfil; die;
/*HECTOR*/ 

        
        if ($PermisoOK == 1)       {
            /*******************************************************************
             *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
            /*******************************************************************/             
            //ACCIONES PARA EL FORMULARIO
            $Action             = isset($_REQUEST['ActionForm'])? VerificarInputs($_REQUEST['ActionForm']) : "";
            $ActionFlex         = isset($_REQUEST['Accion'])? VerificarInputs($_REQUEST['Accion']) : "";
			
/*EDGAR*/
        $PIDE = isset($_REQUEST['PIDE']) ? VerificarInputs($_REQUEST['PIDE']) : "";
        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : "";
        $PIDEbuscado = isset($_REQUEST['PIDEbuscado']) ? VerificarInputs($_REQUEST['PIDEbuscado']) : "";
/*EDGAR*/
            
            /*******************************************************************
             *     RECUPERACION DE DATOS DEL FORMULARIO
            /*******************************************************************/ 
				$SeleccionarID   =   isset($_REQUEST['SeleccionarID'])? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
				$IDE_PROY_COMPONENTE          =   isset($_REQUEST['IDE_PROY_COMPONENTE'])? VerificarInputs($_REQUEST['IDE_PROY_COMPONENTE']) : "";
				$FEC_SEGUIMIENTO          =   isset($_REQUEST['FEC_SEGUIMIENTO'])? VerificarInputs($_REQUEST['FEC_SEGUIMIENTO']) : "";
				$DES_SEGUIMIENTO          =   isset($_REQUEST['DES_SEGUIMIENTO'])? VerificarInputs($_REQUEST['DES_SEGUIMIENTO']) : "";
				$TIP_SEGUIMIENTO          =   isset($_REQUEST['TIP_SEGUIMIENTO'])? VerificarInputs($_REQUEST['TIP_SEGUIMIENTO']) : "";
				$EST_SEGUIMIENTO          =   isset($_REQUEST['EST_SEGUIMIENTO'])? VerificarInputs($_REQUEST['EST_SEGUIMIENTO']) : "";			
            /* FLEXIGRID */
            //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
																		$ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            
            
/*EDGAR*/
         $TipoGrilla = 'SelGrd_PROY_COMP_SEGUIMIENTO2';
         
//       if ( $PIDE>0 ){
//             $ScriptFLX .= " AND P.COD_TABLA=$PIDE";
//             $pAuxiliar = '';   
//               
//             $Tabla_DatosPadre = '<table class="tbDatoPadre" style="width:100%">';
//             $Tabla_DatosPadre .= '<tr><td>';
//             $Tabla_DatosPadre .= Tabla_Proyecto_Datos($Data'IDE_PROYECTO').'<hr>'.Tabla_ProyectoComunicacion_Datos($PIDE , $Data1'DES_ITEM');
//             $Tabla_DatosPadre .= '</tr></td>';
//             $Tabla_DatosPadre .= '</table>';   
//       } 
//       else {
//             $ScriptFLX .= " AND T.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;

/*EDGAR*/
            
            /*******************************************************************
             *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
            /*******************************************************************/ 
            if ($ActionFlex == "LoadJsonList")
            {            
                $lDataSet      = array();
                $ogridDAO   = new PROY_COMP_SEGUIMIENTO2_DAO();    
                $Prueba="ActionFlex";				
				
                if($_POST['query']<>'%')
                {
                    if(strlen(VerificarInputs($_POST['query'])) > 0)
                    {
												
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
                $ogridDAO->Count_PROY_COMP_SEGUIMIENTO2($lDataSet, $procedure_parametrosP); //JCMY
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
//            $Data1 = Recurso_Datos($Data'IDE_RECURSO');
//            $Data2 = Cargo_Datos($Data'IDE_PUESTO');
            
//            $Bdescripcion = $Data1'DES_RECURSO' .' ( '. $Data2'DES_CARGO' .' ) ' ;
            
//            $lCollection->Add('BIDE', $Data'BIDE');
//            $lCollection->Add('Bdescripcion', $Bdescripcion);
        }
            
            
            
            /*******************************************************************
             *        METODO PARA INSERTAR UN REGISTRO 
            /*******************************************************************/ 
            if ($Action == "RegistraDatos")
            {
                /*ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA*/     
							
                /*FIN DE ACTIVACION*/

                $DataSet_PROY_COMP_SEGUIMIENTO2M     = array();
                $Objeto_PROY_COMP_SEGUIMIENTO2_DAO  = new PROY_COMP_SEGUIMIENTO2_DAO();
                $lstparametrosM   = array();
				 if (strlen(rtrim($IDE_PROY_COMPONENTE)) > 0)  {	
					$lstparametrosM['IDE_PROY_COMPONENTE'] 		= $IDE_PROY_COMPONENTE;
				 }	
				 if (strlen(rtrim($FEC_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['FEC_SEGUIMIENTO'] 		= $FEC_SEGUIMIENTO;
				 }	
				 if (strlen(rtrim($DES_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['DES_SEGUIMIENTO'] 		= $DES_SEGUIMIENTO;
				 }	
				 if (strlen(rtrim($TIP_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['TIP_SEGUIMIENTO'] 		= $TIP_SEGUIMIENTO;
				 }	
				 if (strlen(rtrim($EST_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['EST_SEGUIMIENTO'] 		= $EST_SEGUIMIENTO;
				 }			        $lstparametrosM['Usuario']           = $usuario;
                $lstparametrosM['PCODIGO']           = str_repeat("0", 100);
                $lstparametrosM['PMENSAJE']          = str_repeat("0", 200);
				
                $procedure_parametrosMS = array(
					array(&$lstparametrosM['IDE_PROY_COMPONENTE'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['FEC_SEGUIMIENTO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['DES_SEGUIMIENTO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['TIP_SEGUIMIENTO'],       SQLSRV_PARAM_IN),
					array(&$lstparametrosM['EST_SEGUIMIENTO'],       SQLSRV_PARAM_IN)

                    , array(&$lstparametrosM['Usuario'],            SQLSRV_PARAM_IN)
                    , array(&$lstparametrosM['PCODIGO'],            SQLSRV_PARAM_OUT)
                    , array(&$lstparametrosM['PMENSAJE'],           SQLSRV_PARAM_OUT)                
                );
                $Objeto_PROY_COMP_SEGUIMIENTO2_DAO->Insert_PROY_COMP_SEGUIMIENTO2($DataSet_PROY_COMP_SEGUIMIENTO2, $procedure_parametrosMS); //JCMY
				
				$CodMensaje = $procedure_parametrosMS[6][0];		
								
                $mensaje    = $procedure_parametrosMS[7][0];
				
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
                $DataSet_PROY_COMP_SEGUIMIENTO2        = array();  
                $Objeto_PROY_COMP_SEGUIMIENTO2_DAO     = new PROY_COMP_SEGUIMIENTO2_DAO();
                $lstparametrosM     = array();
                $lstparametrosM['SeleccionarID']       = $SeleccionarID;
                $procedure_parametrosMS = array(                  
                      array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                );            
                $Objeto_PROY_COMP_SEGUIMIENTO2_DAO->SelPk_PROY_COMP_SEGUIMIENTO2($DataSet_PROY_COMP_SEGUIMIENTO2, $procedure_parametrosMS); // JCMY
                //var_dump($procedure_parametrosMS);
                $listaContador  = count($DataSet_PROY_COMP_SEGUIMIENTO2) > 0 ? true : false; //JCMY
                //var_dump($listaContador);exit;
                if (($listaContador == true) || ($listaContador > 0)) 
                {                   
                    //Recuperando Valores del arreglo $DataSet_PROY_COMP_SEGUIMIENTO2
					
							$IDE_PROY_COMPONENTE  =  $DataSet_PROY_COMP_SEGUIMIENTO2[0]->IDE_PROY_COMPONENTE;
							$FEC_SEGUIMIENTO  =  $DataSet_PROY_COMP_SEGUIMIENTO2[0]->FEC_SEGUIMIENTO;
							$DES_SEGUIMIENTO  =  $DataSet_PROY_COMP_SEGUIMIENTO2[0]->DES_SEGUIMIENTO;
							$TIP_SEGUIMIENTO  =  $DataSet_PROY_COMP_SEGUIMIENTO2[0]->TIP_SEGUIMIENTO;
							$EST_SEGUIMIENTO  =  $DataSet_PROY_COMP_SEGUIMIENTO2[0]->EST_SEGUIMIENTO;					
                }                                    
                $lCollection->Add('SeleccionarID',$SeleccionarID);
						$lCollection->Add('IDE_PROY_COMPONENTE', $IDE_PROY_COMPONENTE);
						$lCollection->Add('FEC_SEGUIMIENTO', $FEC_SEGUIMIENTO);
						$lCollection->Add('DES_SEGUIMIENTO', $DES_SEGUIMIENTO);
						$lCollection->Add('TIP_SEGUIMIENTO', $TIP_SEGUIMIENTO);
						$lCollection->Add('EST_SEGUIMIENTO', $EST_SEGUIMIENTO);				
            
            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            //$Data = Comunidad_Datos($IDE_COMUNIDAD);
            //$Data1 = UBIGEO_Datos($Data'COD_UBIGEO');
            
            //$Bdescripcion = $Data'DES_COMUNIDAD' .' ( '. $Data1'DES_DEPARTAMENTO' .' - '. $Data1'DES_PROVINCIA' .' - '. $Data1'DES_DISTRITO' . ' )' ;
            
            //$lCollection->Add('Bdescripcion', $Bdescripcion);
            /* EDGAR */
            
            } 
            
            /*******************************************************************
             *        METODO PARA ACTUALIZAR UN REGISTRO 
            /*******************************************************************/ 
            if ($Action == "ActualizarForm")
            {                
                /*ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA*/  
							
                //var_dump($FechaHoraRegistro);exit;        
                /*FIN DE ACTIVACION*/
                $DataSet_PROY_COMP_SEGUIMIENTO2     = array();  
                $Objeto_PROY_COMP_SEGUIMIENTO2_DAO  = new PROY_COMP_SEGUIMIENTO2_DAO();  
				
				$lstparametrosM['SeleccionarID'] = $SeleccionarID;
				 if (strlen(rtrim($IDE_PROY_COMPONENTE)) > 0)  {	
					$lstparametrosM['IDE_PROY_COMPONENTE'] = $IDE_PROY_COMPONENTE;
				 }	
				 if (strlen(rtrim($FEC_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['FEC_SEGUIMIENTO'] = $FEC_SEGUIMIENTO;
				 }	
				 if (strlen(rtrim($DES_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['DES_SEGUIMIENTO'] = $DES_SEGUIMIENTO;
				 }	
				 if (strlen(rtrim($TIP_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['TIP_SEGUIMIENTO'] = $TIP_SEGUIMIENTO;
				 }	
				 if (strlen(rtrim($EST_SEGUIMIENTO)) > 0)  {	
					$lstparametrosM['EST_SEGUIMIENTO'] = $EST_SEGUIMIENTO;
				 }			
                $lstparametrosM['Usuario']           = $usuario;
                $lstparametrosM['PCODIGO']           = str_repeat("0", 100);
                $lstparametrosM['PMENSAJE']          = str_repeat("0", 200); 
								
                $procedure_parametrosMS = array(
                      array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['IDE_PROY_COMPONENTE'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['FEC_SEGUIMIENTO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['DES_SEGUIMIENTO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['TIP_SEGUIMIENTO'], SQLSRV_PARAM_IN)
						,array(&$lstparametrosM['EST_SEGUIMIENTO'], SQLSRV_PARAM_IN)				
                    , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)

                );                        
                $Objeto_PROY_COMP_SEGUIMIENTO2_DAO->Update_PROY_COMP_SEGUIMIENTO2($DataSet_PROY_COMP_SEGUIMIENTO2, $procedure_parametrosMS);   //JCMY

				$CodMensaje = $procedure_parametrosMS[7][0];
								
				$mensaje = $procedure_parametrosMS[8][0];
				
                $lCollection->Add('CodMensaje', $CodMensaje);
                $lCollection->Add('Mensaje', $mensaje);
            }     
            
            /*******************************************************************
             *          METODO ELIMINAR REGISTRO     
            /*******************************************************************/ 
            if ($Action == "EliminaRegistro")
                {
                    $DataSet_PROY_COMP_SEGUIMIENTO2                     = array();
                    $Objeto_PROY_COMP_SEGUIMIENTO2_DAO                  = new PROY_COMP_SEGUIMIENTO2_DAO();
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
                    $Objeto_PROY_COMP_SEGUIMIENTO2_DAO->Delete_PROY_COMP_SEGUIMIENTO2($DataSet_PROY_COMP_SEGUIMIENTO2, $procedure_parametrosMS); //JCMY
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
										
						$DataSet_GEN_TABLAS_1    = array(); 
						$Objeto_EST_SEGUIMIENTO_DAO  	    = new GEN_TABLAS_DAO();
						$lstparametrosM         = array();   
						$lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
						$lstparametrosM['filtro'] = "AND COD_TABLA='99'";
						
						$procedure_parametrosMS = array(                  
							array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
							,array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
						);	
						
						$Objeto_EST_SEGUIMIENTO_DAO ->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1,$procedure_parametrosMS);       
						$lCollection->Add('DataSet_GEN_TABLAS_1',$DataSet_GEN_TABLAS_1);	
											
					/*					*/

			 
 
/*EDGAR*/
        $lCollection->Add('PIDE', $PIDE);
        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
/*EDGAR*/           

        }           
    }    
    //var_dump($lstDepartamento);exit;