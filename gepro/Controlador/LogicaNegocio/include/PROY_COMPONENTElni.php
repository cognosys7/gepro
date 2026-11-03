<?php

  require_once(PATH_CONTROLADOR_DAO . "/PROY_COMPONENTEDAO.php");

  require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
  require_once(PATH_CONTROLADOR_LN . "/include/PROYECTO_ACTIVIDADlni.php");
  require_once(PATH_CONTROLADOR_LN . "/include/PROY_CONTRATOlni.php");
  require_once(PATH_CONTROLADOR_LN . "/include/CONTRATOlni.php");
       


function ProyectoComponente_Datos($PIDE) {
    
    $IDE_PROYECTO_ACTIVIDAD = $IDE_CARTERA = $IDE_COMPONENTE = $NUM_SEC_COMPONENTE = $IDE_MODO_EJECUCION = $IDE_PROC_ITEM = $IMP_COMPONENTE = $IDE_ESTADO = $IDE_COMPONENTE_ESTADO = '';
    
    $campos = " IDE_PROYECTO_ACTIVIDAD, IDE_CARTERA, IDE_COMPONENTE, NUM_SEC_COMPONENTE, IDE_MODO_EJECUCION, IDE_PROC_ITEM, IMP_COMPONENTE, IDE_ESTADO, IDE_COMPONENTE_ESTADO";
//    setlocale(LC_MONETARY,"es_ES");
    
    if($PIDE>0){
        $filtro = " AND IDE_PROY_COMPONENTE = ".$PIDE ; //echo $campos.''.$filtro.' // -';//die;
            $data = VIS_SelCampos ('PROY_COMPONENTE',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_PROYECTO_ACTIVIDAD = $data[0]->IDE_PROYECTO_ACTIVIDAD ;
            $IDE_CARTERA            = $data[0]->IDE_CARTERA ;
            $IDE_COMPONENTE         = $data[0]->IDE_COMPONENTE ;
            $NUM_SEC_COMPONENTE     = $data[0]->NUM_SEC_COMPONENTE ;
            $IDE_MODO_EJECUCION     = $data[0]->IDE_MODO_EJECUCION ;
            $IDE_PROC_ITEM          = $data[0]->IDE_PROC_ITEM ;
            $IMP_COMPONENTE         = $data[0]->IMP_COMPONENTE ;
            $IDE_ESTADO             = $data[0]->IDE_ESTADO ;
            $IDE_COMPONENTE_ESTADO  = $data[0]->IDE_COMPONENTE_ESTADO ;
        }
    }
    
    $Resultado = array (
        'BIDE'               => $PIDE 
        ,'IDE_PROYECTO_ACTIVIDAD'   => $IDE_PROYECTO_ACTIVIDAD
        ,'IDE_CARTERA'              => $IDE_CARTERA
        ,'IDE_COMPONENTE'           => $IDE_COMPONENTE
        ,'NUM_SEC_COMPONENTE'       => $NUM_SEC_COMPONENTE
        ,'IDE_MODO_EJECUCION'       => $IDE_MODO_EJECUCION
        ,'IDE_PROC_ITEM'            => $IDE_PROC_ITEM
        ,'IMP_COMPONENTE'           => $IMP_COMPONENTE
        ,'IDE_ESTADO'               => $IDE_ESTADO
        ,'IDE_COMPONENTE_ESTADO'    => $IDE_COMPONENTE_ESTADO
    ) ;
    
    return $Resultado ;
}



function ProyectoComponente_Datos2($PIDE) {
    
    $IDE_PROYECTO_ACTIVIDAD = $IDE_CARTERA = $IDE_COMPONENTE = $NUM_SEC_COMPONENTE = $IDE_MODO_EJECUCION = $IDE_PROC_ITEM = $IMP_COMPONENTE = $IDE_ESTADO = $IDE_COMPONENTE_ESTADO = '';
    $IDE_PROY_COMPONENTE = '0';
    
    $campos = " IDE_PROYECTO_ACTIVIDAD, IDE_CARTERA, IDE_COMPONENTE, NUM_SEC_COMPONENTE, IDE_MODO_EJECUCION, IDE_PROC_ITEM, IMP_COMPONENTE, IDE_ESTADO, IDE_COMPONENTE_ESTADO , IDE_PROY_COMPONENTE ";
//    setlocale(LC_MONETARY,"es_ES");
    
    if($PIDE>0){
        $filtro = " AND IDE_PROYECTO_ACTIVIDAD = ".$PIDE . ' AND IDE_COMPONENTE=61 '  ; //echo $campos.''.$filtro.' // -';//die;
            $data = VIS_SelCampos ('PROY_COMPONENTE',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_PROYECTO_ACTIVIDAD = $data[0]->IDE_PROYECTO_ACTIVIDAD ;
            $IDE_CARTERA            = $data[0]->IDE_CARTERA ;
            $IDE_COMPONENTE         = $data[0]->IDE_COMPONENTE ;
            $NUM_SEC_COMPONENTE     = $data[0]->NUM_SEC_COMPONENTE ;
            $IDE_MODO_EJECUCION     = $data[0]->IDE_MODO_EJECUCION ;
            $IDE_PROC_ITEM          = $data[0]->IDE_PROC_ITEM ;
            $IMP_COMPONENTE         = $data[0]->IMP_COMPONENTE ;
            $IDE_ESTADO             = $data[0]->IDE_ESTADO ;
            $IDE_COMPONENTE_ESTADO  = $data[0]->IDE_COMPONENTE_ESTADO ;
            $IDE_PROY_COMPONENTE    = $data[0]->IDE_PROY_COMPONENTE ;
        }
    }
    
    $Resultado = array (
        'BIDE'               => $PIDE 
        ,'IDE_PROYECTO_ACTIVIDAD'   => $IDE_PROYECTO_ACTIVIDAD
        ,'IDE_CARTERA'              => $IDE_CARTERA
        ,'IDE_COMPONENTE'           => $IDE_COMPONENTE
        ,'NUM_SEC_COMPONENTE'       => $NUM_SEC_COMPONENTE
        ,'IDE_MODO_EJECUCION'       => $IDE_MODO_EJECUCION
        ,'IDE_PROC_ITEM'            => $IDE_PROC_ITEM
        ,'IMP_COMPONENTE'           => $IMP_COMPONENTE
        ,'IDE_ESTADO'               => $IDE_ESTADO
        ,'IDE_COMPONENTE_ESTADO'    => $IDE_COMPONENTE_ESTADO
        ,'IDE_PROY_COMPONENTE'      => $IDE_PROY_COMPONENTE
    ) ;
    
    return $Resultado ;
}

