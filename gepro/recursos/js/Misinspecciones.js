function ReturnPrincipal()
{
    $("#tabs").tabs({disabled: [1,2]});
    $("#tabs").tabs({active: 0});
    $("#FormularioDiv").empty();
    $("#Formulario2Div").empty();
    LimpiarForm();
}

function ReturnNivel2()
{
    $("#tabs").tabs({disabled: [0,2]});
    $("#tabs").tabs({active: 1});
    $("#Formulario2Div").empty();
    LimpiarForm2();
}

function ReturnNivel2_1()
{
    $("#tabs").tabs({disabled: [0,2]});
    $("#tabs").tabs({active: 1});
    LimpiarForm3();
}

function ReturnNivel3()
{
    $("#tabs").tabs({disabled: [0,2]});
    $("#tabs").tabs({active: 1});
    $("#Formulario2Div").empty();
    LimpiarForm2();
    LimpiarForm3();
    $('body,html').stop(true,true).animate({				
            scrollTop: $("#iralancla").offset().top
    },1000);
}

function LimpiarForm()
{
    var f                        = document.formularioGrid;
    f.COcurrencia.value          = "";
    f.COcurrenciaClasInspeccion.value  = "";
    f.ActionForm.value           = "";
}

function LimpiarForm2()
{
    var f                   = document.formulario;
    f.Codigo.value          = "";
    f.ActionForm.value      = "";
}

function LimpiarForm3()
{
    var f                   = document.formularioListObs;
    f.Codigo.value          = "";
    f.ActionForm.value      = "";
}

function GenerarActaObs(Valor1,Valor2,Valor3)
{
    var f                        = document.formularioGrid;
    var Pagina                   = f.Pagina.value;
    f.ActionForm.value           = "VerOcurrencia";
    f.COcurrencia.value          = Valor1;
    f.COcurrenciaClasInspeccion.value= Valor2;
    f.CClasificacion.value       = Valor3;
    $("#tabs").tabs({disabled: [0,2]});
    $("#tabs").tabs({active: [1]});
    $("#FormularioDiv").empty();
    AjaxGeneraForm(Pagina,'GeneraFormActa','formularioGrid','FormularioDiv');
}

function ProcesarInspeccion(Pagina)
{

    var f       = document.formulario;
    var Pase    = 0;
    var SinObs  = 0;
    if (f.NoObservaciones.checked)
    {
        Pase = 1;
    }
    else
    {
        if(confirm('¿Este registro no cuenta con Observaciones?'))
        {
            Pase   = 1;
            SinObs = 1;
        }
    }
    if (Pase === 1)
    {
        
//        var Valor1  = f.COcurrencia.value;
//        var Valor2  = f.COcurrenciaClasInspeccion.value;
//        var Valor3  = f.CClasificacion.value;
        AjaxProcesaArchivosDatos(Pagina,'flex2');
        if (SinObs === 1)
        {
            Regresar(1);
        }
        else
        {
            Regresar(2);
            //GenerarActaObs(Valor1,Valor2,Valor3);
            CallDatosActa(Pagina);
        }
    }
}

function AjaxProcesaArchivosDatos(Pagina,Grid)
{
    
    var f                       = document.formulario;
    ActionForm                  = (f.ActionForm.value === null) ? 0 : f.ActionForm.value;
    CodigoForm                  = (f.Codigo.value === null) ? 0 : f.Codigo.value;
    CActaForm                   = (f.CActa.value === null) ? 0 : f.CActa.value;
    COcurrenciaForm             = (f.COcurrencia.value === null) ? 0 : f.COcurrencia.value;
    COcurrenciaInspeccionForm   = (f.COcurrenciaClasInspeccion.value === null) ? 0 : f.COcurrenciaClasInspeccion.value;
    CClasificacionForm          = (f.CClasificacion.value === null) ? 0 : f.CClasificacion.value;
    ActaFom                     = (f.Acta.value === null) ? 0 : f.Acta.value;
    if (f.NoObservaciones.checked)
    {
        NoObservacionFom = 1;
    }
    else
    {
        NoObservacionFom = 0;
    }
    var data                = new FormData();

    data.append('ActionForm', ActionForm);
    data.append('Codigo', CodigoForm);
    data.append('CActaForm', CActaForm);
    data.append('COcurrencia', COcurrenciaForm);
    data.append('COcurrenciaClasInspeccion', COcurrenciaInspeccionForm);
    data.append('CClasificacion', CClasificacionForm);
    data.append('ActaFom', ActaFom);
    data.append('NoObservaciones', NoObservacionFom);
    
    
    $.ajax({
        url: "./mainpage.php?Pagina="+Pagina+"&Accion=ProcesaMensaje&AccionLocal=1",
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
           $("#"+Grid).flexReload();
        }
    });
}

