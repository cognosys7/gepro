<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
  //  Empresa	      : ACTIVOS MINEROS S.A.C.
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : Interfaz se elección de archivo para migrar a la tabla MON_PLANIFICACION y MON_PLANIF_MEDICION
  //  Fecha           : sábado, 26 de junio de 2021 17:50:18
  //  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
  //  Modificado      : sábado, 26 de junio de 2021 17:50:18
  //***************************************************************************** */

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    
    $PIDE = 1;
    $Tabla = 'migrar_INTERESADOS';
    
    $BDES_ARCHIVO = $lCollection->Get('BDES_ARCHIVO');
    $BDES_RUTA = $lCollection->Get('BDES_RUTA');
    $BFEC_CARGA = $lCollection->Get('BFEC_CARGA');
    $BFEC_CARGA_fecha = $lCollection->Get('BFEC_CARGA_fecha');
    $BFEC_CARGA_hora = $lCollection->Get('BFEC_CARGA_hora');
    
    ?>
    <!--ESTILOS PARA UTILIZAR-->
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/miflexigridgris.css"  />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/css/botones.css"  />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script>       
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/migrar_CONT_INTERESADOS.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <!--/*EDGAR*/-->
    <link rel="stylesheet" type="text/css" href="../recursos/css/include.css" />
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
    
    
    
    <script type="text/javascript">

        function salir() {
            parent.$.colorbox.close();
        }
        
        
        function abrirGEN_ARCHIVO(PIDE,Tabla)
        {
            OcultaBOx();
            $.colorbox({width: "100%", height: "100%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=GEN_ARCHIVO&Accion=muestraVista&AccionLocal=2&PIDE=" + PIDE+"&Tabla=" + Tabla});
            $('#cboxClose').remove();
        }
        

        function migrarGEN_ARCHIVO(Archivo)
        {
            OcultaBOx();
            $.colorbox({width: "100%", height: "100%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=migrar_INTERESADOS&Accion=muestraVista&AccionLocal=2&Archivo=" + Archivo });
            $('#cboxClose').remove();
        }

    </script> 
    
    <style>
    .padre {
        /*background: yellow;*/
        height: 100%;
        /*IMPORTANTE*/
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .hijo {
        /*background: red;*/
        width: 50%;
      }
   </style>     
        
        
    <div class="padre">
        <div class="hijo" >
            
            <br>
            
            <table style="border:1; width: 80%; background-color:#cccccc">
                
                <tr class="tb_video_cabezera">
                    <td width="10%">
                        <button type=button  onclick="salir()" title = "Salir" id="salir16" ></button>
                    </td>
                    <td>
                        CARGAR INTERESADOS DEL CONTRATO
                    </td>
                    <td width="10%">
                        <button type=button  onclick="salir()" title = "Salir" id="salir16" ></button>
                    </td>
                </tr>
                
                <tr>
                    <td align="center" colspan="3">
                        <br>
                        <div onclick="abrirGEN_ARCHIVO(<?php echo $PIDE ;?>,'<?php echo $Tabla ;?>')"  style=" background-color: #c8e5bc;  width: 80%"  >
                            IMPORTE TU ARCHIVO EXCEL.<br>
                            Se tomara por defecto el ultimo archivo cargado<br>
                            
                            <?php // echo 'pide:'. $PIDE . ' - Tabla:' .$Tabla . ' - BDES_ARCHIVO:' . $BDES_ARCHIVO . '<br>' ;?>
                             <?php echo 'Ultimo Archivo : ' . substr( $BDES_ARCHIVO , 16 ) . '<br>Fecha: ' . $BFEC_CARGA_fecha . ' ' . $BFEC_CARGA_hora ;?>
                            <br>
                            <input type=button title="Abrir Archivo adjuntos para Migrar" id="album_16" >
                            <br>
                            <br>
                        </div>
                        <br><?php //echo 'pide:'. $PIDE . ' - Tabla:' .$Tabla ;?>
                        <br>
                    </td>
                </tr>
                
                
                <tr class="tb_video_cabezera">
                    <td align="center" colspan="3">
                        <button type=button  onclick="migrarGEN_ARCHIVO('<?php echo $BDES_ARCHIVO ; ?>')" title = "MIGRAR" > MIGRAR </button>
                    </td>
                </tr>
            </table>
            
        </div> 
    </div>  
   
   
<?php
}