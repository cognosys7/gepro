<?php
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/Persona.js"></script>    
    
    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>
    
    
    
    
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
                   ?>
                   <div class="box-content">
                       <table style="height: 30px; width: 100%; background-color: #EDEDED;border: solid 1px #CCCCCC;">
                        <tr>
                            <td style="text-align: left; width: 80%;">
                            </td>
                            <td style="text-align: right; width: 20%;">
                            Cerrar <input name="Submit2" type="button" value="" id="salir16" title="Cerrar" onclick="cerrarPopup();">
                            </td>
                        </tr>
                       </table>
                       <div id="tabs">
                           <!-- CAMBIAR ETIQUETAS DE LAS PESTAÑAS-->
                           <ul>
                               <li><a href="#tabs-1">Listado de Persona</a></li>
                               <li><a href="#tabs-2">Mantenimiento</a></li>
                           </ul>
                           <!--CONTENIDO DE LA PESTAÑA 1-->
                           <div id="tabs-1">
                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    
                                    
                                    <div id="contenedor">        
                                    <div id="fila1">
                                        <div class="limpiar"></div>
                                    </div>   
                                    <!--ACTIVA ESTA SECCION CUANDO LA TABLA DEPENDE DE OTRA TABLA Y SE DESEA VER EL DETALLE DE LOS DATOS
                                    <table class="table table-hover table-nomargin table-bordered">
                                        <tr>
                                            <th style="width: 25%">NOMBRE DEL CERRO DE PASCO</th>
                                            <td style="width: 75%"><?php //echo $IdProveedorR; ?></td>
                                        </tr>
                                    </table>                                
                                    -->
                                    <div class="msjinformacion" id="mensaje">
                                        Seleccione un registro para editar 
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
                                            url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList',
                                            /* Tipo de datos devuelto json, xml */
                                            dataType: 'json',
                                            /* Metodo de Envio de  Datos*/
                                            method: 'POST',
                                            /* Lista de campo a mostrar en cada columna */
                                            colModel: [
                                                {display: 'IdPersona', name: 'IdPersona', width: GetColumnSize(2), sortable: true, align: 'center', hide: true},
                                                {display: 'Departamento', name: 'Departamento', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                {display: 'Provincia', name: 'Provincia', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                {display: 'Distrito', name: 'Distrito', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                {display: 'Nombre', name: 'Nombre', width: GetColumnSize(20), sortable: true, align: 'left', hide: false},
                                                {display: 'Descipcion', name: 'Descipcion', width: GetColumnSize(12), sortable: true, align: 'left', hide: false},
                                                {display: 'Sexo', name: 'Sexo', width: GetColumnSize(2), sortable: true, align: 'left', hide: false},
                                                {display: 'Estudios', name: 'Estudios', width: GetColumnSize(20), sortable: true, align: 'left', hide: false},
                                                {display: 'FechaNacimiento', name: 'FechaNacimiento', width: GetColumnSize(5), sortable: true, align: 'left', hide: false},
                                                {display: 'FechaHoraRegistro', name: 'FechaHoraRegistro', width: GetColumnSize(5), sortable: true, align: 'left', hide: false},                                                
                                                {display: 'Editar', name: 'Boton1', width: GetColumnSize(4), sortable: false, align: 'center'},
                                                {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(4), sortable: false, align: 'center'}
                                            ],
                                            /*Botones de Enlace*/
                                            buttons: [
                                                {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                {separator: true}
                                            ],
                                            /*Lista de campo que se podra hacer busqueda */
                                            searchitems: [
                                                {display: 'Nombre', name: 'Nombre'},
                                                {display: 'Sexo', name: 'Sexo'}
                                            ],
                                            sortname: "Nombre",         /* mostrar ordenado por Nombre */
                                            sortorder: "ASC",           /* ordenaor ascendente o descendente */
                                            usepager: true,             /* activa o descativa paginación */
                                            singleSelect: true,
                                            useRp: true,
                                            rp: 5,
                                            height: $("#datos").innerHeight,
                                            query: ''
                                            //,title: 'Listado de Personas'
                                            //,showTableToggleBtn: true

                                        }
                                    );
                                    /* Debe seleccionar una fila antes de pulsar el boton */    
                                    function test(com,grid)
                                    {
                                        var nId = $('.trSelected',grid).children('td:eq(0)').text();
                                        if (com=='Nuevo')
                                        {
                                            Nuevo('<?php echo $PaginaFormulario ?>'); 
                                        }
                                        else
                                        {
                                            $('#mensaje')
                                            .text('Debe Seleccionar un registro del listado')
                                            .addClass('msjalerta')
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
        //$IdPersona        = $lCollection->Get('IdPersona');
        $Departamento     = $lCollection->Get('Departamento');
        $Provincia        = $lCollection->Get('Provincia');
        $Distrito         = $lCollection->Get('Distrito');
        $Nombre           = $lCollection->Get('Nombre');
        $Descipcion       = $lCollection->Get('Descipcion');
        $Sexo             = $lCollection->Get('Sexo');
        $Estudios         = $lCollection->Get('Estudios');
        $FechaNacimiento  = $lCollection->Get('FechaNacimiento');
        $FechaHoraRegistro  = $lCollection->Get('FechaHoraRegistro');
        /*LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX*/
        $lstDepartamento    = $lCollection->Get('lstDepartamento');
        $lstProvincia       = $lCollection->Get('lstProvincia');
        $lstDistrito        = $lCollection->Get('lstDistrito');             
        if (strlen($SeleccionarID) > 0)
        {
            //ACTUALIZAR
            $ActionFormulario   = "ActualizarForm";
            $Btn                = "Actualizar";
            $TitulFormulario    = "Actualizar Persona"; //Nombre de la Tabla
        }
        else
        {
            //INSERT
            $ActionFormulario   = "RegistraDatos";
            $Btn                = "Registrar";
            $TitulFormulario    = "Registro de Persona"; //Nombre de la Tabla
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
                $('#FechaNacimiento, #FechaHoraRegistro').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: 'button',
                    maxDate: '1095',
                    buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                    shortYearCutoff: '+100'
                });
            });            
        </script>        
        <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario;?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID?>">
        <legend><?php echo $TitulFormulario;?></legend>         
            <div class="control-group">
                <label class="control-label" for="Departamento">Departamento: <span class="error">*</span></label>
                <div class="controls">                    
                    <?php comboDepartamento('Departamento',$lstDepartamento,$Departamento,1,"onchange=\"return AjaxProvinciaList('$PaginaFormulario');\"")?> 
                </div>
            </div>    
            <div class="control-group">
                <label class="control-label" for="Provincia">Provincia: <span class="error">*</span></label>
                <div class="controls">
                    <div class="span12" id="divProvincia">                        
                        <?php comboProvincia('Provincia',$lstProvincia,$Provincia,1,"onchange=\"return AjaxDistritoList('$PaginaFormulario');\"")?>
                    </div>
                </div>
            </div>
        
            <div class="control-group">
                <label class="control-label" for="Distrito">Distrito: <span class="error">*</span></label>
                <div class="controls">
                    <div class="span12" id="divDistrito">
                        <?php comboDistrito('Distrito',$lstDistrito,$Distrito,1,"")?>
                    </div>
                </div>
            </div>                           
            <div class="control-group">
                <label class="control-label" for="Nombre">Nombre: <span class="error">*</span></label>
                <div class="controls">
                    <input  name="Nombre" id="Nombre" value="<?php echo $Nombre;?>" onChange="conMayusculas(this)" maxlength="250" type="text" class="input-xlarge alphanumeric required"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="Descipcion">Descipcion: <span class="error">*</span></label>
                <div class="controls">
                    <!--
                    <input  name="Descipcion" id="Descipcion" value="<?php //echo $Descipcion;?>" onChange="conMayusculas(this)" maxlength="250" type="text" class="input-xlarge alphanumericFono required"/>
                    -->
                    <textarea name="Descipcion" id="Descipcion" rows="5" onChange="conMayusculas(this)" maxlength="250" class="input-xlarge alphanumericFono required"><?php echo $Descipcion;?></textarea>
                    
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="Sexo">Sexo: <span class="error">*</span></label>
                <div class="controls">                    
                    <!--<input  name="Sexo" id="Sexo" value="<?php //echo $Sexo;?>" onChange="conMayusculas(this)" maxlength="250" type="text" class="input-xlarge alphanumericContacto required"/> -->
                    
                    Masculino
                    <input type="radio" name="Sexo" id="Sexo" value="M" <?php if($Sexo=="M"){ echo "checked";}?>/>

                    Femenino
                    <input type="radio" name="Sexo" id="Sexo" value="F" <?php if($Sexo=="F"){ echo "checked";}?>/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="Estudios">Estudios: <span class="error">*</span></label>
                <div class="controls">
                    <input  name="Estudios" id="Estudios" value="<?php echo $Estudios;?>" onChange="conMayusculas(this)" maxlength="250" type="text" class="input-xlarge alphanumericContacto required"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="FechaNacimiento">Fecha Nacimiento: <span class="error">*</span></label>
                <div class="controls">
                    <div class="span12">                        
                        <input name="FechaNacimiento" id="FechaNacimiento" style="width: 10%" value="<?php echo $FechaNacimiento;?>" minlength="1" maxlength="10" type="text" class="input-xlarge alphanumeric show-popover" data-trigger="hover" data-content="Ingrese la fecha de Nacimiento" placeholder="DD/MM/YYYY"/>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="FechaHoraRegistro">FechaHora Registro: </label>
                <div class="controls">
                    <div class="span12">
                        <input name="FechaHoraRegistro" id="FechaHoraRegistro" style="width: 10%" value="<?php echo $FechaHoraRegistro;?>" minlength="1" maxlength="10" type="text"  data-trigger="hover" data-content="Ingrese la fecha de Registro" placeholder="DD/MM/YYYY"/>
                    </div>
                </div>
            </div>        
            <div class="form-actions">
                <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn;?>">
                <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
            </div>
        </form>
        <?php
    }
    /***********************************************************************************
    * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA EL CARGADO DE DATOS DE TABLAS AUXILIARES     
    ***********************************************************************************/  
    function LoadProvinciaAjax() 
    {
        $lCollection      = Collection::Singleton();    
        $lProvincia       = $lCollection->Get("lstProvincia");
        $PaginaFormulario = $lCollection->Get("PaginaFormulario");
        ?>        
        <select data-trigger="hover" data-content="Seleccione la Provincia" id="Provincia" class="required" name="Provincia" onchange="return AjaxDistritoList('Persona');">
            <option value="">Seleccione una Opción</option>
            <?php
            $lOption = "";
            for ($i=0; $i<count($lProvincia); $i++) {
                $lOption .= "<option value=\"".$lProvincia[$i]->IdUbigeo."\">".$lProvincia[$i]->UbiLocalidad."</option>\n\r";
            }
            echo $lOption;
            ?>
         </select>
    <?php
    }
    
    function LoadDistritoAjax() 
    {
        $lCollection      = Collection::Singleton();    
        $lDistrito       = $lCollection->Get("lstDistrito");
        $PaginaFormulario = $lCollection->Get("PaginaFormulario");
        ?>
        <select data-trigger="hover" data-content="Seleccione el Distrito" name="Distrito" id="Distrito" onchange="" >
            <option value="">Seleccione una Opción</option>
            <?php
            $lOption = "";
            for ($i=0; $i<count($lDistrito); $i++) {
                $lOption .= "<option value=\"".$lDistrito[$i]->IdUbigeo."\">".$lDistrito[$i]->UbiLocalidad."</option>\n\r";
            }
            echo $lOption;
            ?>
         </select>
    <?php
    }


       