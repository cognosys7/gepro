<?php

require_once(PATH_CONTROLADOR_DAO . "/PROYECTODAO.php");

//require_once("/LNinclude.php");
require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       


function Proyecto_Datos($PIDE) {
    
    $IDE_PROYECTO = $COD_INTERNO = $COD_UNICO = $DES_LARGA_PROYECTO = $IMP_APROBADO_LOC = $FEC_INICIO_PROY = $FEC_TERMINO_PROY = $IDE_ENTIDAD_EJECUTORA =  $IDE_PROGRAMA = $IDE_PORTAFOLIO = $DES_UBICACION_PROYECTO = $DES_PROYECTO_ENGLISH = '';
    $NUM_BENEFICIARIOS = 0;
    
    $campos = " IDE_PROYECTO, COD_INTERNO, COD_UNICO, DES_LARGA_PROYECTO, IMP_APROBADO_LOC, CONVERT(VARCHAR(10),FEC_INICIO_PROY) AS FEC_INICIO_PROY, CONVERT(VARCHAR(10),FEC_TERMINO_PROY) AS FEC_TERMINO_PROY, IDE_ENTIDAD_EJECUTORA, IDE_PROGRAMA, IDE_PORTAFOLIO, DES_UBICACION_PROYECTO, NUM_BENEFICIARIOS , DES_PROYECTO_ENGLISH  ";
//    setlocale(LC_MONETARY,"es_ES");
    
    if($PIDE>0){
        $filtro = "  AND IDE_PROYECTO =".$PIDE ;// echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('PROYECTO',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_PROYECTO           = $data[0]->IDE_PROYECTO ;
            $COD_INTERNO            = $data[0]->COD_INTERNO ;
            $COD_UNICO              = $data[0]->COD_UNICO ;
            $DES_LARGA_PROYECTO     = $data[0]->DES_LARGA_PROYECTO ;
            $IMP_APROBADO_LOC       = $data[0]->IMP_APROBADO_LOC ;
            $FEC_INICIO_PROY        = $data[0]->FEC_INICIO_PROY ;
            $FEC_TERMINO_PROY       = $data[0]->FEC_TERMINO_PROY ;
            $FEC_TERMINO_PROY       = $data[0]->FEC_TERMINO_PROY ;
            $IDE_ENTIDAD_EJECUTORA  = $data[0]->IDE_ENTIDAD_EJECUTORA ;
            $IDE_PROGRAMA           = $data[0]->IDE_PROGRAMA ;
            $IDE_PORTAFOLIO         = $data[0]->IDE_PORTAFOLIO ;
            $DES_UBICACION_PROYECTO = $data[0]->DES_UBICACION_PROYECTO ;
            $NUM_BENEFICIARIOS      = $data[0]->NUM_BENEFICIARIOS ;
            $DES_PROYECTO_ENGLISH   = $data[0]->DES_PROYECTO_ENGLISH  ;
        }
    }
    
    $Resultado = array (
        'IDE_PROYECTO'              => $IDE_PROYECTO
        ,'COD_INTERNO'              => $COD_INTERNO
        ,'COD_UNICO'                => $COD_UNICO
        ,'DES_LARGA_PROYECTO'       => $DES_LARGA_PROYECTO
        ,'IMP_APROBADO_LOC'         => $IMP_APROBADO_LOC
        ,'FEC_INICIO_PROY'          => $FEC_INICIO_PROY
        ,'FEC_TERMINO_PROY'         => $FEC_TERMINO_PROY
            
        ,'IDE_ENTIDAD_EJECUTORA'    => $IDE_ENTIDAD_EJECUTORA
        ,'IDE_PROGRAMA'             => $IDE_PROGRAMA
        ,'IDE_PORTAFOLIO'           => $IDE_PORTAFOLIO
            
        ,'DES_UBICACION_PROYECTO'   => $DES_UBICACION_PROYECTO
        ,'NUM_BENEFICIARIOS'        => $NUM_BENEFICIARIOS
        ,'DES_PROYECTO_ENGLISH'     => $DES_PROYECTO_ENGLISH
    ) ;
    
    return $Resultado ;
}



