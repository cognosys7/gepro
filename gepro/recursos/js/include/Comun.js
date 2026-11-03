/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA

  //  Propósito       : PLAN_SOLIC_PROY_INTERVENCIONDATA de la tabla PLAN_SOLIC_PROY_INTERVENCION
  //  Fecha           : martes, 19 de junio de 2018 02:38:39 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

function AddUBIGEO_c (Boton)
{   
    document.formulario.varBotonInvocador.value = Boton ;
    
    OcultaBOx();
    $.colorbox({width:"97%", height:"95%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=GEN_UBIGEO&Accion=muestraVista&AccionLocal=2"});
    $('#cboxClose').remove();
}


function AddUnidadEjecutora_c (EJECUTORA)
{   
    //    SE IDENTIFICA EL BOTON UTILIZADO
    document.formulario.btnUnidadEjecutora.value = EJECUTORA ;
    
    OcultaBOx();
    $.colorbox({width:"97%", height:"95%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=GEN_ENTIDAD&Accion=muestraVista&AccionLocal=2"});
    $('#cboxClose').remove();
}


function AddPIP_c (PIP)
{   
    //    SE IDENTIFICA EL BOTON UTILIZADO
    document.formulario.varBotonInvocador.value = PIP ;
    
    OcultaBOx();
    $.colorbox({width:"97%", height:"95%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=GEN_PIP&Accion=muestraVista&AccionLocal=2&Pedido=Busqueda"});
    $('#cboxClose').remove();
}

