<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : SIMPLE
  //  Empresa         : Ministerio de Vivienda, Construcción y Saneamiento
  //  Autores         : Ing. Edgar David Pisfil Ahumada
  //  Propósito       : Complemento del archivo PROY_CONT_COMP_CONTROL_DETln
  //  Fecha           : 16 de Enero 2020 02:38:39 p.m.
  //  Desde el Modelo : MF_PROCESO_LICENCIAS
  //  Modificado      : viernes, 30 de abril de 2021 18:49:20
  //
  //***************************************************************************** */

require_once(PATH_CONTROLADOR_DAO . "/PROY_CONT_COMP_CONTROL_DETdao.php");

require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");

function PROY_CONT_COMP_CONTROL_DET_Datos($PIDE) {

    $IDE_CONT_ETAPA_CONTROL = NULL;
    $NUM_ITEM = NULL;
    $NUM_MES = NULL;
    $DES_CONCEPTO_PAGO = NULL;
    $PCT_AVANCE = NULL;
    $IMP_BRUTO = NULL;
    $IMP_REAJUSTE = NULL;
    $IMP_AMORT_ADEL_DIR = NULL;
    $IMP_AMORT_ADEL_MAT = NULL;
    $IMP_AMORTIZACION = NULL;
    $IMP_SALDO_SIN_IGV = NULL;
    $IMP_DEDUC_ADEL_DIR = NULL;
    $IMP_DEDUC_ADEL_MAT = NULL;
    $IMP_IMPONIBLE = NULL;
    $PCT_IGV = NULL;
    $IMP_IGV = NULL;
    $IMP_NETO = NULL;
    $IMP_PENALIDAD = NULL;
    $IMP_RETENCION = NULL;
    $IMP_PAGO = NULL;
    $EST_ETAPA_CONTROL_DET = NULL;
    $NUM_MES_PROVISION = NULL;
    $NUM_ANIO_PROVISION = NULL;

    $campos = "";
    $campos .= " IDE_CONT_ETAPA_CONTROL, ";
    $campos .= " NUM_ITEM, ";
    $campos .= " NUM_MES, ";
    $campos .= " DES_CONCEPTO_PAGO, ";
    $campos .= " PCT_AVANCE, ";
    $campos .= " IMP_BRUTO, ";
    $campos .= " IMP_REAJUSTE, ";
    $campos .= " IMP_AMORT_ADEL_DIR, ";
    $campos .= " IMP_AMORT_ADEL_MAT, ";
    $campos .= " IMP_AMORTIZACION, ";
    $campos .= " IMP_SALDO_SIN_IGV, ";
    $campos .= " IMP_DEDUC_ADEL_DIR, ";
    $campos .= " IMP_DEDUC_ADEL_MAT, ";
    $campos .= " IMP_IMPONIBLE, ";
    $campos .= " PCT_IGV, ";
    $campos .= " IMP_IGV, ";
    $campos .= " IMP_NETO, ";
    $campos .= " IMP_PENALIDAD, ";
    $campos .= " IMP_RETENCION, ";
    $campos .= " IMP_PAGO, ";
    $campos .= " EST_ETAPA_CONTROL_DET, ";
    $campos .= " NUM_MES_PROVISION, ";
    $campos .= " NUM_ANIO_PROVISION, ";
    $campos = substr($campos, 0, strlen($campos) - 2);


    $campos = " IDE_INF_TECNICO , IDE_DOCUMENTO , IDE_FORMULARIO , COD_INFORME , CONVERT(VARCHAR(10),FEC_INFORME,103) as FEC_INFORME , TIP_MODALIDAD_APROBACION , CONVERT(VARCHAR(10),FEC_SUSCRIPCION_ACUERDO,103) as FEC_SUSCRIPCION_ACUERDO, NUM_DIAS_CALENDARIOS , TIP_CON_CERTIFICADO_PARAMETRO , COD_CERTIFICADO_PARAMETRO , CONVERT(VARCHAR(10),FEC_VERIFICACION_FAVORABLE,103) as FEC_VERIFICACION_FAVORABLE , EST_INF_TECNICO ";

    if ($PIDE > 0) {
        $filtro = "  AND IDE_INF_TECNICO =" . $PIDE; // echo $campos.''.$filtro.'-';die;
        $data = VIS_SelCampos('PROY_CONT_COMP_CONTROL_DET', $campos, $filtro);
        if (count($data) > 0) {
            $IDE_INF_TECNICO = $data0->IDE_INF_TECNICO;
            $IDE_DOCUMENTO = $data0->IDE_DOCUMENTO;
            $IDE_FORMULARIO = $data0->IDE_FORMULARIO;
            $COD_INFORME = $data0->COD_INFORME;
            $FEC_INFORME = $data0->FEC_INFORME;
            $TIP_MODALIDAD_APROBACION = $data0->TIP_MODALIDAD_APROBACION;
            $FEC_SUSCRIPCION_ACUERDO = $data0->FEC_SUSCRIPCION_ACUERDO;
            $NUM_DIAS_CALENDARIOS = $data0->NUM_DIAS_CALENDARIOS;
            $TIP_CON_CERTIFICADO_PARAMETRO = $data0->TIP_CON_CERTIFICADO_PARAMETRO;
            $COD_CERTIFICADO_PARAMETRO = $data0->COD_CERTIFICADO_PARAMETRO;
            $EST_INF_TECNICO = $data0->EST_INF_TECNICO;
        }
    }

    $Resultado = array(
        'BIDE' => $IDE_INF_TECNICO
        , 'IDE_DOCUMENTO' => $IDE_DOCUMENTO
        , 'IDE_FORMULARIO' => $IDE_FORMULARIO
        , 'COD_INFORME' => $COD_INFORME
        , 'FEC_INFORME' => $FEC_INFORME
        , 'TIP_MODALIDAD_APROBACION' => $TIP_MODALIDAD_APROBACION
        , 'FEC_SUSCRIPCION_ACUERDO' => $FEC_SUSCRIPCION_ACUERDO
        , 'NUM_DIAS_CALENDARIOS' => $NUM_DIAS_CALENDARIOS
        , 'TIP_CON_CERTIFICADO_PARAMETRO' => $TIP_CON_CERTIFICADO_PARAMETRO
        , 'COD_CERTIFICADO_PARAMETRO' => $COD_CERTIFICADO_PARAMETRO
        , 'EST_INF_TECNICO' => $EST_INF_TECNICO
            );

    return $Resultado;
}

