<?php
/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                   
//  Propósito       : Interfaz se elección de archivo para migrar a la tabla PROY_CONT_ETAPA_CONTROL y PROY_CONT_COMP_CONTROL_DET
//  Fecha           : martes, 25 de mayo de 2021 14:03:14
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 25 de mayo de 2021 14:03:14
//******************************************************************************/

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    
    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    $Tabla = $lCollection->Get('Tabla');
    
    $BDES_ARCHIVO = $lCollection->Get('BDES_ARCHIVO');
    $BDES_RUTA = $lCollection->Get('BDES_RUTA');
    $BFEC_CARGA = $lCollection->Get('BFEC_CARGA');
    $BFEC_CARGA_fecha = $lCollection->Get('BFEC_CARGA_fecha');
    $BFEC_CARGA_hora = $lCollection->Get('BFEC_CARGA_hora');
    /* EDGAR */
    ?>

    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script> 
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>
    <link rel="stylesheet" type="text/css" href="../recursos/css/include.css" />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/include/comun.js"></script> 
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/migrar_CONT_ETAPA_CONTROLvista.js"></script>    

    
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
        

        function migrarGEN_ARCHIVO(PIDE,Tabla)
        {
            OcultaBOx();
            $.colorbox({width: "100%", height: "100%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=migrar_Importar_sqlserver&Accion=muestraVista&AccionLocal=2&PIDE=" + PIDE+"&Tabla=" + Tabla});
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
                        MIGRAR FICHA TECNICA
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
                        <button type=button  onclick="migrarGEN_ARCHIVO(<?php echo $PIDE ;?>,'<?php echo $Tabla ;?>')" title = "MIGRAR" > MIGRAR </button>
                    </td>
                </tr>
            </table>
            
        </div> 
    </div>  

    
<?php
}
