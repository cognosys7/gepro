//OK
function ReturnPrincipal()
{
    $("#tabs").tabs({disabled: [1,2,3]});
    $("#tabs").tabs({active: 0});
    $("#FormularioDiv").empty();
    $("#Formulario2Div").empty();
    LimpiarForm();
}

function ReturnNivel2()
{
    $("#tabs").tabs({disabled: [0,2,3]});
    $("#tabs").tabs({active: 1});
    $("#Formulario2Div").empty();
    LimpiarForm2();
}

function ReturnNivel3()
{
    $("#tabs").tabs({disabled: [0,1,3]});
    $("#tabs").tabs({active: 2});
    $("#Formulario3Div").empty();
    LimpiarForm3();
}

//OK
function AdjuntarFileX(Valor)
{
    var f = document.formularioAcc;
    if (Valor === 0)
    {
        f.fileToUpload.disabled = true;
        $("#ArchivosSubir").hide();
    }
    else
    {
        f.fileToUpload.disabled = false;
        $("#ArchivosSubir").show();
    }
}

//OK
function ValidaTipoAccion()
{
    var f = document.formularioAcc;
    if (f.TipoAccion.value === "1")
    {
        $("#DatosDocumentos").show();
        f.NDocumentoCC.disabled = false;
        f.DescNDocumento.disabled = false;
        f.TipoDocumento.disabled = false;
        f.Asunto.disabled = false;
    }
    else
    {
        $("#DatosDocumentos").hide();
        f.NDocumentoCC.disabled = true;
        f.DescNDocumento.disabled = true;
        f.TipoDocumento.disabled = true;
        f.Asunto.disabled = true;
    }
}

//OK
function LimpiarForm()
{
    var f                             = document.formularioGrid;
    f.COcurrencia.value               = "";
    f.COcurrenciaClasificacion.value  = "";
    f.CClasificacion.value            = "";
    f.ActionForm.value                = "";
}

//OK
function LimpiarForm2()
{
    var f                             = document.formularioObs;
    f.COcurrenciaDerivada.value       = "";
    f.ActionForm.value                = "";
}

function LimpiarForm3()
{
    var f                             = document.formulario;
    f.Codigo.value                    = "";
    f.ActionForm.value                = "";
}

//OK
function ListarObservaciones(Valor1,Valor2,Valor3)
{
    var f                        = document.formularioGrid;
    var Pagina                   = f.Pagina.value;
    f.ActionForm.value           = "VerOcurrencia";
    f.COcurrencia.value          = Valor1;
    f.COcurrenciaClasificacion.value  = Valor2;
    f.CClasificacion.value       = Valor3;
    $("#tabs").tabs({disabled: [0,2,3]});
    $("#tabs").tabs({active: [1]});
    $("#FormularioDiv").empty();
    AjaxGeneraForm(Pagina,'GeneraFormGridObservaciones','formularioGrid','FormularioDiv');
}

//OK
function ListarAccion(Valor)
{
    var f                        = document.formularioObs;
    var Pagina                   = f.Pagina.value;
    f.ActionForm.value           = "VerOcurrencia";
    f.COcurrenciaDerivada.value  = Valor;
    $("#tabs").tabs({disabled: [0,1,3]});
    $("#tabs").tabs({active: [2]});
    $("#Formulario2Div").empty();
    AjaxGeneraForm(Pagina,'GeneraFormGrid','formularioObs','Formulario2Div');
}

//OK
function VerAccion(Pagina)
{
    $("#tabs").tabs({disabled: [0,1,2]});
    $("#tabs").tabs({active: [3]});
    $("#Formulario3Div").empty();
    AjaxGeneraForm(Pagina,'GeneraForm','formulario','Formulario3Div');
}