function Tabla_PROY_CONT_COMP_CONTROL_DET_Datos($PIDE) {

    $Data = PROY_CONT_COMP_CONTROL_DET_Datos($PIDE);
    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';

    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:' . TBpadre_EtiketaAncho(4) . '"> :</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_ValorAncho(4) . '"> ' . $Data['COD_INFORME'] . '</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_EtiketaAncho(4) . '"> :</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_ValorAncho(4) . '"> ' . $Data['FEC_INFORME'] . '</td>';
    $DatosPadre .= '</tr>';

    $DatosPadre .= '</table>';

    return $DatosPadre;
}




function Control_visualizar( $Componente , $Plan , $Concepto ) {

    $verSI = '';
    $verNO = 'display:none';
    
    $Control_visualizar = array(
        'PCT_AVANCE' => $verNO,
        'IMP_BRUTO' => $verNO,
        'IMP_REAJUSTE' => $verNO,
        'IMP_AMORT_ADEL_DIR' => $verNO,
        'IMP_AMORT_ADEL_MAT' => $verNO,
        'IMP_AMORTIZACION' => $verNO,
        'IMP_SALDO_SIN_IGV' => $verNO,
        'IMP_DEDUC_ADEL_DIR' => $verNO,
        'IMP_DEDUC_ADEL_MAT' => $verNO,
        'IMP_IMPONIBLE' => $verNO,
        'IMP_IGV' => $verNO,
        'IMP_NETO' => $verNO,
        'IMP_PENALIDAD' => $verNO,
        'IMP_RETENCION' => $verNO,
        'IMP_PAGO' => $verNO,
        'NUM_MES_PROVISION' => $verNO,
        'NUM_ANIO_PROVISION' => $verNO
    );
    
    if ( $Componente == '154' || $Componente == '151' || $Componente == '168' || $Componente == '163' ){   
        //echo 'OBRAS ('.$Componente.') : Plan:' . $Plan . ' || Concepto:' . $Concepto ; 
        switch ($Plan){
            case 1: // planificado
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                break;
            case 2: // REAL
                //$Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                $Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                $Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                $Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                $Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                $Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
                $Control_visualizar['NUM_MES_PROVISION'] = $verSI ;
                $Control_visualizar['NUM_ANIO_PROVISION'] = $verSI ;
                break;
            case 3: // reprogramado
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                break;
        }
    } elseif ( $Componente == '155' || $Componente == '174' || $Componente == '161' || $Componente == '160' || $Componente == '159' || $Componente == '169' || $Componente == '152' || $Componente == '163' ){    
        //echo 'ESTUDIOS ('.$Componente.') : ' . $Plan . ' || Concepto:' . $Concepto ; 
        switch ($Plan){
            case 1: // planificado
                $Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                //$Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                //$Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
                break;
            case 2: // REAL
                $Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                //$Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
               // $Control_visualizar['NUM_MES_PROVISION'] = $verSI ;

                break;
            case 3: // reprogramado
                $Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                //$Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                //$Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
                break;
        }    
    } elseif ( $Componente == '153' ){   
        //echo 'SUPERVISION ('.$Componente.') : Plan:' . $Plan . ' || Concepto:' . $Concepto ; 
        switch ($Plan){
            case 1: // planificado
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                break;
            case 2: // REAL
                //$Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                $Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                $Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                $Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                $Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                $Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
                $Control_visualizar['NUM_MES_PROVISION'] = $verSI ;
                $Control_visualizar['NUM_ANIO_PROVISION'] = $verSI ;
                break;
            case 3: // reprogramado
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                break;
        }
    } else {    
        //echo 'TODOS LOS DEMAS CASOS ('.$Componente.') : ' . $Plan . ' || Concepto:' . $Concepto ; 
        switch ($Plan){
            case 1: // planificado
                $Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                //$Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                //$Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
                break;
            case 2: // REAL
                $Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                //$Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
               // $Control_visualizar['NUM_MES_PROVISION'] = $verSI ;
                break;
            case 3: // reprogramado
                $Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                //$Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                //$Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
                break;
        }    
    } 
    
    return $Control_visualizar;
}


