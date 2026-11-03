<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Edgar David Pisfil Ahumada                   
//  Propósito       : PROY_COMP_SEGUIMIENTO2VISTA de la tabla PROY_COMP_SEGUIMIENTO2
//  Fecha           : miércoles, 18 de setiembre de 2019 17:56:29
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM - J8(1)Etiqueta
//  Modificado      : 29 de Junio 2019
//
//******************************************************************************/

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK        = $lCollection->Get('PermisoOK');    
?>
    <!--ESTILOS PARA UTILIZAR-->
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/miflexigridgris.css"  />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/css/botones.css"  />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script>       
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/PROY_COMP_SEGUIMIENTO2.js"></script>    
    
    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>
    
<!--/*EDGAR*/-->
<link rel="stylesheet" type="text/css" href="../lib/css/include.css" />
<!--/*EDGAR*/-->
    
    <script type="text/javascript">
        function cerrarPopup() 
        {
            parent.$.colorbox.close();
            parent.$('#flex1').flexReload();
        }
        $(function(){
            $("#tabs").tabs({active: 0});
            $("#tabs").tabs({disabled: [1]});
        });

        function CallFlexiGrid()
        {
            $('#flex1').flexReload();
        }

    </script>
    <div id="Mensajes"></div>
    <div class="row-fluid">
           <div class="span12">
               <div class="box">
                   <?php                
                   if ($PermisoOK <> 0)
                   {       
			   					
/*EDGAR*/                     
                  $PIDE = $lCollection->Get('PIDE');
                  //$Tabla_DatosPadre = $lCollection->Get('Tabla_DatosPadre');

                  //$pAuxiliar = $lCollection->Get('pAuxiliar');
                  
                  //// pedido es para escoger el tipo de grilla
                    $FormularioAccion = $VerSeleccion = '';
                    $Pedido = ( $lCollection->Get('Pedido') == 'Busqueda' ? $lCollection->Get('Pedido') : '' );
                    if (strlen($Pedido) > 0) {
                        $FormularioAccion = 'PasarDatos';
                        $VerSeleccion = 'SI';
                    } else {
                        $Pedido = 'Mantenimiento';
                    }
/*EDGAR*/					
                   ?>
                   <div class="box-content">
						<!--
                       <table style="height: 30px; width: 100%; background-color: #EDEDED;border: solid 1px #CCCCCC;">
                        <tr>
                            <td style="text-align: left; width: 80%;">
                            </td>
                            <td style="text-align: right; width: 20%;">
                            Cerrar <input name="Submit2" type="button" value="" id="salir16" title="Cerrar" onclick="cerrarPopup();">
                            </td>
                        </tr>
                       </table>
					   -->
                       <div id="tabs">
                           <!-- CAMBIAR ETIQUETAS DE LAS PESTAÑAS-->
                           <ul>
                               <li><a href="#tabs-1">Listado de Seguimiento de Contrato </a></li>
                               <li><a href="#tabs-2">Detalle de Seguimiento de Contrato </a></li>
                           </ul>
                           <!--CONTENIDO DE LA PESTAÑA 1-->
                           <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
                                    <!-- <input type="hidden" name="ActionForm" value=""> -->                               
                                    <input type="hidden" name="SeleccionarID" value="">                                    

<!--/*EDGAR*/-->
                                    <input type="hidden" name="PIDE" value="<?php echo $PIDE; ?>">
                                    <input type="hidden" name="PIDEbuscado" value="">
                                    <input type="hidden" name="ActionForm" value="<?php echo $FormularioAccion; ?>">
<!--/*EDGAR*/-->
	   
                                    <div id="contenedor">        
                                    <div id="fila1">
                                        <div class="limpiar"></div>
                                    </div>   

                                    <div class="msjinformacion" id="mensaje">
                                        Seleccione un registro para editar <?php echo ' - '.$Pedido ; ?>
                                    </div>
                                    <div id="datos">
                                        <table id="flex1" style="display:none">                                        
                                        </table>
                                    </div>

                                    <script type="text/javascript">
                                    $("#flex1").flexigrid
                                    (
                                       {
                                            /*Pagina php donde se realiza la consulta sql */  
      													url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&Pedido=<?php echo $Pedido; ?>',
                                            /* Tipo de datos devuelto json, xml */
                                            dataType: 'json',
                                            /* Metodo de Envio de  Datos*/
                                            method: 'POST',
                                            /* Lista de campo a mostrar en cada columna */
											colModel: [								
                              {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},	
                              {display: 'Fecha', name: 'FEC_SEGUIMIENTO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},	
                              {display: 'Descripción', name: 'DES_SEGUIMIENTO', width: GetColumnSize(70), sortable: true, align: 'left', hide: false},	
                              {display: 'Estado', name: 'EST_SEGUIMIENTO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},	
                              {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},	
								

/*EDGAR*/
/*<?php //if( $pAuxiliar=='Anidado' ) { ?>      {display: 'Valores', name: 'Boton3', width: GetColumnSize(6), sortable: false, align: 'center'},   <?php  //} ?>   */
<?php if( $VerSeleccion == 'SI' ) {   ?>        {display: 'Seleccionar', name: 'Seleccionar', width: GetColumnSize(6), sortable: false, align: 'center'}  
<?php }else {   ?>                              {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center'}
<?php }   ?>
/*EDGAR*/
                                            ],
                                            /*Botones de Enlace*/
                                            buttons: [
<?php if( $VerSeleccion <> 'SI' ) {   ?>{name: 'Nuevo', bclass: 'nuevo', onpress: test},    <?php } ?>
													{separator: true},
													{name: 'Salir', bclass: 'salir', onpress: test}
                                            ],
                                            /*Lista de campo que se podra hacer busqueda */
											
								            searchitems: [									        ],
								
								
											sortname: "Id",        			
											sortorder: "ASC",           /* ordenaor ascendente o descendente */									

                                            usepager: true,             /* activa o descativa paginación */
                                            singleSelect: true,
                                            useRp: true,
                                            rp: 10,
                                            height: $("#datos").innerHeight,
                                            query: '',
											nowrap: false
											                           
/*EDGAR*/
<?php if( $PIDE>0 ) {   ?>                ,title: '<?php //echo $Tabla_DatosPadre; ?>'    <?php }   ?>
/*EDGAR*/									
											
                                            //,title: 'Listado de Personas'
                                            //,showTableToggleBtn: true

                                       }
                                    );
                                    /* Debe seleccionar una fila antes de pulsar el boton */    
                                    function test(com,grid)
                                    {
										var nId = $('.trSelected', grid).children('td:eq(0)').text();
													  if (com == 'Nuevo')
													  {
															Nuevo('<?php echo $PaginaFormulario ?>');
										}
													  else if (com == 'Salir')
													  {
															cerrarPopup()
													  }
													  else
										{
															 $('#mensaje').text('Debe Seleccionar un registro del listado').addClass('msjalerta')
										}
                                    }
                                </script>
                                </div>
                                </form>
                           </div>
                           <!--PESTAÑA 2-->
                           <div id="tabs-2">                           
                               <div id="FormularioDiv">
                                   <!-- En esta seccion se muestra todos los datos recuperados del foumulario -->                               
                               </div>
                           </div>
                       </div>
                   </div>
                   <?php 
                   }
                   else
                   {
                       echo "<br><br><center>UD. NO TIENE ACCESO A ESTE MÓDULO</center><br>";
                   }
                   ?>
               </div>
           </div>
       </div>
       <br><br>
    <?php
    }
    //FUNCION PARA PROCESAR LOS MENSAJES DE LAS ACCIONES
    function ProcesaMensaje()
    {
        $lCollection = Collection::Singleton();
        $descmsje           = "";
        $sCodMensaje         = $lCollection->Get('CodMensaje');
        $sMensaje            = $lCollection->Get('Mensaje');
        if ($sCodMensaje <> "") 
        {
            $descmsje = mensajesistema($sCodMensaje,$sMensaje);
        }
        else
        {
            $descmsje = mensajesistema($sMensaje);
        }
        echo $descmsje."<br>";
    }
    //FUNCION UTILIZADA CUANDO SE REGISTRA O EDITA INFORMACIÓN
    function GeneraForm()
    {
        $lCollection        = Collection::Singleton();
        $PaginaFormulario   = $lCollection->Get('PaginaFormulario');
        $PermisoOK          = $lCollection->Get('PermisoOK');  
        
        //Recuperando valores para Mostrar en el Formulario
        $SeleccionarID    = $lCollection->Get('SeleccionarID');
        //$IdPersona        = $lCollection->Get('Id');
		

		$IDE_SEGUIMIENTO     = $lCollection->Get('IDE_SEGUIMIENTO');
		$IDE_PROY_COMPONENTE     = $lCollection->Get('IDE_PROY_COMPONENTE');
		$FEC_SEGUIMIENTO     = $lCollection->Get('FEC_SEGUIMIENTO');
		$TIP_SEGUIMIENTO     = $lCollection->Get('TIP_SEGUIMIENTO');
		$DES_SEGUIMIENTO     = $lCollection->Get('DES_SEGUIMIENTO');
		$EST_SEGUIMIENTO     = $lCollection->Get('EST_SEGUIMIENTO');


/*EDGAR*/                
        $PIDE = $lCollection->Get('PIDE');
//        $Tabla_DatosPadre = $lCollection->Get('Tabla_DatosPadre');
        
        /* para la herencia */
        //$IDE_PROYECTO = $PIDE; //codigo superior autocompleta
        
        /* para la visualizacion de busqueda */
        //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;
        
        /* para el padre buscado */
        //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');
        
        
//        $B_descripcion = $lCollection->Get('Bdescripcion');
        
        $PIDEbuscado = $lCollection->Get('PIDEbuscado') ;
//        $BIDE = $Bdescripcion = "";
//        if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
//          $BIDE = $lCollection->Get('BIDE');;
//          $Bdescripcion = $lCollection->Get('Bdescripcion');
//        }
/*EDGAR*/

        /*LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX*/

		
			$DataSet_GEN_TABLAS_1    = $lCollection->Get('DataSet_GEN_TABLAS_1');	
			


           
        if (strlen($SeleccionarID) > 0)
        {
            //ACTUALIZAR
            $ActionFormulario   = "ActualizarForm";
            $Btn                = "Actualizar";
            $TitulFormulario    = "Actualizar Seguimiento de Contrato"; //Nombre de la Tabla
        }
        else
        {
            //INSERT
            $ActionFormulario   = "RegistraDatos";
            $Btn                = "Registrar";
            $TitulFormulario    = "Registro de Seguimiento de Contrato"; //Nombre de la Tabla
        }
        ?>
        <script type="text/javascript">
            $(function(){
                //ACTIVA LOS TOOLTIPS
                $('*[data-content]').hover(function() 
                {
                    $(this).popover('show');
                });
                //VALIDACION DE FORMULARIO
                $("#BtnForm01").on("click", function() {
                    if ($("#formulario").valid()) {
                        AjaxRegistraDatos('<?php echo $PaginaFormulario;?>');
                  }
                });
                //ACTIVAR PARA TRABAJAR CON FECHAS
			/*
                $('#FechaNacimiento, #FechaHoraRegistro').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: 'button',
                    maxDate: '1095',
                    buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                    shortYearCutoff: '+100'
                });
			*/	
            }); 
            
            
            ////// para extraer datos
        function CompruebaPaseDatos()
        {            
            var f = parent.document.formulario;            
//            alert('busquedas '+'<?php // echo $BIDE.'-<br>-'.$Bdescripcion ; ?>');
//            f.IDE.value = '<?php //echo $BIDE; ?>';
//            f.DES.value = '<?php //echo $Bdescripcion; ?>';
            
            parent.$.colorbox.close();            
        }
        
<?php   if ($PIDEbuscado>0)  {  ?>
            //CompruebaPaseDatos();
<?php   }   ?>
           
        </script>        
        <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario;?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID?>">
		
<!--/*EDGAR*/-->
        <input type="hidden" name="PIDE" value="<?php echo $PIDE ?>"> 
        <input type="hidden" name="varBotonInvocador" value="">       
<!--/*EDGAR*/-->
		
      
      
        <legend><?php echo $TitulFormulario;?></legend>  
		
         <!--/*EDGAR*/--> 
<?php   if ($PIDE > 0) {  
            //echo $Tabla_DatosPadre .'<br>'; 
        }
?>
         <!--/*EDGAR*/-->
         
         <?php //extraerIDEyValor_Text("IDE_tablaBUSCADO", $IDE_tablaBUSCADO, 'ESTANDAR', 'BUSCADO', 'B_descripcion', $B_descripcion, 'tablaBUSCADO' ); ?>
        		

		 
		 
													    <div class="control-group" style="display:none">
                <label class="control-label" for="IDE_SEGUIMIENTO">Ide: <span class="error"></span></label>
                <div class="controls">
				
                    <input  name="IDE_SEGUIMIENTO" id="IDE_SEGUIMIENTO" value="<?php echo $IDE_SEGUIMIENTO;?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>
                
				</div>
            </div>		
		 
		 
							    <div class="control-group">
                <label class="control-label" for="IDE_PROY_COMPONENTE">IdeComponente: <span class="error">*</span></label>
                <div class="controls">
										<input  name="IDE_PROY_COMPONENTE" id="IDE_PROY_COMPONENTE" value="<?php echo $IDE_PROY_COMPONENTE;?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="IdeComponente"/>					
                </div>
            </div>								
		 
		 
									            <div class="control-group">
                <label class="control-label" for="FEC_SEGUIMIENTO">Fecha:<span class="error"></span></label>
                <div class="controls">
                    <div class="span12">    
					                        <input name="FEC_SEGUIMIENTO" id="FEC_SEGUIMIENTO" style="width: 10%" value="<?php echo $FEC_SEGUIMIENTO;?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Fecha" placeholder="DD/MM/YYYY"/>					
					</div>
                </div>
            </div>						
		 
		 
							    <div class="control-group">
                <label class="control-label" for="TIP_SEGUIMIENTO">Tipo Seguimiento: <span class="error"></span></label>
                <div class="controls">
										<input  name="TIP_SEGUIMIENTO" id="TIP_SEGUIMIENTO" value="<?php echo $TIP_SEGUIMIENTO;?>" onChange="conMayusculas(this)" maxlength="3" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Tipo Seguimiento"/>					
                </div>
            </div>								
		 
		 
							            <div class="control-group">
                <label class="control-label" for="DES_SEGUIMIENTO">Descripción: <span class="error">*</span></label>
                <div class="controls">
				                    <textarea name="DES_SEGUIMIENTO" id="DES_SEGUIMIENTO" rows="5" onChange="conMayusculas(this)" maxlength="1000" class="xlarge alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese Descripción" ><?php echo $DES_SEGUIMIENTO;?></textarea>				
                </div>
            </div>						
		 
		 
							            <div class="control-group">
                <label class="control-label" for="EST_SEGUIMIENTO">Estado:<span class="error">*</span></label>
                <div class="controls"> 
									<?php comboEST_SEGUIMIENTO('EST_SEGUIMIENTO',$DataSet_GEN_TABLAS_1,$EST_SEGUIMIENTO,1,"")?>				
                </div>
            </div>  						

		
            <div class="form-actions">
                <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn;?>">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
            </div>
        </form>
        
        <?php
    }
    /***********************************************************************************
    * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
    ***********************************************************************************/  


		
			function comboEST_SEGUIMIENTO($nombre,$lstDatos,$valorInicial,$habil,$estilo) {    
			?>    
			<select data-trigger="hover" data-content="Seleccione Estado" id="<?php echo $nombre;?>" <?php if ($habil == 0){?>disabled="disabled"<?php }?> class="required" name="<?php echo $nombre;?>" <?php echo $estilo;?> >
				<option value="">Seleccione una Opción</option>        
						<?php
						$lOption = "";
						for ($i=0;$i<count($lstDatos);$i++) {
							if (strlen($lstDatos[$i]->COD_ITEM>0))
							{
								if ($lstDatos[$i]->COD_ITEM == $valorInicial)
								{
									$lOption .= "<option value=\"".$lstDatos[$i]->COD_ITEM."\" selected=\"selected\">".$lstDatos[$i]->DES_ITEM."</option>\n\r";
								}
								else
								{
									$lOption .= "<option value=\"".$lstDatos[$i]->COD_ITEM."\">".$lstDatos[$i]->DES_ITEM."</option>\n\r";
								}
							}
						}
						echo $lOption;
						?>
			</select>
			<?php
			} 		


/*	*/