function Tabla_ProyectoComponente_Datos ( $VDES_PROYECTO, $VDES_INTERVENCION,$VFEC_INICIO_CONTRATO,$VFEC_TERMINO_CONTRATO, $VDES_COMPONENTE, $VDES_CARTERA, $VDES_ESTADO, $VIMP_COMPONENTE , $VTIP_PROYECTO_ACTIVIDAD=1 , $PIDE_PROY_COMPONENTE=0 ) {
//    #D1542F
    $Data10 = GenTablas_Datos(65, $VTIP_PROYECTO_ACTIVIDAD) ;
    if($PIDE_PROY_COMPONENTE>0){
        $Data00 = ProyectoComponente_Datos($PIDE_PROY_COMPONENTE);
        $Data11 = ProyectoActividad_Datos( $Data00['IDE_PROYECTO_ACTIVIDAD'] );
        $Data12 = ProyectoContrato_Datos2( $Data00['IDE_PROYECTO_ACTIVIDAD'] , $Data11['IDE_PROYECTO'] ) ;
        $Data13 = Contrato_Datos ( $Data12['IDE_CONTRATO'] ) ;
        
        $BCOD_CONTRATO_ENTIDAD = $Data13['COD_CONTRATO_ENTIDAD'];
        $BCOD_UNICO_ORDEN = $Data13['COD_UNICO_ORDEN'] ;
        $VDES_PROYECTO = $BCOD_CONTRATO_ENTIDAD . ' - ' . $Data11['DES_PROYECTO'];
    }
    
    $DatosPadre = '<table width="95%"  class="tbDatoPadre" >';
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td>Contrato:</td>';
    $DatosPadre .= '<td colspan="5"> '. $VDES_PROYECTO . '</td>';
    $DatosPadre .= '</tr>';

    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(6).'">Fase - Componente:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(6).'"><span style="color: #aa0000;"> ' . $VDES_INTERVENCION . '</span></td>';
//    $DatosPadre .= '<td style="width: 10%">Ejecución contractual:</td>';
//    $DatosPadre .= '<td style="width: 40%"> ' . $VFEC_INICIO_CONTRATO . ' al ' . $VFEC_TERMINO_CONTRATO . '</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(6).'">Modalidad Gestión</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(6).'"><span style="color: #aa0000;"> '. $Data10['DES_ITEM'] .'</span></td>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(6).'"></td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(6).'"></td>';
    $DatosPadre .= '</tr>';

    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(6).'">Etapa de Componente:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(6).'"><span style="color: #aa0000;"> ' . $VDES_COMPONENTE . '</span></td>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(6).'">Etapa Contractual:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(6).'"><span style="color: #aa0000;">  ' . $VDES_CARTERA . '</span></td>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(6).'"></td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(6).'"></td>';
    $DatosPadre .= '</tr>';

    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td>Estado:</td>';
    $DatosPadre .= '<td> ' . $VDES_ESTADO . '</td>';
    $DatosPadre .= '<td>Monto de Inversión:</td>';
    $DatosPadre .= '<td> ' . FormatoMonedas($VIMP_COMPONENTE) . '</td>';
    $DatosPadre .= '</tr>';
    $DatosPadre .= '</table>';
    
    return $DatosPadre ;
}


function Tabla_ProyectoComponente_Datos2 (  $VDES_COMPONENTE, $VDES_CARTERA, $VMODO_EJECUCION ) {
//    #D1542F
    $DatosPadre = '<table width="100%"  class="tbDatoPadre" >';
    
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Etapa de Componente:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'"><span style="color: #aa0000;"> ' . $VDES_COMPONENTE . '</span></td>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Etapa Contractual:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'"><span style="color: #aa0000;">  ' . $VDES_CARTERA . '</span></td>';
    $DatosPadre .= '</tr>';

    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Modo de Ejecución:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'"> ' . $VMODO_EJECUCION . '</td>';
    $DatosPadre .= '<td></td>';
    $DatosPadre .= '<td></td>';
    $DatosPadre .= '</tr>';
    $DatosPadre .= '</table>';
    
    return $DatosPadre ;
}
?>