function Grilla_verBotones_montos( $Componente , $Plan , $Concepto ) {

    $verSI = 'false';
    $verNO = 'true';
    
    $Control_visualizar = array(
        'PCT_AVANCE' => $verNO,
        'IMP_BRUTO' => $verNO,
        'IMP_REAJUSTE' => $verNO,
        'IMP_AMORT_ADEL_DIR' => $verNO,
        'IMP_AMORT_ADEL_MAT' => $verNO,
        'IMP_AMORTIZACION' => $verNO,
        'IMP_SALDO_SIN_IGV' => $verNO,
        'IMP_DEDUC_ADEL_DIR' => $verNO,
        'IMP_DEDUC_ADEL_MAT' => $verNO,
        'IMP_IMPONIBLE' => $verNO,
        'IMP_IGV' => $verNO,
        'IMP_NETO' => $verNO,
        'IMP_PENALIDAD' => $verNO,
        'IMP_RETENCION' => $verNO,
        'IMP_PAGO' => $verNO,
        'NUM_MES_PROVISION' => $verNO
    );
    
    if ( $Componente == '154' || $Componente == '151' || $Componente == '168' || $Componente == '163' ){   
        //echo 'Obras ('.$Componente.') : Plan:' . $Plan . ' || Concepto:' . $Concepto ; 
        switch ($Plan){
            case 1: // planificado
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                break;
            case 2: // REAL
                //$Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                $Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                $Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                $Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                $Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                $Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
                $Control_visualizar['NUM_MES_PROVISION'] = $verSI ;
                break;
            case 3: // reprogramado
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                break;
        }
    } elseif ( $Componente == '155' || $Componente == '174' || $Componente == '161' || $Componente == '160' || $Componente == '159' || $Componente == '169' || $Componente == '152' || $Componente == '163' ){    
        //echo 'estudios ('.$Componente.') : ' . $Plan . ' || Concepto:' . $Concepto ; 
        switch ($Plan){
            case 1: // planificado
                $Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                //$Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                //$Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
                break;
            case 2: // REAL
                $Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                //$Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
                //$Control_visualizar['NUM_MES_PROVISION'] = $verSI ;
                break;
            case 3: // reprogramado
                $Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                //$Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                //$Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
                break;
        }  
    } elseif ( $Componente == '153' ){   
        //echo 'SUPERVISION ('.$Componente.') : Plan:' . $Plan . ' || Concepto:' . $Concepto ; 
        switch ($Plan){
            case 1: // planificado
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                break;
            case 2: // REAL
                //$Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                $Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                $Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                $Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                $Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                $Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
                $Control_visualizar['NUM_MES_PROVISION'] = $verSI ;
                break;
            case 3: // reprogramado
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                break;
        }
    }  else {    
        //echo 'TODOS LOS DEMAS CASOS ('.$Componente.') : ' . $Plan . ' || Concepto:' . $Concepto ; 
        switch ($Plan){
            case 1: // planificado
                $Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                //$Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                //$Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
                break;
            case 2: // REAL
                $Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                //$Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                $Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
               // $Control_visualizar['NUM_MES_PROVISION'] = $verSI ;
                break;
            case 3: // reprogramado
                $Control_visualizar['PCT_AVANCE'] = $verSI ;
                $Control_visualizar['IMP_BRUTO'] = $verSI ;
                //$Control_visualizar['IMP_REAJUSTE'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_AMORT_ADEL_MAT'] = $verSI ;
                $Control_visualizar['IMP_AMORTIZACION'] = $verSI ;
                $Control_visualizar['IMP_SALDO_SIN_IGV'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_DIR'] = $verSI ;
                //$Control_visualizar['IMP_DEDUC_ADEL_MAT'] = $verSI ;
                //$Control_visualizar['IMP_IMPONIBLE'] = $verSI ;
                $Control_visualizar['IMP_IGV'] = $verSI ;
                //$Control_visualizar['IMP_NETO'] = $verSI ;
                $Control_visualizar['IMP_PENALIDAD'] = $verSI ;
                $Control_visualizar['IMP_RETENCION'] = $verSI ;
                $Control_visualizar['IMP_PAGO'] = $verSI ;
                break;
        }  
    }
    
    return $Control_visualizar;
}