function Tabla_Proyecto_Datos ( $PIDE ) {
    
    $Data = Proyecto_Datos($PIDE);
    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';
    
    $DatosPadre .= '<tr>';
//    $DatosPadre .= '<td>Proyecto ('. $Data['IDE_PROYECTO'].') :</td>';
    $DatosPadre .= '<td>Proyecto :</td>';
    $DatosPadre .= '<td colspan="3"> ' . $Data['COD_INTERNO'].' - '.$Data['DES_PROYECTO_ENGLISH'] . '</td>';
    $DatosPadre .= '</tr>';

    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(6).'">Alcance del Proyecto:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(6).'">' . $Data['FEC_INICIO_PROY'] . '&nbsp;&nbsp; al &nbsp;&nbsp;' . $Data['FEC_TERMINO_PROY'] . '</td>';
    $DatosPadre.=  '<td style="width:'.TBpadre_EtiketaAncho(6).'">Monto de Inversión:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(6).'">' . FormatoSoles($Data['IMP_APROBADO_LOC']) . '</td>';
    $DatosPadre.=  '<td style="width:'.TBpadre_EtiketaAncho(6).'">Nº Beneficiados:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(6).'">' . number_format($Data['NUM_BENEFICIARIOS']) . '</td>';
    $DatosPadre .= '</tr>';
    
    $DatosPadre .= '</table>';
    
    return $DatosPadre ;
}



function Grilla_verBotones ($Tipo) {

    $BotonVer = array(
        'Nuevo'             => 'false',
        'Editar'            => 'true',
        'Eliminar'          => 'true',
        
        'ProyectoInversion' => 'true',
        'UBIGEO'            => 'true',
        'Contrato'          => 'true',
        'Contrato_estudios' => 'true',
        'Contrato_obras' => 'true',
        'Contrato_supervision'  => 'true',
        'Contrato_postcierre' => 'true',
        'Contrato_otros' => 'true',
        'GestionSocial'     => 'true',
        'Leccion'           => 'true',
        'Comunicacion'      => 'true',
        'SIGAM'             => 'true',
        'FichaTecnica'      => 'true'
    );
    
    switch ($Tipo){
        case 10:$BotonVer['Editar']             = 'false' ;
                $BotonVer['Eliminar']           = 'false' ;
                $BotonVer['ProyectoInversion']  = 'false' ;
                $BotonVer['UBIGEO']             = 'false' ;
                $BotonVer['Contrato']           = 'false' ;
                $BotonVer['GestionSocial']      = 'false' ;
                $BotonVer['Leccion']            = 'false' ;
                $BotonVer['Comunicacion']       = 'false' ;
            break;
        case 200:
                $BotonVer['Editar']             = 'false' ;
                $BotonVer['Eliminar']           = 'false' ;
                $BotonVer['ProyectoInversion']  = 'false' ;
                $BotonVer['UBIGEO']             = 'false' ;
                $BotonVer['Contrato']           = 'false' ;
                $BotonVer['GestionSocial']      = 'false' ;
                $BotonVer['Leccion']            = 'false' ;
                $BotonVer['Comunicacion']       = 'false' ;
            break;
        
        case 110:
                $BotonVer['Nuevo']              = 'true' ;
                $BotonVer['Editar']             = 'false' ;
                //$BotonVer['Eliminar']           = 'false' ;
                $BotonVer['ProyectoInversion']  = 'false' ;
                $BotonVer['UBIGEO']             = 'false' ;
                $BotonVer['SIGAM']              = 'false' ;
            break;
        
        case 210:   $BotonVer['Contrato']       = 'false' ;
                    $BotonVer['Editar']         = 'false' ;
            break;
        case 211:   //$BotonVer['Contrato']       = 'false' ;
                    $BotonVer['Contrato_estudios'] = 'false' ;
                    $BotonVer['Contrato_obras'] = 'false' ;
                    $BotonVer['Contrato_supervision'] = 'false' ;
                    $BotonVer['Contrato_postcierre'] = 'false' ;
                    $BotonVer['Contrato_otros'] = 'false' ;
                    $BotonVer['GestionSocial']  = 'false' ;
                    $BotonVer['Leccion']        = 'false' ;
                    $BotonVer['FichaTecnica'] = 'false' ;
                    $BotonVer['Editar']         = 'false' ;
            break;
        case 212:   $BotonVer['Contrato']       = 'false' ;
                    $BotonVer['Editar']         = 'false' ;
            break;
        case 213:   $BotonVer['Contrato']       = 'false' ;
            break;
        case 214:   $BotonVer['Contrato']       = 'false' ;
                    $BotonVer['Editar']         = 'false' ;
            break;
        case 215:   $BotonVer['Contrato']       = 'false' ;
                    $BotonVer['Editar']         = 'false' ;
            break;
        case 216:   $BotonVer['Contrato']       = 'false' ;
                    $BotonVer['Editar']         = 'false' ;
            break;
        case 217:$BotonVer['Contrato']       = 'false' ;
            break;
        
        case 310:   //$BotonVer['Contrato']       = 'false' ;
                    $BotonVer['Contrato_estudios'] = 'false' ;
                    $BotonVer['Contrato_obras'] = 'false' ;
                    $BotonVer['Contrato_supervision'] = 'false' ;
                    $BotonVer['Contrato_postcierre'] = 'false' ;
                    $BotonVer['Contrato_otros'] = 'false' ;
                    $BotonVer['GestionSocial']  = 'false' ;
            break;
        
        case 410:$BotonVer['Leccion']        = 'false' ;
            break;
        
        case 510:$BotonVer['Comunicacion']   = 'false' ;
            break;
    }
    
    return $BotonVer;
}