//function CallMotivoCancel(Valor)
//{
//    var f = document.formulario;
//    if (Valor === 1)
//    {
//        $("#MotivoCancel").show();
//        f.Motivo.disabled = false;
//    }
//    else
//    {
//        $("#MotivoCancel").hide();
//        f.Motivo.disabled = true;
//    }
//}

function VerObservacion(Pagina)
{
    $("#tabs").tabs({disabled: [0,1]});
    $("#tabs").tabs({active: [2]});
    $("#Formulario2Div").empty();
    AjaxGeneraForm(Pagina,'GeneraForm','formularioListObs','Formulario2Div');
}

//function ProcesarObservacion(Pagina)
//{
//    var f       = document.formulario;
////    var Valor1  = f.COcurrencia.value;
////    var Valor2  = f.COcurrenciaClasInspeccion.value;
////    var Valor3  = f.CClasificacion.value;
//    AjaxProcesaDatos(Pagina,'formularioObs','flex2');
//    Regresar(2);
//}

function EditarObservacion(Valor)
{
    var f                   = document.formularioListObs;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "ModificarObservacion";
    f.Codigo.value          = Valor;
    $("#tabs").tabs({disabled: [0,1]});
    $("#tabs").tabs({active: [2]});
    AjaxGeneraForm(Pagina,'GeneraForm','formularioListObs','Formulario2Div');
}

function EliminarObservacion(Valor)
{
    var f       = document.formularioListObs;
    var Pagina  = f.Pagina.value;
//    var Valor1  = f.COcurrencia.value;
//    var Valor2  = f.COcurrenciaClasInspeccion.value;
//    var Valor3  = f.CClasificacion.value;
    if(confirm('¿Desea eliminar este registro?'))
    {
        f.ActionForm.value  = "EliminaObservacion";
        f.Codigo.value      = Valor;
        AjaxProcesaDatos(Pagina,'formularioListObs','flex2');
        $("#flex2").flexReload();
        ReturnNivel2_1();
        //GenerarActaObs(Valor1,Valor2,Valor3);
        CallDatosActa(Pagina);
    }
    else
    {
        return;
    }
}

function CancelarClasificacion(Valor1,Valor2)
{
    var f       = document.formularioGrid;
    var Pagina  = f.Pagina.value;
    if(confirm('¿Desea eliminar este registro?'))
    {
        f.ActionForm.value  = "EliminaClasificacionInspeccion";
        f.COcurrenciaClasInspeccion.value = Valor1;
        f.CClasificacion.value = Valor2;
        AjaxProcesaDatos(Pagina,'formularioGrid','flex1');
        f.COcurrenciaClasInspeccion.value = "";
        f.CClasificacion.value = "";
    }
    else
    {
        return;
    }
}

function AsignarObservacion(Valor)
{
    var f       = document.formularioListObs;
    var Pagina  = f.Pagina.value;
    var Valor1  = f.COcurrencia.value;
    var Valor2  = f.COcurrenciaClasInspeccion.value;
    var Valor3  = f.CClasificacion.value;
    f.ActionForm.value  = "AsignaObservacion";
    f.Codigo.value      = Valor;
    AjaxProcesaDatos(Pagina,'formularioListObs','flex2');
    $("#flex2").flexReload();
    ReturnNivel2_1();
    GenerarActaObs(Valor1,Valor2,Valor3);
}

function CallDatosActa(Pagina)
{
    var f  = document.formulario;
    var f2 = document.formularioCbo;
    f2.ActionForm.value = "ProcesarDatosActa";
    f2.ActaFom.value = f.Acta.value;
    
//    ActionForm              = (f.ActionForm.value === null) ? 0 : f.ActionForm.value;
//    CodigoForm              = (f.Codigo.value === null) ? 0 : f.Codigo.value;
//    CActaForm               = (f.CActa.value === null) ? 0 : f.CActa.value;
//    COcurrenciaForm         = (f.COcurrencia.value === null) ? 0 : f.COcurrencia.value;
//    COcurrenciaInspeccionForm = (f.COcurrenciaClasInspeccion.value === null) ? 0 : f.COcurrenciaClasInspeccion.value;
//    CClasificacionForm      = (f.CClasificacion.value === null) ? 0 : f.CClasificacion.value;
//    ActaFom                 = (f.Acta.value === null) ? 0 : f.Acta.value;
//    var data                = new FormData();
//    data.append('ActionForm', ActionForm);
//    data.append('ActaFom', ActaFom);
//    data.append('Codigo', CodigoForm);
//    data.append('CActaForm', CActaForm);
//    data.append('COcurrencia', COcurrenciaForm);
//    data.append('COcurrenciaClasInspeccion', COcurrenciaInspeccionForm);
//    data.append('CClasificacion', CClasificacionForm);
    AjaxGeneraForm(Pagina,'GeneraDatosActa','formularioCbo','CallDatosDiv');
    AjaxGeneraForm(Pagina,'GeneraDatosActaObservaciones','formularioCbo','CallDatosFlexDiv');
    f2.ActaFom.value = "";
}