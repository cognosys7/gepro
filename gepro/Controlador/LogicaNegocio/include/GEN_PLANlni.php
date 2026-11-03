<?php



  require_once(PATH_CONTROLADOR_DAO . "/GEN_PLANdao.php");

  require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
  

function GEN_PLAN_Datos($PIDE) {

    $IDE_PLAN = NULL;
    $DES_PLAN = NULL;
    $TIP_CALENDARIO = NULL;
    $EST_PLAN = NULL;


    $campos = "";
    $campos .= "IDE_PLAN, ";
    $campos .= "DES_PLAN, ";
    $campos .= "TIP_CALENDARIO, ";
    $campos .= "EST_PLAN, ";
    $campos = substr($campos, 0, strlen($campos) - 2);



    if ($PIDE > 0) {
        $filtro = "  AND IDE_PLAN =" . $PIDE; // echo $campos.''.$filtro.'-';die;            
        $data = VIS_SelCampos('GEN_PLAN', $campos, $filtro);
        if (count($data) > 0) {
            $IDE_PLAN = $data[0]->IDE_PLAN;
            $DES_PLAN = $data[0]->DES_PLAN;
            $TIP_CALENDARIO = $data[0]->TIP_CALENDARIO;
            $EST_PLAN = $data[0]->EST_PLAN;
        }
    }

    $Resultado = array(
        'BIDE' => $IDE_PLAN
        , 'DES_PLAN' => $DES_PLAN
        , 'TIP_CALENDARIO' => $TIP_CALENDARIO
        , 'EST_PLAN' => $EST_PLAN
            );

    return $Resultado;
}

function Tabla_GEN_PLAN_Datos($PIDE) {

    $Data = GEN_PLAN_Datos($PIDE);
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
