function ReturnPrincipal()
{
    $("#tabs").tabs({disabled: [1]});
    $("#tabs").tabs({active: 0});
    $("#FormularioDiv").empty();
    LimpiarGrid();
}

function VerTipoOcurrencia()
{
    var f = document.formulario;
    var valorDocumento  = $("#TipoOcurrencia option:selected").html();
    if (valorDocumento === "OCURRENCIA EXTERNA")
    {
        $("#DatosInstitucion").show();
        $("#DatosUnidadOrganica").hide();
        f.RegInstitucion.disabled = false;
        f.UnidadOrganica.disabled = true;
        f.CodigoInstitucion.disabled = false;
        f.UnidadOrganica.value = "";
    }
    if (valorDocumento === "OCURRENCIA INTERNA")
    {
        $("#DatosInstitucion").hide();
        $("#DatosUnidadOrganica").show();
        f.RegInstitucion.disabled = true;
        f.UnidadOrganica.disabled = false;
        f.CodigoInstitucion.disabled = true;
        f.RegInstitucion.value = "";
        f.CodigoInstitucion.value = "";
    }
}

function NuevaOcurrencia(Pagina)
{
    $("#tabs").tabs({disabled: [0]});
    $("#tabs").tabs({active: [1]});
    $("#FormularioDiv").empty();
    AjaxGeneraForm(Pagina,'GeneraForm','formularioGrid','FormularioDiv');
}

function ProcesarOcurrencia(Pagina)
{
    AjaxProcesaArchivosDatos(Pagina,'flex1');
    Regresar(1);
}

function AjaxProcesaArchivosDatos(Pagina,Grid)
{
    var f                   = document.formulario;
    ActionForm              = (f.ActionForm.value === null) ? 0 : f.ActionForm.value;
    CodigoForm              = (f.Codigo.value === null) ? 0 : f.Codigo.value;
    CDocumentoForm          = (f.CDocumento.value === null) ? 0 : f.CDocumento.value;
    ObraIDForm              = (f.ObraID.value === null) ? 0 : f.ObraID.value;
    TipoOcurrenciaFom       = (f.TipoOcurrencia.value === null) ? 0 : f.TipoOcurrencia.value;
    UnidadOrganicaFom       = (f.UnidadOrganica.value === null) ? 0 : f.UnidadOrganica.value;
    CodigoInstitucionFom    = (f.CodigoInstitucion.value === null) ? 0 : f.CodigoInstitucion.value;
    RegInstitucionFom       = (f.RegInstitucion.value === null) ? 0 : f.RegInstitucion.value;
    personaOcurrenciaIDFom  = (f.personaOcurrenciaID.value === null) ? 0 : f.personaOcurrenciaID.value;
    NDocumentoFom           = (f.NDocumento.value === null) ? 0 : f.NDocumento.value;
    FechaOcurrenciaFom      = (f.FechaOcurrencia.value === null) ? 0 : f.FechaOcurrencia.value;
    FechaRecepcionObraForm  = (f.FechaRecepcionObra.value === null) ? 0 : f.FechaRecepcionObra.value;
    FechaIniGarantiaForm    = (f.FechaIniGarantia.value === null) ? 0 : f.FechaIniGarantia.value;
    FechaFinGarantiaForm    = (f.FechaFinGarantia.value === null) ? 0 : f.FechaFinGarantia.value;
    DeficienciaConsFom      = (f.DeficienciaConstructiva.value === null) ? 0 : f.DeficienciaConstructiva.value;
    OcurrenciaFom           = (f.Ocurrencia.value === null) ? 0 : f.Ocurrencia.value;
    PrioridadFom            = (f.Prioridad.value === null) ? 0 : f.Prioridad.value;
    var data                = new FormData();
    data.append('ActionForm', ActionForm);
    data.append('Codigo', CodigoForm);
    data.append('CDocumentoForm', CDocumentoForm);
    data.append('ObraIDForm', ObraIDForm);
    data.append('TipoOcurrenciaFom', TipoOcurrenciaFom);
    data.append('UnidadOrganicaFom', UnidadOrganicaFom);
    data.append('CodigoInstitucionFom', CodigoInstitucionFom);
    data.append('RegInstitucionFom', RegInstitucionFom);
    data.append('personaOcurrenciaIDFom', personaOcurrenciaIDFom);
    data.append('NDocumentoFom', NDocumentoFom);
    data.append('FechaOcurrenciaFom', FechaOcurrenciaFom);
    data.append('FechaRecepcionObraForm', FechaRecepcionObraForm);
    data.append('FechaIniGarantiaForm', FechaIniGarantiaForm);
    data.append('FechaFinGarantiaForm', FechaFinGarantiaForm);
    data.append('DeficienciaConsFom', DeficienciaConsFom);
    data.append('OcurrenciaFom', OcurrenciaFom);
    data.append('PrioridadFom', PrioridadFom);
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

function EditarOcurrencia(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "ModificarRegistro";
    f.Codigo.value          = Valor;
    $("#tabs").tabs({disabled: [0]});
    $("#tabs").tabs({active: 1}); 
    AjaxGeneraForm(Pagina,'GeneraForm','formularioGrid','FormularioDiv');
}

function EliminarOcurrencia(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    if(confirm('¿Desea eliminar este registro?'))
    {
        f.ActionForm.value  = "EliminaOcurrencia";
        f.Codigo.value      = Valor;
        AjaxProcesaDatos(Pagina,'formularioGrid','flex1');
        ReturnPrincipal();
        
    }
    else
    {
        return;
    }
}

function AddObras()
{
    OcultaBOx();
    $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Obraslst&Accion=muestraVista&AccionLocal=2"});
    $('#cboxClose').remove();
}