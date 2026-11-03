<?php


  require_once(PATH_CONTROLADOR_DAO . "/PROY_CONT_ETAPA_CONTROLdao.php");

  require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
  require_once(PATH_CONTROLADOR_LN . "/include/GEN_PLANlni.php");

function PROY_CONT_ETAPA_CONTROL_Datos($PIDE) {

    $IDE_CONT_ETAPA_CONTROL = NULL;
    $IDE_PROY_COMPONENTE = NULL;
    $IDE_PLAN = NULL;
    $NUM_ANIO = NULL;
    $TIP_CONCEPTO = NULL;
    $IMP_BRUTO = NULL;
    $IMP_IMPONIBLE = NULL;
    $PCT_IGV = NULL;
    $IMP_IGV = NULL;
    $IMP_NETO = NULL;
    $IMP_PENALIDAD = NULL;
    $IMP_PAGO = NULL;
    $EST_ETAPA_CONTROL = NULL;

    $campos = "";
    $campos .= " IDE_CONT_ETAPA_CONTROL, ";
    $campos .= " IDE_PROY_COMPONENTE, ";
    $campos .= " IDE_PLAN, ";
    $campos .= " NUM_ANIO, ";
    $campos .= " TIP_CONCEPTO, ";
    $campos .= " IMP_BRUTO, ";
    $campos .= " IMP_IMPONIBLE, ";
    $campos .= " PCT_IGV, ";
    $campos .= " IMP_IGV, ";
    $campos .= " IMP_NETO, ";
    $campos .= " IMP_PENALIDAD, ";
    $campos .= " IMP_PAGO, ";
    $campos .= " EST_ETAPA_CONTROL, ";
    $campos = substr($campos, 0, strlen($campos) - 2);



    if ($PIDE > 0) {

        $filtro = "  AND IDE_CONT_ETAPA_CONTROL =" . $PIDE; // echo $campos.''.$filtro.'-';die;   
        $data = VIS_SelCampos('PROY_CONT_ETAPA_CONTROL', $campos, $filtro);
        if (count($data) > 0) {
            $IDE_CONT_ETAPA_CONTROL = $data[0]->IDE_CONT_ETAPA_CONTROL;
            $IDE_PROY_COMPONENTE = $data[0]->IDE_PROY_COMPONENTE;
            $IDE_PLAN = $data[0]->IDE_PLAN;
            $NUM_ANIO = $data[0]->NUM_ANIO;
            $TIP_CONCEPTO = $data[0]->TIP_CONCEPTO;
            $IMP_BRUTO = $data[0]->IMP_BRUTO;
            $IMP_IMPONIBLE = $data[0]->IMP_IMPONIBLE;
            $PCT_IGV = $data[0]->PCT_IGV;
            $IMP_IGV = $data[0]->IMP_IGV;
            $IMP_NETO = $data[0]->IMP_NETO;
            $IMP_PENALIDAD = $data[0]->IMP_PENALIDAD;
            $IMP_PAGO = $data[0]->IMP_PAGO;
            $EST_ETAPA_CONTROL = $data[0]->EST_ETAPA_CONTROL;
        }
    }

    $Resultado = array(
        'BIDE' => $IDE_CONT_ETAPA_CONTROL /* identificado variable buscado */
        , 'IDE_PROY_COMPONENTE' => $IDE_PROY_COMPONENTE
        , 'IDE_PLAN' => $IDE_PLAN
        , 'NUM_ANIO' => $NUM_ANIO
        , 'TIP_CONCEPTO' => $TIP_CONCEPTO
        , 'IMP_BRUTO' => $IMP_BRUTO
        , 'IMP_IMPONIBLE' => $IMP_IMPONIBLE
        , 'PCT_IGV' => $PCT_IGV
        , 'IMP_IGV' => $IMP_IGV
        , 'IMP_NETO' => $IMP_NETO
        , 'IMP_PENALIDAD' => $IMP_PENALIDAD
        , 'IMP_PAGO' => $IMP_PAGO
        , 'EST_ETAPA_CONTROL' => $EST_ETAPA_CONTROL
            );

    return $Resultado;
}

function Tabla_PROY_CONT_ETAPA_CONTROL_Datos($PIDE) {
    /* Permite mostrar los datos de la tabla actual en el form y grillas dependientes */

    $Data = PROY_CONT_ETAPA_CONTROL_Datos($PIDE) ;
    $Data11 = GenTablas_Datos(66, $Data['TIP_CONCEPTO']) ;
    $Data12 = GEN_PLAN_Datos($Data['IDE_PLAN']) ;
            
    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';

    $DatosPadre .= '<tr>';

    $DatosPadre .= '<td style="width:' . TBpadre_EtiketaAncho(6) . '"> Plan :</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_ValorAncho(6) . '"><span style="color: #aa0000;"> ' . $Data12['DES_PLAN'] . '</span></td>';
    $DatosPadre .= '<td style="width:' . TBpadre_EtiketaAncho(6) . '"> Concepto:</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_ValorAncho(6) . '"><span style="color: #aa0000;"> ' . $Data11['DES_ITEM'] . '</span></td>';
    $DatosPadre .= '<td style="width:' . TBpadre_EtiketaAncho(6) . '"></td>';
    $DatosPadre .= '<td style="width:' . TBpadre_ValorAncho(6) . '"></td>';
    
    $DatosPadre .= '</tr>';
    
    $DatosPadre .= '<tr>';
    
    $DatosPadre .= '<td style="width:' . TBpadre_EtiketaAncho(6) . '"> Importe Bruto :</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_ValorAncho(6) . '"> ' . FormatoSoles($Data['IMP_BRUTO']) . '</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_EtiketaAncho(6) . '"> Importe Imponible :</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_ValorAncho(6) . '"> ' . FormatoSoles($Data['IMP_IMPONIBLE']) . '</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_EtiketaAncho(6) . '"> Importe Pago :</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_ValorAncho(6) . '"> ' . FormatoSoles($Data['IMP_PAGO']) . '</td>';

    $DatosPadre .= '</tr>';

    $DatosPadre .= '</table>';

    return $DatosPadre;
}
