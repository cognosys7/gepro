<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA

  
  //  Fecha           : martes, 19 de junio de 2018 02:38:39 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PLAN_SOLICITUD_FFTODAO.php");

require_once("/GEN_ENTIDADLNI.php");
require_once("/GEN_UBIGEOLNI.php");

require_once("/LNinclude.php");


function SolicitudFFTO_Datos($PIDE) {
    
    $COD_HOJA_RUTA = $IDE_ENTIDAD_SOLICITANTE = $NUM_OFICIO_SOLICITUD = $IMP_MONTO_TOTAL_FFTO = $FEC_SOLICITUD = $FEC_TRAMITE = $FEC_RECEPCION = null;
    
    if($PIDE>0) {
        $campos =   " COD_HOJA_RUTA, IDE_ENTIDAD_SOLICITANTE ";
        $campos .=  " , NUM_OFICIO_SOLICITUD ";
        $campos .=  " , IMP_MONTO_TOTAL_FFTO ";
        $campos .=  " , CONVERT(VARCHAR(10), FEC_SOLICITUD ) as FEC_SOLICITUD ";
        $campos .=  " , CONVERT(VARCHAR(10), FEC_TRAMITE ) as FEC_TRAMITE ";
        $campos .=  " , CONVERT(VARCHAR(10), FEC_RECEPCION ) as FEC_RECEPCION ";
        $filtro = " AND IDE_SOLICITUD =".$PIDE;
            $data = VIS_SelCampos ('PLAN_SOLICITUD_FFTO',$campos,$filtro) ;

        if(count($data)>0) {
            $COD_HOJA_RUTA = $data[0]->COD_HOJA_RUTA;
            $IDE_ENTIDAD_SOLICITANTE = $data[0]->IDE_ENTIDAD_SOLICITANTE  ; 
            $NUM_OFICIO_SOLICITUD = $data[0]->NUM_OFICIO_SOLICITUD;
            $IMP_MONTO_TOTAL_FFTO = 'S/. '.number_format($data[0]->IMP_MONTO_TOTAL_FFTO,2) ;
            $FEC_SOLICITUD = ( is_null( $data[0]->FEC_SOLICITUD ) ? '' : Fecha_formato($data[0]->FEC_SOLICITUD) ) ;
            $FEC_TRAMITE = ( is_null( $data[0]->FEC_TRAMITE ) ? '' : Fecha_formato($data[0]->FEC_TRAMITE) ) ;
            $FEC_RECEPCION = ( is_null( $data[0]->FEC_RECEPCION ) ? '' : Fecha_formato($data[0]->FEC_RECEPCION) );
        }
    }
    
    $Resultado = array (
        'COD_HOJA_RUTA'             => $COD_HOJA_RUTA ,
        'IDE_ENTIDAD_SOLICITANTE'   => $IDE_ENTIDAD_SOLICITANTE ,
        'NUM_OFICIO_SOLICITUD'      => $NUM_OFICIO_SOLICITUD,
        'IMP_MONTO_TOTAL_FFTO'      => $IMP_MONTO_TOTAL_FFTO,
        'FEC_SOLICITUD'     => $FEC_SOLICITUD,
        'FEC_TRAMITE'       => $FEC_TRAMITE,
        'FEC_RECEPCION'     => $FEC_RECEPCION
    ) ;
    
    return $Resultado ;
}
?>