//OK
function EditarAccion(Valor)
{
    var f                   = document.formulario;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "ModificarAccion";
    f.Codigo.value          = Valor;
    $("#tabs").tabs({disabled: [0,1,2]});
    $("#tabs").tabs({active: [3]});
    AjaxGeneraForm(Pagina,'GeneraForm','formulario','Formulario3Div');
}

//OK
function ProcesarAccion(Pagina)
{
    AjaxProcesaArchivosDatos(Pagina,'flex3');
    ReturnNivel3();
}

//OK
function AjaxProcesaArchivosDatos(Pagina,Grid)
{
    var f                   = document.formularioAcc;
    ActionForm              = (f.ActionForm.value === null) ? 0 : f.ActionForm.value;
    CodigoForm              = (f.Codigo.value === null) ? 0 : f.Codigo.value;
    COcurrenciaForm         = (f.COcurrencia.value === null) ? 0 : f.COcurrencia.value;
    COcurrenciaDerivadaForm = (f.COcurrenciaDerivada.value === null) ? 0 : f.COcurrenciaDerivada.value;
    NDocumentoFom           = (f.NDocumentoCC.value === null) ? 0 : f.NDocumentoCC.value;
    DescNDocumentoFom       = (f.DescNDocumento.value === null) ? 0 : f.DescNDocumento.value;
    FechaDocumentoFom       = (f.FechaDocumento.value === null) ? 0 : f.FechaDocumento.value;
    TipoDocumentoFom        = (f.TipoDocumento.value === null) ? 0 : f.TipoDocumento.value;
    AsuntoFom               = (f.Asunto.value === null) ? 0 : f.Asunto.value;
    ObservacionFom          = (f.Observacion.value === null) ? 0 : f.Observacion.value;
    EstadoForm              = (f.EstadoAccion.value === null) ? 0 : f.EstadoAccion.value;
    AdjuntarFileForm        = (f.AdjuntarFile.value === null) ? 0 : f.AdjuntarFile.value;
    TipoAccionForm          = (f.TipoAccion.value === null) ? 0 : f.TipoAccion.value;
    var data                = new FormData();
    if (AdjuntarFileForm !== 0)
    {
        var docFile             = document.getElementById('fileToUpload');
        var file                = docFile.files[0];
        if (typeof file === "undefined") 
        {
            data.append('archivo', null);
        } 
        else 
        {
            data.append('archivo', file);
        }
    }
    
    data.append('ActionForm', ActionForm);
    data.append('Codigo', CodigoForm);
    data.append('COcurrencia', COcurrenciaForm);
    data.append('COcurrenciaDerivada', COcurrenciaDerivadaForm);
    data.append('NDocumentoFom', NDocumentoFom);
    data.append('DescNDocumentoFom', DescNDocumentoFom);
    data.append('FechaDocumentoFom', FechaDocumentoFom);
    data.append('TipoDocumentoFom', TipoDocumentoFom);
    data.append('AsuntoFom', AsuntoFom);
    data.append('ObservacionFom', ObservacionFom);
    data.append('EstadoForm', EstadoForm);
    data.append('TipoAccionForm', TipoAccionForm);
    
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

function LevantarObservacion(Valor)
{
    var f       = document.formularioObs;
    var Pagina  = f.Pagina.value;
    if(confirm('¿Desea levantar esta observación?'))
    {
        f.COcurrenciaDerivada.value = Valor;
        f.ActionForm.value  = "LevantarObservacion";
        AjaxProcesaDatos(Pagina,'formularioObs','flex2');
        Regresar(2);
        f.COcurrenciaDerivada.value = "";
    }
    else
    {
        return;
    }
}

function EliminarAccion(Valor)
{
    var f       = document.formulario;
    var Pagina  = f.Pagina.value;
    if(confirm('¿Desea eliminar este registro?'))
    {
        f.Codigo.value = Valor;
        f.ActionForm.value  = "EliminaAccion";
        AjaxProcesaDatos(Pagina,'formulario','flex3');
        f.Codigo.value = "";
    }
    else
    {
        return;
    }
}