function Control_Bloqueo($Tipo) {

    $Control_Bloqueo = array(
        'COD_INTERNO'               => '',
	'COD_UNICO'                 => '',
	'COD_SNIP'                  => '',
	'DES_LARGA_PROYECTO'        => '',
	'DES_PROYECTO_ENGLISH'      => '',
	'TIP_MONEDA'                => '',
	'IMP_APROBADO_LOC'          => '',
	'IMP_APROBADO_EXT'          => '',
	'FEC_APROBACION'            => '',
	'FEC_INICIO_PROY'           => '',
	'FEC_TERMINO_PROY'          => '',
	'DES_UNIDAD_FORMULADORA'    => '',
	'IDE_CENCOSTO'              => ' style=" width:51%; " ',
        'EST_PROYECTO'              => cboReadonly()
    );
    
    switch ($Tipo){
        case 'SPRING1':
                $Control_Bloqueo['COD_INTERNO']             = 'readonly' ;
                $Control_Bloqueo['COD_UNICO']               = 'readonly' ;
                $Control_Bloqueo['COD_SNIP']                = 'readonly' ;
                $Control_Bloqueo['DES_LARGA_PROYECTO']      = 'readonly' ;
                $Control_Bloqueo['DES_PROYECTO_ENGLISH']    = 'readonly' ;
                $Control_Bloqueo['TIP_MONEDA']              = cboReadonly('') ; 
                $Control_Bloqueo['IMP_APROBADO_LOC']        = 'readonly' ;
                $Control_Bloqueo['IMP_APROBADO_EXT']        = 'readonly' ;
                $Control_Bloqueo['FEC_APROBACION']          = 'readonly' ;
                $Control_Bloqueo['FEC_INICIO_PROY']         = 'readonly' ;
                $Control_Bloqueo['FEC_TERMINO_PROY']        = 'readonly' ;
                $Control_Bloqueo['DES_UNIDAD_FORMULADORA']  = 'readonly' ;
                $Control_Bloqueo['IDE_CENCOSTO']            = cboReadonly() ;
                $Control_Bloqueo['EST_PROYECTO']            = cboReadonly() ; 
            break;
    }
    
    return $Control_Bloqueo;
}

?>