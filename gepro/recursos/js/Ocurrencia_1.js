function ReturnPrincipal()
{
    $("#tabs").tabs({disabled: [1]});
    $("#tabs").tabs({active: 0});
    LimpiarForm();
}

//function CancelarEtapas()
//{
//    $("#tabs").tabs({disabled: [0,1,3]});
//    $("#tabs").tabs({active: [2]});
//    LimpiarForm2();
//    $("#FormularioDiv3").empty();
//}

function LimpiarForm()
{
    var f                   = document.formularioGrid;
    f.Codigo.value          = "";
    f.ActionForm.value      = "";
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
    }
    if (valorDocumento === "OCURRENCIA INTERNA")
    {
        $("#DatosInstitucion").hide();
        $("#DatosUnidadOrganica").show();
        f.RegInstitucion.disabled = true;
        f.UnidadOrganica.disabled = false;
        f.CodigoInstitucion.disabled = true;
    }
}

//function AdjuntaFiles(Valor)
//{
//    var f = document.formulario;
//    if (Valor === 1)
//    {
//        $("#DocumentosAdjuntos").show();
//        f.TipoDocumento.disabled = false;
//        f.fileToUpload.disabled = false;
//    }
//    else
//    {
//        $("#DocumentosAdjuntos").hide();
//        f.TipoDocumento.disabled = true;
//        f.fileToUpload.disabled = true;
//    }
//}

function NuevaOcurrencia(Pagina)
{
    $("#tabs").tabs({disabled: [0]});
    $("#tabs").tabs({active: [1]});
    LimpiarGrid();
    $("#FormularioDiv").empty();
    AjaxGeneraForm(Pagina,'GeneraForm','formularioGrid','FormularioDiv');
}

//function ValidarMontoDerecho()
//{
//    var f = document.formulario;
//    if (f.CkMontoDerecho.checked == true)
//    {
//        $("#MontoDerecho").show();
//        $("#ValorGratuito").hide();
//        f.MontoDerecho.focus();
//        f.MontoDerecho.disabled=false;
//    }
//    else
//    {
//        $("#MontoDerecho").hide();
//        $("#ValorGratuito").show();
//        f.MontoDerecho.disabled=true;
//    }
//}

