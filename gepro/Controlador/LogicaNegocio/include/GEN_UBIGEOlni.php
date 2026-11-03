<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA

  
  //  Fecha           : martes, 19 de junio de 2018 02:38:39 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //
  //***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_UBIGEODAO.php");

require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       


function UBIGEO_Datos($PIDE) {
    
    $COD_UBIGEO = $DES_DEPARTAMENTO = $DES_PROVINCIA = $DES_DISTRITO = $NUM_NIVEL = $GEO_LONGITUD = $GEO_LATITUD = '' ;
    $NUM_NIVEL = 0 ;
    
    $campos = " DES_DEPARTAMENTO, DES_PROVINCIA, DES_DISTRITO, NUM_NIVEL, GEO_LONGITUD, GEO_LATITUD ";
    
    if(strlen($PIDE)>0){
        $filtro = " AND COD_UBIGEO='".$PIDE."'";
            $data = VIS_SelCampos ('GEN_UBIGEO',$campos,$filtro) ;    

        if(count($data)>0) {
            $DES_DEPARTAMENTO       = $data[0]->DES_DEPARTAMENTO ;
            $DES_PROVINCIA          = $data[0]->DES_PROVINCIA ;
            $DES_DISTRITO           = $data[0]->DES_DISTRITO ;
            $NUM_NIVEL              = $data[0]->NUM_NIVEL ;
            $GEO_LONGITUD           = $data[0]->GEO_LONGITUD ;
            $GEO_LATITUD            = $data[0]->GEO_LATITUD ;
        }
    }
    
    $Resultado = array (
        'BIDE'  => $PIDE
        ,'DES_DEPARTAMENTO'  => $DES_DEPARTAMENTO
        ,'DES_PROVINCIA'    => $DES_PROVINCIA
        ,'DES_DISTRITO'     => $DES_DISTRITO
        ,'NUM_NIVEL'        => $NUM_NIVEL
        ,'GEO_LONGITUD'     => $GEO_LONGITUD
        ,'GEO_LATITUD'      => $GEO_LATITUD
    ) ;
    
    return $Resultado ;
}

?>