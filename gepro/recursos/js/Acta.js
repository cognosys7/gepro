function verFormularioOcurrencia(){
    var f                           = document.formularioGrid;       
    f.IdOcurrencia.value            = "";       
    f.IdOcurrenciaActa.value        = "";  
    
    $("#tabs").tabs({disabled: [1,2,3,4]});
    $("#tabs").tabs({active: 0});
    $("#divFormularioListaActas").empty();
    $("#divFormularioNuevaActa").empty();
    $("#divFormularioObservaciones").empty();   
    $("#divFormularioNuevaActaObservacion").empty(); 
    CrearFormulario('verFormularioOcurrencia','FormularioDiv');
}
function verFormularioListaActas(IdOcurrencia){
    var f                           = document.formularioGrid;   
    f.ActionForm.value              = "MostrarActasdeOcurencias";
    f.IdOcurrencia.value            = IdOcurrencia;       
    $("#tabs").tabs({disabled: [0,2,3,4]});
    $("#tabs").tabs({active: [1]});   
    $("#divFormularioNuevaActa").empty();
    $("#divFormularioObservaciones").empty();   
    $("#divFormularioNuevaActaObservacion").empty(); 
    CrearFormulario('verFormularioListaActas','divFormularioListaActas');            
}
function verFormularioListaActaObservacion(IdOcurrencia, IdOcurrenciaActa){
    var f                                       = document.formularioGrid;   
    f.ActionForm.value                          = "MostrarActasdeOcurencias";
    f.IdOcurrencia.value                        = IdOcurrencia;       
    f.IdOcurrenciaActa.value                    = IdOcurrenciaActa;
    f.IdOcurrenciaActaObservacion.value         = 0;    
    $("#tabs").tabs({disabled: [0,1,2,4]});
    $("#tabs").tabs({active: [3]});   
    $("#divFormularioListaActas").empty();
    $("#divFormularioNuevaActa").empty();  
    $("#divFormularioNuevaActaObservacion").empty(); 
    CrearFormulario('verFormularioListaActaObservacion','divFormularioListaActaObservacion');            
}
function verFormularioNuevaActa(IdOcurrencia,IdOcurrenciaActa){  
    var f                           = document.formularioGrid;  
    f.ActionForm.value              = "EditarActa";
    f.IdOcurrencia.value            = IdOcurrencia;
    f.IdOcurrenciaActa.value        = IdOcurrenciaActa;
    $("#tabs").tabs({disabled: [0,1,3,4]});
    $("#tabs").tabs({active: [2]});
    $("#divFormularioListaActas").empty();
    $("#divFormularioObservaciones").empty();    
    $("#divFormularioNuevaActaObservacion").empty();  
    CrearFormulario('verFormularioNuevaActa','divFormularioNuevaActa'); 
}
function verFormularioNuevaActaObservacion(IdOcurrencia,IdOcurrenciaActa,IdOcurrenciaActaObservacion){  
    var f                                   = document.formularioGrid;  
    f.ActionForm.value                      = "EditarActaObservacion";
    f.IdOcurrencia.value                    = IdOcurrencia;
    f.IdOcurrenciaActa.value                = IdOcurrenciaActa;
    f.IdOcurrenciaActaObservacion.value     = IdOcurrenciaActaObservacion;
    $("#tabs").tabs({disabled: [0,1,2,3]});
    $("#tabs").tabs({active: [4]});
    $("#divFormularioListaActas").empty();
    $("#divFormularioNuevaActa").empty();
    $("#divFormularioObservaciones").empty();     
    CrearFormulario('verFormularioNuevaActaObservacion','divFormularioNuevaActaObservacion'); 
}
function GuardarActa(Estado){  
    var f                                       = document.FormularioNuevaActa;
    ActionForm                                  = "GuardarActa";            
    IdOcurrenciaActa                            = (f.IdOcurrenciaActa.value === "") ? 0 : f.IdOcurrenciaActa.value;
    IdOcurrencia                                = (f.IdOcurrencia.value === "") ? 0 : f.IdOcurrencia .value;
    NumeroActa                                  = (f.txtNumeroActa.value === null) ? 0 : f.txtNumeroActa.value;
    FechaActa                                   = (f.txtFechaActa.value === null) ? 0 : f.txtFechaActa .value;
    DiasPlazoObservacionesSubsanadas            = (f.txtPlazo.value === null) ? 0 : f.txtPlazo.value;
    FechaInicialPlazoObservacionesSubsanadas    = (f.txtFechaActaInicial.value === null) ? 0 : f.txtFechaActaInicial.value;
    FechaFinalPlazoObservacionesSubsanadas      = (f.txtFechaActaFinal.value === null) ? 0 : f.txtFechaActaFinal.value;
    IdCatalogoTipoActa                          = (f.cmbTipoActa.value === null) ? 0 : f.cmbTipoActa.value; 
    if(IdOcurrencia==0){alert("No se puede Guardar, por favor seleccione nuevamente la Ocurrencia"); return;}
    var data                                    = new FormData();  
    data.append('ActionForm', ActionForm);    
    data.append('IdOcurrenciaActa', IdOcurrenciaActa);
    data.append('Estado', Estado);
    data.append('IdOcurrencia', IdOcurrencia);
    data.append('NumeroActa', NumeroActa);
    data.append('FechaActa', FechaActa);
    data.append('DiasPlazoObservacionesSubsanadas', DiasPlazoObservacionesSubsanadas);
    data.append('FechaInicialPlazoObservacionesSubsanadas', FechaInicialPlazoObservacionesSubsanadas);
    data.append('FechaFinalPlazoObservacionesSubsanadas', FechaFinalPlazoObservacionesSubsanadas);
    data.append('IdCatalogoTipoActa', IdCatalogoTipoActa);
   
    $.ajax({
        url: "./mainpage.php?Pagina=Acta&Accion=ProcesaMensaje&AccionLocal=1",
        type: 'POST',
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
           CleanMensaje();
           $("#Mensajes").html(msg);         
        }
    });
    verFormularioListaActas(IdOcurrencia);    
}
function GuardarActaObservacion(Estado){  
    var f                                       = document.FormularioNuevaActaObservacion;
    ActionForm                                  = "GuardarActaObservacion";            
    IdOcurrencia                                = (f.IdOcurrencia.value === "") ? 0 : f.IdOcurrencia .value;
    IdOcurrenciaActa                            = (f.IdOcurrenciaActa.value === "") ? 0 : f.IdOcurrenciaActa.value;
    IdOcurrenciaActaObservacion                 = (f.IdOcurrenciaActaObservacion.value === "") ? 0 : f.IdOcurrenciaActaObservacion.value;        
    Observacion                                 = (f.txtActaObservacion.value === null) ? 0 : f.txtActaObservacion.value;   
    Detalle                                     = (f.txtActaObservacionDetalle.value === null) ? 0 : f.txtActaObservacionDetalle.value;
    cboClasificacion                            = (f.cboClasificacion.value === null) ? 0 : f.cboClasificacion.value;   
    if(IdOcurrenciaActa==0){alert("No se puede Guardar, por favor seleccione nuevamente el Acta"); return;}
    var data                                    = new FormData();  
    data.append('ActionForm', ActionForm);    
    data.append('IdOcurrencia', IdOcurrencia);
    data.append('IdOcurrenciaActa', IdOcurrenciaActa);
    data.append('IdOcurrenciaActaObservacion', IdOcurrenciaActaObservacion);
    data.append('Observacion', Observacion);
    data.append('Detalle', Detalle);
    data.append('cboClasificacion', cboClasificacion);
    data.append('Estado', Estado);   
    $.ajax({
        url: "./mainpage.php?Pagina=Acta&Accion=ProcesaMensaje&AccionLocal=1",
        type: 'POST',
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
           CleanMensaje();
           $("#Mensajes").html(msg);         
        }
    });
    verFormularioListaActaObservacion(IdOcurrencia,IdOcurrenciaActa);    
}
function EliminarActa(IdOcurrencia,IdOcurrenciaActa){ 
    if(IdOcurrencia==0){alert("No se puede Eliminar, por favor seleccione nuevamente la Ocurrencia"); return;}
    if(IdOcurrenciaActa==0){alert("No se puede Eliminar, por favor seleccione nuevamente un Acta"); return;}
    if(confirm('¿Desea eliminar este registro?')) {
        var data                                    = new FormData();  
        data.append('ActionForm', "GuardarActa");    
        data.append('IdOcurrenciaActa', IdOcurrenciaActa);
        data.append('Estado', 0);
        $.ajax({
            url: "./mainpage.php?Pagina=Acta&Accion=ProcesaMensaje&AccionLocal=1",
            type: 'POST',
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            //MANDO LOS VALORES POST DEL FORMULARIO GRID
            beforeSend: function (XMLHttpRequest) {
            },
            success: function(msg)
            {
               CleanMensaje();
               $("#Mensajes").html(msg);         
            }
        });
    }
    verFormularioListaActas(IdOcurrencia);    
}
function EliminarActaObservacion(IdOcurrencia,IdOcurrenciaActa,IdOcurrenciaActaObservacion){ 
    if(IdOcurrencia==0){alert("No se puede Eliminar, por favor seleccione nuevamente la Ocurrencia"); return;}
    if(IdOcurrenciaActa==0){alert("No se puede Eliminar, por favor seleccione nuevamente un Acta"); return;}
    if(IdOcurrenciaActaObservacion==0){alert("No se puede Eliminar, por favor seleccione nuevamente la Observacion"); return;}
    if(confirm('¿Desea eliminar este registro?')) {
        var data                                    = new FormData();  
        data.append('ActionForm', "GuardarActaObservacion");    
        data.append('IdOcurrenciaActaObservacion', IdOcurrenciaActaObservacion);
        data.append('Estado', 0);
        $.ajax({
            url: "./mainpage.php?Pagina=Acta&Accion=ProcesaMensaje&AccionLocal=1",
            type: 'POST',
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            //MANDO LOS VALORES POST DEL FORMULARIO GRID
            beforeSend: function (XMLHttpRequest) {
            },
            success: function(msg)
            {
               CleanMensaje();
               $("#Mensajes").html(msg);         
            }
        });
    }
    verFormularioListaActaObservacion(IdOcurrencia,IdOcurrenciaActa);    
}
function VerDocumentos(IdOcurrencia,IdOcurrenciaActa,IdDocumentoGeneral){
    
    if(IdDocumentoGeneral==0)
    {        
        $.ajax({
            type: "POST", 
            async: false,
            dataType : 'json',
            url: "./mainpage.php?Pagina=Acta&ActionForm=CrearDocumentoGeneral&IdOcurrenciaActa="+IdOcurrenciaActa,
            beforeSend: function (XMLHttpRequest) {                    
            },
            success: function(data){
                
                IdDocumentoGeneral=data[2][0];
                OcultaBOx();   
                $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=DocumentoGeneral&Accion=muestraVista&AccionLocal=2&COcurrencia="+IdOcurrencia+"&IdDocumentoGeneralPadre="+IdDocumentoGeneral});   
                $('#cboxClose').remove();  
                verFormularioListaActas(IdOcurrencia); 
            }
        });        
    }
    else
    {
        OcultaBOx();   
        $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=DocumentoGeneral&Accion=muestraVista&AccionLocal=2&COcurrencia="+IdOcurrencia+"&IdDocumentoGeneralPadre="+IdDocumentoGeneral});   
        $('#cboxClose').remove();
    }
}
function CrearFormulario(accion,div){       
    var formulario='formularioGrid';
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina=acta&Accion="+accion+"&AccionLocal=1",
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#"+formulario).serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
            //REEMPLAZO EL DIV INDICADO
           $("#"+div).html(msg);
        }
    });
}

function DiasDePlazo()
{
    var f = document.FormularioNuevaActa;
    var inicio = "";
    var final  = "";
    inicio = f.txtFechaActaInicial.value;
    final  = f.txtFechaActaFinal.value;
    var Plazos = FechasRestar(inicio,final);
    if(isNaN(Plazos))
    {
        //alert(Plazos);
    }
    else
    {
        if (Plazos < 0)
        {
            alert("La fecha final debe ser mayor a la fecha de Inicio");
            f.txtFechaActaInicial.focus();
            return;
        }
        else
        {
            f.txtPlazo.value = Plazos;

        }
    }
}