function ProcesarOcurrencia(Pagina)
{
    AjaxProcesaArchivosDatos(Pagina,'flex1');
    ReturnPrincipal();
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
    personaOcurrenciaIDFom  = (f.personaOcurrenciaID.value === null) ? 0 : f.personaOcurrenciaID.value;
//    TipoDocumentoFom        = (f.TipoDocumento.value === null) ? 0 : f.TipoDocumento.value;
    NDocumentoFom           = (f.NDocumento.value === null) ? 0 : f.NDocumento.value;
    FechaOcurrenciaFom      = (f.FechaOcurrencia.value === null) ? 0 : f.FechaOcurrencia.value;
    FechaRecepcionObraForm  = (f.FechaRecepcionObra.value === null) ? 0 : f.FechaRecepcionObra.value;
    FechaIniGarantiaForm    = (f.FechaIniGarantia.value === null) ? 0 : f.FechaIniGarantia.value;
    FechaFinGarantiaForm    = (f.FechaFinGarantia.value === null) ? 0 : f.FechaFinGarantia.value;
    DeficienciaConsFom      = (f.DeficienciaConstructiva.value === null) ? 0 : f.DeficienciaConstructiva.value;
    OcurrenciaFom           = (f.Ocurrencia.value === null) ? 0 : f.Ocurrencia.value;
//    AdjuntaAdocumentoForm   = (f.AdjuntaAdocumento.value === null) ? 0 : f.AdjuntaAdocumento.value;
//    var docFile             = document.getElementById('fileToUpload');
//    var file                = docFile.files[0];
    var data                = new FormData();
//    if (typeof file === "undefined") {
//        data.append('archivo', null);
//    } 
//    else 
//    {
//        data.append('archivo', file);
//    }
    data.append('ActionForm', ActionForm);
    data.append('Codigo', CodigoForm);
    data.append('CDocumentoForm', CDocumentoForm);
    data.append('ObraIDForm', ObraIDForm);
    data.append('TipoOcurrenciaFom', TipoOcurrenciaFom);
    data.append('UnidadOrganicaFom', UnidadOrganicaFom);
    data.append('CodigoInstitucionFom', CodigoInstitucionFom);
    data.append('personaOcurrenciaIDFom', personaOcurrenciaIDFom);
//    data.append('TipoDocumentoFom', TipoDocumentoFom);
    data.append('NDocumentoFom', NDocumentoFom);
    data.append('FechaOcurrenciaFom', FechaOcurrenciaFom);
    data.append('FechaRecepcionObraForm', FechaRecepcionObraForm);
    data.append('FechaIniGarantiaForm', FechaIniGarantiaForm);
    data.append('FechaFinGarantiaForm', FechaFinGarantiaForm);
    data.append('DeficienciaConsFom', DeficienciaConsFom);
    data.append('OcurrenciaFom', OcurrenciaFom);
//    data.append('AdjuntaAdocumentoForm', AdjuntaAdocumentoForm);
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

//function NuevoCronograma(Pagina)
//{
//    $("#tabs").tabs({disabled: [0,1,2]});
//    $("#tabs").tabs({active: [3]});
//    LimpiarGrid();
//    $("#FormularioDiv").empty();
//    AjaxGeneraForm(Pagina,'GeneraFormEtapas','formularioCronograma','FormularioDiv3');
//}

//function VerCronograma(Valor)
//{
//    var f                   = document.formularioGrid;
//    var Pagina              = f.Pagina.value;
//    f.ActionForm.value      = "";
//    f.Codigo.value          = Valor;
//    $("#tabs").tabs({disabled: [0,1,3]});
//    $("#tabs").tabs({active: [2]});
//    $("#FormularioDiv2").empty();
//    AjaxGeneraForm(Pagina,'GeneraCronograma','formularioGrid','FormularioDiv2');
//}

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

//function EditarEtapaProceso(Valor)
//{
//    var f                   = document.formularioCronograma;
//    var Pagina              = f.Pagina.value;
//    f.ActionForm.value      = "ModificarRegistroEtapa";
//    f.CEtapa.value          = Valor;
//    $("#tabs").tabs({disabled: [0,1,2]});
//    $("#tabs").tabs({active: 3}); 
//    AjaxGeneraForm(Pagina,'GeneraFormEtapas','formularioCronograma','FormularioDiv3');
//}

//function PublicarProceso(Valor)
//{
//    var f                   = document.formularioGrid;
//    var Pagina              = f.Pagina.value;
//    f.ActionForm.value      = "PublicarProceso";
//    f.Codigo.value          = Valor;
//    AjaxProcesaDatos(Pagina,'formularioGrid','flex1');
//    ReturnPrincipal();
//}

//function DesPublicarProceso(Valor)
//{
//    var f                   = document.formularioGrid;
//    var Pagina              = f.Pagina.value;
//    f.ActionForm.value      = "";
//    f.Codigo.value          = Valor;
//    $("#tabs").tabs({disabled: [0,2,3]});
//    $("#tabs").tabs({active: 1}); 
//    AjaxGeneraForm(Pagina,'GeneraFormDespublik','formularioGrid','FormularioDiv');
//}

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

//function EliminarEtapaProceso(Valor)
//{
//    var f                   = document.formularioCronograma;
//    var Pagina              = f.Pagina.value;
//    if(confirm('¿Desea eliminar este registro?'))
//    {
//        f.ActionForm.value  = "EliminaProcesoEtapa";
//        f.CEtapa.value      = Valor;
//        AjaxProcesaDatos(Pagina,'formularioCronograma','flex2');
//        CancelarEtapas();
//    }
//    else
//    {
//        return;
//    }
//}

function AddObras()
{
    OcultaBOx();
    $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Obraslst&Accion=muestraVista&AccionLocal=2"});
    $('#cboxClose').remove();
}

function CambiaCombos(Valor,Tipo)
{
    OcultaBOx();
    if (Tipo == 1)
    {
        $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Directoriolst&Accion=muestraVista&AccionLocal=2&COcurrencia="+Valor});
    }
    if (Tipo == 2)
    {
        $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Documentoslst&Accion=muestraVista&AccionLocal=2&COcurrencia="+Valor});
    }
    $('#cboxClose').remove();
}